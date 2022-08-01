import Edit from './Edit';
const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;

registerBlockType('qubely/upskill-core-tutor-course-search', {
	title: __('Courses Search', 'Skillate-core'),
	icon: 'search',
    category: 'skillate-core',
    keywords: [__('Latest Courses Search', 'Skillate-core'), __('Tutor Courses Search', 'Skillate-core')],
	edit: Edit,
	save: function( props ) {
		return null;
	}
});  