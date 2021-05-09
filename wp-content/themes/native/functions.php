<?php
/*
* Native Theme functions and definitions
* 
* For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
*
* @package WordPress
* @subpackage Native Theme
* @since 1.0
*
* This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://www.gnu.org/licenses/gpl-3.0.txt
*/

require_once('customs/load.php');

/* WHOAAAH! */

/*
* Down here you can set you custom functions and settings.
* To know more about hooks already available in Native check http://themes.designedby.it/native/
*/

// adds google fonts
if (!function_exists('native_googlefonts')) {
	function native_googlefonts() {
	
		// load external google font
		wp_enqueue_style('gfonts', 'http://fonts.googleapis.com/css?family=Monda:400,700|Quando');
	
	}

	add_action('wp_enqueue_scripts', 'native_googlefonts');
}
