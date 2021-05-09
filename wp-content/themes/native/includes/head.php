<?php
/**
* Head template
*
* Part of code in the head of the page including doctype, charset, css and js enqueues and <body> and <html> opened tags.
*
* @package WordPress
* @subpackage Native Theme
* @since 1.0
*/
?>
<!DOCTYPE HTML>
<html dir="ltr" <?php language_attributes(); ?> class="no-js">
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<title><?php wp_title('|', true, 'right'); ?></title>
<meta name="viewport" content="width=device-width">
<?php
// css and js are loaded from functions.php

/* Always have wp_head() just before the closing </head>
* tag of your theme, or you will break many plugins, which
* generally use this hook to add elements to <head> such
* as styles, scripts, and meta tags.
*/
wp_head();
?>
</head>

<body <?php body_class(); ?>>
