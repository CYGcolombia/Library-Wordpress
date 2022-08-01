<?php

add_action( 'wp_ajax_thmloadmore', 'thmloadmore' );
add_action( 'wp_ajax_nopriv_thmloadmore', 'thmloadmore' );

function thmloadmore() {
	global $wpdb; # this is how you get access to the database

	$output         = '';
	$posts          = 0;
	$paged          = 1;
	$perpage        = '';
    $show_column    = '';
    $show_layout    = '';

	if(isset( $_POST['paged'] )){ $paged = $_POST['paged']; }
	if(isset( $_POST['perpage'] )){ $perpage = $_POST['perpage']; }
    if(isset( $_POST['column'] )){ $show_column = $_POST['column']; }
    if(isset( $_POST['layout'] )){ $show_layout = $_POST['layout']; }

	$args = array(
		'post_type'        	=> 'courses',
        'order' 			=> 'ASC',
        'posts_per_page' 	=> $perpage,
        'paged' 			=> $paged
    );

    $posts = get_posts($args);
    if(count($posts)>0){
        foreach ($posts as $key=>$post): setup_postdata($post); 

        global $authordata;
        $profile_url = tutor_utils()->profile_url($authordata->ID); ?>

        <?php if ($show_layout == 1) { ?>
            <div class="tutor-course-grid-item col-md-<?php echo $show_column; ?>">
                <div class="tutor-course-grid-content">
                    <div class="tutor-course-overlay">
                        <?php echo get_the_post_thumbnail($post->ID, 'skillate-wide', array('class' => 'img-responsive')) ?>
                        <div class="tutor-course-grid-level-wishlist">
                            <span class="tutor-course-grid-wishlist tutor-course-wishlist">
                                <a href="javascript:;" class="tutor-icon-bookmark-line tutor-course-wishlist-btn has-wish-listed " data-course-id=<?php echo $post->ID; ?>>
                                    <?php 
                                    $get_avatar_url = get_avatar_url(get_current_user_id($post->ID), 'thumbnail'); 
                                    if ($get_avatar_url) { ?>
                                        <img src="<?php echo $get_avatar_url; ?>" class="img-responsive" />
                                    <?php } ?>
                                </a>
                            </span>
                        </div>
                        <div class="tutor-course-grid-enroll"><a href="<?php echo get_permalink($post->ID); ?>" class="btn btn-classic btn-no-fill">View Details</a></div>
                    </div>
                    <div class="tutor-course-content">
                        <div class="tutor-loop-rating-wrap">
                            <?php 
                                $course_rating = tutor_utils()->get_course_rating($post->ID);
                                ob_start();
                                tutor_utils()->star_rating_generator($course_rating->rating_avg);
                                echo ob_get_clean();
                            ?>
                        </div>
                        <h3 class="tutor-courses-grid-title">
                            <a href="<?php echo get_permalink($post->ID); ?>"><?php echo get_the_title($post->ID); ?></a>
                        </h3>
                        <div class="course-info">
                            <ul class="category-list">
                                <li><span><?php esc_html_e('By ', 'Skillate-core'); ?></span></li>
                                <li><a href="<?php echo esc_url($profile_url); ?>"><?php echo get_the_author() ?></a></li>
                                <li><span><?php esc_html_e(' in ', 'Skillate-core'); ?></span></li>
                                <?php $course_categories = get_tutor_course_categories($post->ID);
                                    if(!empty($course_categories) && is_array($course_categories ) && count($course_categories)){
                                        $ind = 0;
                                        foreach ($course_categories as $course_category){
                                            $category_name = $course_category->name;
                                            $category_link = get_term_link($course_category->term_id); ?>
                                            <li><a href="<?php echo $category_link; ?>"><?php echo $category_name; ?></a></li>
                                        <?php $ind++;
                                        }
                                    }
                                ?>
                                
                            </ul>
                        </div>
                    </div>
                    <div class="tutor-courses-grid-price">
                        
                        <?php 
                        $price = apply_filters('get_tutor_course_price', null, $post->ID);
                        $output = '';
                        ob_start();
                        if($price == !null){
                            $output .= $price;
                        }else{
                            $output .= '<div class="price">'.esc_html__('Free', 'Skillate-core').'</div>';
                        }
                        $output .= ob_get_clean();
                        echo $output;
                        ?>
                        <a class="course-detail" href="<?php echo get_permalink($post->ID); ?>"><i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        <?php } else{ ?>

            <div class="tutor-course-grid-item course-wrap col-md-<?php echo  $show_column; ?>">
                <div class="tutor-course-grid-content">
                    <div class="tutor-course-overlay">
                        <?php echo get_the_post_thumbnail($post->ID, 'skillate-courses', array('class' => 'img-responsive')) ?>
                        <div class="tutor-course-grid-level-wishlist">
                            <span class="tutor-course-grid-wishlist tutor-course-wishlist">
                                <span class="course-level"><?php echo get_tutor_course_level($post->ID); ?></span>
                                <a href="javascript:;" class="tutor-icon-bookmark-line tutor-course-wishlist-btn has-wish-listed " data-course-id=<?php echo $post->ID; ?>></a>
                            </span>
                        </div>
                        <div class="tutor-course-grid-enroll"><a href="<?php echo get_permalink($post->ID); ?>" class="btn btn-classic btn-no-fill"><?php echo esc_html__('View Details','Skillate-core');?></a></div>
                    </div>
                           
                    <div class="tutor-course-content">
                        <div class="tutor-courses-grid-price">
                        <?php 
                            $price = apply_filters('get_tutor_course_price', null, $post->ID);
                            $output = '';
                            ob_start();
                            if($price == !null){
                                $output .= $price;
                            }else{
                                $output .= '<div class="price">'.esc_html__('Free', 'Skillate-core').'</div>';
                            }
                            $output .= ob_get_clean();
                            echo $output;
                        ?>
                        </div>
                        <h3 class="tutor-courses-grid-title">
                            <a href="<?php echo esc_url(get_the_permalink($post->ID)); ?>">
                                <?php echo get_the_title($post->ID); ?>
                            </a>
                        </h3>
                    </div>

                </div>
            </div>
        <?php } ?>
        
        <?php 
        endforeach;
		wp_reset_postdata();   
	}
	wp_die(); # die 

}