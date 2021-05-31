<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit('Restricted Access');
} // Exit if accessed directly

/**
 * Info box Widget class.
 *
 * 'wpsm_box' shortcode
 *
 * @since 1.0.0
 */
class WPSM_Canvas_A_Widget extends Widget_Base {

    /* Widget Name */
    public function get_name() {
        return 'rh_a_canvas';
    }

    /* Widget Title */
    public function get_title() {
        return __('Animated canvas', 'rehub-theme');
    }

        /**
     * Get widget icon.
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-youtube';
    }

    /**
     * category name in which this widget will be shown
     * @since 1.0.0
     * @access public
     *
     * @return array Widget categories.
     */
    public function get_categories() {
        return [ 'helpler-modules' ];
    }

    protected function _register_controls() {
        $this->start_controls_section( 'general_section', [
            'label' => esc_html__( 'General', 'rehub-theme' ),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ]);
        $this->add_control(
            'rh_particle_json',
            array(
                'label'   => esc_html__( 'Particle json content', 'rehub-theme' ),
                'description' => 'Configure it on <a href="https://vincentgarreau.com/particles.js/" target="_blank">Particle site</a>, download json file and copy content of file to this area',
                'type'    => \Elementor\Controls_Manager::TEXTAREA,
            )
        );

        $this->end_controls_section();
    }

    /* Widget output Rendering */
    protected function render() {
        $settings = $this->get_settings_for_display();
        if ( !empty($settings['rh_particle_json'])) {
            $uniqueid = 'rh_particle_'.uniqid().'hash';
            wp_enqueue_script('rh_elparticle');
            $particlejson = sanitize_text_field($settings['rh_particle_json']);
            $particlecode = 'particlesJS("'.$uniqueid.'", '.$particlejson.', function() {console.log("callback - particles.js config loaded");});';
            wp_add_inline_script('rh_elparticle', $particlecode);
            if ( Plugin::$instance->editor->is_edit_mode() ) {
                echo '<div id="'.$uniqueid.'" class="rh-particle-canvas-true" data-particlejson=\''.$particlejson.'\'></div>';
            } else{
                echo '<div id="'.$uniqueid.'" class="rh-particle-canvas-true"></div>';
            } 
        }    
    }

  

}

Plugin::instance()->widgets_manager->register_widget_type( new WPSM_Canvas_A_Widget );
