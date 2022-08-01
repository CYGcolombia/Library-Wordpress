const { __ } = wp.i18n
const { registerBlockType } = wp.blocks
import './style.scss'
import Edit from './Edit'

registerBlockType('qubely/upskill-countdown', {
	title: __('Countdown', 'Skillate-core'),
    category: 'skillate-core',
    description: __('skillate Countdown', 'Skillate-core'),
    icon: 'clock',
	keywords: [__('Countdown', 'Skillate-core'), __('Timer', 'Skillate-core'), __('skillate Countdown', 'Skillate-core')],

	edit: Edit,
	save: () => null,
});
