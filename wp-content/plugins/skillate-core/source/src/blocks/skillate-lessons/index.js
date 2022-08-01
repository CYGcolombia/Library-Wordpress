import Edit from './Edit';
const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;

registerBlockType('qubely/skillate-core-tutor-course-lessons', {
	title: __('Courses Lessons', 'Skillate-core'),
	icon: 'book',
    category: 'skillate-core',
    keywords: [__('Latest Course Lessons', 'Skillate-core'), __('Tutor Course Lessons', 'Skillate-core')],
	edit: Edit,
	save: function( props ) {
		return null;
	}
});  