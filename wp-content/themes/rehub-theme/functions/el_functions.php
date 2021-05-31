<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php
// Enqueue Scripts
add_action( 'elementor/preview/enqueue_scripts', function () {
    wp_enqueue_script('owlcarousel', get_template_directory_uri() . '/js/owl.carousel.min.js', array('jquery'), '1.9.9', true);
    wp_enqueue_script('flexslider', get_template_directory_uri() . '/js/jquery.flexslider-min.js', false, false, true);
    wp_enqueue_script('video_playlist');
    wp_enqueue_script('modulobox');
    wp_enqueue_script('tipsy');
    wp_enqueue_script('zeroclipboard');
    wp_enqueue_script('rh_elparticle');
    wp_enqueue_script('rehub-elementor', get_template_directory_uri() . '/rehub-elementor/js/custom-elementor.js', array('jquery'), false, true);
}); 
add_action( 'elementor/preview/enqueue_styles', function() {
    wp_enqueue_style( 'video-pl' );
    wp_enqueue_style('modulobox');
} );    

add_action( 'elementor/elements/categories_registered', function( $elements_manager ) {
     $elements_manager->add_category( 'rehub-category', [ 'title' => esc_html__( 'Rehub Woocommerce Modules', 'rehub-theme' ), 'icon' => 'eicon-woocommerce' ] );
     $elements_manager->add_category( 'content-modules', [ 'title' => esc_html__( 'Rehub Post Modules', 'rehub-theme' ) ] );
     $elements_manager->add_category( 'deal-helper', [ 'title' => esc_html__( 'Rehub Deal/Coupon Modules', 'rehub-theme' ) ] );
     $elements_manager->add_category( 'helpler-modules', [ 'title' => esc_html__( 'Rehub Helper Modules', 'rehub-theme' ) ] );       
});

add_action( 'init', function () {
    // Ajax general callback methods  and control
    require_once (locate_template('rehub-elementor/controls/ajax-callbacks.php'));
    require_once (locate_template('rehub-elementor/controls/select2ajax-control.php'));
    // Abstracts
    require_once (rh_locate_template('rehub-elementor/abstracts/content-base-widget.php'));

    // Widgets
    if(class_exists('Woocommerce')){
        // Abstracts
        require_once (rh_locate_template('rehub-elementor/abstracts/woo-base-widget.php')); 

        require_once (rh_locate_template('rehub-elementor/wpsm-woogrid.php'));
        require_once (rh_locate_template('rehub-elementor/wpsm-woocolumns.php'));       
        require_once (rh_locate_template('rehub-elementor/wpsm-woorows.php'));
        require_once (rh_locate_template('rehub-elementor/wpsm-woolist.php'));
        require_once (rh_locate_template('rehub-elementor/wpsm-woofeatured.php'));
        require_once (rh_locate_template('rehub-elementor/wpsm-woocarousel.php'));
        require_once (rh_locate_template('rehub-elementor/wpsm-woocomparebars.php'));
         require_once (rh_locate_template('rehub-elementor/wpsm-wooday.php'));
    }

    require_once (rh_locate_template('rehub-elementor/wpsm_columngrid.php'));
    require_once (rh_locate_template('rehub-elementor/wpsm-newslist.php'));
    require_once (rh_locate_template('rehub-elementor/wpsm-regularblog.php'));
    require_once (rh_locate_template('rehub-elementor/wpsm-masonrygrid.php'));
    require_once (rh_locate_template('rehub-elementor/wpsm-simplelist.php'));
    require_once (rh_locate_template('rehub-elementor/wpsm-postfeatured.php'));
    require_once (rh_locate_template('rehub-elementor/wpsm-news-with-thumbs.php'));
    require_once (rh_locate_template('rehub-elementor/wpsm-twocolnews.php'));
    require_once (rh_locate_template('rehub-elementor/wpsm-news-ticker.php'));
    require_once (rh_locate_template('rehub-elementor/wpsm_coloredgrid.php'));
    require_once (rh_locate_template('rehub-elementor/wpsm-3col-grid.php'));        
    
    require_once (rh_locate_template('rehub-elementor/wpsm-deallist.php'));
    require_once (rh_locate_template('rehub-elementor/wpsm-dealgrid.php'));
    require_once (rh_locate_template('rehub-elementor/wpsm-dealcarousel.php'));
    require_once (rh_locate_template('rehub-elementor/wpsm-reviewlist.php'));
    require_once (rh_locate_template('rehub-elementor/wpsm-offerbox.php'));
    require_once (rh_locate_template('rehub-elementor/wpsm-CEbox.php'));

    require_once (rh_locate_template('rehub-elementor/wpsm-hover-banner.php'));
    require_once (rh_locate_template('rehub-elementor/wpsm-box.php'));
    require_once (rh_locate_template('rehub-elementor/wpsm-taxarchive.php'));
    require_once (rh_locate_template('rehub-elementor/wpsm-videolist.php'));
    require_once (rh_locate_template('rehub-elementor/wpsm-catbox.php'));
    require_once (rh_locate_template('rehub-elementor/wpsm-proscons.php'));
    require_once (rh_locate_template('rehub-elementor/wpsm-searchbox.php'));
    require_once (rh_locate_template('rehub-elementor/wpsm-cardbox.php'));
    require_once (rh_locate_template('rehub-elementor/wpsm-getter.php'));
    require_once (rh_locate_template('rehub-elementor/wpsm-buttonpopup.php'));
    require_once (rh_locate_template('rehub-elementor/wpsm-versustable.php'));
    require_once (rh_locate_template('rehub-elementor/wpsm-countdown.php'));
    require_once (rh_locate_template('rehub-elementor/wpsm-itinerary.php'));    
    require_once (rh_locate_template('rehub-elementor/wpsm-numhead.php')); 
    require_once (rh_locate_template('rehub-elementor/wpsm-reviewbox.php')); 
    require_once (rh_locate_template('rehub-elementor/wpsm-tabevery.php'));
    require_once (rh_locate_template('rehub-elementor/wpsm-canvas.php'));  
});

