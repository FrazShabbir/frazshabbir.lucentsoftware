<?php
/**
* External functions.php loading file for theme setup, don't be scared, I only have a thing for cleaning!
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

define('DBM_THEME_PATH', dirname(__FILE__));

require_once DBM_THEME_PATH . '/functions/settings.php';
require_once DBM_THEME_PATH . '/functions/hooks.php';
require_once DBM_THEME_PATH . '/functions/classes.php';

