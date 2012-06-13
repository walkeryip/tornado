Tornado.Label = Class.create();
Tornado.Label.prototype = {
	initialize: function(data) {
		this.populate(data);
	},

	populate: function(data) {
		this.name = data.name;
		this.id = data.id;
		this.created = data.created;
	}
};
