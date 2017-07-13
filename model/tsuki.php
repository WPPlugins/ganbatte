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
 * Days of the month
 */
class Tsuki extends DataObject
{
	function Tsuki()
	{
		parent::DataObject();
		$this->_name = __('Days of the month', GANBATTE_LOCALIZE);
	}
	
	function create()
	{
		if (!empty($this->_items)) return;

		$this->_items[] = array('base' => 1, 'kana' => 'ついたち', 'kanji' => '一日');
		$this->_items[] = array('base' => 2, 'kana' => 'ふつか', 'kanji' => '二日');
		$this->_items[] = array('base' => 3, 'kana' => 'みっか', 'kanji' => '三日');
		$this->_items[] = array('base' => 4, 'kana' => 'よっか', 'kanji' => '四日');
		$this->_items[] = array('base' => 5, 'kana' => 'いつか', 'kanji' => '五日');
		$this->_items[] = array('base' => 6, 'kana' => 'むいか', 'kanji' => '六日');
		$this->_items[] = array('base' => 7, 'kana' => 'なのか', 'kanji' => '七日');
		$this->_items[] = array('base' => 8, 'kana' => 'ようか', 'kanji' => '八日');
		$this->_items[] = array('base' => 9, 'kana' => 'ここのか', 'kanji' => '九日');
		$this->_items[] = array('base' => 10, 'kana' => 'とうか', 'kanji' => '十日');
		$this->_items[] = array('base' => 11, 'kana' => 'じゅういちにち', 'kanji' => '十一日');
		$this->_items[] = array('base' => 12, 'kana' => 'じゅうににち', 'kanji' => '十二日');
		$this->_items[] = array('base' => 13, 'kana' => 'じゅうさんにち', 'kanji' => '十三日');
		$this->_items[] = array('base' => 14, 'kana' => 'じゅうよっか', 'kanji' => '十四日');
		$this->_items[] = array('base' => 15, 'kana' => 'じゅうごにち', 'kanji' => '十五日');
		$this->_items[] = array('base' => 16, 'kana' => 'じゅうろくにち', 'kanji' => '十六日');
		$this->_items[] = array('base' => 17, 'kana' => 'じゅうしちにち', 'kanji' => '十七日');
		$this->_items[] = array('base' => 18, 'kana' => 'じゅうはちにち', 'kanji' => '十八日');
		$this->_items[] = array('base' => 19, 'kana' => 'じゅうくにち', 'kanji' => '十九日');
		$this->_items[] = array('base' => 20, 'kana' => 'はつか', 'kanji' => '二十日');
		$this->_items[] = array('base' => 21, 'kana' => 'にじゅういちにち', 'kanji' => '二十一日');
		$this->_items[] = array('base' => 22, 'kana' => 'にじゅうににち', 'kanji' => '二十二日');
		$this->_items[] = array('base' => 23, 'kana' => 'にじゅうさんにち', 'kanji' => '二十三日');
		$this->_items[] = array('base' => 24, 'kana' => 'にじゅうよっか', 'kanji' => '二十四日');
		$this->_items[] = array('base' => 25, 'kana' => 'にじゅうごにち', 'kanji' => '二十五日');
		$this->_items[] = array('base' => 26, 'kana' => 'にじゅうろくにち', 'kanji' => '二十六日');
		$this->_items[] = array('base' => 27, 'kana' => 'にじゅうしちにち', 'kanji' => '二十七日');
		$this->_items[] = array('base' => 28, 'kana' => 'にじゅうはちにち', 'kanji' => '二十八日');
		$this->_items[] = array('base' => 29, 'kana' => 'にじゅうくにち', 'kanji' => '二十九日');
		$this->_items[] = array('base' => 30, 'kana' => 'さんじゅうにち', 'kanji' => '三十日');
		$this->_items[] = array('base' => 31, 'kana' => 'さんじゅういちにち', 'kanji' => '三十一日');
	}
}