if(!function_exists('rh_add_el_page_settings_controls')){
    function rh_add_el_page_settings_controls( $page ) {
        if(isset($page)) {
            $page->add_control( 'content_type', [
                'type'        => \Elementor\Controls_Manager::SELECT,
                'label'       => esc_html__( 'Type of content area', 'rehub-theme' ),
                'default'    => 'def',
                'options'     => [
                    'def'   =>  esc_html__('Content with sidebar', 'rehub-theme'),
                    'full_width'   =>  esc_html__('Full Width Content Box', 'rehub-theme'),
                    'full_post_area'   =>  esc_html__('Full width of browser window', 'rehub-theme')
                ],
                'condition'  => [ 'template' => [ 'default' ] ],
                'label_block'  => true,
            ]);
            $page->add_control( '_header_disable', [
                'type'        => \Elementor\Controls_Manager::SELECT,
                'label'       => esc_html__( 'How to show header?', 'rehub-theme' ),
                'default'    => '0',
                'options'     => [
                    '0'   =>  esc_html__('Default', 'rehub-theme'),
                    '1'   =>  esc_html__('Disable header', 'rehub-theme'),
                    '2'   =>  esc_html__('Transparent', 'rehub-theme')
                ],
                'condition'  => [ 'template' => [ 'default' ] ],
                'label_block'  => true,
            ]); 
            $page->add_control( '_enable_preloader', [
                'type'        => \Elementor\Controls_Manager::SWITCHER,
                'label'       => esc_html__( 'Enable page preloader', 'rehub-theme' ),
                'label_on'    => esc_html__('Yes', 'rehub-theme'),
                'label_off'   => esc_html__('No', 'rehub-theme'),
                'return_value' => '1',
                'condition'  => [ 'template' => [ 'default' ] ],
            ]);                         
            $page->add_control( 'menu_disable', [
                'type'        => \Elementor\Controls_Manager::SWITCHER,
                'label'       => esc_html__( 'Disable menu', 'rehub-theme' ),
                'label_on'    => esc_html__('Yes', 'rehub-theme'),
                'label_off'   => esc_html__('No', 'rehub-theme'),
                'selectors' => [
                     'nav.top_menu, .responsive_nav_wrap' => 'display: none !important',
                ],
                'condition'  => [ 'template' => [ 'default' ] ],                
            ]); 
            $page->add_control( '_footer_disable', [
                'type'        => \Elementor\Controls_Manager::SWITCHER,
                'label'       => esc_html__( 'Disable footer', 'rehub-theme' ),
                'label_on'    => esc_html__('Yes', 'rehub-theme'),
                'label_off'   => esc_html__('No', 'rehub-theme'),
                'return_value' => '1',
                'condition'  => [ 'template' => [ 'default' ] ],
            ]);                                     
        }
    }       
}
add_action( 'elementor/element/wp-page/document_settings/before_section_end', 'rh_add_el_page_settings_controls', 10, 2 ); 

