const { __ } = wp.i18n;
const { InspectorControls, RichText } = wp.editor;
const { Component, Fragment } = wp.element;
const { PanelBody,SelectControl } = wp.components;

const {
    BorderRadius,
    Toggle,
    Range,
    Typography,
    Color,
    Tabs,
    Tab,
    Border,
    CssGenerator: { CssGenerator }
} = wp.qubelyComponents
 
 
class Edit extends Component {
    constructor(props) {
        super(props)
        this.state = { device: 'md', selector: true, spacer: true, openPanelSetting: '' };
    }
    componentDidMount() {
        const { setAttributes, clientId, attributes: { uniqueId } } = this.props
        const _client = clientId.substr(0, 6)
        if (!uniqueId) {
            setAttributes({ uniqueId: _client });
        } else if (uniqueId && uniqueId != _client) {
            setAttributes({ uniqueId: _client });
        }
    }

    handlePanelOpenings = (panelName) => {
        this.setState({ ...this.state, openPanelSetting: panelName })
    }

    render() {
        const {
            setAttributes,
            attributes: {
                uniqueId,
                layout,
                enableTitle,
                searchtitle,
                searchBtnText,
                inputTypography,
                inputBg,
                inputColor,
                placeholderColor,
                inputBgFocus,
                inputBorderColorFocus,
                border,
                borderRadius,
                btnTypography, 
                btnBorder, 
                btnBorderRadius, 
                buttonBgColor, 
                btnTextColor, 
                btnBgHoverColor, 
                btnTextHoverColor,
                SearchTypography,
                searchTextColor,
                titleSpacing,
            },
        } = this.props

        const { device } = this.state

        if (uniqueId) { CssGenerator(this.props.attributes, 'upskill-core-tutor-course-search', uniqueId) }

        return (
            <Fragment>
                <InspectorControls key="inspector">
                    <PanelBody title='' initialOpen={true}>
                        <SelectControl
							label={__('Select Layout', 'Skillate-core')}
							value={layout}
							options={[
								{ label: __('Layout 1', 'Skillate-core'), value: 1 },
								{ label: __('Layout 2', 'Skillate-core'), value: 2 },
							]}
							onChange={value => setAttributes({ layout: value })}
						/>
					</PanelBody>
                    <PanelBody title={__('Search Title', 'Skillate-core')} initialOpen={false}>
                        <Toggle 
                            label={__('Disable Title', 'Skillate-core')} 
                            value={enableTitle} 
                            onChange={value => setAttributes({ enableTitle: value })} 
                        />
                        { enableTitle &&
                            <Fragment>
                                <Typography
                                    label={__('Typography', 'Skillate-core')}
                                    value={SearchTypography}
                                    onChange={value => setAttributes({ SearchTypography: value })} 
                                />
                                <Color 
                                    label={__('Text Color', 'Skillate-core')} 
                                    value={searchTextColor} 
                                    onChange={value => setAttributes({ searchTextColor: value })} 
                                />
                                <Range 
                                    label={__('Spacing', 'Skillate-core')} 
                                    value={titleSpacing} 
                                    onChange={val => setAttributes({ titleSpacing: val })} 
                                    min={0} max={200} unit={['px', 'em', '%']} 
                                    responsive device={device} 
                                    onDeviceChange={value => this.setState({ device: value })} 
                                />
                            </Fragment>
                        }
                    </PanelBody>
                    <PanelBody title={__('Input', 'Skillate-core')} initialOpen={false}>
                        <Typography
                            label={__('Typography', 'Skillate-core')}
                            value={inputTypography}
                            onChange={value => setAttributes({ inputTypography: value })} 
                        />
                        {layout == 2 &&
                            <Fragment>
                                <Border 
                                    label={__('Border', 'Skillate-core')} 
                                    value={border} 
                                    onChange={val => setAttributes({ border: val })} 
                                    min={0} max={10} unit={['px', 'em', '%']} 
                                    responsive device={device} onDeviceChange={value => this.setState({ device: value })} 
                                />
                                <BorderRadius 
                                    min={0} max={100} 
                                    responsive device={device} 
                                    label={__('Border Radius', 'Skillate-core')} 
                                    value={borderRadius} unit={['px', 'em', '%']} 
                                    onChange={value => setAttributes({ borderRadius: value })} 
                                    onDeviceChange={value => this.setState({ device: value })} 
                                />
                            </Fragment>
                        }	
                        <Tabs>
                            <Tab tabTitle={__('Normal', 'Skillate-core')}>
                                { layout == 2 &&
                                    <Color label={__('Background Color', 'Skillate-core')} value={inputBg} onChange={value => setAttributes( { inputBg: value }) } />
                                }
                                <Color label={__('Input Text Color', 'Skillate-core')} value={inputColor} onChange={value => setAttributes({ inputColor: value })} />
                                <Color label={__('Placeholder Color', 'Skillate-core')} value={placeholderColor} onChange={value => setAttributes({ placeholderColor: value })} />
                            </Tab>
                            <Tab tabTitle={__('Focus', 'Skillate-core')}>
                                { layout == 2 &&
                                    <Color label={__('Background Color', 'Skillate-core')} value={inputBgFocus} onChange={val => setAttributes({ inputBgFocus: val })} />
                                }
                                <Color label={__('Border Color', 'Skillate-core')} value={inputBorderColorFocus} onChange={(value) => setAttributes({ inputBorderColorFocus: value })} />
                            </Tab>
                        </Tabs>
                    </PanelBody>

                    {layout == 2 &&
                        <PanelBody title={__('Button Settings', 'Skillate-core')} initialOpen={false}>
                            <Typography
                                label={__('Typography', 'Skillate-core')}
                                value={btnTypography}
                                onChange={value => setAttributes({ btnTypography: value })} 
                            />
                            <Border 
                                label={__('Border', 'Skillate-core')} 
                                value={btnBorder} 
                                onChange={val => setAttributes({ btnBorder: val })} 
                                min={0} max={10} unit={['px', 'em', '%']} 
                                responsive device={device} onDeviceChange={value => this.setState({ device: value })} 
                            />
                            <BorderRadius 
                                min={0} max={100} 
                                responsive device={device} 
                                label={__('Border Radius', 'Skillate-core')} 
                                value={btnBorderRadius} unit={['px', 'em', '%']} 
                                onChange={value => setAttributes({ btnBorderRadius: value })} 
                                onDeviceChange={value => this.setState({ device: value })} 
                            />
                            <Tabs>
                                <Tab tabTitle={__('Normal COlor', 'Skillate-core')}>
                                    <Color label={__('Background Color', 'Skillate-core')} value={buttonBgColor} onChange={value => setAttributes( { buttonBgColor: value }) } />
                                    <Color label={__('Text Color', 'Skillate-core')} value={btnTextColor} onChange={value => setAttributes({ btnTextColor: value })} />
                                </Tab>

                                <Tab tabTitle={__('Hover Color', 'Skillate-core')}>
                                    <Color label={__('Background Hover Color', 'Skillate-core')} value={btnBgHoverColor} onChange={val => setAttributes({ btnBgHoverColor: val })} />
                                    <Color label={__('Text Hover Color', 'Skillate-core')} value={btnTextHoverColor} onChange={value => setAttributes({ btnTextHoverColor: value })} />
                                </Tab>
                            </Tabs>
                        </PanelBody>
                    }
                </InspectorControls>

                <div className={`qubely-block-${uniqueId}`}>
                    <div className={`skillate-form-search-wrapper layout-${layout}`}>
                        { enableTitle &&
                            <div className="skillate-title-inner">
                                <div onClick={() => this.handlePanelOpenings('Title')}>
                                    <RichText
                                        key="editable"
                                        tagName="span"
                                        className="skillate-search-title"
                                        keepPlaceholderOnFocus
                                        placeholder={__('Add Text...', 'Skillate-core')}
                                        onChange={value => setAttributes({ searchtitle: value })}
                                        value={searchtitle} />
                                </div>
                            </div>
                        }

                        <div  className={`qubely-form`} id="searchform">
                            <div class="form-inlines">
                                { layout == 2 ? 
                                <div className="skillate-search-wrapper search">
                                    <div class="skillate-course-search-icons">
                                        <img src={thm_option.plugin+'assets/img/search.svg'} />
                                    </div>
                                    <input type="text" className="skillate-coursesearch-input" placeholder={__('Search your courses', 'Skillate-core')} name="s" />
                                    <button type="submit">
                                        <RichText
                                            key="editable"
                                            tagName="span"
                                            className="skillate-search-btn-text"
                                            keepPlaceholderOnFocus
                                            placeholder={__('SEARCH', 'Skillate-core')}
                                            onChange={value => setAttributes({ searchBtnText: value })}
                                            value={searchBtnText} />
                                    </button>
                                </div>
                                : 
                                <div className={`skillate-search-wrapper search search-layout-${layout}`}>
                                    <input type="text" className="skillate-coursesearch-input" placeholder={__('Search your courses', 'Skillate-core')} name="s" />
                                    <div class="skillate-course-search-icons"></div>
                                    <button type="submit"> <img src={thm_option.plugin+'assets/img/search1.svg'} /></button>
                                </div>
                                }
                            </div>
                        </div>
                    </div>
                </div>
            </Fragment>
        )
    }
}
export default Edit
