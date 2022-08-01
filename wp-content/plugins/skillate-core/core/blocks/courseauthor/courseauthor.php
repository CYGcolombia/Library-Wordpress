<?php
defined( 'ABSPATH' ) || exit;

if (! class_exists('skillate_Core_Tutor_Course_Author')) {
    class skillate_Core_Tutor_Course_Author{
        protected static $_instance = null;
        public static function instance(){
            if(is_null(self::$_instance)){
                self::$_instance = new self();
            }
            return self::$_instance;
        }  
        public function __construct(){
			register_block_type(
                'qubely/upskill-course-author',
                array(
                    'attributes' => array(
                        //common settings
                        'uniqueId'      => array(
                            'type'      => 'string',
                        ),

                        'layout'   => array(
                            'type'      => 'string',
                            'default'   => 1
                        ),
                        'postTypes'         => array(
                            'type'          => 'string',
                            'default'       => 'courses'
                        ),
                        'selectedCategory' => array (
                            'type'         => 'string',
                            'default'      => 'all',
                        ),
                        'order'             => array(
                            'type'          => 'string',
                            'default'       => 'desc'
                        ),
                        'disFilter'         => array(
                            'type'          => 'boolean',
                            'default'       => true
                        ),
                        'numbers'           => array(
                            'type'          => 'number',
                            'default'       => 8,
                        ),
                        'columns'           => array(
                            'type'          => 'string',
                            'default'       => '3',
                        ),

                        'slidercolumns'     => array(
                            'type'          => 'string',
                            'default'       => '4',
                        ),

                        //title
                        'enableTitle' => array (
                            'type'         => 'boolean',
                            'default'      => true,
                        ),
                        'typographyTitle'   => array(
                            'type'          => 'object',
                            'default'       => (object) [
                                'openTypography' => 1,
                                'family'    => "Open Sans",
                                'type'      => "sans-serif",
                                'size'      => (object) ['md' => 20, 'unit' => 'px'],
                            ],
                            'style'         => [(object) [
                                'selector'  => '{{QUBELY}} .skillate-instructor-content .instructor-name'
                            ]]
                        ),
                        'titleColor' => array(
                            'type'    => 'string',
                            'default' => '#1f2949',
                            'style' => [(object) [
                                'selector' => '{{QUBELY}} .skillate-instructor-content .upskil-instructor-content .instructor-name {color: {{titleColor}};} {{QUBELY}} .skillate-instructor-content .upskil-instructor-content .instructor-name a { transition: .3s; color: {{titleColor}};}'
                            ]]
                        ),
                        'titleHoverColor' => array(
                            'type'    => 'string',
                            'default' => '',
                            'style' => [(object) [
                                'selector' => '{{QUBELY}} .skillate-instructor-content .upskil-instructor-content .instructor-name:hover {color: {{titleHoverColor}};} {{QUBELY}} .skillate-instructor-content .upskil-instructor-content .instructor-name a:hover {color: {{titleHoverColor}};}'
                            ]]
                        ),

                        # Rating
                        'enableRating' => array (
                            'type'         => 'boolean',
                            'default'      => true,
                        ),
                        'ratingtypography' => array(
                            'type' => 'object',
                            'default' => (object) [
                                'openTypography' => 0,
                                'family' => "Roboto",
                                'type' => "sans-serif",
                                'size' => (object) ['md' => '14', 'unit' => 'px'],
                            ],
                            'style' => [(object) [
                                'selector' => '{{QUBELY}} .skillate-instructor-thumb .rating-avg'
                            ]]
                        ),
                        'ratingColor' => array(
                            'type'    => 'string',
                            'default' => '#1f2949',
                            'style' => [(object) [
                                'selector' => '{{QUBELY}} .skillate-instructor-thumb .rating-avg {color: {{ratingColor}};}'
                            ]]
                        ),

                        # Course.
                        'enableCourse' => array (
                            'type'         => 'boolean',
                            'default'      => true,
                        ),
                        'coursetypography' => array(
                            'type' => 'object',
                            'default' => (object) [
                                'openTypography' => 1,
                                'family' => "Open Sans",
                                'type' => "sans-serif",
                                'size' => (object) ['md' => '14', 'unit' => 'px'],
                            ],
                            'style' => [(object) [
                                'selector' => '{{QUBELY}} .instructor-course-count'
                            ]]
                        ),
                        'courseColor' => array(
                            'type'    => 'string',
                            'default' => '#797c7f',
                            'style' => [(object) [
                                'selector' => '{{QUBELY}} .instructor-course-count {color: {{courseColor}};}'
                            ]]
                        ),
                        'digiteColor' => array(
                            'type'    => 'string',
                            'default' => '#1f2949',
                            'style' => [(object) [
                                'selector' => '{{QUBELY}} .instructor-course-count strong {color: {{digiteColor}};}'
                            ]]
                        ),
                        'starColor' => array(
                            'type'    => 'string',
                            'default' => '#ffc922',
                            'style' => [(object) [
                                'selector' => '{{QUBELY}} .skillate-instructor-thumb .rating-avg i {color: {{starColor}};}'
                            ]]
                        ),
                        # End 

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
                    'render_callback' => array( $this, 'skillate_Core_Tutor_Course_Author_block_callback' ),
                )
            );
        }
    
		public function skillate_Core_Tutor_Course_Author_block_callback( $att ){
            $uniqueId 		= isset( $att['uniqueId'] ) ? $att['uniqueId'] : '';
            $layout 		= isset( $att['layout'] ) ? $att['layout'] : '1';
            $columns 		= isset( $att['columns'] ) ? $att['columns'] : '3';
            $order 		    = isset( $att['order'] ) ? $att['order'] : 'desc';
            $numbers 		= isset( $att['numbers'] ) ? $att['numbers'] : '';
            $enableTitle    = isset( $att['enableTitle'] ) ? $att['enableTitle'] : 1;
            $enableRating   = isset( $att['enableRating'] ) ? $att['enableRating'] : '';
            $enableCourse   = isset( $att['enableCourse'] ) ? $att['enableCourse'] : '';
            $animation      = isset($att['animation']) ? ( count((array)$att['animation']) > 0 && $att['animation']['animation']  ? 'data-qubelyanimation="'.htmlspecialchars(json_encode($att['animation']), ENT_QUOTES, 'UTF-8').'"' : '' ) : '';
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



            // $instructor_slide_query = get_theme_mod('instructor_slide_query', 'fav_instructor');
            // if($instructor_slide_query == 'fav_instructor'){
            //     $user_id = get_users( array(
            //         "meta_key"      => "favourite_instructor",
            //         "meta_value"    => 'yes',
            //         "fields"        => "ID",
            //         'number'        => $numbers 
            //     ));
            // }else{
            //     $user_id = get_users(array(
            //         'role'    => 'tutor_instructor',
            //         'fields'    => 'all_with_meta',
            //         // 'fields'  => 'ID',
            //         'number'        => $numbers 
            //     ));
            // }

            $user_id = get_users(array(
                'role'    => 'tutor_instructor',
                'fields'  => 'ID',
                'number'        => $numbers 
            ));
            
            $column = '';
            if( $columns == 2 ){
                $column = '6';
            }elseif( $columns == 3 ){
                $column = '4';
            }elseif( $columns == 4 ){
                $column = '3';
            }elseif( $columns == 6 ){
                $column = '2';
            }


            
            $user_id_count = count($user_id);

            $html = '';
            
            $html .= '<div class="qubely-block-'. $uniqueId .'">';
                $html .= '<div class="'.$interaction.'" '.$animation.'>';
                    if($layout == 2) {
                        $html .= '<div dir="rtl" class="author-slide-parent" data-columns="'.esc_attr($column).'">';
                            for ($i=0; $i < $user_id_count; $i++) { 
                                if(tutor_utils()->is_instructor($user_id[$i])){ 
                                    $user = get_userdata($user_id[$i]);  
                                    $instructor_rating = tutor_utils()->get_instructor_ratings($user_id[$i]);
                                    $html .= '<div class="single-instructor-slide">';
                                    $html .= '<div class="skillate-instructor-content">';
                                        $html .= '<div class="skillate-instructor-thumb">';
                                            global $post;
                                            $author_id = $user_id[$i]; 
                                            $user_photo = '';
                                            $tutor_user = tutor_utils()->get_tutor_user($author_id);
                                            if ($tutor_user->tutor_profile_photo){
                                                $user_photo = wp_get_attachment_image_url($tutor_user->tutor_profile_photo, 'skillate-courses');
                                            }
                                            if($user_photo){
                                                $html .= '<a href="'.tutor_utils()->profile_url($author_id).'"><img src='.$user_photo.' /></a>';
                                            }else{
                                                $html .= get_avatar($author_id, 255);
                                            }
                                            if($enableRating) {
                                                $html .= '<span class="rating-avg"><i class="fas fa-star"></i><strong>'.$instructor_rating->rating_avg.'</strong>/'.__('5', 'Skillate-core').'</span>';
                                            }
                                        $html .= '</div>';

                                        $html .= '<div class="upskil-instructor-content">';
                                            if( $enableTitle == 1 ) {
                                                $html .= '<a href="'.tutor_utils()->profile_url($author_id).'">';
                                                    $html .= '<h3 class="instructor-name">'.$user->display_name.'</h3>';
                                                $html .= '</a>';
                                            }
                                            if($enableCourse) {
                                                $html .= '<p class="instructor-course-count"><strong>'.tutor_utils()->get_course_count_by_instructor($user_id[$i]).'</strong>'.esc_html__('Courses', 'Skillate-core').'</p>';
                                            }
                                        $html .= '</div>';
                                    $html .= '</div>';
                                    $html .= '</div>';
                                }
                            }
                        $html .= '</div>';
                    }else {
                        $html .= '<div class="row">';


                            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1; // Needed for pagination
                            $paged -= 1;
                            $offset = $paged * $numbers;
                            $args  = array(
                                'role'      => 'tutor_instructor',
                                'fields'    => 'all_with_meta',
                                'number'    => $numbers, 
                                'offset'    => $offset     
                            );
                            $wp_user_query = new WP_User_Query($args);
                            $authors = $wp_user_query->get_results();

                            $users = get_users(array(
                                'role'    => 'tutor_instructor',
                            ));
                            // $users    = get_users();
                            $query    = get_users('&offset='.$offset.'&number='.$numbers);
                            $total_users = count($users);
                            $total_query = count($query);
                            $total_pages = intval($total_users / $numbers) + 1;

                            foreach($authors as $value) {
                                if(tutor_utils()->is_instructor($value->ID)){ 
                                    $user = get_userdata($value->ID);  
                                    $instructor_rating = tutor_utils()->get_instructor_ratings($value->ID);
                                    $html .= '<div class="col-md-'.$columns.' col-6">';
                                        $html .= '<div class="skillate-instructor-content">';
                                            $html .= '<div class="skillate-instructor-thumb">';
                                                global $post;
                                                $author_id = $value->ID; 
                                                $user_photo = '';
                                                $tutor_user = tutor_utils()->get_tutor_user($author_id);
                                                if ($tutor_user->tutor_profile_photo){
                                                    $user_photo = wp_get_attachment_image_url($tutor_user->tutor_profile_photo, 'skillate-courses');
                                                }
                                                
                                                if($user_photo){
                                                    $html .= '<img src='.$user_photo.' />';
                                                }else{
                                                    $html .= get_avatar($author_id, 255);
                                                }
                                                if($enableRating) {
                                                    $html .= '<span class="rating-avg"><i class="fas fa-star"></i><strong>'.$instructor_rating->rating_avg.'</strong>/'.__('5', 'Skillate-core').'</span>';
                                                }
                                                
                                            $html .= '</div>';

                                            $html .= '<div class="upskil-instructor-content">';
                                                if( $enableTitle == 1 ) {
                                                    $html .= '<h3 class="instructor-name">';
                                                        $html .= '<a href="'.tutor_utils()->profile_url($author_id).'">'.$user->display_name.'</a>';
                                                    $html .= '</h3>';
                                                }
                                                if($enableCourse) {
                                                    $html .= '<p class="instructor-course-count"><strong>'.tutor_utils()->get_course_count_by_instructor($author_id).'</strong>'.esc_html__('Courses', 'Skillate-core').'</p>';
                                                }
                                            $html .= '</div>';
                                        $html .= '</div>';
                                    $html .= '</div>';
                                }
                            } 
                            
                            // Author Grid Paginations
                            if ($total_users > $total_query) {
                                $big = 999999999;
                                $html .= '<div class="col-12"><div class="skillate-pagination" data-preview="'.__( "Prev","Skillate-core" ).'" data-nextview="'.__( "Next","Skillate-core" ).'">';
                                    $current_page = max(1, get_query_var('paged'));
                                    $html .= paginate_links(array(
                                        'base'          => esc_url_raw(str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) )),
                                        'format'        => 'page/%#%/',
                                        'current'       => $current_page,
                                        'total'         => $total_pages,
                                        'prev_text'     => __( 'Previous', 'Skillate-core' ),
                                        'next_text'     => __( 'Next', 'Skillate-core' ),
                                        'prev_next'    => true,
                                        'type'         => 'list',
                                    ));
                                $html .= '</div></div>';
                            }
                        
                        $html .= '</div>';
                    }
                $html .= '</div>';
            $html .= '</div>';

            wp_reset_postdata();
            return $html;
              
		}
    }
}
skillate_Core_Tutor_Course_Author::instance();
