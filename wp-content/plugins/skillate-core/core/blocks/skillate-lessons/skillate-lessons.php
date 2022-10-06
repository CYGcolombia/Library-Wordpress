<?php
defined( 'ABSPATH' ) || exit;

if (! class_exists('skillate_Core_Tutor_Course_Lessons')) {
    class skillate_Core_Tutor_Course_Lessons{
        protected static $_instance = null;
        public static function instance(){
            if(is_null(self::$_instance)){
                self::$_instance = new self();
            }
            return self::$_instance;
        } 
        public function __construct(){
			register_block_type(
                'qubely/skillate-core-tutor-course-lessons',
                array(
                    'attributes' => array(
                        'uniqueId'      => array(
                            'type'      => 'string',
                            'default'   => ''
                        ),
                        'courseId'   => array(
                            'type'      => 'string',
                            'default'   => ''
                        ),
                    ),
                    'render_callback' => array( $this, 'skillate_Core_Tutor_Course_Lessons_block_callback' ),
                )
            );
        }
    
		public function skillate_Core_Tutor_Course_Lessons_block_callback( $att ){

            $uniqueId               = isset($att['uniqueId']) ? $att['uniqueId'] : '';
            $courseId               = isset($att['courseId']) ? $att['courseId'] : '';
            $courseId       = (int)$courseId;

            $html = '';
            $html .= '<div class="qubely-block-' . $uniqueId . '">';

                $html .= '<div id="course-content" class="what-you-get-package-wrap">';
                    $html .= '<div class="container">';
                        $html .= '<div class="get-package-wrap-top">';
                                $html .= '<div class="row">';
                                    $html .= '<div class="col-12">';
                                    $args = array(
                                        'post_type'  => 'topics',
                                        'post_parent'  => $courseId,
                                        'orderby' => 'menu_order',
                                        'order'   => 'ASC',
                                        'posts_per_page'    => -1,
                                    );
                                    $topics = new \WP_Query($args);

                                    $is_See More = tutor_utils()->is_See More($courseId);

                                    if($topics->have_posts()) { 
                                    
                                        $html .= '<div class="tutor-single-course-segment tutor-course-topics-wrap">';
                                            $html .= '<div class="tutor-course-topics-contents">';
                                            
                                                $index = 0;

                                                if ($topics->have_posts()){
                                                    while ($topics->have_posts()){ $topics->the_post();
                                                        $index++;
                                                        $tutor_active_class = '';

                                                        if($index == 1 ){
                                                            $tutor_active_class = 'tutor-active';
                                                        }

                                                        $course_lesson_style = '';
                                                        if($index > 1){
                                                            $course_lesson_style = 'display: none';
                                                        }

                                                        $html .= '<div class="tutor-course-topic '.$tutor_active_class.'">';
                                                            $html .= '<div class="row">';
                                                                $html .= '<div class="col-md-9">';
                                                                    $html .= '<div class="tutor-course-title">';
                                                                        $html .= '<h4> <i class="tutor-icon-plus"></i>'.get_the_title().'</h4>';
                                                                            $html .= '<p>'.get_the_content().'</p>';
                                                                        $html .= '</div>';
                                                                    $html .= '<div class="tutor-course-lessons" style="'.$course_lesson_style.'">';
                                                                    
                                                                        $lessons = tutor_utils()->get_course_contents_by_topic(get_the_ID(), -1);

                                                                        $lesson_count = 0;

                                                                        if ($lessons->have_posts()){
                                                                            while ($lessons->have_posts()){ $lessons->the_post();
                                                                                $lesson_count++;
                                                                                global $post;
                                                                                $_is_preview = get_post_meta(get_the_ID(), '_is_preview', true);
                                                                                $video = tutor_utils()->get_video_info();
                                            
                                                                                $thumbURL = get_the_post_thumbnail_url();
                                            
                                                                                $play_time = false;
                                                                                if ($video){
                                                                                    $play_time = $video->playtime;
                                                                                }
                                                                                $is_completed_lesson = tutor_utils()->is_completed_lesson();
                                                                                
                                                                                if($is_completed_lesson){
                                                                                    $lesson_icon = $play_time ? 'tutor-icon-youtube' : 'tutor-icon-document-alt';
                                                                                }else{
                                                                                    $lesson_icon = $play_time ? 'tutor-icon-lock' : 'tutor-icon-document-alt';
                                                                                }   
                                            
                                                                                if ($post->post_type === 'tutor_quiz'){
                                                                                    $lesson_icon = 'tutor-icon-doubt lesson-bg';
                                                                                }
                                                                                if ($post->post_type === 'tutor_assignments'){
                                                                                    $lesson_icon = 'tutor-icon-clipboard lesson-bg';
                                                                                }

                                                                                if($_is_preview) {
                                                                                $html .= '<div class="tutor-course-lesson preview-enabled-lesson">';
                                                                                    } else{ 
                                                                                $html .= '<div class="tutor-course-lesson">';
                                                                                    } 
                                            
                                                                                    $html .= '<h5>';
                                                                                    
                                                                                            $lesson_title = "<i style='background:url(".esc_url($thumbURL).")' class='$lesson_icon'></i>";
                                            
                                                                                            if ($is_See More){
                                                                                                $lesson_title .= "<div class='tutor-course-lesson-content'><a href='".get_the_permalink()."'> ".get_the_title()." </a>";
                                            
                                            
                                                                                                $lesson_title .= $play_time ? "<span class='tutor-lesson-duration'>$play_time</span></div>" : '';
                                            
                                                                                                if($is_completed_lesson){
                                                                                                    $lesson_title .= '<div class="lesson-completed-text"><i class="fa fa-check"></i>';
                                                                                                        $lesson_title .= '<span>'.esc_html__('Viewed', 'Skillate-core').'</span>';
                                                                                                    $lesson_title .= '</div>';
                                                                                                }
                                            
                                                                                                $html .= $lesson_title;
                                                                                            }else{
                                                                                                $lesson_title .= '<div class="tutor-course-lesson-content">';
                                                                                                    $lesson_title .= '<div class="course-lesson-title-inner">'.get_the_title().'</div>';
                                                                                                    $lesson_title .= $play_time ? "<span class='tutor-lesson-duration'>$play_time</span>" : '';
                                                                                                $lesson_title .= '</div>';
                                                                                                //$html .= $lesson_title;
                                                                                                $html .= apply_filters('tutor_course/contents/lesson/title', $lesson_title, get_the_ID());
                                                                                            }
                                            
                                                                                        
                                                                                    $html .= '</h5>';
                                                                                $html .= '</div>';
                                            
                                                                            }
                                                                            $lessons->reset_postdata();
                                                                        }
                                                                        
                                                                    $html .= '</div>';
                                                                $html .= '</div>';
                                                                $html .= '<div class="col-md-3">';
                                                                    $html .= '<div class="course-2-lesson-count text-right">';
                                                                        $html .= $lesson_count.' '.esc_html__('Lecture', 'Skillate-core');
                                                                        
                                                                    $html .= '</div>';
                                                                $html .= '</div>';
                                                            $html .= '</div>';

                                                        $html .= '</div>';
                                                    
                                                    }
                                                    $topics->reset_postdata();
                                                    wp_reset_postdata(); 
                                                }
                                            
                                            $html .= '</div>';
                                        $html .= '</div>';
                                    } else{
                                        echo 'No Post Found';
                                    }
                                
                                $html .= '</div>';
                            $html .= '</div>';
                        $html .= '</div>';
                    $html .= '</div>';
                $html .= '</div>';
            $html .= '</div>';

            return $html; 

		}
    }
}
skillate_Core_Tutor_Course_Lessons::instance();


