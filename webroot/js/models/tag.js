Tornado.Tag = Class.create(Tornado.Label, {
	initialize: function($super, data) {
		$super(data);
	},

    getModelUrlName: function(){
        return "tags";
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
	}
});
