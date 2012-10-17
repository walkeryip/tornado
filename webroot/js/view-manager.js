Tornado.ViewManager = Class.create();
Tornado.ViewManager.prototype = {
	initialize: function() {
		this.views = new Array();
	},
	
	addView: function(view) {
		this.views.push(view);
		view.load();
	},

	itemChanged: function(item) {
		this.views.each(function(view){
			view.itemChanged(item);
		});
	},

	itemDeleted: function(item) {
		this.views.each(function(view){
			view.itemDeleted(item);
		});
	},

	itemAdded: function(item) {
		this.views.each(function(view){
			view.itemAdded(item);
		});
	},

	addItem: function(data) {
		var self = this;
		var item;
		if (data.Task){
			item = new Tornado.Task(data);
		} else if (data.TaskList){
			item = new Tornado.List(data);
		}

		item.create(function() {
			self.itemAdded(item);
		});
		
	}
};
