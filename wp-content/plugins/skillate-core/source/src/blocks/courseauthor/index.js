import Edit from './Edit';
const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;

registerBlockType('qubely/upskill-course-author', {
	title: __('Courses Author', 'Skillate-core'),
	icon: 'businessman',
    category: 'skillate-core',
    keywords: [__('Courses Author', 'Skillate-core') ],
	edit: Edit,
	save: function( props ) {
		return null;
	}
}); 