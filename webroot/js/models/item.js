Tornado.Item = Class.create();
Tornado.Item.prototype = {
    initialize: function(data) {
	this.contexts = new Hash();
        this.tags = new Hash();
        this.lists = new Hash();
        this.tasks = new Hash();
        this.users = new Hash();

        this.populate(data);
    },

    // TODO: Use the same populate method that is used when loading data from backend
    populate: function(data) {
        var self = this, contexts, tags, lists, tasks;

	self.reset();

	this.fetchModels(data.Tasks, "task", this.tasks, "id");
	this.fetchModels(data.Lists, "list", this.lists, "id");
	this.fetchModels(data.Users, "user", this.users, "id");
	this.fetchModels(data.Tags, "tag", this.tags, "name");
	this.fetchModels(data.Contexts, "context", this.contexts, "name");
    },

    fetchModels: function(data, modelName, map, identifier) {
	var self = this;
	if (data) {
	    data.each(function(itemData){
		var dataTag = Tornado.getItemDataTag(modelName);
		if (itemData[dataTag]) {
		    var item = self.fetchItem(itemData[dataTag], modelName, identifier);
		    map.set(item[identifier], item);

		}
            });
	}
    },

    fetchItem: function(data, modelName, identifier) {	
	var item = Tornado.getItem(modelName, data[identifier]);

	if (!item) {
	    var itemClass = Tornado.getItemClass(modelName);
	    item = new itemClass(data);
	    if (item.id) {
		Tornado.setItem(modelName, item[identifier], item);
	    }
	}

	return item;
    },
    
    // Make sure that no old data remains after an update
    reset: function() {
	this.contexts.clear();
	this.tags.clear();
	this.lists.clear();
	this.tasks.clear();
	this.users.clear();
    },
    
    remove: function(callback) {
	Tornado.panelManager.loadData(	{url: "/tornado/" + this.getModelUrlName() + "/delete/" + this.id, 
					 callback: callback, 
					 post: false});
    },

    restore: function(callback) {
	Tornado.panelManager.loadData(	{url: "/tornado/" + this.getModelUrlName() + "/restore/" + this.id, 
					 callback: Tornado.panelManager.dataUpdated, 
					 post: true});
    },

    create: function(callback) {
	Tornado.panelManager.loadData(	{url: "/tornado/" + this.getModelUrlName() + "/add/", 
					 callback: callback, 
					 data: this.getSubmitData(false), 
					 post: true});
    },

    save: function(callback) {
	Tornado.panelManager.loadData(	{url: "/tornado/" + this.getModelUrlName() + "/edit/" + this.id, 
					 callback: callback, 
					 data: this.getSubmitData(true), 
					 post: true});
    },

    move: function(parentId, callback, errorCallback) {
	var oldParentId = this.parent ? this.parent.id : this.parent_id;
	var url = "/tornado/" + this.getModelUrlName() + "/move/" + this.id + "/" + oldParentId;
	
	if (parentId) {
	    url += "/" + parentId;
	}
	
	Tornado.panelManager.loadData(	{url:  url, 
					 callback: callback, 
					 error: errorCallback,
					 post: true});
    },
   
    getLabelsString: function(data) {
	var result = new Array();
	
	data.each(function(label) {
	    result.push(label.value.name);
	});
	
	return result.join(",");
    },
    
    getObjectSubmitString: function(name, data){
        var result = {};
        var hashString = "data[" + name + "]";

        data.each(function(item, index){
			if (!item.value.id) {
				result[hashString + "[name]"] = item.value.name;
			} else {
               	result[hashString + "[id]"] = item.value.id;
			}
        });
        return result;
    },

    getContextsString: function() { return this.getLabelsString(this.contexts); },
    getTagsString: function() { return this.getLabelsString(this.tags); },
    getUsersString: function() { return this.getLabelsString(this.users); },

    getContextsSubmitString: function(data){ return this.getObjectSubmitString("Context", this.contexts); },
    getTagsSubmitString: function(data){ return this.getObjectSubmitString("Tag", this.tags); },
    getListsSubmitString: function(data){ return this.getObjectSubmitString("List", this.lists); },
    
    getModelUrlName: function() { return this.getModelName() + "s"; }, 
    getModelName: function() { return "item"; },
    getSubmitData: function() { return {}; },

    hasLabelId: function(map, labelId) { return map.get(labelId); },
    hasContextId: function(contextId) { return this.hasLabelId(this.contexts, contextId); },
    hasTagId: function(tagId) { return this.hasLabelId(this.tags, tagId); },
};
