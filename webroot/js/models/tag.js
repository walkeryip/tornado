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
		    this.name = escapeString(tag.name) || "";
		} else {
		    this.name = escapeString(data.name) || "";
		}
	},

    	getSubmitData: function(compactMode) {
        var data = {"data[Tag][name]": this.name,
		    "data[Tag][id]": this.id};

        return data;
    },


	getClass: function() {
		return Tornado.Tag;
	},

	getContainer: function() {
		return Tornado.tags;
	}
});
