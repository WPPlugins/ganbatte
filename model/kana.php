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
 * hiragana & katakana
 */
class Kana extends DataObject
{
	function Kana()
	{
		parent::DataObject();
		$this->_name = __('Hiragana and Katakana', GANBATTE_LOCALIZE);
	}

	function create()
	{
		if (!empty($this->_items)) return;

		$this->_items[] = array('romaji' => 'a', 'hiragana' => 'あ', 'katakana' => 'ア');
		$this->_items[] = array('romaji' => 'i', 'hiragana' => 'い', 'katakana' => 'イ');
		$this->_items[] = array('romaji' => 'u', 'hiragana' => 'う', 'katakana' => 'ウ');
		$this->_items[] = array('romaji' => 'e', 'hiragana' => 'え', 'katakana' => 'エ');
		$this->_items[] = array('romaji' => 'o', 'hiragana' => 'お', 'katakana' => 'オ');
		$this->_items[] = array('romaji' => 'ka', 'hiragana' => 'か', 'katakana' => 'カ');
		$this->_items[] = array('romaji' => 'ki', 'hiragana' => 'き', 'katakana' => 'キ');
		$this->_items[] = array('romaji' => 'ku', 'hiragana' => 'く', 'katakana' => 'ク');
		$this->_items[] = array('romaji' => 'ke', 'hiragana' => 'け', 'katakana' => 'ケ');
		$this->_items[] = array('romaji' => 'ko', 'hiragana' => 'こ', 'katakana' => 'コ');
		$this->_items[] = array('romaji' => 'sa', 'hiragana' => 'さ', 'katakana' => 'サ');
		$this->_items[] = array('romaji' => 'shi', 'hiragana' => 'し', 'katakana' => 'シ');
		$this->_items[] = array('romaji' => 'su', 'hiragana' => 'す', 'katakana' => 'ス');
		$this->_items[] = array('romaji' => 'se', 'hiragana' => 'せ', 'katakana' => 'セ');
		$this->_items[] = array('romaji' => 'so', 'hiragana' => 'そ', 'katakana' => 'ソ');
		$this->_items[] = array('romaji' => 'ta', 'hiragana' => 'た', 'katakana' => 'タ');
		$this->_items[] = array('romaji' => 'chi', 'hiragana' => 'ち', 'katakana' => 'チ');
		$this->_items[] = array('romaji' => 'tsu', 'hiragana' => 'つ', 'katakana' => 'ツ');
		$this->_items[] = array('romaji' => 'te', 'hiragana' => 'て', 'katakana' => 'テ');
		$this->_items[] = array('romaji' => 'to', 'hiragana' => 'と', 'katakana' => 'ト');
		$this->_items[] = array('romaji' => 'na', 'hiragana' => 'な', 'katakana' => 'ナ');
		$this->_items[] = array('romaji' => 'ni', 'hiragana' => 'に', 'katakana' => 'ニ');
		$this->_items[] = array('romaji' => 'nu', 'hiragana' => 'ぬ', 'katakana' => 'ヌ');
		$this->_items[] = array('romaji' => 'ne', 'hiragana' => 'ね', 'katakana' => 'ネ');
		$this->_items[] = array('romaji' => 'no', 'hiragana' => 'の', 'katakana' => 'ノ');
		$this->_items[] = array('romaji' => 'ha', 'hiragana' => 'は', 'katakana' => 'ハ');
		$this->_items[] = array('romaji' => 'hi', 'hiragana' => 'ひ', 'katakana' => 'ヒ');
		$this->_items[] = array('romaji' => 'fu', 'hiragana' => 'ふ', 'katakana' => 'フ');
		$this->_items[] = array('romaji' => 'he', 'hiragana' => 'へ', 'katakana' => 'ヘ');
		$this->_items[] = array('romaji' => 'ho', 'hiragana' => 'ほ', 'katakana' => 'ホ');
		$this->_items[] = array('romaji' => 'ma', 'hiragana' => 'ま', 'katakana' => 'マ');
		$this->_items[] = array('romaji' => 'mi', 'hiragana' => 'み', 'katakana' => 'ミ');
		$this->_items[] = array('romaji' => 'mu', 'hiragana' => 'む', 'katakana' => 'ム');
		$this->_items[] = array('romaji' => 'me', 'hiragana' => 'め', 'katakana' => 'メ');
		$this->_items[] = array('romaji' => 'mo', 'hiragana' => 'も', 'katakana' => 'モ');
		$this->_items[] = array('romaji' => 'ya', 'hiragana' => 'や', 'katakana' => 'ヤ');
		$this->_items[] = array('romaji' => 'yu', 'hiragana' => 'ゆ', 'katakana' => 'ユ');
		$this->_items[] = array('romaji' => 'yo', 'hiragana' => 'よ', 'katakana' => 'ヨ');
		$this->_items[] = array('romaji' => 'ra', 'hiragana' => 'ら', 'katakana' => 'ラ');
		$this->_items[] = array('romaji' => 'ri', 'hiragana' => 'り', 'katakana' => 'リ');
		$this->_items[] = array('romaji' => 'ru', 'hiragana' => 'る', 'katakana' => 'ル');
		$this->_items[] = array('romaji' => 're', 'hiragana' => 'れ', 'katakana' => 'レ');
		$this->_items[] = array('romaji' => 'ro', 'hiragana' => 'ろ', 'katakana' => 'ロ');
		$this->_items[] = array('romaji' => 'wa', 'hiragana' => 'わ', 'katakana' => 'ワ');
		$this->_items[] = array('romaji' => 'wo', 'hiragana' => 'を', 'katakana' => 'ヲ');
		$this->_items[] = array('romaji' => 'n', 'hiragana' => 'ん', 'katakana' => 'ン');
	}
}