Tornado.Item = Class.create();
Tornado.Item.prototype = {
	initialize: function(data) {
		this.contexts = new Array();
        this.tags = new Array();
        this.lists = new Array();
	},

	fetchContext: function(contextData) {
		var context = Tornado.contexts.get(contextData.id);

		if (!context) {
			context = new Tornado.Context(contextData);
			Tornado.contexts.set(context.id, context);
		}

		this.contexts.push(context);
	},

    fetchTag: function(tagData) {
        var tag = Tornado.tags.get(tagData.id);

        if (!tag) {
            tag = new Tornado.Tag(tagData);
            Tornado.tags.set(tag.id, tag);
        }

        this.tags.push(tag);
    },

    fetchList: function(listData) {
        var list = Tornado.lists.get(listData.id);

        if (!list) {
            list = new Tornado.List(listData);
            Tornado.lists.set(list.id, list);
        }

        this.lists.push(list);
    },

	getLabelsString: function(arrayObject) {
		var nameArray = new Array();
	
		arrayObject.each(function(label) {
			nameArray.push(label.name);
		});

		return nameArray.join(", ");
	},

	getContextsString: function() {
		return this.getLabelsString(this.contexts);
	},

	getTagsString: function() {
		return this.getLabelsString(this.tags);
	}
};
