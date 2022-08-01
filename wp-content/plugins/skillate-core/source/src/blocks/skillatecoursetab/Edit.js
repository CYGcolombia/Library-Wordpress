const { __ } = wp.i18n;
const { withSelect, dateI18n, format } = wp.data;
const { RichText, InspectorControls } = wp.editor;
const { Component, Fragment } = wp.element;
const { SelectControl, RangeControl, PanelBody, Spinner } = wp.components;
const { addQueryArgs } = wp.url;
const { apiFetch } = wp;

const {
    Toggle,
    Typography,
    Color,
    Dropdown,
    CssGenerator: { CssGenerator }
} = wp.qubelyComponents

class Edit extends Component {

    // constructor(props) {
    //     super(props)
    //     this.state = {
    //         categories: [], 
    //         courses: [],
    //     }  
    // } 

    constructor(props) {
        super(props)
        this.state = {
            categories: [],
            courses: []
        }
        this.skillateCourselisting2 = this.skillateCourselisting2.bind( this );
    }


    componentDidMount(){
        const { cat, courses, setAttributes, clientId, attributes: { uniqueId } } = this.props
        let postSelections = [];
        wp.apiFetch({ path: "/skillateapi/v2/category" }).then(cat => {
            postSelections.push({ value: __(''), label: __('') });
            $.each(cat, function (key, val) {
                postSelections.push({ value: val.term_id, label: val.name });
            });
            return postSelections;
        });
        this.setState({ categories: postSelections })
        this.skillateCourselisting2();

        const _client = clientId.substr(0, 6)
        if (!uniqueId) {
            setAttributes({ uniqueId: _client });
        } else if (uniqueId && uniqueId != _client) {
            setAttributes({ uniqueId: _client });
        }
    }

    componentDidUpdate( prevProps ) {
        if (this.checkAttrChanged( prevProps.attributes, this.props.attributes )) {
            this.skillateCourselisting2();
        }    
    }
    checkAttrChanged( prevAttrs, curAttrs ) {
        const {
            // selectedCategory:  prevCategories,
            order:  prevOrder,
            offset:  prevOffset,
            orderby:  prevOrderby,
            // include:  prevInclude,
            // exclude:  prevExclude,
            numbers:  prevNumber
        } = prevAttrs;
        const { selectedCategory,numbers,order, orderby, offset, include, exclude } = curAttrs;
        return (
            // selectedCategory   !== prevCategories
            order !== prevOrder
            || offset !== prevOffset
            || orderby !== prevOrderby
            // || include !== prevInclude
            // || exclude !== prevExclude
            || numbers !== prevNumber
        )
    }

    skillateCourselisting2(){
        const {
            numbers,
            order,
            orderby,
            offset,
            // include,
            // exclude,
            // selectedCategory
        } = this.props.attributes;
        // console.log(selectedCategory,'skillateCourselisting2')
		apiFetch({
			path: addQueryArgs( '/skillateapi/v2/courses', {
                per_page: numbers,
                order: order,
                orderby: orderby,
                offset: offset,
                // include: include,
                // exclude: exclude,
                // category: selectedCategory
            }),
        })
        .then( ( courses ) => {
            this.setState( { courses: courses, loading: false } );
        })
        .catch( () => {
            this.setState({ courses: [], loading: true });
        });
    }

     
    // componentDidMount() {

    //     const { courses, setAttributes, clientId, attributes: { uniqueId } } = this.props
    //     const _client = clientId.substr(0, 6)
    //     if (!uniqueId) {
    //         setAttributes({ uniqueId: _client });
    //     } else if (uniqueId && uniqueId != _client) {
    //         setAttributes({ uniqueId: _client });
    //     }

    //     let courseselections = [];
    //     wp.apiFetch({ path: "/wp/v2/course-category" }).then(courses => {
    //         courseselections.push({ label: __('Select All Category'), value: __('all') });
    //         $.each(courses, function (key, val) {
    //             courseselections.push({ label: val.name, value: val.id });
    //         });
    //         return courseselections;
    //     });
    //     this.setState({ categories: courseselections })

    // }




