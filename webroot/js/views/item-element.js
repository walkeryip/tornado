Tornado.ItemElement = Class.create();
Tornado.ItemElement.prototype = {
	init: function() {
		this.visible = false;
	},

	remove: function() {
		this.element.remove();
		this.visible = false;
	}
};
