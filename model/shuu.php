<?php
/*  Copyright YEAR  PLUGIN_AUTHOR_NAME  (email : scieck at gmail dot com)

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
/**
 * Days of the week
 */
class Shuu extends DataObject
{
	function Shuu()
	{
		parent::DataObject();
		$this->_name = __('Days of the week', GANBATTE_LOCALIZE);
	}

	function create()
	{
		if (!empty($this->_items)) return;
		
		$this->_items[] = array('base' => __('sunday', GANBATTE_LOCALIZE), 'kana' => 'にちようび', 'kanji' => '日');
		$this->_items[] = array('base' => __('monday', GANBATTE_LOCALIZE), 'kana' => 'げつようび', 'kanji' => '月');
		$this->_items[] = array('base' => __('tuesday', GANBATTE_LOCALIZE), 'kana' => 'かようび', 'kanji' => '火');
		$this->_items[] = array('base' => __('wednesday', GANBATTE_LOCALIZE), 'kana' => 'すいようび', 'kanji' => '水');
		$this->_items[] = array('base' => __('thursday', GANBATTE_LOCALIZE), 'kana' => 'もくようび', 'kanji' => '木');
		$this->_items[] = array('base' => __('friday', GANBATTE_LOCALIZE), 'kana' => 'きんようび', 'kanji' => '金');
		$this->_items[] = array('base' => __('saturday', GANBATTE_LOCALIZE), 'kana' => 'どようび', 'kanji' => '土');
	}
}