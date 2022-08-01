const { __ } = wp.i18n;
const { Component, Fragment } = wp.element;
const { RichText, InspectorControls } = wp.editor
const { PanelBody, DateTimePicker, TextControl } = wp.components;
const { Color, ColorAdvanced, Tabs, Tab, BoxShadow, Border, Typography, BorderRadius, Range, Toggle, CssGenerator: { CssGenerator } } = wp.qubelyComponents


import Timer from './components';

class Edit extends Component {
	constructor(props) {
		super(props)
		this.state = {
			device: 'md',
			spacer: true
		}
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
     
	render() {
		const {
			setAttributes,
			attributes: {
                uniqueId,
                endDate,
                countdownTitle,
                countdownIntro,
                countdownButton,
                enableButton,
                buttonColor, 
                buttonBgColor, 
                buttonBorder, 
                buttonShadow, 
                buttonHoverColor,
                buttonurl,
                titleColor,
                titleTypography,
                titleSpacing,
                subtitleColor,
                subtitleTypography,
                subtitleSpacing,
                digiteColor, digiteTypography, digiteTextColor, digiteTextTypography,


                countdownBgColor, bgPadding, border, borderRadius, boxShadow
            } 
        } = this.props

        const { device } = this.state
        if (uniqueId) { CssGenerator(this.props.attributes, 'upskill-countdown', uniqueId); }

		return (
			<Fragment>
				<InspectorControls key="inspector">
                    <PanelBody title={__('Countdown Date Time', 'Skillate-core')}>
						<DateTimePicker
							currentDate={endDate * 1000}
							onChange={value => {
								setAttributes({
									endDate: Math.floor(
										Date.parse(value) / 1000
									)
								});
							}}
						/>
                        <TextControl label="Button URL" value={buttonurl} onChange={(buttonurl) => setAttributes({ buttonurl })} />
					</PanelBody> 


                    <PanelBody title={__('Countdown Design', 'Skillate-core')} initialOpen={false}>
                        <Color 
                            label={__('Digite Color', 'Skillate-core')} 
                            value={digiteColor} 
                            onChange={(value) => setAttributes({ digiteColor: value }) } />
                        <Typography
                            label={__('Digite Typography', 'Skillate-core')}
                            value={digiteTypography}
                            onChange={value => setAttributes({ digiteTypography: value })} 
                        />
                        <Color 
                            label={__('Digite Text Color', 'Skillate-core')} 
                            value={digiteTextColor} 
                            onChange={(value) => setAttributes({ digiteTextColor: value }) } />
                        <Typography
                            label={__('Digite Text Typography', 'Skillate-core')}
                            value={digiteTextTypography}
                            onChange={value => setAttributes({ digiteTextTypography: value })} 
                        />
                     </PanelBody>
                     
                    <PanelBody title={__('Title', 'Skillate-core')} initialOpen={false}>
                        <Color 
                            label={__('Title Color', 'Skillate-core')} 
                            value={titleColor} 
                            onChange={(value) => setAttributes({ titleColor: value }) } />
                        <Typography
                            label={__('Title Typography', 'Skillate-core')}
                            value={titleTypography}
                            onChange={value => setAttributes({ titleTypography: value })} 
                        />
                        <Range 
                            label={__('Title Spacing', 'Skillate-core')} 
                            value={titleSpacing} 
                            onChange={val => setAttributes({ titleSpacing: val })} 
                            min={0} max={200} unit={['px', 'em', '%']} 
                            responsive device={device} 
                            onDeviceChange={value => this.setState({ device: value })} 
                        />
                     </PanelBody>

                     <PanelBody title={__('SubTitle', 'Skillate-core')} initialOpen={false}>
                        <Color 
                            label={__('Subtitle Color', 'Skillate-core')} 
                            value={subtitleColor} 
                            onChange={(value) => setAttributes({ subtitleColor: value }) } />
                        <Typography
                            label={__('Subtitle Typography', 'Skillate-core')}
                            value={subtitleTypography}
                            onChange={value => setAttributes({ subtitleTypography: value })} 
                        />
                        <Range 
                            label={__('Title Spacing', 'Skillate-core')} 
                            value={subtitleSpacing} 
                            onChange={val => setAttributes({ subtitleSpacing: val })} 
                            min={0} max={200} unit={['px', 'em', '%']} 
                            responsive device={device} 
                            onDeviceChange={value => this.setState({ device: value })} 
                        />
                    </PanelBody>

                    <PanelBody title={__('Button', 'Skillate-core')} initialOpen={false}>
                        <Toggle 
                            label={__('Disable Button', 'Skillate-core')} 
                            value={enableButton} 
                            onChange={value => setAttributes({ enableButton: value })} 
                        />
                        {enableButton && 
                            <Tabs>
                                <Tab tabTitle={__('Normal', 'Skillate-core')}>
                                    <Color 
                                        label={__('Text Color', 'Skillate-core')} 
                                        value={buttonColor} 
                                        onChange={(value) => setAttributes({ buttonColor: value }) } />
                                    <ColorAdvanced label={__('Background', 'Skillate-core')} value={buttonBgColor} onChange={(value) => setAttributes({ buttonBgColor: value })} />
                                    <Border 
                                        label={__('Border', 'Skillate-core')} 
                                        value={buttonBorder} 
                                        onChange={val => setAttributes({ buttonBorder: val })} 
                                        min={0} max={10} unit={['px', 'em', '%']} 
                                        responsive device={device} 
                                        onDeviceChange={value => this.setState({ device: value })} 
                                    />
                                    <BoxShadow 
                                        label={__('Box-Shadow', 'Skillate-core')} 
                                        value={buttonShadow} 
                                        onChange={(value) => setAttributes({ buttonShadow: value })} 
                                    />
                                </Tab>
                                <Tab tabTitle={__('Hover', 'Skillate-core')}>
                                    <Color 
                                        label={__('Text Color', 'Skillate-core')} 
                                        value={buttonHoverColor} 
                                        onChange={(value) => setAttributes({ buttonHoverColor: value }) } />

                                </Tab>
                            </Tabs>
                        }
                    </PanelBody>

                    
                    <PanelBody title={__('Background Style', 'Skillate-core')} initialOpen={false}>
                        <ColorAdvanced label={__('Background', 'Skillate-core')} value={countdownBgColor} onChange={(value) => setAttributes({ countdownBgColor: value })} />
                        <Range 
                            label={__('Padding', 'Skillate-core')} 
                            value={bgPadding} 
                            onChange={val => setAttributes({ bgPadding: val })} 
                            min={0} max={200} unit={['px', 'em', '%']} 
                            responsive device={device} 
                            onDeviceChange={value => this.setState({ device: value })} 
                        />
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
                        <BoxShadow
                            label={__('Box Shadow', 'Skillate-core')}
                            value={boxShadow} onChange={val => setAttributes({ boxShadow: val })}
                        />
                    </PanelBody>
				</InspectorControls>


                <section className={`skillate-home-countdown qubely-block-${uniqueId}`}>
                    <div className="row">
                        <div className="col-lg-12">
                            <div className={`skillate-home-countdown-content`}>
                                <header className="skillate-home-countdown-header">
                                    <div className="skillate-home-countdown-title">
                                        <RichText
                                            key="editable"
                                            tagName="h3"
                                            className="skillate-countdown-title"
                                            keepPlaceholderOnFocus
                                            placeholder={__('Add Text...', 'Skillate-core')}
                                            onChange={value => setAttributes({ countdownTitle: value })}
                                            value={countdownTitle} />
                                    </div>
                                    <div className="skillate-home-countdown-body">
                                        <RichText
                                            key="editable"
                                            tagName="p"
                                            className="countdown-intro-text"
                                            keepPlaceholderOnFocus
                                            placeholder={__('Add Text...', 'Skillate-core')}
                                            onChange={value => setAttributes({ countdownIntro: value })}
                                            value={countdownIntro} />
                                    </div>
                                </header>
                                <footer className="skillate-home-countdown-footer">
                                    <div className="row">

                                        {enableButton ? 
                                        <div className="col-md-7 col-sm-12">
                                            <Timer deadline={endDate} />
                                        </div>
                                            :
                                        <div className="col-md-12 col-sm-12">
                                            <Timer deadline={endDate} />
                                        </div> }
                                        
                                        

                                        {enableButton && 
                                            <div className="col-md-5 col-sm-12">
                                                <div className="skillate-home-countdown-cta-btn">
                                                    <RichText
                                                        key="editable"
                                                        tagName="a"
                                                        className="btn btn-primary"
                                                        keepPlaceholderOnFocus
                                                        placeholder={__('Add Button', 'Skillate-core')}
                                                        onChange={value => setAttributes({ countdownButton: value })}
                                                        value={countdownButton} />
                                                </div>
                                            </div>
                                        }
                                    </div> 
                                </footer>	
                            </div>
                        </div>
                    </div>
                </section> 

			</Fragment>
		);
	}
}

export default Edit;