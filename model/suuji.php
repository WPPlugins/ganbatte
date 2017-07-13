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
 * Numbers up to 90 or above
 */
class Suuji extends DataObject
{
	var $_above_ninety;

	function Suuji($above_ninety = false)
	{
		parent::DataObject();
		$this->_above_ninety = $above_ninety;
		if ($above_ninety) {
			$this->_name = __('Numbers (100 - 1000000000)', GANBATTE_LOCALIZE);
		}
		else {
			$this->_name = __('Numbers (1 - 90)', GANBATTE_LOCALIZE);
		}
	}

	
	function create()
	{
		if (!empty($this->_items)) return;

		if (!$this->_above_ninety) {
			$this->_items[] = array('base' => 1, 'kana' => 'いち', 'kanji' => '一');
			$this->_items[] = array('base' => 2, 'kana' => 'に', 'kanji' => '二');
			$this->_items[] = array('base' => 3, 'kana' => 'さん', 'kanji' => '三');
			$this->_items[] = array('base' => 4, 'kana' => 'よん', 'kanji' => '四');
			$this->_items[] = array('base' => 5, 'kana' => 'ご', 'kanji' => '五');
			$this->_items[] = array('base' => 6, 'kana' => 'ろく', 'kanji' => '六');
			$this->_items[] = array('base' => 7, 'kana' => 'なな', 'kanji' => '七');
			$this->_items[] = array('base' => 8, 'kana' => 'はち', 'kanji' => '八');
			$this->_items[] = array('base' => 9, 'kana' => 'きゅう', 'kanji' => '九');
			$this->_items[] = array('base' => 10, 'kana' => 'じゅう', 'kanji' => '十');
			$this->_items[] = array('base' => 11, 'kana' => 'じゅういち', 'kanji' => '十一');
			$this->_items[] = array('base' => 12, 'kana' => 'じゅうに', 'kanji' => '十二');
			$this->_items[] = array('base' => 13, 'kana' => 'じゅうさん', 'kanji' => '十三');
			$this->_items[] = array('base' => 14, 'kana' => 'じゅうよん', 'kanji' => '十四');
			$this->_items[] = array('base' => 15, 'kana' => 'じゅうご', 'kanji' => '十五');
			$this->_items[] = array('base' => 16, 'kana' => 'じゅうろく', 'kanji' => '十六');
			$this->_items[] = array('base' => 17, 'kana' => 'じゅうなな', 'kanji' => '十七');
			$this->_items[] = array('base' => 18, 'kana' => 'じゅうはち', 'kanji' => '十八');
			$this->_items[] = array('base' => 19, 'kana' => 'じゅうきゅう', 'kanji' => '十九');
			$this->_items[] = array('base' => 20, 'kana' => 'にじゅう', 'kanji' => '二十');
			$this->_items[] = array('base' => 30, 'kana' => 'さんじゅう', 'kanji' => '三十');
			$this->_items[] = array('base' => 40, 'kana' => 'よんじゅう', 'kanji' => '四十');
			$this->_items[] = array('base' => 50, 'kana' => 'ごじゅう', 'kanji' => '五十');
			$this->_items[] = array('base' => 60, 'kana' => 'ろくじゅう', 'kanji' => '六十');
			$this->_items[] = array('base' => 70, 'kana' => 'ななじゅう', 'kanji' => '七十');
			$this->_items[] = array('base' => 80, 'kana' => 'はちじゅう', 'kanji' => '八十');
			$this->_items[] = array('base' => 90, 'kana' => 'きゅうじゅう', 'kanji' => '九十');
		}
		else {
			$this->_items[] = array('base' => 100, 'kana' => 'ひゃく', 'kanji' => '百');
			$this->_items[] = array('base' => 200, 'kana' => 'にひゃく', 'kanji' => '二百');
			$this->_items[] = array('base' => 300, 'kana' => 'さんびゃく', 'kanji' => '三百');
			$this->_items[] = array('base' => 400, 'kana' => 'よんひゃく', 'kanji' => '四百');
			$this->_items[] = array('base' => 500, 'kana' => 'ごひゃく', 'kanji' => '五百');
			$this->_items[] = array('base' => 600, 'kana' => 'ろっぴゃく', 'kanji' => '六百');
			$this->_items[] = array('base' => 700, 'kana' => 'ななひゃく', 'kanji' => '七百');
			$this->_items[] = array('base' => 800, 'kana' => 'はっぴゃく', 'kanji' => '八百');
			$this->_items[] = array('base' => 900, 'kana' => 'きゅうひゃく', 'kanji' => '九百');
			$this->_items[] = array('base' => 1000, 'kana' => 'せん', 'kanji' => '千');
			$this->_items[] = array('base' => 2000, 'kana' => 'にせん', 'kanji' => '二千');
			$this->_items[] = array('base' => 3000, 'kana' => 'さんぜん', 'kanji' => '三千');
			$this->_items[] = array('base' => 4000, 'kana' => 'よんせん', 'kanji' => '四千');
			$this->_items[] = array('base' => 5000, 'kana' => 'ごせん', 'kanji' => '五千');
			$this->_items[] = array('base' => 6000, 'kana' => 'ろくせん', 'kanji' => '六千');
			$this->_items[] = array('base' => 7000, 'kana' => 'ななせん', 'kanji' => '七千');
			$this->_items[] = array('base' => 8000, 'kana' => 'はっせん', 'kanji' => '八千');
			$this->_items[] = array('base' => 9000, 'kana' => 'きゅうせん', 'kanji' => '九千');
			$this->_items[] = array('base' => 10000, 'kana' => 'いちまん', 'kanji' => '一万');
			$this->_items[] = array('base' => 100000, 'kana' => 'じゅうまん', 'kanji' => '十万');
			$this->_items[] = array('base' => 1000000, 'kana' => 'ひゃくまん', 'kanji' => '百万');
			$this->_items[] = array('base' => 10000000, 'kana' => 'せんまん', 'kanji' => '千万');
			$this->_items[] = array('base' => 1000000000, 'kana' => 'いちおく', 'kanji' => '一億');
		}
	}
}