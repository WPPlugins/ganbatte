<?php
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
/**
 * This class doesn't do any logic
 * only displays data
 */
class GanbatteView
{
	function GanbatteView() {}

	/**
	 * plug-in initial view
	 */
	function start_view($model)
	{
		$html = '<table border="0" cellpadding="0" cellspacing="0" id="ganbatte-console"><tr>'.
			'<td style="text-align:left;">'.$this->model_chart($model).'</td>'.
			'<td>'.$this->choose_game_form().'</td></tr></table>';

		return $this->ganbatte_wrap($html);
	}

	function model_chart($model)
	{
		if (is_a($model, 'Kana')) {
			return $this->kana_model($model);
		}
		$html = '<table border="1" cellpadding="0" cellspacing="0" id="ganbatte-chart">'.
			'<caption>'.$model->getName().'</caption>'."\n";
		foreach ($model->getItems() as $items) {
			$html .= "<tr>\n";
			foreach ($items as $item) {
				$html .= '<td><span>'.$item.'</span></td>';
			}
			$html .= "\n</tr>";
		}
		$html .= '</table>';
		return $html;
	}

	/**
	 * Create the table to display the kana chart
	 * @param $model Kana the kana object model
	 * @return String An html table
	 */
	function kana_model($model)
	{
		$kanas = $model->getItems();
		$i = 0;
		$html = '<table border="1" cellpadding="0" cellspacing="0" id="ganbatte-chart">'.
			'<caption>'.$model->getName().'</caption>'."\n".'<tr>'."\n";
		foreach ($kanas as $kana) {
			if (($i != 0) && ($i % 5) == 0) {
				$i = 0;
				$html .= "\n</tr>\n<tr>\n";
			}
			
			$html .= '<td><span class="hiragana">'.
				$kana['hiragana'].'</span>&nbsp;<span class="katakana">'.
				$kana['katakana'].'</span><br /><span class="romaji">'.
				$kana['romaji'].'</span></td>'."\n";

			switch ($kana['romaji']) {
			case 'ya':
				{
					$html .= '<td>&nbsp;</td>';
					$i++;
				}
				break;
			case 'yu':
				{
					$html .= '<td>&nbsp;</td>';
					$i++;
				}
				break;
			case 'wa':
				{
					for($k = 0; $k < 3; $k++ ) {
						$html .= '<td>&nbsp;</td>';
						$i++;
					}
				}
				break;
			case 'n':
				{
					for ($k = 0; $k < 4; $k++) {
						$html .= '<td>&nbsp;</td>';
					}
				}
				break;
			}
			$i++;
		}
		$html .= '</tr></table>';

		return $html;
	}

	function choose_game_form()
	{
		$url = parse_url($_SERVER['REQUEST_URI']);
		$url = $url['path'] . (empty($url['query']) ? '' : '?' . $url['query']);

		$html = '<form method="post" action="'.$url.'" name="ganbatte-choose-game" id="ganbatte-choose-game">'.
			'<input type="hidden" name="ganbatte_ajax" value="no" id="ganbatte_ajax" />'.
			'<input type="hidden" name="ganbatte_action" value="choose-game" />'.
			'<label>'.__('learn japanese', GANBATTE_LOCALIZE).':</label>'.
			'<select name="game">'.
			'<option value="">'.__('choose game', GANBATTE_LOCALIZE).'</option>'.
			'<option value="kana">hiragana &ndash; katakana</option>'.
			'<option value="suuji-90">'.__('numbers up to 90', GANBATTE_LOCALIZE).'</option>'.
			'<option value="shuu">'.__('days of week', GANBATTE_LOCALIZE).'</option>'.
			'<option value="tsuki">'.__('days of month', GANBATTE_LOCALIZE).'</option>'.
			'<option value="kisetsu">'.__('seasons', GANBATTE_LOCALIZE).'</option>'.
			'<option value="suuji">'.__('numbers above 90', GANBATTE_LOCALIZE).'</option>'.
			'</select>'.
			'<input type="submit" value="'.__('go', GANBATTE_LOCALIZE).'!" id="ganbatte-go" /></form>';
			
		return $html;
	}

