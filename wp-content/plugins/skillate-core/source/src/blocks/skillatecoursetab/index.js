import Edit from './Edit';
const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;

registerBlockType('qubely/upskill-course-tab', {
	title: __('Courses Tab', 'Skillate-core'),
	icon: 'index-card',
    category: 'skillate-core',
    keywords: [__('Latest Courses', 'Skillate-core'), __('Skillate Courses', 'Skillate-core')],
	edit: Edit,
	save: function( props ) {
		return null;
	}
}); 