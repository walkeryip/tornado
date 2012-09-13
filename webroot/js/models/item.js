Tornado.Item = Class.create();
Tornado.Item.prototype = {
	initialize: function(data) {
		this.contexts = new Array();
        this.tags = new Array();
        this.lists = new Array();

        this.populate(data);
	},

    populate: function(data) {
        var self = this;

        if (data.Context){
            data.Context.each(function(contextData){
                self.fetchContext(contextData);
            });
        }

        if (data.Tag){
            data.Tag.each(function(tagData){
                self.fetchTag(tagData);
            });
        }

        if (data.List){
            data.List.each(function(listData){
                self.fetchList(listData);
            });
        }
    },

    delete: function(callback) {
        jq.ajax({
            cache: false,
            dataType: 'json',
            url: "/tornado/" + this.getModelUrlName() + "/delete/" + this.id
        }).done(function (data) {
                if (data){
                    callback();
                }
            });
    },

    create: function(callback) {
        var self = this;

        jq.ajax({
            type: "post",
            cache: false,
            dataType: 'json',
            url: "/tornado/" + this.getModelUrlName() + "/add/",
            data: this.getSubmitData(false)
        }).done(function (result) {
                if (result){
                    self.populate(result);
                    callback();
                }
            });
    },

    save: function(callback) {
        var self = this;

        jq.ajax({
            type: "post",
            cache: false,
            dataType: 'json',
            url: "/tornado/" + this.getModelUrlName() + "/edit/" + self.id,
            data: this.getSubmitData(true)
        }).done(function (result) {
                if (result){
                    self.populate(result);
                    callback();
                }
            });
    },

	fetchContext: function(contextData) {
		var context = Tornado.contexts.get(contextData.name);

		if (!context || context === undefined) {
			context = new Tornado.Context(contextData);
			Tornado.contexts.set(context.name, context);
		}

		this.contexts.push(context);
	},

    fetchTag: function(tagData) {
        var tag = Tornado.tags.get(tagData.name);

        if (!tag || tag === undefined) {
            tag = new Tornado.Tag(tagData);
            Tornado.tags.set(tag.name, tag);
        }

        this.tags.push(tag);
    },

    fetchList: function(listData) {
        var list = Tornado.lists.get(listData.id);

        if (!list || list === undefined) {
            list = new Tornado.List(listData);
            Tornado.lists.set(list.id, list);
        }

        this.lists.push(list);
    },

	getLabelsString: function(data) {
		var result = new Array();
	
		data.each(function(label) {
			result.push(label.name);
		});

		return result.join(",");
	},

	getContextsString: function() {
		return this.getLabelsString(this.contexts);
	},

	getTagsString: function() {
		return this.getLabelsString(this.tags);
	},

    getObjectSubmitString: function(name, data){
        var result = {};
        var hashString = "data[" + name + "]";

        if (data.length > 0){
            data.each(function(item, index){
				if (item.id === undefined) {
					result[hashString + "[name]"] = item.name;
				} else {
                	result[hashString + "[id]"] = item.id;
				}
            });
        }
        return result;
    },

    getContextsSubmitString: function(data){
        return this.getObjectSubmitString("Context", this.contexts);
    },

    getTagsSubmitString: function(data){
        return this.getObjectSubmitString("Tag", this.tags);
    },

    getListsSubmitString: function(data){
        return this.getObjectSubmitString("TaskList", this.lists);
    },

    getModelUrlName: function() { return ""; },
    getSubmitData: function() { return {}; }
};