	function choose_game($model)
	{
		$html = '<table border="0" cellpadding="0" cellspacing="0" id="ganbatte-console"><tr>'.
			'<td style="text-align:left;">'.$this->model_chart($model).'</td>'.
			'<td>'.$this->start_game_form($model).'</td></tr></table>';
		
		return $this->ganbatte_wrap($html);
	}

	function start_game_form($model)
	{
		if (is_a($model, 'Kana')) {
			return $this->start_kana_form();
		}
		$url = parse_url($_SERVER['REQUEST_URI']);
		$url = $url['path'] . (empty($url['query']) ? '' : '?' . $url['query']);

		$html = '<form method="post" action="'.$url.'" name="ganbatte-game-control" id="ganbatte-game-control">'.
			'<input type="hidden" name="ganbatte_ajax" value="yes" id="ganbatte_ajax" />'.
			'<input type="hidden" name="ganbatte_action" value="game-start" />'.
			'<table border="0" cellpadding="3" cellspacing="0"><tr>'.
			'<th>'.__('View', GANBATTE_LOCALIZE).'</th>'.
			'<td><select name="view">'.
			'<option value="hiragana-kanji">hiragana &#45; kanji</option>'.
			'<option value="kanji-hiragana">kanji &#45; hiragana</option>'.
			'<option value="alphanumeric-hiragana">'.__('aphanumeric - hiragana', GANBATTE_LOCALIZE).'</option>'.
			'<option value="hiragana-alphanumeric">'.__('hiragana - alphanumeric', GANBATTE_LOCALIZE).'</option>'.
			'<option value="alphanumeric-kanji">'.__('alphanumeric - kanji', GANBATTE_LOCALIZE).'</option>'.
			'<option value="kanji-alphanumeric">'.__('kanji - alphanumeric', GANBATTE_LOCALIZE).'</option>'.
			'</select></td></tr><tr>'.
			'<td><input type="button" value="'.__('Back', GANBATTE_LOCALIZE).'" id="ganbatte-back" /></td>'.
			'<td style="text-align:right;">'.
			'<input type="button" value="'.__('Start Game', GANBATTE_LOCALIZE).'" id="ganbatte-start-game" /></td></tr>'.
			'</table></form>';
		return $html;
	}

	function start_kana_form()
	{
		$url = parse_url($_SERVER['REQUEST_URI']);
		$url = $url['path'] . (empty($url['query']) ? '' : '?' . $url['query']);

		$html = '<form method="post" action="'.$url.'" name="ganbatte-game-control" id="ganbatte-game-control">'.
			'<input type="hidden" name="ganbatte_ajax" value="yes" id="ganbatte_ajax" />'.
			'<input type="hidden" name="ganbatte_action" value="game-start" />'.
			'<table border="0" cellpadding="3" cellspacing="0"><tr>'.
			'<th>'.__('Learn', GANBATTE_LOCALIZE).'</th>'.
			'<td style="text-align:right;"><select name="learn">'.
			'<option value="hiragana">hiragana</option>'.
			'<option value="katakana">katakana</option>'.
			'</select></td></tr><tr>'.
			'<th>'.__('View', GANBATTE_LOCALIZE).'</th>'.
			'<td style="text-align:right;"><select name="view">'.
			'<option value="kana">kana</option>'.
			'<option value="romaji">romaji</option>'.
			'</select></td></tr><tr>'.
			'<td><input type="button" value="'.__('Back', GANBATTE_LOCALIZE).'" id="ganbatte-back" /></td>'.
			'<td style="text-align:right;">'.
			'<input type="button" value="'.__('Start Game', GANBATTE_LOCALIZE).'" id="ganbatte-start-game" /></td></tr>'.
			'</table></form>';

		return $html;		
	}

	function ganbatte_wrap($html)
	{
		return '<div id="ganbatte">'.$html.'</div>';
	}
}