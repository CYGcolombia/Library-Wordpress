const { __ } = wp.i18n;
const { withSelect } = wp.data;
const { InspectorControls } = wp.editor;
const { Component, Fragment } = wp.element;
const { SelectControl, RangeControl, PanelBody, Spinner, TextControl } = wp.components;
const { addQueryArgs } = wp.url;
const { apiFetch } = wp;

const {
    Toggle,
    Typography,
    Dropdown,
    Color,
    CssGenerator: { CssGenerator }
} = wp.qubelyComponents

let skillateCourselisting = null;

class Edit extends Component {

    constructor(props) {
        super(props)
        this.state = {
            categories: [],
            courses: []
        }
        this.skillateCourselisting = this.skillateCourselisting.bind(this);
    }

    componentDidMount() {
        let postSelections = [{ value: __('all', 'Skillate-core'), label: __('Select All Category', 'Skillate-core') }];
        wp.apiFetch({ path: "/skillateapi/v2/category" }).then(cat => {
            $.each(cat, function (key, val) {
                postSelections.push({ value: val.slug, label: val.name });
            });
        });
        this.setState({ categories: postSelections })
        this.skillateCourselisting();
    }

    componentDidUpdate(prevProps) {
        if (this.checkAttrChanged(prevProps.attributes, this.props.attributes)) {
            this.skillateCourselisting();
        }
    }
    checkAttrChanged(prevAttrs, curAttrs) {
        const {
            selectedCategory: prevCategories,
            order: prevOrder,
            offset: prevOffset,
            orderby: prevOrderby,
            include: prevInclude,
            exclude: prevExclude,
            numbers: prevNumber
        } = prevAttrs;
        const { selectedCategory, numbers, order, orderby, offset, include, exclude } = curAttrs;
        return (
            selectedCategory !== prevCategories
            || order !== prevOrder
            || offset !== prevOffset
            || orderby !== prevOrderby
            || include !== prevInclude
            || exclude !== prevExclude
            || numbers !== prevNumber
        )
    }

    skillateCourselisting() {
        const {
            numbers,
            order,
            orderby,
            offset,
            include,
            exclude,
            selectedCategory
        } = this.props.attributes;
        apiFetch({
            path: addQueryArgs('/skillateapi/v2/courses', {
                per_page: numbers,
                order: order,
                orderby: orderby,
                offset: offset,
                include: include,
                exclude: exclude,
                category: selectedCategory
            }),
        })
            .then((courses) => {
                this.setState({ courses: courses, loading: false });
            })
            .catch(() => {
                this.setState({ courses: [], loading: true });
            });
    }

