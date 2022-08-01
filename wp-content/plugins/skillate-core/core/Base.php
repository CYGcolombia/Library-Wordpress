<?php
defined( 'ABSPATH' ) || exit;


if (! class_exists('skillate_Core_Base')) {

    class skillate_Core_Base{

        protected static $_instance = null;
        public static function instance(){
            if (is_null(self::$_instance)){
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        public function __construct() {
			add_action( 'init', array( $this, 'blocks_init' ));
			add_action( 'enqueue_block_editor_assets', array( $this, 'post_editor_assets' ) );
			add_action( 'enqueue_block_assets', array( $this, 'post_block_assets' ) );
			// Block Categories
			if ( version_compare( get_bloginfo( 'version' ), '5.8', '>=' ) ) {
				add_filter( 'block_categories_all', array( $this, 'block_categories' ), 1, 2 );
			} else {
			   add_filter( 'block_categories', array( $this, 'block_categories' ), 1, 2 );
			}
		}

		/**
		 * Blocks Init
		 */
		public function blocks_init(){
			require_once SKILLATE_CORE_PATH . 'core/blocks/tutorcourse/tutorcourse.php';
			require_once SKILLATE_CORE_PATH . 'core/blocks/courseauthor/courseauthor.php';
			require_once SKILLATE_CORE_PATH . 'core/blocks/skillatesearch/skillatesearch.php';
			require_once SKILLATE_CORE_PATH . 'core/blocks/skillate-countdown/skillate-countdown.php';
			require_once SKILLATE_CORE_PATH . 'core/blocks/skillatecoursecategory/coursecategory.php';
			require_once SKILLATE_CORE_PATH . 'core/blocks/skillate-course-tab/skillate-course-tab.php';
			require_once SKILLATE_CORE_PATH . 'core/blocks/skillate-lessons/skillate-lessons.php';
        }
        
		/**
		 * Only for the Gutenberg Editor(Backend Only)
		 */
		public function post_editor_assets(){
			global $pagenow;

			wp_enqueue_style(
				'skillate-core-editor-editor-css',
				skillate_CORE_URL . 'assets/css/blocks.editor.build.css',
				array( 'wp-edit-blocks' ),
				false
			);

			if ( 'widgets.php' !== $pagenow ) {
				// Scripts.
				wp_enqueue_script(
					'skillate-core-block-script-js',
					skillate_CORE_URL . 'assets/js/blocks.script.build.min.js', 
					array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor','qubely-blocks-js' ),
					false,
					true
				);
	
				wp_localize_script( 'skillate-core-block-script-js', 
				'thm_option', array(
					'plugin' => skillate_CORE_URL,
					'name' => 'skillate'
				) );
			}
		}

		/**
		 * All Block Assets (Frontend & Backend)
		 */
		public function post_block_assets(){
			// Styles.
			wp_enqueue_style(
				'skillate-core-global-style-css',
				skillate_CORE_URL . 'assets/css/blocks.style.build.css', 
				array( 'wp-editor' ),
				false
			);
		}

		/**
		 * Block Category Add
		 */
		public function block_categories( $categories, $post ){
			return array_merge(
				array(
					array(
						'slug' => 'skillate-core',
						'title' => __( 'Skillate Core', 'Skillate-core' ),
					)
				),
				$categories
			);
		}


		
    }
}
skillate_Core_Base::instance();





