<?php
/*
Plugin Name: Ganbatte
Plugin URI: http://www.andreabelvedere.com/ganbatte
Description: Simple games to aid the process of learning the Japanese language
Author: Andrea Belvedere
Version: 1.2
Author URI: http://www.andreabelvedere.com/
*/
/*  Copyright 2008  Andrea Belvedere  (email : scieck at gmail dot com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
define('GANBATTE_VERSION', '1.2');
define('GANBATTE_LOCALIZE', 'ganbatte');

if (! defined('WP_CONTENT_DIR'))
    define('WP_CONTENT_DIR', ABSPATH . 'wp-content');
if (! defined('WP_CONTENT_URL'))
    define('WP_CONTENT_URL', get_option('siteurl') . '/wp-content');

if (! defined('WP_PLUGIN_DIR'))
    define('WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins');
if (! defined('WP_PLUGIN_URL'))
    define('WP_PLUGIN_URL', WP_CONTENT_URL . '/plugins');

define('GANBATTE_DIR', dirname(__FILE__));
define('GANBATTE_URL', WP_PLUGIN_URL . '/' . plugin_basename(dirname(__FILE__)));

require_once GANBATTE_DIR . '/model/dataobject.php';
require_once GANBATTE_DIR . '/model/kana.php';
require_once GANBATTE_DIR . '/model/kisetsu.php';
require_once GANBATTE_DIR . '/model/shuu.php';
require_once GANBATTE_DIR . '/model/suuji.php';
require_once GANBATTE_DIR . '/model/tsuki.php';
require_once GANBATTE_DIR . '/controller/ganbatte_controller.php';
require_once GANBATTE_DIR . '/controller/ganbatte_admin_controller.php';


class Ganbatte
{
	function Ganbatte()
	{
		register_activation_hook( __FILE__, array(&$this, 'activate_ganbatte'));
		register_deactivation_hook( __FILE__, array(&$this, 'deactivate_ganbatte'));

		new GanbatteController();
		new GanbatteAdminController();
	}

	function activate_ganbatte() {}
	
	function deactivate_ganbatte() {}
}

new Ganbatte();