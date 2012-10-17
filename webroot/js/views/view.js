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
        var contexts = this.populateContexts(data);
        var tags = this.populateTags(data);
        var tasks = this.populateTasks(data);
        var lists = this.populateLists(data);

        this.populateContextElements(contexts);
        this.populateTagElements(tags);
        this.populateTaskElements(tasks);
        this.populateListElements(lists);
		this.model = this.getModel();

		this.container.prepend("<h2>" + this.getTitle() + "</h2>");
    },


    populateLists: function(data) {
		var lists = Array();
		
		var listsData = data.TaskLists;
		if (listsData !== undefined){
		    listsData.each(function(listData) {
		        var list = Tornado.lists.get(listData.TaskList.id);

		        if (!list) {
		            list = new Tornado.List(listData);
		            Tornado.lists.set(list.id, list);
		        }
				
				lists.push(list);
		    });
		}
		
		var contextsLists = data.ContextsLists;
		if (contextsLists !== undefined){
			contextsLists.each(function(contextListData) {
				var contextList = contextListData.ContextTaskList;

				var list = Tornado.lists.get(contextList.task_id);
				var context = Tornado.contexts.get(contextList.context_id);
				list.contexts.set(contextList.context_id, context); 
			});
		}

		var tagsLists = data.TagsLists;
		if (tagsLists !== undefined){
			tagsLists.each(function(tagListData) {
				var tagList = tagListData.TagTaskList;

				var list = Tornado.lists.get(tagList.task_id);
				var tag = Tornado.tags.get(tagList.tag_id);
				list.tags.set(tagList.tag_id, tag); 
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
				task.contexts.set(contextTask.context_id, context); 
			});
		}

		var tagsTasks = data.TagsTasks;
		if (tagsTasks !== undefined){
			tagsTasks.each(function(tagTaskData) {
				var tagTask = tagTaskData.TagTask;

				var task = Tornado.tasks.get(tagTask.task_id);
				var tag = Tornado.tags.get(tagTask.tag_id);
				task.tags.set(tagTask.tag_id, tag); 
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
				}

				contexts.push(context);			
			});
		}

		return contexts;
	},



	populateListElements: function(lists) {
		var self = this;
		if (lists !== undefined){
		    lists.each(function(list) {
		        self.listElements.set(list.id, new Tornado.ListElement(list));
		    });
		}
    },

	populateTaskElements: function(tasks) {
		var self = this;
		if (tasks !== undefined){
			tasks.each(function(task) {
				if (self.includeItem(task)){
					self.taskElements.set(task.id, new Tornado.TaskElement(task));
				}
			});
		}
	},
	
	populateTagElements: function(tags) {
		var self = this;
		if (tags !== undefined){
			tags.each(function(tag){
				self.tagElements.set(tag.id, new Tornado.TagElement(tag));
			});
		}
	},
	
	populateContextElements: function(contexts) {
		var self = this;
		if (contexts !== undefined){
			contexts.each(function(context){
				self.contextElements.set(context.id, new Tornado.ContextElement(context));
			});
		}
	},

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

		jq.ajax({
		  	cache: false,
			dataType: 'json',
		  	url: this.getAjaxUrl()
		}).done(function (data) {
			if (data && view.containsData(data)){
				view.populate(data);
				view.display();
				view.container.fadeIn("slow");
				view.loaded = true;
			}
		});
	},
	
	arrayHasElements: function(data){
		
	},
	
	containsData: function(data){
		return (data.Tags !== undefined && data.Tags.length > 0) || 
				(data.Tasks !== undefined && data.Tasks.length > 0) || 
				(data.TaskLists !== undefined && data.TaskLists.length > 0) || 
				(data.Contexts !== undefined && data.Contexts.length > 0);
	},

	// Abstract function 
	getAjaxUrl: function() {},

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
		if (this.includeItem(item)){
			var element = this.newItemElement(item);
			
            this.addItem(element);
		}
	},
	
	getModelElementMatrix: function(item) {
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
