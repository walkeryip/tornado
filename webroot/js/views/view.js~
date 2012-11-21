// Abstract class
Tornado.View = Class.create();
Tornado.View.prototype = {
	initialize: function (id, containerId) {
		this.id = id;

		this.taskElements = new Hash();
		this.tagElements = new Hash();
        this.contextElements = new Hash();
        this.listElements = new Hash();

		this.container = jq(containerId);
		this.container.hide();
		this.container.addClass("view");


	},

	populate: function (data) {
        /*var contexts = this.populateContexts(data);
        var tags = this.populateTags(data);
        var tasks = this.populateTasks(data);
        var lists = this.populateLists(data);*/

        /*this.populateContextElements(data.contexts);
        this.populateTagElements(data.tags);
        this.populateTaskElements(data.tasks);
        this.populateListElements(data.lists);*/

    },

	dataUpdated: function (data) {
		
		var emptyView = false;
		if (this.taskElements.size() == 0 && this.tagElements.size() == 0 && this.contextElements.size() == 0 && this.listElements.size() == 0){
			emptyView = true;
		}

        this.populateItemElements(data.contexts);
        this.populateItemElements(data.tags);
        this.populateItemElements(data.tasks);
        this.populateItemElements(data.lists);
		this.display();

		if (emptyView) {
			this.model = this.getModel();
			this.container.prepend("<h2>" + this.getTitle() + "</h2>");
			this.container.fadeIn("slow");
			this.loaded = true;
		}
	},


    /*populateLists: function(data) {
		var lists = Array();
		
		var listsData = data.TaskLists;
		if (listsData !== undefined){
		    listsData.each(function(listData) {
		        var list = Tornado.lists.get(listData.TaskList.id);

		        if (!list) {
		            list = new Tornado.List(listData);
		            Tornado.lists.set(list.id, list);
		        } else {
					list.populate(listData);
				}
				
				lists.push(list);
		    });
		}
		
		var contextsLists = data.ContextsTaskLists;
		if (contextsLists !== undefined){
			contextsLists.each(function(contextListData) {
				var contextList = contextListData.ContextTaskList;

				var list = Tornado.lists.get(contextList.task_list_id);
				var context = Tornado.contexts.get(contextList.context_id);
				if (list !== undefined && context !== undefined){
					list.contexts.set(contextList.context_id, context); 
				}
			});
		}

		var tagsLists = data.TagsTaskLists;
		if (tagsLists !== undefined){
			tagsLists.each(function(tagListData) {
				var tagList = tagListData.TagTaskList;

				var list = Tornado.lists.get(tagList.task_list_id);
				var tag = Tornado.tags.get(tagList.tag_id);
				if (list !== undefined && tag !== undefined){
					list.tags.set(tagList.tag_id, tag); 
				}
			});
		}
		
		return lists;
    },

	populateTasks: function(data) {
		var tasks = Array();

		var tasksData = data.Tasks;
		if (tasksData !== undefined){
			tasksData.each(function(taskData) {
				var task = Tornado.tasks.get(taskData.Task.id);

				if (!task) {
					task = new Tornado.Task(taskData);
					Tornado.tasks.set(task.id, task);	
				} else {
					task.populate(taskData);
				}

				tasks.push(task);		
			});
		}

		var contextsTasks = data.ContextsTasks;
		if (contextsTasks !== undefined){
			contextsTasks.each(function(contextTaskData) {
				var contextTask = contextTaskData.ContextTask;

				var task = Tornado.tasks.get(contextTask.task_id);
				var context = Tornado.contexts.get(contextTask.context_id);
				if (task !== undefined && context !== undefined){
					task.contexts.set(contextTask.context_id, context);
				} 
			});
		}

		var tagsTasks = data.TagsTasks;
		if (tagsTasks !== undefined){
			tagsTasks.each(function(tagTaskData) {
				var tagTask = tagTaskData.TagTask;

				var task = Tornado.tasks.get(tagTask.task_id);
				var tag = Tornado.tags.get(tagTask.tag_id);
				if (task !== undefined && tag !== undefined){
					task.tags.set(tagTask.tag_id, tag); 
				}
			});
		}

		return tasks;
	},

	populateTags: function(data) {
		var tags = Array();

		var tagsData = data.Tags;
		if (tagsData !== undefined){
			tagsData.each(function(tagData) {
				var tag = Tornado.tags.get(tagData.Tag.id);

				if (!tag) {
					tag = new Tornado.Tag(tagData);
					Tornado.tags.set(tag.id, tag);			
				} else {
					tag.populate(tagData);
				}

				tags.push(tag);
			});
		}

		return tags;
	},

	populateContexts: function(data) {
		var contexts = Array();

		var contextsData = data.Contexts;
		if (contextsData !== undefined){
			contextsData.each(function(contextData) {
				var context = Tornado.contexts.get(contextData.Context.id);

				if (!context) {
					context = new Tornado.Context(contextData);
					Tornado.contexts.set(context.id, context);
				} else {
					context.populate(contextData);
				}

				contexts.push(context);			
			});
		}

		return contexts;
	},*/

	populateItemElement: function(item, itemElements) {
		if (this.includeItem(item)){
			if (itemElements.get(item.id) == undefined){
				this.itemAdded(item);
			} else {
				this.itemChanged(item);
			}
		}
	},

	populateItemElements: function(items) {
		var self = this;
		var itemElements = this.getModelElementMatrix(items);

		if (items !== undefined){
			items.each(function(item) {
				self.populateItemElement(item, itemElements);
			});
		}
	},

	itemChanged: function(item) {
		var foundItem = this.getItemElement(item);
		if (foundItem) {
			this.updateItem(foundItem);
		} else {
			this.itemAdded(item);
		}
	},

	itemDeleted: function(item) {
		var foundItem = this.getItemElement(item);

		if (foundItem){			
			foundItem.element.fadeOut("fast", function (){
				$(this).remove();
			});
			this.unsetItemElement(item);
		}
	},

	itemAdded: function(item) {
		//if (this.includeItem(item)){
			var element = this.newItemElement(item);
			
            this.addItem(element);
		//}
	},
	
	getModelElementMatrix: function(o) {
		var item = o;

		// If list
		if (o[0] !== undefined){
			item = o[0];
		}

		if (item instanceof Tornado.Task) {
			return this.taskElements; 
		} else if (item instanceof Tornado.Tag) {
			return this.tagElements;
		} else if (item instanceof Tornado.Context) {
			return this.contextElements;
		} else if (item instanceof Tornado.List) {
			return this.listElements;
		}
	},
	
	getNewModelElement: function(item) {
		if (item instanceof Tornado.Task) {
			return new Tornado.TaskElement(item);
		} else if (item instanceof Tornado.Tag) {
			return new Tornado.TagElement(item);
		} else if (item instanceof Tornado.Context) {
			return new Tornado.ContextElement(item);
		} else if (item instanceof Tornado.List) {
			return new Tornado.ListElement(item);
		}
	},

	/*populateListElements: function(lists) {
		var self = this;
		if (lists !== undefined){
		    lists.each(function(list) {
				if (self.includeItem(list)){
					if (self.listElements.get(list.id) == undefined){
						self.itemAdded(list);
					} else {
						self.itemChanged(list);
					}
				}
				self.populateItemElement(list);
		    });
		}
    },

	populateTaskElements: function(tasks) {
		var self = this;
		if (tasks !== undefined){
			tasks.each(function(task) {
				if (self.includeItem(task) && self.taskElements.get(task.id) == undefined && self.includeItem(task)){
					self.taskElements.set(task.id, new Tornado.TaskElement(task));
				}
			});
		}
	},
	
	populateTagElements: function(tags) {
		var self = this;
		if (tags !== undefined){
			tags.each(function(tag){
				if (self.includeItem(tag) && self.listElements.get(tag.id) == undefined){
					self.tagElements.set(tag.id, new Tornado.TagElement(tag));
				}
			});
		}
	},
	
	populateContextElements: function(contexts) {
		var self = this;
		if (contexts !== undefined){
			contexts.each(function(context){
				if (self.includeItem(context) && self.contextElements.get(context.id) == undefined){
					self.contextElements.set(context.id, new Tornado.ContextElement(context));
				}
			});
		}
	},*/

	// Abstract function
	display: function() {},

	// Overridable function
	getTitle: function() {
		return "unknown";
	},

	

    // Abstract function
    addItem: function() {},
	updateItem: function() {},

	load: function () {
		var view = this;

		/*jq.ajax({
		  	cache: false,
			dataType: 'json',
			error: function(data){
				Tornado.error(data);
			}, 
		  	url: this.getAjaxUrl()
		}).done(function (data) {
			if (data && view.containsData(data)){
				view.populate(data);
				view.display();
				view.container.fadeIn("slow");
				view.loaded = true;
			} 
		});*/

		Tornado.viewManager.loadData(this.getAjaxUrl(), this);
	},
	
	arrayHasElements: function(data){
		
	},
	
	/*containsData: function(data){
		return (data.Tags !== undefined && data.Tags.length > 0) || 
				(data.Tasks !== undefined && data.Tasks.length > 0) || 
				(data.TaskLists !== undefined && data.TaskLists.length > 0) || 
				(data.Contexts !== undefined && data.Contexts.length > 0);
	},*/

	// Abstract function 
	getAjaxUrl: function() {},

	
	
	getItemElement: function(item) {
		return this.getModelElementMatrix(item).get(item.id);
	},
	
	unsetItemElement: function(item) {
		this.getModelElementMatrix(item).unset(item.id);
	},
	
	newItemElement: function(item) {
		var element = this.getNewModelElement(item);
		this.getModelElementMatrix(item).set(item.id, element);
		
		return element;
	},

	includeItem: function(item) { return true; },
	
	getModel: function() { return null; }
};
