const { __ } = wp.i18n;
const { InspectorControls } = wp.editor;
const { Component, Fragment } = wp.element;
const { SelectControl, RangeControl, PanelBody, Spinner } = wp.components;
const { addQueryArgs } = wp.url;
const { apiFetch } = wp;
const { Toggle, Typography, Color, CssGenerator: { CssGenerator } } = wp.qubelyComponents

let skillateGetTutorCourses = null;

class Edit extends Component {
    constructor(props) {
        super(props)
        this.state = {
            device: 'md',
            users: [],
        }
        this.skillateGetTutorCourses = this.skillateGetTutorCourses.bind( this );
    }
 
    componentDidMount() {
        const { setAttributes, clientId, attributes: { uniqueId } } = this.props
        const _client = clientId.substr(0, 6)
		if (!uniqueId) {
			setAttributes({ uniqueId: _client });
		} else if (uniqueId && uniqueId != _client) {
			setAttributes({ uniqueId: _client });
        }
        let usersProfile = [];
        apiFetch( { path: '/wp/v2/users/?role=tutor_instructor' } ).then( users => {
            $.each(users, function (key, value) {
                usersProfile.push({ value: value.id, name: value.name, link: value.link, avatar_urls: value.avatar_urls });
            });
            return usersProfile;
        } );
        this.setState({ usersProfile: usersProfile })
        this.skillateGetTutorCourses();
    }

    componentDidUpdate( prevProps ) {
        if (this.checkAttrChanged( prevProps.attributes, this.props.attributes )) {
            this.skillateGetTutorCourses()
        }    
    }

    checkAttrChanged( prevAttrs, curAttrs ) {
        const {
            numbers: prevNumberOfcourses,
            order:  prevOrder,
        } = prevAttrs;
        const { numbers, order } = curAttrs;

        return (
            numbers !== prevNumberOfcourses || order !== prevOrder
        )
    }

    skillateGetTutorCourses(){
        const {
            numbers, 
            order
        } = this.props.attributes;
		apiFetch({
			path: addQueryArgs('/wp/v2/users/?role=tutor_instructor', {
                per_page: numbers,
                order: order
            }),
        })
        .then( ( users ) => {
            this.setState( { users: users, loading: false } );
        })
        .catch( () => {
            this.setState({ users: [], loading: true });
        });
    }
    
