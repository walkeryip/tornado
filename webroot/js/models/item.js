Tornado.Item = Class.create();
Tornado.Item.prototype = {
	initialize: function(data) {
		this.contexts = new Hash();
        this.tags = new Hash();
        this.lists = new Hash();
        this.tasks = new Hash();

        this.populate(data);
	},

    populate: function(data) {
        var self = this;
		self.reset();

		var contexts, tags, lists, tasks;

		if (data.Contexts !== undefined){
			data.Contexts.each(function(contextData){
            	self.fetchContext(contextData.Context);
            });
		}

		if (data.Tags !== undefined){
            data.Tags.each(function(tagData){
            	self.fetchTag(tagData.Tag);
            });
		}

		if (data.TaskLists !== undefined){
			data.TaskList.each(function(listData){
            	self.fetchList(listData.TaskList);
            });
		}

		/*if (data.Tasks !== undefined){
			data.Tasks.each(function(taskData){
            	self.fetchTask(taskData.Task);
            });
		}*/
    },

	// Make sure that no old data remains after an update
	reset: function() {
		this.contexts.clear();
		this.tags.clear();
		this.lists.clear();
	},

    remove: function(callback) {
		Tornado.viewManager.loadData("/tornado/" + this.getModelUrlName() + "/delete/" + this.id, callback, false);
    },

    create: function(callback) {
		Tornado.viewManager.loadData("/tornado/" + this.getModelUrlName() + "/add/", callback, this.getSubmitData(false), true);
    },

    save: function(callback) {
		Tornado.viewManager.loadData("/tornado/" + this.getModelUrlName() + "/edit/" + this.id, callback, this.getSubmitData(true), true);
    },

	move: function(parentId, callback) {
		Tornado.viewManager.loadData("/tornado/" + this.getModelUrlName() + "/move/" + this.id + "/" + this.parent.id + "/" + parentId, callback, null, true);
	},

	fetchContext: function(contextData) {
		var context = Tornado.contexts.get(contextData.name);

		if (!context || context === undefined) {
			context = new Tornado.Context(contextData);
			if (context.id !== undefined) {
				Tornado.contexts.set(context.name, context);
			}
		}

		this.contexts.set(context.name, context);
	},

    fetchTag: function(tagData) {
        var tag = Tornado.tags.get(tagData.name);

        if (!tag || tag === undefined) {
            tag = new Tornado.Tag(tagData);
        	if (tag.id !== undefined) {
            	Tornado.tags.set(tag.name, tag);
			}
        }

		this.tags.set(tag.name, tag);
    },

    fetchList: function(listData) {
        var list = Tornado.lists.get(listData.id);

        if (!list || list === undefined) {
            list = new Tornado.List(listData);
            Tornado.lists.set(list.id, list);
        }

        this.lists.set(list.id, list);
    },

    fetchTask: function(taskData) {
        var task = Tornado.tasks.get(taskData.id);

        if (!task || task === undefined) {
            task = new Tornado.Task(taskData);
            Tornado.tasks.set(task.id, task);
        }

        this.tasks.set(task.id, task);
    },

	getLabelsString: function(data) {
		var result = new Array();
	
		data.each(function(label) {
			result.push(label.value.name);
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

        data.each(function(item, index){
			if (item.value.id === undefined) {
				result[hashString + "[name]"] = item.value.name;
			} else {
               	result[hashString + "[id]"] = item.value.id;
			}
        });
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
    getSubmitData: function() { return {}; },

	hasLabelId: function(map, labelId) {
		return map.get(labelId) !== undefined;
	},

	hasContextId: function(contextId) {
		return this.hasLabelId(this.contexts, contextId);
	},

	hasTagId: function(tagId) {
		return this.hasLabelId(this.tags, tagId);
	},

	getParent: function() {
		var result = null;
		this.lists.each(function (item, index){
			result = item.value;
		});
		return result;
	},

	getClass: function() {
		return Tornado.Item;
	},

	getContainer: function() {
		return null;
	}
};
