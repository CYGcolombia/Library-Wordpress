const { __ } = wp.i18n;
const { withSelect } = wp.data;
const { InspectorControls } = wp.editor;
const { Component, Fragment } = wp.element;
const { SelectControl, RangeControl, PanelBody, Spinner, TextControl } = wp.components;
const { addQueryArgs } = wp.url;
const { apiFetch } = wp;
const {
    Color,
    Padding,
    Dropdown,
    Range,
    Typography,
    Toggle,
    Border,
    CssGenerator: { CssGenerator }
} = wp.qubelyComponents


class Edit extends Component {
    constructor(props) {
        super(props)
        this.state = {
            categories: [],
            courses: []
        }
        this.skillateCourseCategory = this.skillateCourseCategory.bind( this );
    }

    componentDidMount() {
        const { setAttributes, clientId, courses, cat, attributes: { uniqueId } } = this.props
        const _client = clientId.substr(0, 6)
		if (!uniqueId) {
			setAttributes({ uniqueId: _client });
		} else if (uniqueId && uniqueId != _client) {
			setAttributes({ uniqueId: _client });
        }
        
        let postSelections = [];
        wp.apiFetch({ path: "/skillateapi/v2/category" }).then(cat => {
            postSelections.push({ value: __('all', 'Skillate-core'), label: __('Select Categories', 'Skillate-core')});
            $.each(cat, function (key, val) {
                postSelections.push({ value: val.slug, label: val.name });
            });
            return postSelections;
        });
        this.setState({ categories: postSelections })
        this.skillateCourseCategory();
    }

    componentDidUpdate( prevProps ) {
        if (this.checkAttrChanged( prevProps.attributes, this.props.attributes )) {
            this.skillateCourseCategory();
        }    
    }

    checkAttrChanged( prevAttrs, curAttrs ) {
        const {
            selectedCategory:  prevCategories,
        } = prevAttrs;
        const { selectedCategory } = curAttrs;
        return (
            selectedCategory   !== prevCategories
        )
    }