    render() {
        const { users } = this.state
        const {
			setAttributes,
			attributes: {
                uniqueId,
                layout,
                columns, 
                // slidercolumns,
                numbers, 
                order, 
                enableTitle,
                typographyTitle,
                titleColor,
                titleHoverColor,
                enableRating, ratingtypography, ratingColor, starColor,
                enableCourse, coursetypography, courseColor, digiteColor
            } 
        } = this.props

        const { device } = this.state
        if (uniqueId) { CssGenerator(this.props.attributes, 'upskill-course-author', uniqueId); }

        let output = '';
        return ( 
            <Fragment>
                <InspectorControls key="inspector">
                    <PanelBody title={__('Profile Settings', 'Skillate-core')} initialOpen={true}>    
                            <SelectControl
                                label={__('Select Layout', 'Skillate-core')}
                                value={layout}
                                options={[
                                    { label: __('Grid View', 'Skillate-core'), value: 1 },
                                    { label: __('Slider View', 'Skillate-core'), value: 2 },
                                ]}
                                onChange={value => setAttributes({ layout: value })}
                            />

                            <SelectControl
                                label= {__('Select Column', 'Skillate-core')}
                                value={columns}
                                options={[
                                    { label: __('1', 'Skillate-core'), value: '12' },
                                    { label: __('2', 'Skillate-core'), value: '6' },
                                    { label: __('3', 'Skillate-core'), value: '4' },
                                    { label: __('4', 'Skillate-core'), value: '3' },
                                    { label: __('6', 'Skillate-core'), value: '2' },
                                ]}
                                onChange={(value) => { setAttributes({ columns: value }) }}
                            />
                            
                            {layout == 1 &&
                                <SelectControl
                                    label={__('Post Order', 'Skillate-core')}
                                    value={order}
                                    options={[
                                        { label: 'ASC', value: 'asc' },
                                        { label: 'DESC', value: 'desc' },
                                    ]}
                                    onChange={(value) => { setAttributes({ order: value }) }}
                                />
                            }
                        <RangeControl
                            label={__('Number Of Post', 'Skillate-core')}
                            value={numbers}
                            onChange={(value) => { setAttributes({ numbers: value }) }}
                            min={1}
                            max={20}
                        />
                    </PanelBody> 

                    <PanelBody title={__('Author Name', 'Skillate-core')} initialOpen={false}>   
                        <Toggle 
                            label={__('Disable Name', 'Skillate-core')} 
                            value={enableTitle} 
                            onChange={value => setAttributes({ enableTitle: value })} 
                        />
                        { enableTitle &&
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
                                    onChange={(value) => setAttributes({ titleColor: value }) } />
                                <Color 
                                    label={__('Hover Color', 'Skillate-core')} 
                                    value={titleHoverColor} 
                                    onChange={value => setAttributes({ titleHoverColor: value })} 
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

                        { enableRating &&
                            <Fragment>
                                <Color 
                                    label={__('Start Color', 'Skillate-core')} 
                                    value={starColor} 
                                    onChange={(value) => setAttributes({ starColor: value }) } />
                                <Typography
                                    label={__('Digite Typography', 'Skillate-core')}
                                    value={ratingtypography}
                                    onChange={(value) => setAttributes({ ratingtypography: value })}
                                    disableLineHeight
                                    device={device}
                                    onDeviceChange={value => this.setState({ device: value })}
                                />
                                <Color 
                                    label={__('Digit Color', 'Skillate-core')} 
                                    value={ratingColor} 
                                    onChange={(value) => setAttributes({ ratingColor: value }) } />
                            </Fragment>
                        }
                    </PanelBody>

                    <PanelBody title={__('Course Count', 'Skillate-core')} initialOpen={false}>   
                        <Toggle 
                            label={__('Disable Count', 'Skillate-core')} 
                            value={enableCourse} 
                            onChange={value => setAttributes({ enableCourse: value })} 
                        />
                        { enableCourse &&
                            <Fragment>
                                <Typography
                                    label={__('Typography', 'Skillate-core')}
                                    value={coursetypography}
                                    onChange={(value) => setAttributes({ coursetypography: value })}
                                    disableLineHeight
                                    device={device}
                                    onDeviceChange={value => this.setState({ device: value })}
                                />
                                <Color 
                                    label={__('Digite Color', 'Skillate-core')} 
                                    value={digiteColor} 
                                    onChange={(value) => setAttributes({ digiteColor: value }) } />
                                <Color 
                                    label={__('Text Color', 'Skillate-core')} 
                                    value={courseColor} 
                                    onChange={(value) => setAttributes({ courseColor: value }) } />
                            </Fragment>
                        }  
                    </PanelBody>
                </InspectorControls>


                { (users && users.length) ?
                    <Fragment>
                        { users &&
                            <div className={`qubely-block-${uniqueId}`}>
                                <div className={`course-container`}>
                                    { layout == 1 ? 
                                        <div className="skillate-course row">
                                            { users.map(user => {
                                                output = <div className={`col-md-${columns}`}>
                                                    <div className="skillate-instructor-content">
                                                        <div className="skillate-instructor-thumb">
                                                            <img src={user.avatar_urls[96]} />
                                                            {enableRating && 
                                                                <span className="rating-avg"><i className="fas fa-star"></i><strong>4.32</strong>/5</span>
                                                            }
                                                            
                                                        </div>
                                                        <div className="upskil-instructor-content">
                                                            { enableTitle &&
                                                                <h3 className="instructor-name">{user.name}</h3>
                                                            }
                                                            { enableCourse &&
                                                                <p className="instructor-course-count"><strong>10</strong>Courses</p>
                                                            }
                                                        </div>
                                                    </div>
                                                </div>
                                                return output
                                            })} 

                                        </div>
                                        :
                                        <div className="skillate-course row slider">
                                            <div className="qubely-block-team-carousel qubely-layout-style">
                                                <div className="qubely-carousel qubely-carousel-wrapper author-slide-parent" items="4" margin="30" arrowstyle="arrowright2">
                                                    <div className="qubely-carousel-extended-list">
                                                        <div className="qubely-carousel-extended-outer-stage">
                                                            { users.map(user => {
                                                                output = <div className={`qubely-carousel-item col-${columns}`}>
                                                                    <div className="single-instructor-slide">
                                                                        <div className="skillate-instructor-content">
                                                                            <div className="skillate-instructor-thumb">
                                                                                <img src={user.avatar_urls[96]} />
                                                                                {enableRating && 
                                                                                    <span className="rating-avg"><i className="fas fa-star"></i><strong>4.32</strong>/5</span>
                                                                                }
                                                                            </div>
                                                                            <div className="upskil-instructor-content">
                                                                                { enableTitle &&
                                                                                    <h3 className="instructor-name">{user.name}</h3>
                                                                                }
                                                                                { enableCourse &&
                                                                                    <p className="instructor-course-count"><strong>10</strong>Courses</p>
                                                                                }
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                return output
                                                            })}
                                                        </div>
                                                    </div>

                                                    <div class="qubely-carousel-nav-control">
                                                        <span class="next-control nav-control [object Object]">
                                                            <span class="fas fa-angle-right"></span>
                                                        </span>
                                                        <span class="prev-control nav-control [object Object]">
                                                            <span class="fas fa-angle-left"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    }
                                </div> 
                            </div> //row
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