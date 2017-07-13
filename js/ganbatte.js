var Ganbatte = Class.create();
Ganbatte.prototype = 
{
	initialize : function()
	{
		this.siteurl = '';
		this.game = '';

		if ($('ganbatte')) {
			this.getSiteurl();
		}
		if ($('ganbatte_ajax')) {
			$('ganbatte_ajax').setAttribute('value','yes');
		}
		if ($('ganbatte-go')) {
			$('ganbatte-go').observe('click', this.chooseGame.bindAsEventListener(this));
		}
	},

	getSiteurl : function()
	{
		var url = window.location.pathname;
		new Ajax.Request(url, {
				parameters:	'ganbatte_action=siteurl&ganbatte_ajax=yes',
				onSuccess: this.setSiteUrl.bindAsEventListener(this)
		});
	},

	setSiteUrl : function(transport)
	{
		this.siteurl = transport.responseText;
	},

	chooseGame : function(e)
	{
		e.stop();
		var url = window.location.pathname;
		var form = $('ganbatte-choose-game');
		this.game = Form.Element.getValue(form['game']);
		if (!this.game || (this.game.length == 0)) return;

		new Ajax.Request(url, {
				method:'post',
				parameters: form.serialize(true),
				onSuccess : this.chooseGameOnComplete.bindAsEventListener(this)
		});
		$('ganbatte').innerHTML = '<img src="' + 
		this.siteurl + '/wp-content/plugins/ganbatte/images/ajax-loader.gif" alt="Loading..." />';
	},

	chooseGameOnComplete : function(response)
	{
		var head = document.getElementsByTagName('head')[0];
		var js = document.createElement('script');
		js.setAttribute('type','text/javascript');
		switch (this.game) {
		case 'kana':
			js.setAttribute('src',this.siteurl + '/wp-content/plugins/ganbatte/js/kana.js');
			break;
		default:
			js.setAttribute('src',this.siteurl + '/wp-content/plugins/ganbatte/js/minna.js');
		}
		head.appendChild(js);

		$('ganbatte').innerHTML = response.responseText;
		$('ganbatte-back').observe('click', this.backButton.bindAsEventListener(this));
		$('ganbatte-start-game').observe('click', this.startGame.bindAsEventListener(this));
	},

	backButton : function(e)
	{
		e.stop();
		var url = window.location.pathname;

		$('ganbatte').innerHTML = '<img src="' + this.siteurl + '/wp-content/plugins/ganbatte/images/ajax-loader.gif" alt="Loading..." />';
		new Ajax.Request(url, {
				parameters: 'ganbatte_action=start-view&ganbatte_ajax=yes',
				onSuccess : this.backButtonReAttachEvents.bindAsEventListener(this)
		});
	},

	backButtonReAttachEvents : function(response)
	{
		$('ganbatte').innerHTML = response.responseText;
		if ($('ganbatte_ajax')) {
			$('ganbatte_ajax').setAttribute('value','yes');
		}
		if ($('ganbatte-go')) {
			$('ganbatte-go').observe('click', this.chooseGame.bindAsEventListener(this));
		}		
	},

	startGame : function(e)
	{
		e.stop();
		switch (this.game) {
		case 'kana':
			var kana = new Kana(this.siteurl);
			kana.startGame();
			break;
		default:
			var minna = new Minna(this.siteurl, this.game);
			minna.startGame();
		}
	}
}
function init() {
	new Ganbatte();
}
Event.observe(window, 'load', init);

//