    render() {
        const { courses, categories } = this.state
        const {
            attributes: {
                uniqueId,
                layout,
                columns,
                numbers,
                order,
                offset,
                include,
                exclude,
                orderby,
                typography,
                selectedCategory,
                enableTitle,
                typographyTitle,
                titleColor,
                titleHoverColor,
                enableMeta,
                typographyMeta,
                metaColor,
                enableRating,
                ratingColor,
                enablePrice,
                typographyPrice,
                priceColor,
                arrowColor,
                arrowHoverColor,
                arrowHoverBg,
                enableLoadMore,
                buttonColor,
                buttonHoverColor,
                buttonBg,
                buttonHoverBg,
                bgHoverColor,
                enableWishlist,
                enableProfile,
            }, setAttributes
        } = this.props

        const { device } = this.state
        if (uniqueId) { CssGenerator(this.props.attributes, 'upskill-core-tutor-course', uniqueId) }

        let output = '';
        let count = 0;

        return (
            <Fragment>
                <InspectorControls key="inspector">
                    <PanelBody title={__('Course Settings', 'Skillate-core')} initialOpen={true}>
                        <SelectControl
                            label={__("Select Layout", 'Skillate-core')}
                            value={layout}
                            options={[
                                { label: __('Layout 1', 'Skillate-core'), value: 1 },
                                { label: __('Layout 2', 'Skillate-core'), value: 2 },
                            ]}
                            onChange={value => setAttributes({ layout: value })}
                        />
                        <SelectControl
                            label={__('Select Column', 'Skillate-core')}
                            value={columns}
                            options={[
                                { label: __('1', 'Skillate-core'), value: '12' },
                                { label: __('2', 'Skillate-core'), value: '6' },
                                { label: __('3', 'Skillate-core'), value: '4' },
                                { label: __('4', 'Skillate-core'), value: '3' },
                            ]}
                            onChange={(value) => { setAttributes({ columns: value }) }}
                        />

                        <RangeControl
                            label={__('Number Of Post', 'Skillate-core')}
                            value={numbers}
                            onChange={(value) => { setAttributes({ numbers: value }) }}
                            min={1}
                            max={20}
                        />

                        {/* <SelectControl
                            // multiple
                            label={ __('Category')}
                            value={selectedCategory}
                            options={this.state.categories}
                            onChange={(value) => setAttributes({ selectedCategory: value })}
                        />   */}

                        <Dropdown
                            label={__('Categories', 'Skillate-core')}
                            enableSearch
                            defaultOptionsLabel="All"
                            options={this.state.categories}
                            value={selectedCategory}
                            onChange={(value) => setAttributes({ selectedCategory: value.length !== 0 && value[value.length - 1].value === "all" ? [] : value })}
                        />
                        <SelectControl
                            label={__('Order', 'Skillate-core')}
                            value={order}
                            options={[
                                { label: 'ASC', value: 'asc' },
                                { label: 'DESC', value: 'desc' },
                            ]}
                            onChange={(value) => { setAttributes({ order: value }) }}
                        />
                        <SelectControl
                            label={__('Orderby', 'Skillate-core')}
                            value={orderby}
                            options={[
                                { label: 'Date', value: 'date' },
                                { label: 'ID', value: 'ID' },
                                { label: 'Title', value: 'title' },
                                { label: 'Random', value: 'rand' },
                                { label: 'Modified', value: 'modified' },
                                { label: 'Name', value: 'name' },
                            ]}
                            onChange={(value) => { setAttributes({ orderby: value }) }}
                        />
                        <RangeControl
                            label={__('Offset', 'Skillate-core')}
                            value={offset}
                            onChange={(value) => { setAttributes({ offset: value }) }}
                            min={0}
                            max={20}
                        />
                        <TextControl
                            label={__('Include (Course ID Ex. 29,20)', 'Skillate-core')}
                            value={include}
                            onChange={val => setAttributes({ include: val })}
                        />
                        <TextControl
                            label={__('Exclude (Course ID Ex. 29,20)', 'Skillate-core')}
                            value={exclude}
                            onChange={val => setAttributes({ exclude: val })}
                        />
                    </PanelBody>

                    <PanelBody title={__('Title', 'Skillate-core')} initialOpen={false}>
                        <Toggle
                            label={__('Disable Title', 'Skillate-core')}
                            value={enableTitle}
                            onChange={value => setAttributes({ enableTitle: value })}
                        />
                        {enableTitle &&
                            <Fragment>
                                <Typography
                                    label={__('Typography', 'Skillate-core')}
                                    value={typographyTitle}
                                    onChange={(value) => setAttributes({ typographyTitle: value })}
                                    disableLineHeight
                                    device={device}
                                    onDeviceChange={value => this.setState({ device: value })}
                                />
                                <Color
                                    label={__('Color', 'Skillate-core')}
                                    value={titleColor}
                                    onChange={value => setAttributes({ titleColor: value })}
                                />
                                <Color
                                    label={__('Hover Color', 'Skillate-core')}
                                    value={titleHoverColor}
                                    onChange={value => setAttributes({ titleHoverColor: value })}
                                />
                            </Fragment>
                        }
                    </PanelBody>

                    <PanelBody title={__('Meta', 'Skillate-core')} initialOpen={false}>
                        <Toggle
                            label={__('Disable Meta', 'Skillate-core')}
                            value={enableMeta}
                            onChange={value => setAttributes({ enableMeta: value })}
                        />
                        {enableMeta &&
                            <Fragment>
                                <Typography
                                    label={__('Typography', 'Skillate-core')}
                                    value={typographyMeta}
                                    onChange={(value) => setAttributes({ typographyMeta: value })}
                                    disableLineHeight
                                    device={device}
                                    onDeviceChange={value => this.setState({ device: value })}
                                />
                                <Color
                                    label={__('Color', 'Skillate-core')}
                                    value={metaColor}
                                    onChange={value => setAttributes({ metaColor: value })}
                                />
                            </Fragment>
                        }
                    </PanelBody>

                    <PanelBody title={__('Price', 'Skillate-core')} initialOpen={false}>
                        <Toggle
                            label={__('Disable Price', 'Skillate-core')}
                            value={enablePrice}
                            onChange={value => setAttributes({ enablePrice: value })}
                        />
                        {enablePrice &&
                            <Fragment>
                                <Typography
                                    label={__('Typography', 'Skillate-core')}
                                    value={typographyPrice}
                                    onChange={(value) => setAttributes({ typographyPrice: value })}
                                    disableLineHeight
                                    device={device}
                                    onDeviceChange={value => this.setState({ device: value })}
                                />
                                <Color
                                    label={__('Color', 'Skillate-core')}
                                    value={priceColor}
                                    onChange={value => setAttributes({ priceColor: value })}
                                />
                                <Color
                                    label={__('Arrow Color', 'Skillate-core')}
                                    value={arrowColor}
                                    onChange={value => setAttributes({ arrowColor: value })}
                                />
                                <Color
                                    label={__('Arrow Hover Color', 'Skillate-core')}
                                    value={arrowHoverColor}
                                    onChange={value => setAttributes({ arrowHoverColor: value })}
                                />
                                <Color
                                    label={__('Arrow Hover Background', 'Skillate-core')}
                                    value={arrowHoverBg}
                                    onChange={(value) => setAttributes({ arrowHoverBg: value })}
                                />
                            </Fragment>
                        }
                    </PanelBody>

                    <PanelBody title={__('Rating', 'Skillate-core')} initialOpen={false}>
                        <Toggle
                            label={__('Disable Rating', 'Skillate-core')}
                            value={enableRating}
                            onChange={value => setAttributes({ enableRating: value })}
                        />
                        {enableRating &&
                            <Fragment>
                                <Color
                                    label={__('Color', 'Skillate-core')}
                                    value={ratingColor}
                                    onChange={value => setAttributes({ ratingColor: value })}
                                />
                            </Fragment>
                        }
                    </PanelBody>

                    <PanelBody title={__('Overlay', 'Skillate-core')} initialOpen={false}>
                        <Toggle
                            label={__('Disable Wishlist', 'Skillate-core')}
                            value={enableWishlist}
                            onChange={value => setAttributes({ enableWishlist: value })}
                        />
                        <Toggle
                            label={__('Disable Profile', 'Skillate-core')}
                            value={enableProfile}
                            onChange={value => setAttributes({ enableProfile: value })}
                        />
                        <Color
                            label={__('Background', 'Skillate-core')}
                            value={bgHoverColor}
                            onChange={(value) => setAttributes({ bgHoverColor: value })}
                        />
                    </PanelBody>

                    <PanelBody title={__('Load More', 'Skillate-core')} initialOpen={false}>
                        <Toggle
                            label={__('Disable Load More', 'Skillate-core')}
                            value={enableLoadMore}
                            onChange={value => setAttributes({ enableLoadMore: value })}
                        />
                        {enableLoadMore &&
                            <Fragment>
                                <Typography
                                    label={__('Typography', 'Skillate-core')}
                                    value={typography}
                                    onChange={(value) => setAttributes({ typography: value })}
                                    disableLineHeight
                                    device={device}
                                    onDeviceChange={value => this.setState({ device: value })}
                                />
                                <Color
                                    label={__('Button Color', 'Skillate-core')}
                                    value={buttonColor}
                                    onChange={value => setAttributes({ buttonColor: value })}
                                />
                                <Color
                                    label={__('Button Hover Color', 'Skillate-core')}
                                    value={buttonHoverColor}
                                    onChange={value => setAttributes({ buttonHoverColor: value })}
                                />
                                <Color
                                    label={__('Button Background', 'Skillate-core')}
                                    value={buttonBg}
                                    onChange={value => setAttributes({ buttonBg: value })}
                                />
                                <Color
                                    label={__('Button Hover Background', 'Skillate-core')}
                                    value={buttonHoverBg}
                                    onChange={value => setAttributes({ buttonHoverBg: value })}
                                />
                            </Fragment>
                        }
                    </PanelBody>
                </InspectorControls>
                {(courses && courses.length) ?
                    <Fragment>
                        {courses &&
                            <div className={`qubely-block-${uniqueId}`}>
                                <div className={`course-container layout-${layout}`}>
                                    <div className="skillate-course row">
                                        {courses.map(course => {
                                            // console.log(course,'course')
                                            if (layout == 1) {

                                                output = <div className={`tutor-course-grid-item col-md-${columns}`}>
                                                    <div className="tutor-course-grid-content">

                                                        <div className="tutor-course-overlay">
                                                            {course.image.portrait[0] &&
                                                                <img src={course.image.portrait[0]} className="img-responsive" alt={course.name} />
                                                            }
                                                            <div className="tutor-course-grid-level-wishlist">
                                                                <span className="tutor-course-grid-wishlist tutor-course-wishlist">
                                                                    {enableWishlist &&
                                                                        <a href="javascript:;" className="tutor-icon-fav-line tutor-course-wishlist-btn" data-course-id="376"></a>
                                                                    }
                                                                    {enableProfile && course.authoravatar &&
                                                                        <a href="" className="tutor-course-author-thumb">
                                                                            <img src={course.authoravatar} className="tutor-image-avatar" alt={course.authorname} />
                                                                        </a>
                                                                    }
                                                                </span>
                                                            </div>
                                                            <div className="tutor-course-grid-enroll"><a href="#" className="btn btn-classic btn-no-fill">View Details</a></div>
                                                        </div>

                                                        <div className="tutor-course-content">
                                                            {enableRating &&
                                                                <div className="tutor-loop-rating-wrap ">
                                                                    <span dangerouslySetInnerHTML={{ __html: course.rating }} />
                                                                </div>
                                                            }
                                                            {enableTitle &&
                                                                <h3 className="tutor-courses-grid-title"><a href="">{course.name}</a></h3>
                                                            }
                                                            {enableMeta &&
                                                                <div className="course-info">
                                                                    <ul className="category-list">
                                                                        <li><span>By </span></li>
                                                                        <li><a href="#">{course.authorname}</a></li>
                                                                        {course.category_name &&
                                                                            <Fragment>
                                                                                <li><span> in </span></li>
                                                                                <li><a href="">{course.category_name.course_category}</a></li>
                                                                            </Fragment>
                                                                        }
                                                                    </ul>
                                                                </div>
                                                            }
                                                        </div>
                                                        <div className="tutor-courses-grid-price">
                                                            <span dangerouslySetInnerHTML={{ __html: course.price }} />
                                                            <a className="course-detail" href="#"><i className="fas fa-arrow-right"></i></a>
                                                        </div>

                                                        {/* <h4>{course.name}</h4> */}
                                                        {/* <img src={course.image.portrait[0]} alt={course.name}/>
                                            <div dangerouslySetInnerHTML={ { __html: course.price } } />
                                            <div dangerouslySetInnerHTML={ { __html: course.cart } } />
                                            <div dangerouslySetInnerHTML={ { __html: course.wishlist } } />
                                            <div dangerouslySetInnerHTML={ { __html: course.rating } } /> */}
                                                    </div>
                                                </div>
                                                return output

                                            } else {

                                                output = (count == 0) ? (
                                                    <div className="col-md-12">
                                                        <div className="row">
                                                            <div className="tutor-course-grid-item col-md-6">
                                                                <div className="tutor-course-grid-content">
                                                                    <div className="tutor-course-overlay">
                                                                        {course.image.portrait[0] &&
                                                                            <img src={course.image.portrait[0]} className="img-responsive" alt={course.name} />
                                                                        }
                                                                        <div className="tutor-course-grid-enroll">
                                                                            <a href="#" className="btn btn-classic btn-no-fill">View Details</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div className="tutor-course-content col-md-6">
                                                                {enableTitle &&
                                                                    <h3 className="tutor-courses-grid-title"><a href="">{course.name}</a></h3>
                                                                }
                                                                {enableMeta &&
                                                                    <div className="course-info">
                                                                        <ul>
                                                                            <li>
                                                                                <a href="#">
                                                                                    {/* <span dangerouslySetInnerHTML={{ __html: course.skillate_author.tutor_author }} />   */}
                                                                                    {course.authoravatar &&
                                                                                        <img src={course.authoravatar} className="tutor-image-avatar" />
                                                                                    }
                                                                                    {course.authorname}
                                                                                </a>
                                                                            </li>
                                                                            <li><span className="course-level">{course.level}</span></li>
                                                                            <li><span className="course-duration">{course.courseduration}</span></li>
                                                                        </ul>
                                                                    </div>
                                                                }
                                                                <p>{course.excerpt}</p>
                                                                <div className="tutor-courses-grid-price">
                                                                    {enablePrice &&
                                                                        <span dangerouslySetInnerHTML={{ __html: course.price }} />
                                                                    }
                                                                    {enableRating &&
                                                                        <div className="tutor-star-rating-group">
                                                                            <span dangerouslySetInnerHTML={{ __html: course.rating }} />
                                                                        </div>
                                                                    }
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                ) : (
                                                        <div className={`tutor-course-grid-item col-md-${columns}`}>
                                                            <div className="tutor-course-grid-content">
                                                                <div className="tutor-course-overlay">
                                                                    {course.image.portrait[0] &&
                                                                        <img src={course.image.portrait[0]} className="img-responsive" alt={course.name} />
                                                                    }
                                                                    {enableWishlist &&
                                                                        <div className="tutor-course-grid-level-wishlist">
                                                                            <span className="tutor-course-grid-wishlist tutor-course-wishlist">
                                                                                <a href="javascript:;" className="tutor-icon-fav-line tutor-course-wishlist-btn" data-course-id="376"></a>
                                                                            </span>
                                                                        </div>
                                                                    }
                                                                    <div className="tutor-course-grid-enroll"><a href="#" className="btn btn-classic btn-no-fill">View Details</a></div>
                                                                </div>
                                                                <div className="tutor-course-content">
                                                                    <div className="tutor-courses-grid-price">
                                                                        <span dangerouslySetInnerHTML={{ __html: course.price }} />
                                                                    </div>
                                                                    <h3 className="tutor-courses-grid-title"><a href="">{course.name}</a></h3>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    );
                                                count++;
                                                return output;
                                            }

                                        })}
                                        {enableLoadMore &&
                                            <div className="col-md-12">
                                                <a className="view-all-course" href="#">View all Courses</a>
                                            </div>
                                        }
                                    </div>
                                </div>
                            </div>
                        }
                    </Fragment>
                    :
                    <div className="qubely-postgrid-is-loading">
                        <Spinner />
                    </div>
                }
            </Fragment>
        )
    }
}

export default Edit
