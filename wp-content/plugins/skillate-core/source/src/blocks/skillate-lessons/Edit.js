const { __ } = wp.i18n;
const { withSelect } = wp.data;
const { InspectorControls } = wp.editor;
const { Component, Fragment } = wp.element;
const { PanelBody, TextControl, ServerSideRender, SelectControl } = wp.components;

const {
    CssGenerator: { CssGenerator }
} = wp.qubelyComponents
 
 
class Edit extends Component {
    constructor(props) {
        super(props)
        this.state = { 
            device: 'md', 
            selector: true, 
            spacer: true, 
            openPanelSetting: '',
            courseIds: [],
            courses: [],
         };
    }
    componentDidMount() {
        const { setAttributes, clientId, attributes: { uniqueId } } = this.props
        let courseselections = [];
        wp.apiFetch({ path: "/skillateapi/v2/courses" }).then(courses => {
            courseselections.push({ label: __('Select Course', 'Skillate-core'), value: __('all', 'Skillate-core') });
            $.each(courses, function (key, val) {
                courseselections.push({ label: val.name, value: val.id });
            });
            return courseselections;
        });
        this.setState({ courseIds: courseselections })

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
                courseId
            },
        } = this.props

        if (uniqueId) { CssGenerator(this.props.attributes, 'skillate-core-tutor-course-lessons', uniqueId) }

        return (
            
            <Fragment>
                <InspectorControls key="inspector">
                   
                    <PanelBody title={__('Select Course ID', 'Skillate-core')} initialOpen={false}>
                        <Fragment>
                            <SelectControl
                                value={courseId}
                                options={this.state.courseIds}
                                onChange={(value) => setAttributes({ courseId: value })}
                            />  
                        </Fragment>
                    </PanelBody>
                </InspectorControls>
                <ServerSideRender
                    block="qubely/skillate-core-tutor-course-lessons"
                    attributes={ this.props.attributes }
                />
            </Fragment>
        )
    }
}

export default withSelect((select, props) => {
    const { attributes: { numbers, order } } = props
    const { getEntityRecords } = select('core')
    const output = {courses: getEntityRecords('postType', 'courses', { per_page: numbers, order: order, status: 'publish', } )}

    return output; 
})

(Edit)