    skillateCourseCategory(){
        const {
            selectedCategory
        } = this.props.attributes;
		apiFetch({
			path: addQueryArgs( '/skillateapi/v2/categories', {
                skillate_cat: selectedCategory
            }),
        })
        .then( ( courses ) => {
            this.setState( { courses: courses, loading: false } );
        })
        .catch( () => {
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
                selectedCategory,
                BgPadding, 
                categoryBgColor,
                categoryHoverBg,
                categoryColor,
                categoryHoverColor,
                enableImage,
                imageWidth,
                brightness,
                brightnessHover,
                enableTitle,
                categoryTypography,
                marginTop,

                enableButton, 
                buttontypography, 
                buttonColor, 
                buttonHoverColor, 
                buttonBg, 
                buttonHoverBg,
                buttonurl,
                buttonBorder,


            }, setAttributes 
        } = this.props

        const { device } = this.state

        if (uniqueId) { CssGenerator(this.props.attributes, 'upskill-tutor-course-category', uniqueId) }

        let output = '';
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
                                { label: __('Layout 3', 'Skillate-core'), value: 3 },
							]}
							onChange={value => setAttributes({ layout: value })}
						/>
                        {categories && <Dropdown
                            label={ __('Categories', 'Skillate-core')}
                            enableSearch
                            defaultOptionsLabel="All"
                            options={this.state.categories}
                            value={selectedCategory}
                            onChange={(value) => setAttributes({ selectedCategory: value })}
                        />
                        }
                        { (layout != 3)  &&
                        <SelectControl
                            label= {__('Select Column', 'Skillate-core')}
                            value={columns}
                            options={[
                                { label: __('1', 'Skillate-core'), value: '12' },
                                { label: __('2', 'Skillate-core'), value: '6' },
                                { label: __('3', 'Skillate-core'), value: '4' },
                                { label: __('4', 'Skillate-core'), value: '3' },
                            ]}
                            onChange={(value) => { setAttributes({ columns: value }) }}
                        />
                        }
                    </PanelBody>
                    
                    <PanelBody title={__('Design', 'Skillate-core')} initialOpen={false}>    
                        <Color 
                            label={__('Background Color', 'Skillate-core')}  
                            value={categoryBgColor} 
                            onChange={val => setAttributes({ categoryBgColor: val })} 
                        />
                        <Color 
                            label={__('Background Hover Color', 'Skillate-core')}  
                            value={categoryHoverBg} 
                            onChange={val => setAttributes({ categoryHoverBg: val })} 
                        />
                        <Padding 
                            label={__('Padding', 'Skillate-core')} 
                            value={BgPadding} 
                            onChange={val => setAttributes({ BgPadding: val })} 
                            min={0} max={200} unit={['px', 'em', '%']} 
                            responsive device={device} onDeviceChange={value => this.setState({ device: value })} 
                        />
                    </PanelBody>

                    <PanelBody title={__('Image', 'Skillate-core')} initialOpen={false}>
                        <Toggle 
                            label={__('Disable Image', 'Skillate-core')} 
                            value={enableImage} 
                            onChange={value => setAttributes({ enableImage: value })} 
                        />
                        <Range 
                            label={__('Image Width', 'Skillate-core')} 
                            value={imageWidth} 
                            onChange={val => setAttributes({ imageWidth: val })} 
                            min={0} max={400} unit={['px', 'em', '%']} 
                            responsive device={device} 
                            onDeviceChange={value => this.setState({ device: value })} 
                        />
                        <Range 
                            label={__('Brightness', 'Skillate-core')} 
                            value={brightness} 
                            onChange={val => setAttributes({ brightness: val })} 
                            min={0} max={1}
                            responsive device={device} 
                            onDeviceChange={value => this.setState({ device: value })} 
                        />
                        <Range 
                            label={__('Brightness over', 'Skillate-core')} 
                            value={brightnessHover} 
                            onChange={val => setAttributes({ brightnessHover: val })} 
                            min={0} max={1}
                            responsive device={device} 
                            onDeviceChange={value => this.setState({ device: value })} 
                        />
                    </PanelBody>
                    
                    <PanelBody title={__('Title', 'Skillate-core')} initialOpen={false}>
                        <Toggle 
                            label={__('Disable Title', 'Skillate-core')} 
                            value={enableTitle} 
                            onChange={value => setAttributes({ enableTitle: value })} 
                        />
                        <Typography label={__('Typography', 'Skillate-core')} value={categoryTypography} onChange={value => setAttributes({ categoryTypography: value })} device={device} onDeviceChange={value => this.setState({ device: value })} />
                        <Color label={__('Color', 'Skillate-core')} value={categoryColor} onChange={value => setAttributes({ categoryColor: value })} />
                        <Color label={__('Hover Color', 'Skillate-core')} value={categoryHoverColor} onChange={value => setAttributes({ categoryHoverColor: value })} />
                        { (layout == 2) &&
                            <Range 
                                label={__('Margin Top', 'Skillate-core')} 
                                value={marginTop} 
                                onChange={val => setAttributes({ marginTop: val })} 
                                min={0} max={2000} unit={['px', 'em', '%']} 
                                responsive device={device} 
                                onDeviceChange={value => this.setState({ device: value })} 
                            />
                        }
                    </PanelBody>

                    { layout == 2 &&
                        <PanelBody title={__('Category Button', 'Skillate-core')} initialOpen={false}>
                            <Toggle 
                                label={__('Disable Button', 'Skillate-core')} 
                                value={enableButton} 
                                onChange={value => setAttributes({ enableButton: value })} 
                            />
                            {enableButton &&
                                <Fragment>
                                    
                                    <TextControl label="Button URL" value={buttonurl} onChange={(buttonurl) => setAttributes({ buttonurl })} />
                                    
                                    <Typography
                                        label={__('Typography', 'Skillate-core')}
                                        value={buttontypography}
                                        onChange={(value) => setAttributes({ buttontypography: value })}
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
                                    <Border 
                                        label={__('Border', 'Skillate-core')} 
                                        value={buttonBorder} 
                                        onChange={val => setAttributes({ buttonBorder: val })} 
                                        min={0} max={10} unit={['px', 'em', '%']} 
                                        responsive device={device} 
                                        onDeviceChange={value => this.setState({ device: value })} 
                                    />
                                </Fragment>
                            }
                        </PanelBody>
                    }
                    
                </InspectorControls>
                { (courses && courses.length) ?
                    <Fragment>
                        { courses &&
                            <div className={`qubely-block-${uniqueId}`}>
                                
                                <div className={`row`}>
                                    { courses.map(course => { 
                                        course.term_id && <Fragment>
                                        { (layout == 1 || layout == 2) ?
                                            output = <div className={`tutor-course-grid-item col-md-${columns} col-6`}>
                                                <div className={`skillate-cat-layout-${layout}`}>
                                                    {layout == 1 ?
                                                        <div className="skillate-course-category-list">
                                                            <div className="row align-items-center">
                                                                { enableImage && 
                                                                    <div className="cat-image col-sm-4 col-12" dangerouslySetInnerHTML={{ __html: course.image_link }} /> 
                                                                }
                                                                { enableTitle &&
                                                                    <div className="course-cat-link col-sm-5 col-9 course-category"><a href="#">{ course.name  }</a></div>
                                                                }
                                                                <div className="course-count col-sm-3 col-3">{ course.count  }</div> 
                                                            </div>
                                                        </div>
                                                        :
                                                        <div className="skillate-course-category-list">
                                                            { enableImage && 
                                                                <div className="cat-image" dangerouslySetInnerHTML={{ __html: course.image_link }} />  
                                                            }
                                                            { enableTitle &&
                                                                <span><a href="#">{ course.name  }</a></span>
                                                            }
                                                        </div>
                                                    }
                                                </div>
                                            </div> // tutor-courses-grid-items
                                            :
                                            output = <div className={`tutor-course-grid-item col-md-12 col-6`}>
                                                <div className={`skillate-cat-layout-${layout}`}>
                                                    <div className="skillate-course-category-list">
                                                        { enableImage && 
                                                            <div className="cat-image" dangerouslySetInnerHTML={{ __html: course.image_link }} />  
                                                        }
                                                        { enableTitle &&
                                                            <span><a href="#">{ course.name  }</a></span>
                                                        }
                                                    </div>
                                                </div>
                                            </div>
                                        }
                                        </Fragment>
                                        return output
                                    })} 

                                    {layout == 2 && 
                                        <div class="col-md-12 category-btn enable">
                                            <div class="all-category">
                                                <a href="#" class="view-all-category">View all Categories</a>
                                            </div>
                                        </div>
                                    }
                                </div>
                            </div> //row
                        }
                    </Fragment>
                    :
                    <div className="qubely-postgrid-is-loading">
                        <Spinner /> <span>Please select one or more categories from the dropdown in the settings panel.</span>
                    </div>
                }
                {/* {!courses && <Spinner />} */}
            </Fragment>
        )
    }
}
export default Edit
// export default withSelect((select, props) => {
//     const { attributes: { numbers, order } } = props
//     const { getEntityRecords } = select('core')
//     const output = ({courses: getEntityRecords('postType', 'courses', { per_page: numbers, order: order, status: 'publish', }) }) 
//     return output; 
// })
// (Edit)
