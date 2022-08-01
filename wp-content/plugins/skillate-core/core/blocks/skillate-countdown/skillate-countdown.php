<?php
defined( 'ABSPATH' ) || exit;

if (! class_exists('skillate_Core_Countdown')) {

    class skillate_Core_Countdown{
		
        protected static $_instance = null;
        public static function instance(){
            if(is_null(self::$_instance)){
                self::$_instance = new self();
            }
            return self::$_instance;
        }
  
        public function __construct(){
			register_block_type(
                'qubely/upskill-countdown',
                    array(
                        'attributes' => array(

                            'uniqueId' => array(
                                'type' => 'string',
                            ),
                            
                            'endDate'       => array (
                                'type'      => 'number',
                                'default'       => ''
                            ),
                            'countdownTitle' => array (
                                'type'          => 'string',
                                'default'       => 'Deal Of The Year! 50% OFF!!',
                            ),
                            'countdownIntro' => array (
                                'type'          => 'string',
                                'default'       => 'Enjoy a hefty 50% discount on all courses for a limited time. This opportunity comes once in a year.',
                            ),
                            'countdownButton' => array (
                                'type'      => 'string',
                                'default'   => 'Grab It Now!',
                            ),

                            'buttonurl' => array (
                                'type'      => 'string',
                                'default'   => '#',
                            ),

                            #digiteColor, digiteTypography, digiteTextColor, digiteTextTypography
                            'digiteColor' => array(
                                'type'    => 'string',
                                'default' => '#1f2949',
                                'style' => [(object) [
                                    'selector' => '{{QUBELY}} .skillate-home-countdown-content .skillate-home-countdown-item .number h4 {color: {{digiteColor}};}'
                                ]]
                            ), 
                            'digiteTypography'   => array(
                                'type'          => 'object',
                                'default'       => (object) [
                                    'openTypography' => 1,
                                    'family'    => "Open Sans",
                                    'type'      => "sans-serif",
                                    'size'      => (object) ['md' => 24, 'unit' => 'px'],
                                ],
                                'style'         => [(object) [
                                    'selector'  => '{{QUBELY}} .skillate-home-countdown-content .skillate-home-countdown-item .number h4'
                                ]]
                            ),

                            # Digite Text.
                            'digiteTextColor' => array(
                                'type'    => 'string',
                                'default' => '#b0b4b8',
                                'style' => [(object) [
                                    'selector' => '{{QUBELY}} .skillate-home-countdown-content .skillate-home-countdown-item .text h5 {color: {{digiteTextColor}};}'
                                ]]
                            ), 
                            'digiteTextTypography'   => array(
                                'type'          => 'object',
                                'default'       => (object) [
                                    'openTypography' => 1,
                                    'family'    => "Open Sans",
                                    'type'      => "sans-serif",
                                    'size'      => (object) ['md' => 16, 'unit' => 'px'],
                                ],
                                'style'         => [(object) [
                                    'selector'  => '{{QUBELY}} .skillate-home-countdown-content .skillate-home-countdown-item .text h5'
                                ]]
                            ),

                            #titleColor
                            'titleColor' => array(
                                'type'    => 'string',
                                'default' => '#1f2949',
                                'style' => [(object) [
                                    'selector' => '{{QUBELY}} .skillate-home-countdown-title .skillate-countdown-title {color: {{titleColor}};}'
                                ]]
                            ), 
                            'titleTypography'   => array(
                                'type'          => 'object',
                                'default'       => (object) [
                                    'openTypography' => 1,
                                    'family'    => "Open Sans",
                                    'type'      => "sans-serif",
                                    'size'      => (object) ['md' => 32, 'unit' => 'px'],
                                ],
                                'style'         => [(object) [
                                    'selector'  => '{{QUBELY}} .skillate-home-countdown-title .skillate-countdown-title'
                                ]]
                            ),
                            'titleSpacing'      => array(
                                'type'          => 'object',
                                'default'       => (object) array(
                                    'md'        => 10,
                                    'unit'      => 'px'
                                ),
                                'style'         => [
                                    (object) [
                                        'selector' => '{{QUBELY}} .skillate-home-countdown-title h3 {margin-bottom: {{titleSpacing}};}'
                                    ]
                                ]
                            ),


                            # Subtitle
                            'subtitleColor' => array(
                                'type'    => 'string',
                                'default' => '#797c7f',
                                'style' => [(object) [
                                    'selector' => '{{QUBELY}} .countdown-intro-text {color: {{subtitleColor}};}'
                                ]]
                            ), 
                            'subtitleTypography'   => array(
                                'type'          => 'object',
                                'default'       => (object) [
                                    'openTypography' => 1,
                                    'family'    => "Open Sans",
                                    'type'      => "sans-serif",
                                    'size'      => (object) ['md' => 16, 'unit' => 'px'],
                                ],
                                'style'         => [(object) [
                                    'selector'  => '{{QUBELY}} .countdown-intro-text'
                                ]]
                            ),
                            'subtitleSpacing'      => array(
                                'type'          => 'object',
                                'default'       => (object) array(
                                    'md'        => 30,
                                    'unit'      => 'px'
                                ),
                                'style'         => [
                                    (object) [
                                        'selector' => '{{QUBELY}} .skillate-home-countdown-content .skillate-home-countdown-header {margin-bottom: {{subtitleSpacing}};}'
                                    ]
                                ]
                            ),

                            // Design.
                            'buttonColor' => array(
                                'type'    => 'string',
                                'default' => '#ffffff',
                                'style' => [(object) [
                                    'selector' => '{{QUBELY}} .skillate-home-countdown-content .skillate-home-countdown-cta-btn a.btn-primary {color: {{buttonColor}};}'
                                ]]
                            ), 
                            'buttonBgColor' => array(
                                'type' => 'object',
                                'default' => (object) array(
                                    'openColor' => 1,
                                    'type' => 'color',
                                    'color' => '#2184F9',
                                    'gradient' => (object) [
                                        'color1' => '#16d03e',
                                        'color2' => '#1f91f3',
                                        'direction' => 45,
                                        'start' => 0,
                                        'stop' => 100,
                                        'type' => 'linear'
                                    ],
                                ),
                                'style' => [(object) [
                                    'selector' => '{{QUBELY}} .skillate-home-countdown-content .skillate-home-countdown-cta-btn .btn-primary'
                                ]]
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
                                        'selector' => '{{QUBELY}} .skillate-home-countdown-content .skillate-home-countdown-cta-btn .btn-primary'
                                    ]
                                ]
                            ),
                            'buttonShadow' => array(
                                'type' => 'object',
                                'default' => (object) array(
                                    'blur' => 8,
                                    'color' => "rgba(0,0,0,0.10)",
                                    'horizontal' => 0,
                                    'inset' => 0,
                                    'openShadow' => true,
                                    'spread' => 0,
                                    'vertical' => 4
                                ),
                                'style' => [
                                    (object) [
                                        'selector' => '{{QUBELY}} .skillate-home-countdown-content .skillate-home-countdown-cta-btn .btn-primary'
                                    ]
                                ]
                            ),
                            'buttonHoverColor' => array(
                                'type'    => 'string',
                                'default' => '#ffffff',
                                'style' => [(object) [
                                    'selector' => '{{QUBELY}} .skillate-home-countdown-content .skillate-home-countdown-cta-btn a.btn-primary:hover {color: {{buttonHoverColor}};}'
                                ]]
                            ),




                            # border, borderRadius, boxShadow
                            'countdownBgColor' => array(
                                'type' => 'object',
                                'default' => (object) array(
                                    'openColor' => 1,
                                    'type' => 'color',
                                    'color' => '#ffffff',
                                    'gradient' => (object) [
                                        'color1' => '#16d03e',
                                        'color2' => '#1f91f3',
                                        'direction' => 45,
                                        'start' => 0,
                                        'stop' => 100,
                                        'type' => 'linear'
                                    ],
                                ),
                                'style' => [(object) [
                                    'selector' => '{{QUBELY}} .skillate-home-countdown-content'
                                ]]
                            ),
                            'bgPadding'      => array(
                                'type'          => 'object',
                                'default'       => (object) array(
                                    'md'        => 40,
                                    'unit'      => 'px'
                                ),
                                'style'         => [
                                    (object) [
                                        'selector' => '{{QUBELY}} .skillate-home-countdown-content {padding: {{bgPadding}}; display: block;}'
                                    ]
                                ]
                            ),
                            'border'            => array(
                                'type'          => 'object',
                                'default'       => (object) array(),
                                'style'         => [(object) [
                                    'selector'  => '{{QUBELY}} .skillate-home-countdown-content'
                                ]]
                            ),
                            'borderRadius'      => array(
                                'type'          => 'object',
                                'default'       => (object) array(),
                                'style'         => [(object) [
                                    'selector' => '{{QUBELY}} .skillate-home-countdown-content'
                                ]]
                            ),
                            'boxShadow' => array(
                                'type' => 'object',
                                'default' => (object) array(),
                                'style' => [(object) [
                                    'selector' => '{{QUBELY}} .skillate-home-countdown-content'
                                ]]
                            ),

                            'enableButton'         => array(
                                'type'          => 'boolean',
                                'default'       => true
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
                        'render_callback' => array( $this, 'skillate_core_countdown_block_callback' ),
                )
            );
        }
    
		public function skillate_core_countdown_block_callback( $att ){
            $uniqueId 		    = isset($att['uniqueId']) ? $att['uniqueId'] : '';
            $endDate 	        = isset( $att['endDate'] ) ? $att['endDate'] : '';
            $countdownTitle 	= isset( $att['countdownTitle'] ) ? $att['countdownTitle'] : '';
            $countdownIntro 	= isset( $att['countdownIntro'] ) ? $att['countdownIntro'] : '';
            $countdownButton 	= isset( $att['countdownButton'] ) ? $att['countdownButton'] : '';
            $enableButton 	    = isset( $att['enableButton'] ) ? $att['enableButton'] : 1;
            $url 	    = isset( $att['buttonurl'] ) ? $att['buttonurl'] : '';

            $animation  = isset($att['animation']) ? ( count((array)$att['animation']) > 0 && $att['animation']['animation']  ? 'data-qubelyanimation="'.htmlspecialchars(json_encode($att['animation']), ENT_QUOTES, 'UTF-8').'"' : '' ) : '';

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


            $timeLeft   = $endDate - time();
            $seconds    = $timeLeft % 60;
            $minutes    = (($timeLeft - $seconds) % 3600) / 60;
            $hours      = (($timeLeft - $minutes * 60 - $seconds) % 86400) / 3600;
            $minute     = ($minutes == '0') ? 1 : $minutes;
            $days       = (int)(($timeLeft - $hours / 3600 / $minute * 60 - $seconds) / 86400 );

            $html = '';
            $html .= '<div class="skillate-home-countdown qubely-block-'.$uniqueId.'">';
                $html .= '<div class="skillate-home-countdown-content '.$interaction.'" '.$animation.'>';
                    $html .= '<header class="skillate-home-countdown-header">';
                        if( $countdownTitle ) {
                            $html .= '<div class="skillate-home-countdown-title">';
                                $html .= '<h3 class="skillate-countdown-title">'. $countdownTitle .'</h3>';
                            $html .= '</div>';
                        }
                        if( $countdownIntro ) {
                            $html .= '<div class="skillate-home-countdown-body">';
                                $html .= '<p class="countdown-intro-text">'. $countdownIntro .'</p>';
                            $html .= '</div>';
                        }
                    $html .= '</header>';

                    $html .= '<footer class="skillate-home-countdown-footer">';
                        $html .= '<div class="row">';
                                
                                $html .= ($enableButton) ? '<div class="col-md-7 col-sm-12">' : '<div class="col-md-12 col-sm-12">';
                                    $html .= '<div class="skillate-home-countdown-wrapper" data-enddate='.$endDate.'>';
                                        $html .= '<div class="skillate-home-countdown-item">';
                                            $html .= '<div class="number"><h4>'.$days.'</h4></div>';
                                            $html .= '<div class="text"><h5>days</h5></div>';
                                        $html .= '</div>';
                                        $html .= '<div class="skillate-home-countdown-item">';
                                            $html .= '<div class="number"><h4 class="hours">'.$hours.'</h4></div>';
                                            $html .= '<div class="text"><h5>Hours</h5></div>';
                                        $html .= '</div>';
                                        $html .= '<div class="skillate-home-countdown-item">';
                                            $html .= '<div class="number"><h4 class="minutes">'.$minutes.'</h4></div>';
                                            $html .= '<div class="text"><h5>Minutes</h5></div>';
                                        $html .= '</div>';
                                        $html .= '<div class="skillate-home-countdown-item">';
                                            $html .= '<div class="number"><h4 class="second">'.$seconds.'</h4></div>';
                                            $html .= '<div class="text"><h5>Seconds</h5></div>';
                                        $html .= '</div>';
                                    $html .= '</div>';
                                $html .= '</div>';

                                if($enableButton) {
                                    $html .= '<div class="col-md-5 col-sm-12">';
                                        $html .= '<div class="skillate-home-countdown-cta-btn">';
                                        $html .= '<a target="_blank" href="'. esc_url($url) .'" class="btn btn-primary">'. $countdownButton .'</a>';
                                    $html .= '</div>';
                                }
                                
                            $html .= '</div>';
                        $html .= '</div>';
                    $html .= '</footer>';
                $html .= '</div>';
            $html .= '</div>';
            
			return $html;
		}
    }
}
skillate_Core_Countdown::instance();
