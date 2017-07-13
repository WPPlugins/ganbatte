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
require_once GANBATTE_DIR . '/view/ganbatte_view.php';

class GanbatteController
{
	var $_view;
	var $_models;

	function GanbatteController()
	{
		$this->_view =& new GanbatteView();
		$this->_models = array();
		$this->_models['kana'] =& new Kana();
		$this->_models['kisetsu'] =& new Kisetsu();
		$this->_models['shuu'] =& new Shuu();
		$this->_models['suuji-90'] =& new Suuji();
		$this->_models['suuji'] =& new Suuji(true);
		$this->_models['tsuki'] =& new Tsuki();

		add_action('wp_print_scripts', array(&$this, 'ganbatte_print_scripts'));
		add_action('wp_head', array(&$this, 'ganbatte_head'));
		add_action('init', array(&$this, 'ganbatte_init'));
		add_filter('the_content', array(&$this, 'ganbatte_the_content'),9);
	}

	function ganbatte_init()
	{
		if (isset($_POST['ganbatte_ajax']) && strcasecmp($_POST['ganbatte_ajax'], 'yes') == 0) {
			$this->process_request();
			exit();
		}
	}

	function process_request()
	{
		$ganbatte_action = isset($_POST['ganbatte_action']) ? $_POST['ganbatte_action'] : null;
		if ($ganbatte_action == 'siteurl') {
			@header("Content-Type: text/plain");
			echo get_option('siteurl');
		}
		else if ($ganbatte_action == 'choose-game') {
			@header('Content-Type: text/html; charset=utf-8');
			echo $this->_view->choose_game($this->_models[$_POST['game']]);
		}
		else if ($ganbatte_action == 'start-view') {
			@header('Content-Type: text/html; charset=utf-8');
			echo $this->_view->start_view($this->pick_model());
		}
		else if ($ganbatte_action == 'game-start') {
			@header('Content-Type: application/x-json; charset=utf-8');
			echo $this->ganbatte_encode($this->_models[$_POST['game']]);
		}
	}

	function ganbatte_the_content($content)
	{
		$regex = '/\[\s*ganbatte-kana\s*\]/';
		return preg_replace_callback($regex, array(&$this, 'ganbatte_the_content_callback'), $content, 1);
	}

	function ganbatte_the_content_callback($matches)
	{
		return $this->_view->start_view($this->pick_model());
	}

	function ganbatte_head()
	{
		echo '<link rel="stylesheet" type="text/css" href="'. GANBATTE_URL . '/css/ganbatte.css" />';
	}

	function ganbatte_print_scripts() 
	{
		wp_enqueue_script('ganbatte_js', GANBATTE_URL . '/js/ganbatte.js', array('prototype'));
	}

	function pick_model()
	{
		$pick = rand(0, (count($this->_models) - 1));
		$i = 0;
		foreach ($this->_models as $model) {
			if ($pick == $i) {
				return $model;
			}
			$i++;
		}
		// panic return
		return new Kana();
	}

	function ganbatte_encode($model)
	{
		if (is_a($model, 'Kana')) {
			return $this->ganbatte_kanas_encode($model);
		}
		$items = $model->getItems();
		$i = 0;
		$enc = '{"items": [';
		foreach ($items as $item) {
			$enc .= '{"id":"'.$i.'",';
			foreach ($item as $key => $value) {
				$enc .= '"'.$key.'":"'.$value.'",';
			}
			$i++;
			$enc = substr($enc, 0, -1);
			$enc .= '},';
		}
		$enc = substr($enc, 0, -1);
		$enc .= ']}';
		return $enc;
	}

	/**
	 * @param $kanas array An array of kanas to json encode
	 */
	function ganbatte_kanas_encode($model)
	{
		$kanas = $model->getItems();
		$i = 0;
		$enc = '{"kanas": [';
		foreach ($kanas as $kana) {
			$enc .= '{"id":"'.$i.'","romaji":"'.$kana['romaji'].'","hiragana":"'.
				$kana['hiragana'].'","katakana":"'.$kana['katakana'].'"},';
			$i++;
		}
		$enc = substr($enc, 0, -1);
		$enc .= ']}';
		return $enc;
	}
}