if(!function_exists('rh_register_elementor_locations')){
function rh_register_elementor_locations( $elementor_theme_manager ) {
    $elementor_theme_manager->register_location(
        'woo_btn_code_area',
        [
            'label' => esc_html__( 'Woo Code area near Button', 'rehub-theme' ),
            'multiple' => true,
            'edit_in_content' => true,
        ]
    );
    $elementor_theme_manager->register_location(
        'woo_btn_content_area',
        [
            'label' => esc_html__( 'Woo Code area near Short Description', 'rehub-theme' ),
            'multiple' => true,
            'edit_in_content' => true,
        ]
    );
    $elementor_theme_manager->register_location(
        'woo_btn_footer_area',
        [
            'label' => esc_html__( 'Woo Code area after content', 'rehub-theme' ),
            'multiple' => true,
            'edit_in_content' => true,
        ]
    );                      
}
}
add_action( 'elementor/theme/register_locations', 'rh_register_elementor_locations' );  

/*add_action('elementor/widgets/widgets_registered', function($widgets_manager){
    $elementor_widget_blacklist = array('star-rating');
    foreach($elementor_widget_blacklist as $widget_name){
        $widgets_manager->unregister_widget_type($widget_name);
    }
}, 15);*/

// Font-awesome pro support
add_action( 'elementor/editor/before_enqueue_scripts', function() {
   wp_enqueue_style( 'rehubfontawesome', get_template_directory_uri() . '/admin/fonts/fontawesome/font-awesome.min.css', array(), '5.3.1' );
} );   
add_action( 'elementor/frontend/after_enqueue_styles', function () { 
    wp_dequeue_style( 'font-awesome' );
    wp_dequeue_style( 'font-awesome-5-all' );
    wp_dequeue_style('font-awesome-4-shim');
    wp_dequeue_script('font-awesome-4-shim');  
}, 15 );
add_action( 'elementor/editor/after_enqueue_styles', function () { 
    wp_dequeue_style( 'font-awesome' );
    wp_dequeue_style( 'font-awesome-5-all' );
    wp_dequeue_style('font-awesome-4-shim');
    wp_dequeue_script('font-awesome-4-shim');  
}, 15 );

add_filter('elementor/icons_manager/native', 'rh_change_native_fa', 99);
function rh_change_native_fa($tabs){
    return [
            'rh-regular' => [
                'name' => 'fa-regular',
                'label' => esc_html__( 'Font Awesome - Regular', 'rehub-theme' ),
                'url' => '',
                'enqueue' => '',
                'prefix' => 'fa-',
                'displayPrefix' => 'far',
                'labelIcon' => 'fab fa-font-awesome-alt',
                'ver' => '5.9.0',
                'fetchJson' => get_template_directory_uri() . '/rehub-elementor/solid.json',
                'native' => true,
            ],
            'rh-solid' => [
                'name' => 'fa-solid',
                'label' => esc_html__( 'Font Awesome - Solid', 'rehub-theme' ),
                'url' => '',
                'enqueue' => '',
                'prefix' => 'fa-',
                'displayPrefix' => 'fas',
                'labelIcon' => 'fab fa-font-awesome',
                'ver' => '5.9.0',
                'fetchJson' => get_template_directory_uri() . '/rehub-elementor/solid.json',
                'native' => true,
            ],
            'rh-light' => [
                'name' => 'fa-light',
                'label' => esc_html__( 'Font Awesome - Light', 'rehub-theme' ),
                'url' => '',
                'enqueue' => '',
                'prefix' => 'fa-',
                'displayPrefix' => 'fal',
                'labelIcon' => 'fab fa-font-awesome',
                'ver' => '5.9.0',
                'fetchJson' => get_template_directory_uri() . '/rehub-elementor/solid.json',
                'native' => true,
            ],            
            'rh-brands' => [
                'name' => 'fa-brands',
                'label' => esc_html__( 'Font Awesome - Brands', 'rehub-theme' ),
                'url' => '',
                'enqueue' => '',
                'prefix' => 'fa-',
                'displayPrefix' => 'fab',
                'labelIcon' => 'fab fa-font-awesome-flag',
                'ver' => '5.9.0',
                'fetchJson' => get_template_directory_uri() . '/rehub-elementor/brands.json',
                'native' => true,
            ],
        ];
}

