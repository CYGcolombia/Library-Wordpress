<?php
defined( 'ABSPATH' ) || exit;

if (! class_exists('skillate_Core_Tutor_Course_Category')) {
    class skillate_Core_Tutor_Course_Category{
        protected static $_instance = null;
        public static function instance(){
            if(is_null(self::$_instance)){
                self::$_instance = new self();
            }
            return self::$_instance;
        }
        public function __construct(){
			register_block_type(
                'qubely/upskill-tutor-course-category',
                array(
                    'attributes' => array(
                        //common settings
                        'uniqueId'          => array (
                            'type'          => 'string',
                        ),
                        'layout'   => array(
                            'type'      => 'string',
                            'default'   => 1
                        ),
                        'selectedCategory' => array(
                            'type' => 'array',
                            'default' => [],
                            'items'   => [
                                'type' => 'object'
                            ],
                        ),
                        'disFilter'         => array(
                            'type'          => 'boolean',
                            'default'       => true
                        ),
                        'columns'           => array(
                            'type'          => 'string',
                            'default'       => '4',
                        ),

                        //design    
                        'categoryBgColor' => array(
                            'type' => 'string',
                            'default' => '',
                            'style' => [
                                (object) [
                                    'selector' => '{{QUBELY}} .skillate-course-category-list {background:{{categoryBgColor}};}'
                                ]
                            ]
                        ),
                        'categoryHoverBg' => array(
                            'type' => 'string',
                            'default' => '',
                            'style' => [
                                (object) [
                                    'selector' => '{{QUBELY}} .skillate-course-category-list:hover {background:{{categoryHoverBg}};}'
                                ]
                            ]
                        ),
                        'BgPadding' => array(
                            'type'              => 'object',
                            'default'           => (object) [
                                'openPadding'   => 1,
                                'paddingType'   => 'global',
                                'unit'          => 'px',
                                'global'        => (object) ['md' => 0],
                            ],
                            'style' => [
                                (object) [
                                    'selector' => '{{QUBELY}} .skillate-course-category-list'
                                ]
                            ]
                        ),

                        //image
                        'enableImage' => array (
                            'type'         => 'boolean',
                            'default'      => true,
                        ),
                        'imageWidth' => array(
                            'type' => 'object',
                            'default' => (object) array(
                                'md' => 100,
                                'unit' => 'px'
                            ),
                            'style' => [
                                (object) [
                                    'condition' => [
                                        (object) ['key' => 'enableImage', 'relation' => '==', 'value' => true]
                                    ],
                                    'selector' => '{{QUBELY}} .skillate-course-category-list img { width: {{imageWidth}};}'
                                 ],
                            ],
                        ),
                        'brightness' => array(
                            'type' => 'object',
                            'default' => (object) array(
                                'md' => ''
                            ),
                            'style' => [
                                (object) [
                                    'condition' => [
                                        (object) ['key' => 'enableImage', 'relation' => '==', 'value' => true]
                                    ],
                                    'selector' => '{{QUBELY}} .skillate-course-category-list img { filter: brightness({{brightness}});}'
                                 ],
                            ],
                        ),
                        'brightnessHover' => array(
                            'type' => 'object',
                            'default' => (object) array(
                                'md' => ''
                            ),
                            'style' => [
                                (object) [
                                    'condition' => [
                                        (object) ['key' => 'enableImage', 'relation' => '==', 'value' => true]
                                    ],
                                    'selector' => '{{QUBELY}} .skillate-course-category-list:hover img { filter: brightness({{brightnessHover}});}'
                                 ],
                            ],
                        ),

                        //title
                        'enableTitle' => array (
                            'type'         => 'boolean',
                            'default'      => true,
                        ),
                        'categoryTypography' => array(
                            'type' => 'object',
                            'default' => (object) [
                                'openTypography' => 1,
                                'family' => "Roboto",
                                'type' => "sans-serif",
                                'size' => (object) ['md' => 16, 'unit' => 'px'],
                            ],
                            'style' => [(object) [
                                'selector' => '{{QUBELY}} .skillate-course-category-list, {{QUBELY}} .skillate-course-category-list .single-course-categories'
                            ]]
                        ),
                        'categoryColor' => array(
                            'type'    => 'string',
                            'default' => '#1f2949',
                            'style' => [(object) [
                                'selector' => '{{QUBELY}} .skillate-course-category-list, {{QUBELY}} .skillate-course-category-list a, {{QUBELY}} .skillate-course-category-list .single-course-categories {color:{{categoryColor}};}'
                            ]]
                        ),
                        'categoryHoverColor' => array(
                            'type'    => 'string',
                            'default' => '',
                            'style' => [(object) [
                                'selector' => '{{QUBELY}} .skillate-course-category-list:hover, {{QUBELY}} .skillate-course-category-list:hover a, {{QUBELY}} .skillate-course-category-list:hover .single-course-categories {color: {{categoryHoverColor}};}'
                            ]]
                        ),
                        'marginTop' => array(
                            'type' => 'object',
                            'default' => (object) array(
                                'md' => 8,
                                'unit' => 'px'
                            ),
                            'style' => [
                                (object) [
                                    'condition' => [
                                        (object) ['key' => 'layout', 'relation' => '==', 'value' => 2]
                                    ],
                                    'selector' => '{{QUBELY}} .skillate-course-category-list .single-course-categories { display: inline-block; margin-top: {{marginTop}};} {{QUBELY}} .skillate-course-category-list span { display: inline-block; margin-top: {{marginTop}};}'
                                ],
                            ],
                        ),

                        # Button .
                        'enableButton' => array (
                            'type'         => 'boolean',
                            'default'      => true,
                        ),
                        'buttontypography' => array(
                            'type' => 'object',
                            'default' => (object) [
                                'openTypography' => 1,
                                'family' => "Open Sans",
                                'type' => "sans-serif",
                                'size' => (object) ['md' => 14, 'unit' => 'px'],
                            ],
                            'style' => [(object) [
                                'selector' => '{{QUBELY}} .all-category .view-all-category'
                            ]]
                        ),
                        'buttonColor' => array(
                            'type'    => 'string',
                            'default' => '#ff5248',
                            'style' => [(object) [
                                'selector' => '{{QUBELY}} .all-category .view-all-category {color: {{buttonColor}};}'
                            ]]
                        ),
                        'buttonHoverColor' => array(
                            'type'    => 'string',
                            'default' => '#fff',
                            'style' => [(object) [
                                'selector' => '{{QUBELY}} .all-category .view-all-category:hover {color: {{buttonHoverColor}};}'
                            ]]
                        ),
                        'buttonBg' => array(
                            'type'    => 'string',
                            'default' => '#ffffff',
                            'style' => [(object) [
                                'selector' => '{{QUBELY}} .all-category .view-all-category {background: {{buttonBg}};}'
                            ]]
                        ),
                        'buttonHoverBg' => array(
                            'type'    => 'string',
                            'default' => '#ff5248',
                            'style' => [(object) [
                                'selector' => '{{QUBELY}} .all-category .view-all-category:hover {background: {{buttonHoverBg}};}'
                            ]]
                        ),

                        'buttonurl' => array (
                            'type'      => 'string',
                            'default'   => '#',
                        ),

                        'buttonBorder' => array(
                            'type' => 'object',
                            'default' => (object) array(
                                'unit' => 'px',
                                'widthType' => 'global',
                                'global' => (object) array(
                                    'md' => '1',
                                ),
                            ),
                            'style' => [
                                (object) [
                                    'selector' => '{{QUBELY}} .all-category .view-all-category'
                                ]
                            ]
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
                    'render_callback' => array( $this, 'skillate_Core_Tutor_Course_Category_block_callback' ),
                )
            );
        }
    
		public function skillate_Core_Tutor_Course_Category_block_callback( $att ){
            $uniqueId       = isset($att['uniqueId']) ? $att['uniqueId'] : '';
            $layout         = isset($att['layout']) ? $att['layout'] : '';
			$columns 		= isset( $att['columns'] ) ? $att['columns'] : '3';
			$enableTitle 	= isset( $att['enableTitle'] ) ? $att['enableTitle'] : 1;
            $enableImage 	= isset( $att['enableImage'] ) ? $att['enableImage'] : 1;
            $buttonurl 	    = isset( $att['buttonurl'] ) ? $att['buttonurl'] :'';
            $categoryList   = $att['selectedCategory'];

            $animation 		        = isset($att['animation']) ? ( count((array)$att['animation']) > 0 && $att['animation']['animation']  ? 'data-qubelyanimation="'.htmlspecialchars(json_encode($att['animation']), ENT_QUOTES, 'UTF-8').'"' : '' ) : '';
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
          
            $html = '';

            if ( isset($categoryList) && !empty($categoryList) ){
                if( $categoryList[0]['value'] != 'all' ){
                    $category = $categoryList;
                    
                } else {
                    $category = get_terms(array(
                        'taxonomy' 		=> 'course-category',
                        'hide_empty' 	=> false,
                        'number' => '8',
                    ));
                }
            } else {
                $category = get_terms(array(
                    'taxonomy' 		=> 'course-category',
                    'hide_empty' 	=> false,
                    'number' => '8',
                ));
            }


            $html .= '<div class="qubely-block-'.$uniqueId.'">';
            $html .= '<div class="'.$interaction.'" '.$animation.'>';

            if($layout == '2'){
            $html .= '<div class="row course-slide-mobile-only">';
            }else{
            $html .= '<div class="row">';
            }
    
            foreach ($category as $skillate_course_cateory) {
                if( isset($categoryList) && !empty($categoryList) ){
                    if( $categoryList[0]['value'] != 'all' ){   
                        if($skillate_course_cateory['value'] != 'all'){
                            $skillate_course_cateory  = get_term_by('slug', $skillate_course_cateory['value'] , 'course-category');
                            if ( isset($skillate_course_cateory->term_id) && !empty($skillate_course_cateory->term_id) ) {
                                $image_id = get_term_meta($skillate_course_cateory->term_id,'thumbnail_id', true );
                            }
                        }
                    } else {
                        $image_id = get_term_meta($skillate_course_cateory->term_id,'thumbnail_id', true );
                    }
                } else {
                    $image_id = get_term_meta($skillate_course_cateory->term_id,'thumbnail_id', true );
                }
                if ( isset($skillate_course_cateory->term_id) && !empty($skillate_course_cateory->term_id) ) {
                    if($layout == '1' || $layout == '2' ) {
                        $html .= '<div class="tutor-course-grid-item col-md-'.$columns.' col-6">';
                            $html .= '<div class="skillate-cat-layout-'.$layout.'">';
                                if ($layout == 1) {
                                    $html .= '<div class="skillate-course-category-list">';
                                        $html .= '<a class="course-cat-link-full" href="'.get_term_link($skillate_course_cateory->term_id).'"></a>';
                                        $html .= '<div class="row align-items-center">';
                                            if( $enableImage == 1) {
                                                $html .= '<div class="cat-image col-sm-3 col-5">';
                                                if($image_id){
                                                    $html .= wp_get_attachment_image($image_id, 'skillate-squre');
                                                }
                                                $html .= '</div>';
                                            }
                                            if( $enableTitle == 1 ){
                                                $html .= '<a class="course-cat-link col-sm-6 col-7" href="'.get_term_link($skillate_course_cateory->term_id).'" class="single-course-categories">';
                                                    $html .= '<div class="course-category">'.esc_html($skillate_course_cateory->name).'</div>';
                                                $html .= '</a>';
                                            }

                                            $html .= '<div class="course-count col-sm-3 col-3">'. esc_html($skillate_course_cateory->count) .'</div> ';
                                        $html .= '</div>';
                                    $html .= '</div>';
                                }else {
                                    $html .= '<div class="skillate-course-category-list">';
                                        if( $enableImage == 1) {
                                            $html .= '<div class="cat-image">';
                                            if($image_id){
                                                $html .= '<a href="'.get_term_link($skillate_course_cateory->term_id).'">'.wp_get_attachment_image($image_id, 'skillate-courses').'</a>';
                                            }
                                            $html .= '</div>';
                                        }
                                        if( $enableTitle == 1 ){
                                            $html .= '<a href="'.get_term_link($skillate_course_cateory->term_id).'" class="single-course-categories">';
                                                $html .= '<div class="course-category">'.esc_html($skillate_course_cateory->name).'</div>';
                                            $html .= '</a>';
                                        }
                                    $html .= '</div>';  
                                }
                            $html .= '</div>';
                        $html .= '</div>';

                    }else {
                        $html .= '<div class="tutor-course-grid-item col-md-12 col-6">';
                            $html .= '<div class="skillate-cat-layout-'.$layout.'">';
                                $html .= '<div class="skillate-course-category-list">';
                                    if( $enableImage == 1) {
                                        $html .= '<div class="cat-image">';
                                        if($image_id){
                                            $html .= '<a href="'.get_term_link($skillate_course_cateory->term_id).'">'.wp_get_attachment_image($image_id, 'skillate-courses').'</a>';
                                        }
                                        $html .= '</div>';
                                    }
                                    if( $enableTitle == 1 ){
                                        $html .= '<span>';
                                        $html .= '<a href="'.get_term_link($skillate_course_cateory->term_id).'" class="single-course-categories">';
                                            $html .= '<div class="course-category">'.esc_html($skillate_course_cateory->name).'</div>';
                                        $html .= '</a>';
                                        $html .= '</span>';
                                    }
                                $html .= '</div>';  
                            $html .= '</div>';
                        $html .= '</div>';
                    } 
                }  
            }
            $html .= '</div>';

                if($layout == 2) {
                    $html .= '<div class="row">';
                        $html .= '<div class="col-md-12 category-btn">';
                        $html .= '<div class="all-category">';
                        $html .= '<a href="'. $buttonurl .'" class="view-all-category">View all Categories</a>';
                        $html .= '</div>';
                        $html .= '</div>';
                    $html .= '</div>';
                }


                
            $html .= '</div>';
            $html .= '</div>';
            return $html;
		}
    }
}
skillate_Core_Tutor_Course_Category::instance();
