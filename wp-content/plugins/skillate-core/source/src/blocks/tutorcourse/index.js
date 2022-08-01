import Edit from './Edit';
const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;

registerBlockType('qubely/upskill-core-tutor-course', {
	title: __('Courses Listing', 'Skillate-core'),
	icon: 'list-view',
    category: 'skillate-core',
    keywords: [__('Latest Courses', 'Skillate-core'), __('Tutor Courses', 'Skillate-core')],
	edit: Edit,
	save: function( props ) {
		return null;
	}
});