add_action( 'elementor/frontend/widget/before_render', 'RH_el_elementor_frontend' );
add_action( 'elementor/frontend/section/before_render', 'RH_el_elementor_frontend_section' );
add_action( 'elementor/element/section/section_advanced/after_section_end', 'RH_custom_section_elementor', 10, 2 );
add_action( 'elementor/element/common/_section_responsive/after_section_end', 'RH_parallax_el_elementor', 10, 2 );
add_action( 'elementor/element/html/section_title/after_section_end', 'RH_el_html_add_custom', 10, 2 );
add_action( 'elementor/widget/render_content', 'RH_el_custom_widget_render', 10, 2 );
add_filter('elementor/controls/animations/additional_animations', 'RH_additional_el_annimation');
add_filter( 'elementor/widget/print_template', 'rh_custom_print_template', 10, 2 );

function RH_custom_section_elementor( $obj, $args ) {

    $obj->start_controls_section(
        'section_rh_stickyel',
        array(
            'label' => esc_html__( 'RH Smart Sticky Scroll and Parallax', 'rehub-theme' ),
            'tab'   => Elementor\Controls_Manager::TAB_ADVANCED,
        )
    );

    $obj->add_control(
        'rh_stickyel_section_sticky',
        array(
            'label'        => esc_html__( 'Enable smart scroll', 'rehub-theme' ),
            'description' => esc_html__( 'You must have minimum two columns. Smart scroll is visible only on frontend site and not visible in Editor mode of Elementor', 'rehub-theme' ),
            'type'         => Elementor\Controls_Manager::SWITCHER,
            'label_on'     => esc_html__( 'Yes', 'rehub-theme' ),
            'label_off'    => esc_html__( 'No', 'rehub-theme' ),
            'return_value' => 'true',
            'prefix_class' => 'rh-elementor-sticky-',
        )
    );

    $obj->add_control(
        'rh_stickyel_top_spacing',
        array(
            'label'   => esc_html__( 'Top Spacing', 'rehub-theme' ),
            'type'    => Elementor\Controls_Manager::NUMBER,
            'min'     => 0,
            'max'     => 500,
            'step'    => 1,
            'condition' => array(
                'rh_stickyel_section_sticky' => 'true',
            ),
        )
    );

    $obj->add_control(
        'rh_stickyel_bottom_spacing',
        array(
            'label'   => esc_html__( 'Bottom Spacing', 'rehub-theme' ),
            'type'    => Elementor\Controls_Manager::NUMBER,
            'min'     => 0,
            'max'     => 500,
            'step'    => 1,
            'condition' => array(
                'rh_stickyel_section_sticky' => 'true',
            ),
        )
    );

    $obj->add_control(
        'rh_parallax_bg',
        array(
            'label'        => esc_html__( 'Enable parallax for background image', 'rehub-theme' ),
            'description' => esc_html__( 'Add background in Style section', 'rehub-theme' ),
            'type'         => Elementor\Controls_Manager::SWITCHER,
            'label_on'     => esc_html__( 'Yes', 'rehub-theme' ),
            'label_off'    => esc_html__( 'No', 'rehub-theme' ),
            'return_value' => 'true',
            'prefix_class' => 'rh-parallax-bg-',
        )
    );

    $obj->add_control(
        'rh_parallax_bg_speed',
        array(
            'label'   => esc_html__( 'Parallax speed', 'rehub-theme' ),
            'type'    => Elementor\Controls_Manager::NUMBER,
            'min'     => 1,
            'max'     => 200,
            'step'    => 1,
            'default' => 10,
            'condition' => array(
                'rh_parallax_bg' => 'true',
            ),
            'prefix_class' => 'rh-parallax-bg-speed-',
        )
    );      

    $obj->end_controls_section();
} 
function RH_parallax_el_elementor( $obj, $args ) {

    $obj->start_controls_section(
        'rh_parallax_el_section',
        array(
            'label' => esc_html__( 'Re:Hub Effects', 'rehub-theme' ),
            'tab'   => Elementor\Controls_Manager::TAB_ADVANCED,
        )
    );

    $obj->add_control(
        'rh_parallax_el',
        array(
            'label'        => esc_html__( 'Enable parallax effect', 'rehub-theme' ),
            'type'         => Elementor\Controls_Manager::SWITCHER,
            'label_on'     => esc_html__( 'Yes', 'rehub-theme' ),
            'label_off'    => esc_html__( 'No', 'rehub-theme' ),
            'return_value' => 'true',
            'prefix_class' => 'rh-parallaxel-',
        )
    );

    $obj->add_control(
        'rh_parallax_el_speed',
        array(
            'label'   => esc_html__( 'Speed', 'rehub-theme' ),
            'type'    => Elementor\Controls_Manager::NUMBER,
            'min'     => 1,
            'max'     => 200,
            'step'    => 1,
            'default' => 10,
            'condition' => array(
                'rh_parallax_el' => 'true',
            ),
            'prefix_class' => 'rh-parallaxel-speed-',
        )
    );
    $obj->add_control(
        'rh_parallax_el_dir',
        array(
            'label'        => esc_html__( 'Enable reverse direction', 'rehub-theme' ),
            'type'         => Elementor\Controls_Manager::SWITCHER,
            'label_on'     => esc_html__( 'Yes', 'rehub-theme' ),
            'label_off'    => esc_html__( 'No', 'rehub-theme' ),
            'return_value' => 'rev',
            'condition' => array(
                'rh_parallax_el' => 'true',
            ),                
            'prefix_class' => 'rh-parallaxel-dir-',
        )
    ); 

    $obj->add_control(
        'rh_infinite_rotate',
        array(
            'label'        => esc_html__( 'Enable Infinite rotating', 'rehub-theme' ),
            'type'         => Elementor\Controls_Manager::SWITCHER,
            'label_on'     => esc_html__( 'Yes', 'rehub-theme' ),
            'label_off'    => esc_html__( 'No', 'rehub-theme' ),
            'return_value' => 'infinite',
            'condition' => [
                'rh_parallax_el' => '',
            ],                
            'prefix_class' => 'rotate',
        )
    ); 
    $obj->add_control(
        'rh_infinite_leftright',
        array(
            'label'        => esc_html__( 'Enable Infinite Left to right', 'rehub-theme' ),
            'type'         => Elementor\Controls_Manager::SWITCHER,
            'label_on'     => esc_html__( 'Yes', 'rehub-theme' ),
            'label_off'    => esc_html__( 'No', 'rehub-theme' ),
            'return_value' => 'infinite',
            'condition' => [
                'rh_parallax_el' => '',
            ],                
            'prefix_class' => 'leftright',
        )
    ); 
    $obj->add_control(
        'rh_infinite_updownright',
        array(
            'label'        => esc_html__( 'Enable Infinite Up and Down', 'rehub-theme' ),
            'type'         => Elementor\Controls_Manager::SWITCHER,
            'label_on'     => esc_html__( 'Yes', 'rehub-theme' ),
            'label_off'    => esc_html__( 'No', 'rehub-theme' ),
            'return_value' => 'infinite',
            'condition' => [
                'rh_parallax_el' => '',
            ],                
            'prefix_class' => 'upanddown',
        )
    );
    $obj->add_control(
        'rh_infinite_fastshake',
        array(
            'label'        => esc_html__( 'Enable Infinite Shake', 'rehub-theme' ),
            'type'         => Elementor\Controls_Manager::SWITCHER,
            'label_on'     => esc_html__( 'Yes', 'rehub-theme' ),
            'label_off'    => esc_html__( 'No', 'rehub-theme' ),
            'return_value' => 'Shake',
            'condition' => [
                'rh_parallax_el' => '',
            ],                
            'prefix_class' => 'fast',
        )
    );
    
    $obj->add_control( 'rh_infinite_speed', [
        'type'        => \Elementor\Controls_Manager::SELECT,
        'label'       => esc_html__( 'Animation Speed', 'rehub-theme' ),
        'options'     => [
            '5'   => '5s',
            '10'   =>  '10s',
            '15'   =>  '15s',
            '20'   =>  '20s',
            '25'   =>  '25s',
            '50'   =>  '50s',
            '100'   =>  '100s',                        
            '0'   =>  '0s',
        ],
        'condition' => [
            'rh_parallax_el' => '',
        ],                
        'prefix_class' => 'animationspeed',
    ]); 
    $obj->add_control(
        'rh_perspective_boxshadow',
        array(
            'label'        => esc_html__( 'Enable Perspective Box shadow', 'rehub-theme' ),
            'type'         => Elementor\Controls_Manager::SWITCHER,
            'label_on'     => esc_html__( 'Yes', 'rehub-theme' ),
            'label_off'    => esc_html__( 'No', 'rehub-theme' ),
            'return_value' => '1',
            'selectors' => [
                '{{WRAPPER}} > .elementor-widget-container' => 'box-shadow: 0 1px 0 #ccc, 0 2px 0 #ccc, 0 3px 0 #ccc, 0 4px 0 #ccc, 0 5px 0 #ccc, 0 6px 0 #ccc, 0 7px 0 #ccc, 0 8px 0 #ccc, 0 9px 0 #ccc, 0 50px 30px rgba(0,0,0,.25)',
            ],                
        )
    ); 
    $obj->add_control(
        'rh_perspective_textshadow',
        array(
            'label'        => esc_html__( 'Enable Perspective Text shadow', 'rehub-theme' ),
            'type'         => Elementor\Controls_Manager::SWITCHER,
            'label_on'     => esc_html__( 'Yes', 'rehub-theme' ),
            'label_off'    => esc_html__( 'No', 'rehub-theme' ),
            'return_value' => '1',
            'selectors' => [
                '{{WRAPPER}} > .elementor-widget-container' => 'text-shadow: 0 1px 0 #ccc, 0 2px 0 #ccc, 0 3px 0 #ccc, 0 4px 0 #ccc, 0 5px 0 #ccc, 0 6px 0 #ccc, 0 7px 0 #ccc, 0 8px 0 #ccc, 0 9px 0 #ccc, 0 50px 30px rgba(0,0,0,.25)',
            ],                
        )
    );                
    $obj->add_control(
        'rh_parallax_circle',
        array(
            'label'   => esc_html__( 'Make shape', 'rehub-theme' ),
            'type'    => Elementor\Controls_Manager::NUMBER,
            'min'     => 1,
            'max'     => 3000,
            'step'    => 1,
            'selectors' => [
                '{{WRAPPER}} > .elementor-widget-container' => 'width: {{VALUE}}px;height: {{VALUE}}px;display: flex; align-items: center;justify-content: center;',
            ],
        )
    );  
    $obj->add_control(
        'rh_make_rotate',
        array(
            'label'   => esc_html__( 'Rotation (deg)', 'rehub-theme' ),
            'type'    => Elementor\Controls_Manager::NUMBER,
            'min'     => 1,
            'max'     => 360,
            'step'    => 1,
            'selectors' => [
                '{{WRAPPER}} > .elementor-widget-container' => 'transform: rotate({{VALUE}}deg);',
            ],
        )
    );                                                 

    $obj->end_controls_section();
}
function RH_el_elementor_frontend( $element) {
    if ( $element->get_settings( 'rh_parallax_el' ) == 'true' ) {
        wp_enqueue_script('rh_elparallax');
    }           
    return;        
}
function RH_el_elementor_frontend_section( $element) {
    if('section' === $element->get_name()){
        if ( $element->get_settings( 'rh_stickyel_section_sticky' ) == 'true' ) {
            wp_enqueue_script('stickysidebar');
            $element->add_render_attribute( '_wrapper', array(
                'data-sticky-top-offset' => ($element->get_settings('rh_stickyel_top_spacing')  != '') ? $element->get_settings('rh_stickyel_top_spacing') : '',
                'data-sticky-bottom-offset' => ($element->get_settings('rh_stickyel_bottom_spacing')  != '') ? $element->get_settings('rh_stickyel_bottom_spacing') : '',            
            ) );
        }
        if ( $element->get_settings( 'rh_parallax_bg' ) == 'true' ) {
            wp_enqueue_script('rh_elparallax');
        }  
    }       
    return;        
}
function RH_el_html_add_custom( $obj, $args ) {
    $obj->start_controls_section(
        'section_rh_custom_html',
        array(
            'label' => esc_html__( 'Custom JS, CSS', 'rehub-theme' ),
            'tab'   => Elementor\Controls_Manager::TAB_CONTENT,
        )
    );    
    $obj->add_control(
        'rh_js',
        [
            'label' => __( 'Enter your JS code', 'rehub-theme' ),
            'type' => Elementor\Controls_Manager::CODE,
            'default' => '',
            'language' => 'javascript', 
            'dynamic' => [
                'active' => true,
            ],            
        ]
    );
    $obj->add_control(
        'rh_css',
        [
            'label' => __( 'Enter your CSS code', 'rehub-theme' ),
            'type' => Elementor\Controls_Manager::CODE,
            'default' => '',
            'language' => 'css',
            'dynamic' => [
                'active' => true,
            ],            
        ]
    );
    $obj->end_controls_section();    
} 
function RH_el_custom_widget_render( $content, $widget ) {
    if ( 'html' === $widget->get_name() ) {
        $settings = $widget->get_settings();
   
        if ( ! empty( $settings['rh_js'] ) ) {
            $customjs = $settings['rh_js'];
            wp_add_inline_script('rehub', $customjs);
        }
        if ( ! empty( $settings['rh_css'] ) ) {
            $customcss = $settings['rh_css'];
            $cssid = 'el_rh_css_html'.uniqid();
            wp_register_style( $cssid, false );
            wp_enqueue_style( $cssid );
            wp_add_inline_style($cssid, $customcss);            
        } 
       
    }
    return $content;
}
function RH_additional_el_annimation($array){
    $array['Rehub Effects'] = [
        'stuckMoveUpOpacity' => 'Stuck Up with Fade',
        'slide-in-blurred-top' => 'Blurred Slide From Top',
        'rotate-in-2-fwd' => 'Rotate In Forward',
        'rotate-in-2-bck' => 'Rotate In Backward',
        'flip-in-hor-top' => 'Flip in from Top',
        'flip-in-ver-right' => 'Flip In to Right',
        'slide-in-fwd-center' => 'Slide and Scale to center',
        'scale-in-ver-center' => 'Grow from center',        
        'swing-in-top-fwd' => 'Swing from Top',
        'swing-in-left-fwd' => 'Swing from Left',
        'fade-in-fwd' => 'Fade in Forward',
        'fade-in-bck' => 'Fade in Backward',
        'stuckFlipUpOpacity' => 'Stuck Up with Flip and Fade',
        'flip-l-r-s' => 'Flip with Scale to left',
        'flip-r-r-s' => 'Flip with Scale to right',
        'tracking-in-expand' => 'Text tracking and expand',

    ];
    return $array; 
}
function rh_custom_print_template($content, $widget){
    if ( 'html' === $widget->get_name() ) {
        ob_start();
        ?>
        {{{ settings.html }}}
        <# if (settings.rh_css ) { #>
        <style>{{{ settings.rh_css }}}</style>
        <# } #>       
        <?php
        $content = ob_get_clean();
    }
    return $content;
}
//add_action( 'elementor/element/parse_css', 'rh_add_post_css', 10, 2 );
/*function rh_add_post_css( $post_css, $element ) {
    if ( $post_css instanceof Dynamic_CSS ) {
        return;
    }
    $element_settings = $element->get_settings();
    if ( empty( $element_settings['rh_css'] ) ) {
        return;
    }
    $css = trim( $element_settings['rh_css'] );
    if ( empty( $css ) ) {
        return;
    }
    $post_css->get_stylesheet()->add_raw_css( $css );
}*/