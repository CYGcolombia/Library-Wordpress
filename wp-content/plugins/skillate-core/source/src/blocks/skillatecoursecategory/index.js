import Edit from './Edit';
const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;

registerBlockType('qubely/upskill-tutor-course-category', {
	title: __('Category Listing', 'Skillate-core'),
	icon: 'grid-view',
    category: 'skillate-core',
    keywords: [__('Course Category', 'Skillate-core'), __('Tutor Courses Category', 'Skillate-core')],
	edit: Edit,
	save: function( props ) {
		return null;
	}
}); 