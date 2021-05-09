<?php 

	/*
	Plugin Name: Image Hover Effects for WooCommerce  Products
	Description: Display your woocommerce products with animated hover effects.
	Plugin URI: http://webdevocean.com/hover-effects-for-woocommerce
	Author: Labib Ahmed
	Author URI: http://webdevocean.com
	Version: 1.1
	License: GPL2
	Text Domain: wdo-woohover 
	*/
	
	/*
	
	    Copyright (C) 2020  Labib Ahmed  webdevocean@gmail.com
	
	    This program is free software; you can redistribute it and/or modify
	    it under the terms of the GNU General Public License, version 2, as
	    published by the Free Software Foundation.
	
	    This program is distributed in the hope that it will be useful,
	    but WITHOUT ANY WARRANTY; without even the implied warranty of
	    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	    GNU General Public License for more details.
	
	    You should have received a copy of the GNU General Public License
	    along with this program; if not, write to the Free Software
	    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
	*/

	add_action( 'activated_plugin', 'wdo_free_activation_redirect' );

	function wdo_free_activation_redirect( $plugin ) {
	    if( $plugin == plugin_basename( __FILE__ ) ) {
	        exit( wp_redirect( admin_url( 'admin.php?page=woo_hover_effects' ) ) );
	    }
	}

	include_once ('plugin.class.php');
	if (class_exists('WDO_Woo_Hover_Effects')) {
		$object = new WDO_Woo_Hover_Effects();
	}

	function wdo_dump_variable($var){
		echo '<pre>';
		print_r($var);
		echo '</pre>';
	}
	
 ?>