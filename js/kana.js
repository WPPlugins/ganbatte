var Kana = Class.create();
Kana.prototype = 
{
	initialize : function(siteurl)
	{
		this.siteurl = siteurl;

		this.translate = new Array('Score','Start','Revise');
		this.kana_view = '';
		this.kana_learn = '';
		this.kana_all = new Hash();
		this.kana_to_guess = new Hash();
		this.kana_wrong = new Hash();
		this.kana_game_over = false;
		this.kana_correct = 0;
		this.kana_current_id = 0;
	},

	startGame : function()
	{
		var form = $('ganbatte-game-control');
		this.kana_view = Form.Element.getValue(form['view']);
		this.kana_learn = Form.Element.getValue(form['learn']);

		form.request({
				requestHeaders: {Accept: 'application/json'},
				parameters: 'game=kana',
				onSuccess: this.startSuccess.bind(this)
			});

		$('ganbatte').innerHTML = '<img src="' + this.siteurl + 
		'/wp-content/plugins/ganbatte/images/ajax-loader.gif" alt="Loading..." />';
	},

	startSuccess : function(response)
	{
		var kanas = response.responseText.evalJSON(true);
		kanas.kanas.each(function(kana, i) {
				this.kana_all.set(i, kana);
				this.kana_to_guess.set(i, kana);
			}, this);

		var kana_to_guess = this.getKanaToGuess(this.kana_to_guess);
		var guess_view = this.getToGuessView(kana_to_guess);
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
		if (!this.kana_game_over) {
			var t = e.element();
			if (!t) return;

			if (this.kana_current_id == t.name) {
				this.kana_correct++;
				this.kanaNext();
			}
			else {
				this.kana_all.each(function(k) {
						if (k.value.id == this.kana_current_id) {
							var index = this.kana_wrong.size();
							this.kana_wrong.set(index, k.value);
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
		var kana_to_guess = this.getKanaToGuess(this.kana_to_guess);

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
			this.kana_game_over = true;
			var control_view = this.getControlView();
			start_console.rows[0].deleteCell(1);
			var control_cell = start_console.rows[0].insertCell(1);
			control_cell.id = 'kana-control';
			control_cell.innerHTML = control_view;
		}
	},

	getKanaToGuess : function(kana_to_guess)
	{
		var size = kana_to_guess.size();
		if (size == 0) return null;

		var n = this.rand(size);
		var kana = null;
		var key = 0;
		this.kana_to_guess.each(function(k, i) {
				if (i == n) {
					kana = k.value;
					key = k.key;
					throw $break;
				}
			});
		this.kana_to_guess.unset(key);

		var ans = new Hash();
		ans.set('to_guess', kana);
		ans.set('correct', kana);
		this.kana_current_id = kana.id;

		var guessable_n = 8;
		while (guessable_n >= 0) {
			n = this.rand(this.kana_all.size());
			this.kana_all.each(function(k, i) {
					if ((i == n) && (kana.romaji != k.value.romaji)) {
						var v = ans.values();
						var found = false;
						for (var j = 0; j < v.length; j++) {
							if (v[j].romaji == k.value.romaji) {
								found = true;
								break;
							}
						}
						if (!found) {
							ans.set('choice_'+guessable_n, k.value);
							guessable_n--;
						}
					}
				});
		}
		return ans;
	},

	getControlView : function(is_end)
	{
		var html = '<table border="0" cellpadding="0" cellspacing="0"><tr>' + 
		'<td><img src="'+this.siteurl+'/wp-content/plugins/ganbatte/images/correct.gif" alt="Correct" /></td>' + 
		'<td>' + this.kana_correct + '</td></tr>';

		if (this.kana_game_over) {
			var score = Math.floor((100 * this.kana_correct) / this.kana_all.size());
			html += '<tr><td colspan="2"><ul id="kana-score"><li>' + this.translate[0] + ': ' + score + '&#37;</li>' +
				'<li><input type="button" value="' + this.translate[1] + '" onclick="window.location.reload()" /></li>' +
				'</ul></td></tr>';
		}

		if (this.kana_wrong.size() > 0) {
			html += '<tr><td colspan="2"><table border="0" cellpadding="0" cellspacing="0"><tr>' + 
				'<td colspan="2">' + this.translate[2] + '</td></tr><tr>';
			
				this.kana_wrong.each(function(k, i) {
						if ((i != 0) && ((i % 2) == 0)) {
							html += '</tr><tr>';
						}
						if (this.kana_learn == 'hiragana') {
							html += '<td><span class="hiragana">' + k.value.hiragana + '</span> = <span class="romaji">' + 
								k.value.romaji + '</span></td>';
						}
						if (this.kana_learn == 'katakana') {
							html += '<td><span class="katakana">' + k.value.katakana + '</span> = <span class="romaji">' + 
								k.value.romaji + '</span></td>';
						}

					}, this);
			html += '</tr></table></td></tr>';
		}

		html += '</table>';
		return html;
	},

	getToGuessView : function(kana_to_guess)
	{
		var correct_pos = this.rand(9);
		while (correct_pos == 4) {
			correct_pos = this.rand(9);
		}

		var html = '<table border="0" cellpadding="0" cellspacing="0"><tr>';

		if (this.kana_view == 'kana') {
			for (var i = 0; i < 9; i++) {
				if ((i != 0) && ((i % 3) == 0)) {
					html += '</tr><tr>';
				}
				if (i == 4) {
					if (this.kana_learn == 'hiragana') {
						html += '<td>'+kana_to_guess.get('to_guess').hiragana + '</td>';
					}
					else if (this.kana_learn == 'katakana') {
						html += '<td>'+kana_to_guess.get('to_guess').katakana + '</td>';
					}
				}
				else if (i == correct_pos) {
					html += '<td><a class="kana_to_guess" href="#" name="'+kana_to_guess.get('correct').id +'">'+
						kana_to_guess.get('correct').romaji+ '</a></td>';
				}
				else {
					html += '<td><a class="kana_to_guess" href="#" name="'+kana_to_guess.get('choice_'+i).id + '">'+
						kana_to_guess.get('choice_'+i).romaji+'</a></td>';
				}
			}
		}
		else if (this.kana_view == 'romaji') {
			for (var i = 0; i < 9; i++) {
				if ((i != 0) && ((i % 3) == 0)) {
					html += '</tr><tr>';
				}
				if (i == 4) {
					html += '<td>'+kana_to_guess.get('to_guess').romaji + '</td>';
				}
				else if (i == correct_pos) {
					if (this.kana_learn == 'hiragana') {
						html += '<td><a class="kana_to_guess" href="#" name="'+kana_to_guess.get('correct').id +'">'+
						kana_to_guess.get('correct').hiragana+ '</a></td>';
					}
					else if (this.kana_learn == 'katakana') {
						html += '<td><a class="kana_to_guess" href="#" name="'+kana_to_guess.get('correct').id +'">'+
						kana_to_guess.get('correct').katakana+ '</a></td>';
					}
				}
				else {
					if (this.kana_learn == 'hiragana') {
						html += '<td><a class="kana_to_guess" href="#" name="'+kana_to_guess.get('choice_'+i).id + '">'+
						kana_to_guess.get('choice_'+i).hiragana+'</a></td>';
					}
					else if (this.kana_learn == 'katakana') {
						html += '<td><a class="kana_to_guess" href="#" name="'+kana_to_guess.get('choice_'+i).id + '">'+
						kana_to_guess.get('choice_'+i).katakana+'</a></td>';
					}
				}
			}
		}

		html += '</tr></table>';
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
