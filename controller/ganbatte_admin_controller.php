<?php
/*  Copyright 2008  Andrea Belvedere  (email : scieck at gmail.com)

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
require_once GANBATTE_DIR . '/view/ganbatte_admin_view.php';

class GanbatteAdminController
{
	var $_view;

	function GanbatteAdminController()
	{
		$this->_view =& new GanbatteAdminView();
		add_action('admin_menu', array(&$this, 'ganbatte_admin_menu'));
	}

	function ganbatte_admin_menu()
	{
		add_submenu_page('options-general.php', __('Ganbatte Settings', GANBATTE_LOCALIZE), 
						 __('Ganbatte', GANBATTE_LOCALIZE), 8, __FILE__, array(&$this->_view, 'show_page'));
	}
}
