Tornado.Tag = Class.create(Tornado.Item, {
	initialize: function($super, data) {
		$super(data);
	},

    getModelName: function(){
        return "tag";
    },

	populate: function($super, data) {
        $super(data);

		var tag = data.Tag;

		if (tag) {
			this.id = tag.id;
			this.name = tag.name;
		} else {
			this.name = data.name;
		}
	},

	getClass: function() {
		return Tornado.Tag;
	},

	getContainer: function() {
		return Tornado.tags;
	}
});
