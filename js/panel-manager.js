Tornado.PanelManager = Class.create();
Tornado.PanelManager.prototype = {
    // Constructor
    initialize: function() {
	this.panels = new Array();
    },
    
    // Add a panel to panelmanager
    addPanel: function(panel) {
	this.panels.push(panel);
	this.loadData({url: panel.getAjaxUrl(), callback: function(data) {
	    panel.dataUpdated(data);
	}});
    },
    
    // Triggers
    itemDeleted: function(item) {
	this.panels.each(function(panel){
	    panel.itemDeleted(item);
	});
    },
    
    // Called when data is updated
    dataUpdated: function(data) {
	this.panels.each(function(panel){
	    panel.dataUpdated(data);
	});
    },

    // Add an item to one or more panels
    addItem: function(data) {
	var self = this;
	var item;

	if (data.Task){
	    item = new Tornado.Task(data);
	} else if (data.List){
	    item = new Tornado.List(data);
	}
	
	item.create(function(data) {
	    self.dataUpdated(data);
	});
    },

    // Populate the global cache
    populateModels: function(data) {
        var contextModels = this.populateContextModels(data);
        var tagModels = this.populateTagModels(data);
        var userModels = this.populateUserModels(data);
        var taskModels = this.populateTaskModels(data);
        var listModels = this.populateListModels(data);

	return {contexts: contextModels,
		tags: tagModels,
		tasks: taskModels,
		lists: listModels,
		users: userModels};
    },

    // Get or post data to the backend
    loadData: function(args) {
	var self = this;
	
	if (!args) {
	    args = {};
	}
	
	jq.ajax({			
            type: args.post ? "post" : "get",
	    cache: false,
	    dataType: 'json',
	    error: function(data){
		Tornado.error(data);
		
		if (args.error) {
		    args.error(data);
		}
	    }, 
	    data: args.data,
	    url: args.url
	}).done(function (data) {
	    if (self.containsData(data)){
		var models = self.populateModels(data);
		
		if (args.callback) {
		    args.callback(models);
		}
	    } else {
		if (args.error) {
		    args.error(data);
		}
	    }
	});
    },

    // Determine if the retrieved data is valid
    // TODO: Should be posible to check if data has any content instead
    containsData: function(data){
	return data && ((data.Tags && data.Tags) || 
	    (data.Tasks && data.Tasks[0]) || 
	    (data.Lists && data.Lists[0]) || 
	    (data.Contexts && data.Contexts[0]) ||
	    (data.ContextsTasks && data.ContextsTasks[0]) ||
	    (data.TagsTasks && data.TagsTasks[0]) ||
	    (data.ListsTasks && data.ListsTasks[0]) || 
	    (data.ContextsLists && data.ContextsLists[0]) || 
	    (data.TagsLists && data.TagsLists[0]));
    },
    
    // Populate lists with its relations to tasks, tags, contexts and users
    populateListModels: function(data) {   
	var lists = this.populateItemModel("list", data);
	this.populateItemModelRelation("list", "context", "ContextList", data.ContextsLists);
	this.populateItemModelRelation("list", "tag", "TagList", data.TagsLists);
	this.populateItemModelRelation("list", "task", "ListTask", data.ListsTasks, true);
	this.populateItemModelRelation("list", "user", "ListUser", data.ListsUsers);
	return lists;
    },
    
    // Populate tasks with its relations to contexts, tags and users
    populateTaskModels: function(data) {
	var tasks = this.populateItemModel("task", data);
	this.populateItemModelRelation("task", "context", "ContextTask", data.ContextsTasks);
	this.populateItemModelRelation("task", "tag", "TagTask", data.TagsTasks);
	this.populateItemModelRelation("task", "user", "TaskUser", data.TasksUsers);
	return tasks;
    },
    
    // Populate tags
    populateTagModels: function(data) {
	return this.populateItemModel("tag", data);
    },
    
    // Populate contexts
    populateContextModels: function(data) {
	return this.populateItemModel("context", data);
    },
    
    // Populate users
    populateUserModels: function(data) {
	return this.populateItemModel("user", data);
    },

    // General function for populating an item
    populateItemModel: function(modelName, data) {
	var items = Array();
	var self = this;
	
	var dataTag = Tornado.getItemDataTag(modelName);
	var itemsData = data[dataTag + "s"];

	if (itemsData){
	    itemsData.each(function(itemData) {
		var item = Tornado.getItem(modelName, itemData[dataTag].id);
		
		if (item && itemData[dataTag].deleted == true && itemData[dataTag].name === undefined) {
		    self.itemDeleted(item);
		    Tornado.unsetItem(modelName, item.id);
		} else {
		    if (!item) {
			var itemClass = Tornado.getItemClass(modelName);
			item = new itemClass(itemData);
			Tornado.setItem(modelName, item.id, item);	
		    } else {
			item.populate(itemData);
		    }
		    
		    items.push(item);	
		}
	    });
	}

	return items;
    },

    // General function for relating items with each other
    populateItemModelRelation: function(mainModel, secondaryModel, relName, data, addAsParent) {
	if (data){
	    data.each(function(relData) {
		var rel = relData[relName];
		var item = Tornado.getItem(mainModel, rel[mainModel + "_id"]);
		var relItem = Tornado.getItem(secondaryModel, rel[secondaryModel + "_id"]);
		
		if (relData && relData[relName].deleted == true) {
		    item[secondaryModel + "s"].unset(relItem.id);
		    
		    if (addAsParent) {
			relItem.parent = null;
		    }
		} else {
		    if (item && relItem){
			item[secondaryModel + "s"].set(rel[secondaryModel + "_id"], relItem); 
			
			if (addAsParent) {
			    relItem.parent = item;
			}
		    }
		}
	    });
	}
    }
};
