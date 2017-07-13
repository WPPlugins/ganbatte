var Minna = Class.create();
Minna.prototype = 
{
	/**
	 * @param game String The name of the game to play
	 */
	initialize : function(siteurl, game)
	{
		this.siteurl = siteurl;
		this.game = game;
		this.translate = new Array('Score','Start','Revise');
		this.view = '';
		this.all = new Hash();
		this.to_guess = new Hash();
		this.wrong = new Hash();
		this.game_over = false;
		this.correct = 0;
		this.current_id = 0;
		this.guessable = 0;

	},

	startGame : function()
	{
		var form = $('ganbatte-game-control');
		this.view = Form.Element.getValue(form['view']);

		form.request({
				requestHeaders: {Accept: 'application/json'},
				parameters: 'game=' + this.game,
				onSuccess: this.startSuccess.bind(this)
			});

		$('ganbatte').innerHTML = '<img src="' + this.siteurl + 
		'/wp-content/plugins/ganbatte/images/ajax-loader.gif" alt="Loading..." />';
	},

	startSuccess : function(response)
	{
		var items = response.responseText.evalJSON(true);
		items.items.each(function(item, i) {
				this.all.set(i, item);
				this.to_guess.set(i, item);
			}, this);

		var items_to_guess = this.getItemsToGuess(this.to_guess);
		var guess_view = this.getToGuessView(items_to_guess);
		var control_view = this.getControlView();
		
		var console_table = document.createElement('table');
		console_table.id = 'ganbatte-console';
		console_table.cellPadding = 0;
		console_table.cellSpacing = 0;
		var row = console_table.insertRow(0);
		var choose_cell = row.insertCell(0);
		var control_cell = row.insertCell(1);
		choose_cell.id = 'kana-choose';
		control_cell.id = 'kana-control';
		choose_cell.innerHTML = guess_view;
		control_cell.innerHTML = control_view;

		$('ganbatte').innerHTML = '';
		$('ganbatte').insert(console_table);
		
		$$('#kana-choose .kana_to_guess').invoke('observe', 'click', this.checkChoosen.bindAsEventListener(this));
	},
	
	checkChoosen : function(e)
	{
		e.stop();
		if (!this.game_over) {
			var t = e.element();
			if (!t) return;

			if (this.current_id == t.name) {
				this.correct++;
				this.kanaNext();
			}
			else {
				this.all.each(function(k) {
						if (k.value.id == this.current_id) {
							var index = this.wrong.size();
							this.wrong.set(index, k.value);
							throw $break;
						}
					}, this);
				
				this.kanaNext();
			}
		}
	},

	kanaNext : function()
	{
		var start_console = $('ganbatte-console');
		var kana_to_guess = this.getItemsToGuess(this.to_guess);

		if (kana_to_guess != null) {
			var guess_view = this.getToGuessView(kana_to_guess);
			var control_view = this.getControlView();

			for (var i = 0; i < start_console.rows.length; i++) {
				start_console.deleteRow(i);
			}

			var row = start_console.insertRow(0);
			var choose_cell = row.insertCell(0);
			var control_cell = row.insertCell(1);
			choose_cell.id = 'kana-choose';
			control_cell.id = 'kana-control';
			choose_cell.innerHTML = guess_view;
			control_cell.innerHTML = control_view;

			$$('#kana-choose .kana_to_guess').invoke('observe', 'click', this.checkChoosen.bindAsEventListener(this));
		}
		else {
			this.game_over = true;
			var control_view = this.getControlView();
			start_console.rows[0].deleteCell(1);
			var control_cell = start_console.rows[0].insertCell(1);
			control_cell.id = 'kana-control';
			control_cell.innerHTML = control_view;
		}
	},


	getItemsToGuess : function(to_guess)
	{
		var size = to_guess.size();
		if (size == 0) return null;

		var n = this.rand(size);
		var item = null;
		var key = 0;
		this.to_guess.each(function(k, i) {
				if (i == n) {
					item = k.value;
					key = k.key;
					throw $break;
				}
			});
		this.to_guess.unset(key);

		var ans = new Hash();
		ans.set('to_guess', item);
		ans.set('correct', item);
		this.current_id = item.id;

		switch (this.game) {
		case 'kisetsu':
		case 'shuu':
			this.guessable = 2;
			break;
		default:
			this.guessable = 8;
		}
		var guessable = this.guessable;
		while (guessable >= 0) {
			n = this.rand(this.all.size());
			this.all.each(function(k, i) {
					if ((i == n) && (item.id != k.value.id)) {
						var v = ans.values();
						var found = false;
						for (var j = 0; j < v.length; j++) {
							if (v[j].id == k.value.id) {
								found = true;
								break;
							}
						}
						if (!found) {
							ans.set('choice_'+guessable, k.value);
							guessable--;
						}
					}
				});
		}
		return ans;		
	},

	getToGuessViewKisetsuShuu : function(kana_to_guess)
	{
		var pos = new Array(0,2,6,8);
		var correct_pos = pos[this.rand(pos.length)];
		var k = 0;

		var html = '<table border="0" cellpadding="0" cellspacing="0"><tr>';

		for (var i = 0; i < 9; i++) {
			if ((i != 0) && ((i % 3) == 0)) {
				html += '</tr><tr>';
			}
			if (this.view == 'hiragana-kanji') {
				if (i == 4) {
					html += '<td><span class="bolder">'+kana_to_guess.get('to_guess').kana + '</span></td>';
				}
				else if (i == correct_pos) {
					html += '<td><span class="bolder">'+
						'<a class="kana_to_guess" href="#" name="'+kana_to_guess.get('correct').id +'">'+
						kana_to_guess.get('correct').kanji+ '</a></span></td>';
				}
				else if (i == 1 || i == 3 || i == 5 || i == 7) {
					html += '<td>&nbsp;</td>';
				}
				else {
					html += '<td><a class="kana_to_guess" href="#" name="'+kana_to_guess.get('choice_'+k).id + '">'+
						'<span class="bolder">'+kana_to_guess.get('choice_'+k).kanji+'</span></a></td>';
					k++;
				}
			}
			else if (this.view == 'kanji-hiragana') {
				if (i == 4) {
					html += '<td><span class="bolder">'+kana_to_guess.get('to_guess').kanji + '</span></td>';
				}
				else if (i == correct_pos) {
					html += '<td><a class="kana_to_guess" href="#" name="'+kana_to_guess.get('correct').id +'">'+
						kana_to_guess.get('correct').kana+ '</a></td>';
				}
				else if (i == 1 || i == 3 || i == 5 || i == 7) {
					html += '<td>&nbsp;</td>';
				}
				else {
					html += '<td><a class="kana_to_guess" href="#" name="'+kana_to_guess.get('choice_'+k).id + '">'+
						kana_to_guess.get('choice_'+k).kana+'</a></td>';
					k++;
				}				
			}
			else if (this.view == 'alphanumeric-hiragana') {
				if (i == 4) {
					html += '<td>'+kana_to_guess.get('to_guess').base + '</td>';
				}
				else if (i == correct_pos) {
					html += '<td><a class="kana_to_guess" href="#" name="'+kana_to_guess.get('correct').id +'">'+
						kana_to_guess.get('correct').kana+ '</a></td>';
				}
				else if (i == 1 || i == 3 || i == 5 || i == 7) {
					html += '<td>&nbsp;</td>';
				}
				else {
					html += '<td><a class="kana_to_guess" href="#" name="'+kana_to_guess.get('choice_'+k).id + '">'+
						kana_to_guess.get('choice_'+k).kana+'</a></td>';
					k++;
				}
			}
			else if (this.view == 'hiragana-alphanumeric') {
				if (i == 4) {
					html += '<td>'+kana_to_guess.get('to_guess').kana + '</td>';
				}
				else if (i == correct_pos) {
					html += '<td><a class="kana_to_guess" href="#" name="'+kana_to_guess.get('correct').id +'">'+
						kana_to_guess.get('correct').base+ '</a></td>';
				}
				else if (i == 1 || i == 3 || i == 5 || i == 7) {
					html += '<td>&nbsp;</td>';
				}
				else {
					html += '<td><a class="kana_to_guess" href="#" name="'+kana_to_guess.get('choice_'+k).id + '">'+
						kana_to_guess.get('choice_'+k).base+'</a></td>';
					k++;
				}				
			}
			else if (this.view == 'alphanumeric-kanji') {
				if (i == 4) {
					html += '<td>'+kana_to_guess.get('to_guess').base + '</td>';
				}
				else if (i == correct_pos) {
					html += '<td><span class="bolder"><a class="kana_to_guess" href="#" name="'+kana_to_guess.get('correct').id +'">'+
						kana_to_guess.get('correct').kanji+ '</a></span></td>';
				}
				else if (i == 1 || i == 3 || i == 5 || i == 7) {
					html += '<td>&nbsp;</td>';
				}
				else {
					html += '<td><span class="bolder"><a class="kana_to_guess" href="#" name="'+kana_to_guess.get('choice_'+k).id + '">'+
						kana_to_guess.get('choice_'+k).kanji+'</a></span></td>';
					k++;
				}				
			}
			else if (this.view == 'kanji-alphanumeric') {
				if (i == 4) {
					html += '<td><span class="bolder">'+kana_to_guess.get('to_guess').kanji + '</span></td>';
				}
				else if (i == correct_pos) {
					html += '<td><a class="kana_to_guess" href="#" name="'+kana_to_guess.get('correct').id +'">'+
						kana_to_guess.get('correct').base+ '</a></td>';
				}
				else if (i == 1 || i == 3 || i == 5 || i == 7) {
					html += '<td>&nbsp;</td>';
				}
				else {
					html += '<td><a class="kana_to_guess" href="#" name="'+kana_to_guess.get('choice_'+k).id + '">'+
						kana_to_guess.get('choice_'+k).base+'</a></td>';
					k++;
				}
			}
		}
		html += '</tr></table>';
		return html;
	},

	getToGuessView : function(kana_to_guess)
	{
		switch (this.game) {
		case 'kisetsu':
		case 'shuu':
		return this.getToGuessViewKisetsuShuu(kana_to_guess);
		default:
		}

		var correct_pos = this.rand(9);
		while (correct_pos == 4) {
			correct_pos = this.rand(9);
		}

		var html = '<table border="0" cellpadding="0" cellspacing="0"><tr>';

		if (this.view == 'hiragana-kanji') {
			for (var i = 0; i < 9; i++) {
				if ((i != 0) && ((i % 3) == 0)) {
					html += '</tr><tr>';
				}
				if (i == 4) {
					html += '<td><span class="bolder">'+kana_to_guess.get('to_guess').kana + '</span></td>';
				}
				else if (i == correct_pos) {
					html += '<td><span class="bolder"><a class="kana_to_guess" href="#" name="'+kana_to_guess.get('correct').id +'">'+
						kana_to_guess.get('correct').kanji+ '</a></span></td>';
				}
				else {
					html += '<td><span class="bolder"><a class="kana_to_guess" href="#" name="'+kana_to_guess.get('choice_'+i).id + '">'+
						kana_to_guess.get('choice_'+i).kanji+'</a></span></td>';
				}
			}
		}
		else if (this.view == 'kanji-hiragana') {
			for (var i = 0; i < 9; i++) {
				if ((i != 0) && ((i % 3) == 0)) {
					html += '</tr><tr>';
				}
				if (i == 4) {
					html += '<td><span class="bolder">'+kana_to_guess.get('to_guess').kanji + '</span></td>';
				}
				else if (i == correct_pos) {
					html += '<td><a class="kana_to_guess" href="#" name="'+kana_to_guess.get('correct').id +'">'+
					kana_to_guess.get('correct').kana+ '</a></td>';
				}
				else {
					html += '<td><a class="kana_to_guess" href="#" name="'+kana_to_guess.get('choice_'+i).id + '">'+
					kana_to_guess.get('choice_'+i).kana+'</a></td>';
				}
			}
		}
		else if (this.view == 'alphanumeric-hiragana') {
			for (var i = 0; i < 9; i++) {
				if ((i != 0) && ((i % 3) == 0)) {
					html += '</tr><tr>';
				}
				if (i == 4) {
					html += '<td>'+kana_to_guess.get('to_guess').base + '</td>';
				}
				else if (i == correct_pos) {
					html += '<td><a class="kana_to_guess" href="#" name="'+kana_to_guess.get('correct').id +'">'+
					kana_to_guess.get('correct').kana+ '</a></td>';
				}
				else {
					html += '<td><a class="kana_to_guess" href="#" name="'+kana_to_guess.get('choice_'+i).id + '">'+
					kana_to_guess.get('choice_'+i).kana+'</a></td>';
				}
			}
		}
		else if (this.view == 'hiragana-alphanumeric') {
			for (var i = 0; i < 9; i++) {
				if ((i != 0) && ((i % 3) == 0)) {
					html += '</tr><tr>';
				}
				if (i == 4) {
					html += '<td>'+kana_to_guess.get('to_guess').kana + '</td>';
				}
				else if (i == correct_pos) {
					html += '<td><a class="kana_to_guess" href="#" name="'+kana_to_guess.get('correct').id +'">'+
					kana_to_guess.get('correct').base+ '</a></td>';
				}
				else {
					html += '<td><a class="kana_to_guess" href="#" name="'+kana_to_guess.get('choice_'+i).id + '">'+
					kana_to_guess.get('choice_'+i).base+'</a></td>';
				}
			}
		}
		else if (this.view == 'alphanumeric-kanji') {
			for (var i = 0; i < 9; i++) {
				if ((i != 0) && ((i % 3) == 0)) {
					html += '</tr><tr>';
				}
				if (i == 4) {
					html += '<td>'+kana_to_guess.get('to_guess').base + '</td>';
				}
				else if (i == correct_pos) {
					html += '<td><span class="bolder">'+
					'<a class="kana_to_guess" href="#" name="'+kana_to_guess.get('correct').id +'">'+
					kana_to_guess.get('correct').kanji+ '</a></span></td>';
				}
				else {
					html += '<td><span class="bolder">'+
					'<a class="kana_to_guess" href="#" name="'+kana_to_guess.get('choice_'+i).id + '">'+
					kana_to_guess.get('choice_'+i).kanji+'</a></span></td>';
				}
			}
		}
		else if (this.view == 'kanji-alphanumeric') {
			for (var i = 0; i < 9; i++) {
				if ((i != 0) && ((i % 3) == 0)) {
					html += '</tr><tr>';
				}
				if (i == 4) {
					html += '<td><span class="bolder">'+kana_to_guess.get('to_guess').kanji + '</span></td>';
				}
				else if (i == correct_pos) {
					html += '<td><a class="kana_to_guess" href="#" name="'+kana_to_guess.get('correct').id +'">'+
					kana_to_guess.get('correct').base+ '</a></td>';
				}
				else {
					html += '<td><a class="kana_to_guess" href="#" name="'+kana_to_guess.get('choice_'+i).id + '">'+
					kana_to_guess.get('choice_'+i).base+'</a></td>';
				}
			}
		}
		html += '</tr></table>';
		return html;
	},

	getControlView : function()
	{
		var html = '<table border="0" cellpadding="0" cellspacing="0"><tr>' + 
		'<td><img src="'+this.siteurl+'/wp-content/plugins/ganbatte/images/correct.gif" alt="Correct" /></td>' + 
		'<td>' + this.correct + '</td></tr>';

		if (this.game_over) {
			var score = Math.floor((100 * this.correct) / this.all.size());
			html += '<tr><td colspan="2"><ul id="kana-score"><li>' + this.translate[0] + ': ' + score + '&#37;</li>' +
				'<li><input type="button" value="' + this.translate[1] + '" onclick="window.location.reload()" /></li>' +
				'</ul></td></tr>';
		}

		if (this.wrong.size() > 0) {
			html += '<tr><td colspan="2"><table border="0" cellpadding="0" cellspacing="0"><tr>' + 
				'<td colspan="2">' + this.translate[2] + '</td></tr><tr>';
			
				this.wrong.each(function(k, i) {
						if ((i != 0) && ((i % 2) == 0)) {
							html += '</tr><tr>';
						}
						if (this.view == 'hiragana-kanji') {
							html += '<td><span class="hiragana">' + k.value.kana + '</span> = <span class="bolder">' + 
								k.value.kanji + '</span></td>';
						}
						else if (this.view == 'kanji-hiragana') {
							html += '<td><span class="bolder">' + k.value.kanji + '</span> = <span class="romaji">' + 
								k.value.kana + '</span></td>';
						}
						else if (this.view == 'alphanumeric-hiragana') {
							html += '<td><span class="katakana">' + k.value.base + '</span> = <span class="romaji">' + 
								k.value.kana + '</span></td>';
						}
						else if (this.view == 'hiragana-alphanumeric') {
							html += '<td><span class="katakana">' + k.value.kana + '</span> = <span class="romaji">' + 
								k.value.base + '</span></td>';
						}
						else if (this.view == 'alphanumeric-kanji') {
							html += '<td><span class="katakana">' + k.value.base + '</span> = <span class="bolder">' + 
								k.value.kanji + '</span></td>';
						}
						else if (this.view == 'kanji-alphanumeric') {
							html += '<td><span class="bolder">' + k.value.kanji + '</span> = <span class="romaji">' + 
								k.value.base + '</span></td>';
						}

					}, this);
			html += '</tr></table></td></tr>';
		}
		html += '</table>';
		return html;
	},

	/**
	 * return an random number between 0 and n - 1
	 */
	rand : function(n)
	{
		return Math.floor(Math.random() * n);
	}
}

