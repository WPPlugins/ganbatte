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
 * seasons
 */
class Kisetsu extends DataObject
{
	function Kisetsu()
	{
		parent::DataObject();
		$this->_name = __('Seasons', GANBATTE_LOCALIZE);
	}

	function create()
	{
		if (!empty($this->_items)) return;

		$this->_items[] = array('base' => __('spring', GANBATTE_LOCALIZE), 'kana' => 'はる', 'kanji' => '春');
		$this->_items[] = array('base' => __('summer', GANBATTE_LOCALIZE), 'kana' => 'なつ', 'kanji' => '夏');
		$this->_items[] = array('base' => __('autumn', GANBATTE_LOCALIZE), 'kana' => 'あき', 'kanji' => '秋');
		$this->_items[] = array('base' => __('winter', GANBATTE_LOCALIZE), 'kana' => 'ふゆ', 'kanji' => '冬');
	}
}
