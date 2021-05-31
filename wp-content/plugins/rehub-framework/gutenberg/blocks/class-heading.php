<?php
namespace Rehub\Gutenberg\Blocks;

defined('ABSPATH') OR exit;

use Elementor\Widget_Wpsm_Box;
use WP_REST_Request;
use WP_REST_Server;

class Heading extends Basic {
    protected $name = 'heading';

    protected $attributes = array(
        'level' => array(
            'type'=> 'number',
            'default' => 2,
        ),
        'content' => array(
            'type'=> 'string',
            'default' => 'Heading',
        ),
        'backgroundText' => array(
            'type'=> 'string',
            'default' => '01.',
        ),
        'textalign' => array(
            'type'=> 'string',
            'default' => 'left',
        ),
    );

    protected function render($settings = array()) {

        $level = $settings['level'];
        if (!is_numeric($level) || $level < 1 || $level > 6) $level = 2;

        $level = 'h'.$level;

        //.rh-flex-justify-center, .rh-flex-justify-start, .rh-flex-justify-end - add to wpsm_heading_number for align

        //.text-center, .text-right-align, .text-left-align - add to number class for align



        $out = '<div class="wpsm_heading_number rh-flex-center-align position-relative mb25">
            <div class="number abdfullwidth width-100p">'.$settings['backgroundText'].'</div>
            <div class="wpsm_heading_context position-relative">
            <'.$level.' class="mt0 mb0 ml15 mr15">
			' .$settings['content']. '
			</'.$level.'>
            </div>
			</div>';
        return $out;
    }
}