    render() {
        const { courses, categories } = this.state

        const {
            setAttributes,
            attributes: {
                uniqueId,
                columns, 
                orderby,
                offset,
                numbers, 
                order, 
                courseTabTitle,
                enableTitle,
                typographyTitle,
                titleColor,
                titleHoverColor,
                enableTabTitle,
                typographyTabTitle,
                titleTabColor,
                enablePrice,
                typographyPrice,
                priceColor,
                priceBg,
                enableBestSale,
                enableBookmark,
                overlayBg,
            },
        } = this.props
        const { device } = this.state
        
        if (uniqueId) { CssGenerator(this.props.attributes, 'upskill-course-tab', uniqueId) }

        let output = '';
        let count = 0;
        return (
            <Fragment>
                <InspectorControls key="inspector">
                    <PanelBody title={__('Course Settings', 'Skillate-core')} initialOpen={true}>    
                        {/* <SelectControl
                            label= {__('Select Column')}
                            value={columns}
                            options={[
                                { label: __('1'), value: '12' },
                                { label: __('2'), value: '6' },
                                { label: __('3'), value: '4' },
                                { label: __('4'), value: '3' },
                            ]}
                            onChange={(value) => { setAttributes({ columns: value }) }}
                        /> */}
                        <SelectControl
                            label={__('Post Order', 'Skillate-core')}
                            value={order}
                            options={[
                                { label: 'ASC', value: 'asc' },
                                { label: 'DESC', value: 'desc' },
                            ]}
                            onChange={(value) => { setAttributes({ order: value }) }}
                        />
                        <RangeControl
                            label={__('Number Of Post', 'Skillate-core')}
                            value={numbers}
                            onChange={(value) => { setAttributes({ numbers: value }) }}
                            min={1}
                            max={20}
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
                    </PanelBody>

                    <PanelBody title={__('Tab Title', 'Skillate-core')} initialOpen={false}>   
                        <Toggle 
                            label={__('Disable Tab Title', 'Skillate-core')} 
                            value={enableTabTitle} 
                            onChange={value => setAttributes({ enableTabTitle: value })} 
                        />
                        { enableTabTitle &&
                            <Fragment>
                                <Typography
                                    label={__('Typography', 'Skillate-core')}
                                    value={typographyTabTitle}
                                    onChange={(value) => setAttributes({ typographyTabTitle: value })}
                                    device={device}
                                    onDeviceChange={value => this.setState({ device: value })}
                                />
                                <Color 
                                    label={__('Color', 'Skillate-core')} 
                                    value={titleTabColor} 
                                    onChange={value => setAttributes({ titleTabColor: value })} 
                                />
                            </Fragment>
                        }
                    </PanelBody>

                    <PanelBody title={__('Course Title', 'Skillate-core')} initialOpen={false}>   
                        <Toggle 
                            label={__('Disable Title', 'Skillate-core')} 
                            value={enableTitle} 
                            onChange={value => setAttributes({ enableTitle: value })} 
                        />
                        { enableTitle &&
                            <Fragment>
                                <Typography
                                    label={__('Typography', 'Skillate-core')}
                                    value={typographyTitle}
                                    onChange={(value) => setAttributes({ typographyTitle: value })}
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

                    <PanelBody title={__('Price', 'Skillate-core')} initialOpen={false}>   
                        <Toggle 
                            label={__('Disable Price', 'Skillate-core')} 
                            value={enablePrice} 
                            onChange={value => setAttributes({ enablePrice: value })} 
                        />
                        { enablePrice &&
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
                                label={__('Background', 'Skillate-core')} 
                                value={priceBg} 
                                onChange={(value) => setAttributes({ priceBg: value })} 
                            />          
                        </Fragment>
                        }
                    </PanelBody>

                    <PanelBody title={__('Overlay', 'Skillate-core')} initialOpen={false}>   
                        <Toggle 
                            label={__('Disable Best Sale', 'Skillate-core')} 
                            value={enableBestSale} 
                            onChange={value => setAttributes({ enableBestSale: value })} 
                        />
                        <Toggle 
                            label={__('Disable Bookmark', 'Skillate-core')} 
                            value={enableBookmark} 
                            onChange={value => setAttributes({ enableBookmark: value })} 
                        />
                        <Color 
                            label={__('Oberlay Background', 'Skillate-core')} 
                            value={overlayBg} 
                            onChange={(value) => setAttributes({ overlayBg: value })} 
                        />          
                    </PanelBody> 
            </InspectorControls>

                <section className={`skillate-courses-tab-wrapper tab-vertical qubely-block-${uniqueId}`}>
                    <div className="container">
                        <div className="tab-wrapper">
                            <div className="tab-nav-wrapper">
                                { enableTabTitle &&
                                    <div className="upskil-section-title">
                                        <RichText
                                            key="editable"
                                            tagName="span"
                                            className="course-tab-title"
                                            keepPlaceholderOnFocus
                                            placeholder={__('Add Text...', 'Skillate-core')}
                                            onChange={value => setAttributes({ courseTabTitle: value })}
                                            value={courseTabTitle} />
                                    </div>
                                }
                                { courses &&
                                    <ul className="skillate-tab-nav nav nav-tabs">
                                        { categories.map(cat => {
                                            categories && <Fragment>
                                            if(count === 0) {
                                                output = <li className="skillate-tab-nav-item"><a className="skillate-tab-nav-link active" data-toggle="tab" href="#tab-v-1">{ cat.label  }</a></li>
                                            } else {
                                                output = <li className="skillate-tab-nav-item"><a className="skillate-tab-nav-link" data-toggle="tab" href="#tab-v-2">{ cat.label }</a></li>  
                                            } count++
                                            </Fragment>
                                            return output
                                        } ) }
                                    </ul>
                                }
                            </div>
                            <div className="tab-content-wrapper">
                                <div className="tab-content">
                                    <div className="tab-pane fade show active" id="tab-v-1">
                                        <div className="skillate-related-course">
                                            <div className="skillate-related-course-items">
                                            { (courses && courses.length) ?
                                                <Fragment>
                                                    
                                                { courses &&
                                                    <div className={`row`}>
                                                        { courses.map(course => {
                                                            output =  <div className="col-md-4">
                                                                <div className="tutor-course-grid-item">
                                                                    <div className="tutor-course-grid-content">
                                                                        <div className="tutor-course-overlay">
                                                                            {course.image.portrait[0] && 
                                                                                <img src={course.image.portrait[0]} className="img-responsive" alt={course.name}/>
                                                                            }
                                                                            <div className="tutor-course-overlay-element">
                                                                                { enableBestSale && 
                                                                                    <div className="level-tag">
                                                                                        <span className="tag intermediate">Best Selling</span>
                                                                                    </div> 
                                                                                }
                                                                                { enableBookmark &&
                                                                                    <div className="bookmark">
                                                                                        <a href="javascript:;">
                                                                                            <i className="far fa-bookmark"></i>
                                                                                        </a>
                                                                                    </div>
                                                                                }
                                                                                { enablePrice &&
                                                                                    <span dangerouslySetInnerHTML={{ __html: course.price }} />    
                                                                                }
                                                                            </div>
                                                                            <div className="tutor-course-grid-enroll">
                                                                                <div className="course-related-hover-price">
                                                                                    <span dangerouslySetInnerHTML={{ __html: course.price }} />   
                                                                                </div>
                                                                                <span className="tutor-course-grid-level">{course.level}</span>
                                                                                <span className="tutor-course-duration">{course.courseduration}</span>
                                                                                <a href="" className="btn btn-classic btn-no-fill" tabindex="-1"> Enroll Now </a>
                                                                            </div>
                                                                        </div>
                                                                        { enableTitle &&
                                                                            <h3 className="tutor-courses-grid-title">
                                                                                <a href="" tabindex="-1">{course.name}</a>
                                                                            </h3>
                                                                        }
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        
                                                            return output
                                                        })} 
                                                    </div> //row
                                                }
                                                </Fragment>
                                                    :
                                                    <div className="qubely-postgrid-is-loading">
                                                        <Spinner />
                                                    </div>
                                                }
                                                {/* {!courses && <Spinner />}  */}

                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </section>

            </Fragment>
        )
    }
}

export default Edit
