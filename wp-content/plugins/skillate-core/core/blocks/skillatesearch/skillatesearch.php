<?php
defined( 'ABSPATH' ) || exit;

if (! class_exists('skillate_Core_Tutor_Course_Search')) {
    class skillate_Core_Tutor_Course_Search {
        protected static $_instance = null;
        public static function instance() {
            if(is_null(self::$_instance)) {
                self::$_instance = new self();
            }
            return self::$_instance;
        } 
        public function __construct(){
			register_block_type(
                'qubely/upskill-core-tutor-course-search',
                array(
                    'attributes' => array(
                        'uniqueId'      => array(
                            'type'      => 'string',
                            'default'   => ''
                        ),
                        'layout'   => array(
                            'type'      => 'string',
                            'default'   => 2
                        ),
                        //title
                        'enableTitle'         => array(
                            'type'          => 'boolean',
                            'default'       => true
                        ),
                        'searchtitle'   => array(
                            'type'      => 'string',
                            'default'   => ''
                        ),
                        'searchBtnText'   => array(
                            'type'      => 'string',
                            'default'   => 'Button'
                        ),
                        'SearchTypography'   => array(
                            'type'          => 'object',
                            'default'       => (object) [
                                'openTypography' => 1,
                                'family'    => "Open Sans",
                                'type'      => "sans-serif",
                                'size'      => (object) ['md' => 70, 'unit' => 'px'],
                            ],
                            'style'         => [(object) [
                                'selector'  => '{{QUBELY}} .skillate-title-inner span.skillate-search-title'
                            ]]
                        ),
                        'searchTextColor'   => array(
                            'type'          => 'string',
                            'default'       => '#ffffff',
                            'style'         => [(object) [
                                'selector'  => '{{QUBELY}} .skillate-title-inner span.skillate-search-title { color: {{searchTextColor}};}'
                            ]]
                        ),
                        'titleSpacing'      => array(
                            'type'          => 'object',
                            'default'       => (object) array(
                                'md'        => 40,
                                'unit'      => 'px'
                            ),
                            'style'         => [
                                (object) [
                                    'selector' => '{{QUBELY}} .skillate-title-inner span.skillate-search-title {margin-bottom: {{titleSpacing}}; display: block;}'
                                ]
                            ]
                        ),

                        # Input Typrography
                        'inputTypography'   => array(
                            'type'          => 'object',
                            'default'       => (object) [
                                'openTypography' => 1,
                                'family'    => "Open Sans",
                                'type'      => "sans-serif",
                                'size'      => (object) ['md' => 16, 'unit' => 'px'],
                            ],
                            'style'         => [(object) [
                                'selector'  => '{{QUBELY}} .skillate-form-search-wrapper .skillate-coursesearch-input, {{QUBELY}} .edit-post-visual-editor .skillate-form-search-wrapper input[type=text]'
                            ]]
                        ),
                        
                        # Normal
                        'inputBg'        => array(
                            'type'          => 'string',
                            'default'       => '#fff',
                            'style'         => [(object) [
                                'selector'  => '{{QUBELY}} .skillate-form-search-wrapper .skillate-coursesearch-input { background: {{inputBg}}; }'
                            ]]
                        ),
                        'inputColor'        => array(
                            'type'          => 'string',
                            'default'       => '#1f2949',
                            'style'         => [(object) [
                                'selector'  => '{{QUBELY}} .skillate-form-search-wrapper .skillate-coursesearch-input { color: {{inputColor}};}'
                            ]]
                        ),
                        'placeholderColor'  => array(
                            'type'          => 'string',
                            'default'       => '#8c94a8',
                            'style'         => [(object) [
                                'selector'  => '{{QUBELY}} .skillate-form-search-wrapper .skillate-coursesearch-input::placeholder { color: {{placeholderColor}};}'
                            ]]
                        ),

                        # Focus Color
                        'inputBgFocus'  => array(
                            'type'          => 'string',
                            'default'       => '#fafafa',
                            'style'         => [(object) [
                                'selector'  => '{{QUBELY}} .skillate-form-search-wrapper .skillate-coursesearch-input:focus {background: {{inputBgFocus}};}'
                            ]]
                        ),
                        'inputBorderColorFocus'  => array(
                            'type'          => 'string',
                            'default'       => '#ff5248',
                            'style'         => [(object) [
                                'selector'  => '{{QUBELY}} .skillate-form-search-wrapper .skillate-coursesearch-input:focus {border-color: {{inputBorderColorFocus}};}'
                            ]]
                        ),

                        'border'            => array(
                            'type'          => 'object',
                            'default'       => (object) array(),
                            'style'         => [(object) [
                                'selector'  => '{{QUBELY}} .skillate-form-search-wrapper .skillate-coursesearch-input'
                            ]]
                        ),
                        'borderRadius'      => array(
                            'type'          => 'object',
                            'default'       => (object) array(),
                            'style'         => [(object) [
                                'selector' => '{{QUBELY}} .skillate-form-search-wrapper .skillate-search-wrapper .skillate-coursesearch-input'
                            ]]
                        ),
                        
                        # Submit Button.
                        'btnTypography'   => array(
                            'type'          => 'object',
                            'default'       => (object) [
                                'openTypography' => 1,
                                'family'    => "Open Sans",
                                'type'      => "sans-serif",
                                'size'      => (object) ['md' => 16, 'unit' => 'px'],
                            ],
                            'style'         => [(object) [
                                'selector'  => '{{QUBELY}} .skillate-form-search-wrapper .skillate-search-wrapper.search button'
                            ]]
                        ),
                        'btnBorder'            => array(
                            'type'          => 'object',
                            'default'       => (object) array(),
                            'style'         => [(object) [
                                'selector'  => '{{QUBELY}} .skillate-form-search-wrapper .skillate-search-wrapper.search button'
                            ]]
                        ),
                        'btnBorderRadius'      => array(
                            'type'          => 'object',
                            'default'       => (object) array(),
                            'style'         => [(object) [
                                'selector' => '{{QUBELY}} .skillate-form-search-wrapper .skillate-search-wrapper.search button'
                            ]]
                        ),

                        # color
                        'buttonBgColor'        => array(
                            'type'          => 'string',
                            'default'       => '#ff5248',
                            'style'         => [(object) [
                                'selector'  => '{{QUBELY}} .skillate-form-search-wrapper .skillate-search-wrapper.search button { background: {{buttonBgColor}}; }'
                            ]]
                        ),
                        'btnTextColor'        => array(
                            'type'          => 'string',
                            'default'       => '#ffffff',
                            'style'         => [(object) [
                                'selector'  => '{{QUBELY}} .skillate-form-search-wrapper .skillate-search-wrapper.search button { color: {{btnTextColor}};}'
                            ]]
                        ),
                        # Hover Color.
                        'btnBgHoverColor'        => array(
                            'type'          => 'string',
                            'default'       => '#ea3b30',
                            'style'         => [(object) [
                                'selector'  => '{{QUBELY}} .skillate-form-search-wrapper .skillate-search-wrapper.search button:hover { background: {{btnBgHoverColor}}; }'
                            ]]
                        ),
                        'btnTextHoverColor'        => array(
                            'type'          => 'string',
                            'default'       => '#ffffff',
                            'style'         => [(object) [
                                'selector'  => '{{QUBELY}} .skillate-form-search-wrapper .skillate-search-wrapper.search button:hover { color: {{btnTextHoverColor}};}'
                            ]]
                        ),

                        # Animation.
                        'animation' => array(
                            'type' => 'object',
                            'default' => (object) array(),
                        ),
                        'globalZindex' => array(
                            'type'    => 'string',
                            'default' => '0',
                            'style' => [(object) [
                                'selector' => '{{QUBELY}} {z-index:{{globalZindex}};}'
                            ]]
                        ),
                        'hideTablet' => array(
                            'type' => 'boolean',
                            'default' => false,
                            'style' => [(object) [
                                'selector' => '{{QUBELY}}{display:none;}'
                            ]]
                        ),
                        'hideMobile' => array(
                            'type' => 'boolean',
                            'default' => false,
                            'style' => [(object) [
                                'selector' => '{{QUBELY}}{display:none;}'
                            ]]
                        ),
                        'globalCss' => array(
                            'type' => 'string',
                            'default' => '',
                            'style' => [(object) [
                                'selector' => ''
                            ]]
                        ),
                        'interaction' => array(
                            'type' => 'object',
                            'default' => (object) array(),
                        ),
                    ),
                    'render_callback' => array( $this, 'skillate_Core_Tutor_Course_Search_block_callback' ),
                )
            );
        }
    
		public function skillate_Core_Tutor_Course_Search_block_callback( $att ){

            $uniqueId       = isset($att['uniqueId']) ? $att['uniqueId'] : '';
            $layout         = isset($att['layout']) ? $att['layout'] : '';
            $searchtitle 	= isset( $att['searchtitle'] ) ? $att['searchtitle'] : '';
            $searchBtnText 	= isset( $att['searchBtnText'] ) ? $att['searchBtnText'] : '';
            $enableTitle 	= isset( $att['enableTitle'] ) ? $att['enableTitle'] : 1;
            $animation 		= isset($att['animation']) ? ( count((array)$att['animation']) > 0 && $att['animation']['animation']  ? 'data-qubelyanimation="'.htmlspecialchars(json_encode($att['animation']), ENT_QUOTES, 'UTF-8').'"' : '' ) : '';

            $interaction = '';
            if(isset($att['interaction'])) {
                if (!empty((array)$att['interaction'])) {
                    if(isset($att['interaction']['while_scroll_into_view'])) {
                        if($att['interaction']['while_scroll_into_view']['enable']){
                            $interaction = 'qubley-block-interaction';
                        }
                    }
                    if(isset($att['interaction']['mouse_movement'])) {
                        if($att['interaction']['mouse_movement']['enable']) {
                            $interaction = 'qubley-block-interaction';
                        }
                    }
                }
            }

            $skillate_action = function_exists('tutor_utils') ? tutor_utils()->course_archive_page_url() : site_url('/');

            $html = '';
            $html .= '<div class="qubely-block-' . $uniqueId . '">';
                if( $enableTitle == 1 ) {
                    $html .= '<div class="skillate-title-inner '.$interaction.'" '.$animation.'>';
                        $html .= '<span class="skillate-search-title">'. $searchtitle .'</span>';
                    $html .= '</div>';
                }
                $html .= '<div class="skillate-form-search-wrapper '.$interaction.' layout-'.$layout.'" '.$animation.'>';
                    $html .= '<form role="search" method="get" id="searchform" action="'. esc_url($skillate_action) .'">';
                        $html .= '<div class="form-inlines">';
                            if ($layout == 2) {
                                $html .= '<div class="skillate-search-wrapper search">';
                                    $html .= '<div class="skillate-course-search-icons">';
                                        $html .= '<img src="'.skillate_CORE_URL.'assets/img/search.svg" />';
                                    $html .= '</div>';
                                    $html .= '<input type="text" class="skillate-coursesearch-input" placeholder="'.esc_attr__('Search your courses', 'Skillate-core').'" value="'.esc_attr( get_search_query()).'" name="s" id="searchword" title="'.esc_attr_x( 'Search for:', 'label', 'Skillate-core' ).'" data-url="'.get_template_directory_uri().'/lib/search-data.php'.'">';
                                    $html .= '<button type="submit">'.$searchBtnText.' <i class="fas fa-search"></i></button>';
                                $html .= '</div>';
                            }else {
                                $html .= '<div class="skillate-search-wrapper search search-layout-'.$layout.'">';
                                $html .= '<input type="text" class="skillate-coursesearch-input" placeholder="'.esc_attr__('Search your courses', 'Skillate-core').'" value="'.esc_attr( get_search_query()).'" name="s" id="searchword" title="'.esc_attr_x( 'Search for:', 'label', 'Skillate-core' ).'" data-url="'.get_template_directory_uri().'/lib/search-data.php'.'">';
                                $html .= '<div class="skillate-course-search-icons"></div>';
                                $html .= '<button type="submit"><img src="'.skillate_CORE_URL.'assets/img/search1.svg" /></button>';
                                $html .= '</div>';
                            }
                        $html .= '</div>';
                    $html .= '</form>';
                    $html .= '<div class="skillate-course-search-results"></div>';
                $html .= '</div>';
            $html .= '</div>';
			return $html;
		}
    }
}
skillate_Core_Tutor_Course_Search::instance();


