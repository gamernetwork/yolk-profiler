
var yolk_debug = {

	container: null,
	header:    null,
	body:      null,
	resizer:   null,

	current: null,

	height: 0,

	transition_time: 350,

	init: function() {

		this.container = jQuery('#yolk-debug');
		this.header    = jQuery('#yolk-debug header');
		this.body      = jQuery('#yolk-debug-body');
		this.resizer   = jQuery('#yolk-debug-resize');

		this.closed_height = this.header.height() + this.resizer.height();

		jQuery('#yolk-debug header li:first-child').on('click', this.show.bind(this));
		jQuery('#yolk-debug header li:last-child').on('click', this.hide.bind(this));
		jQuery('#yolk-debug header li[data-tab!=""][data-tab]').on('click', this.setTab.bind(this));

		this.resize(500);

		this.container.fadeIn(1000);

	},

	resize: function( height ) {
		this.height = height;
		this.body.height(this.height);
		return this;
	},

	show: function() {
		// fade the resizer back in so we can use it
		this.resizer.fadeIn(this.transition_time);
		// maximise the bar to the width of the page
		this.container.animate({width:'100%'}, this.transition_time);
		// if we have a current tab then open it at the same time
		if( this.current )
			this.open();
		return this;
	},

	hide: function() {
		// fade out the resizer as we won't need it when the bar is hidden
		this.resizer.fadeOut(350);
		// minimise the bar to the top right corner
		this.container.animate({width:'3em'}, this.transition_time);
		// at the same time make sure the body is closed
		this.close();
		return this;
	},

	open: function() {
		this.body.slideDown(this.transition_time);
		return this;
	},

	close: function() {
		this.body.slideUp(this.transition_time);
		return this;
	},

	showTab: function( tab ) {
		this.current = tab;
		tab.state.addClass('active');
		tab.panel.fadeIn(this.transition_time);
		return this;
	},

	hideTab: function( tab ) {
		this.current.state.removeClass('active');
		this.current.panel.fadeOut(this.transition_time);
		this.current = null;
		return this;
	},

	setTab: function( e ) {

		var next = jQuery(e.currentTarget).data('tab');
		next = {
			name: next,
			state: jQuery(e.currentTarget),
			panel: jQuery('#' + next),
		};

		// no current tab so just show it
		if( !this.current ) {
			this.open().showTab(next);
		}
		// hide current tab
		else if( next.name == this.current.name ) {
			this.hideTab(next).close();
		}
		// hide current tab and show next one
		else {
			this.hideTab(next).showTab(next);
		}

	}

};

jQuery(document).ready(function() {
	yolk_debug.init();
});
