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
        this.populateTaskElements(data.Tasks);
        this.populateListElements(data.TaskLists);
        this.populateContextElements(data.Contexts);
        this.populateTagElements(data.Tags);
		this.model = this.getModel();

		this.container.prepend("<h2>" + this.getTitle() + "</h2>");
    },

    populateListElements: function(listsData) {
        var self = this;

		if (listsData !== undefined){
		    listsData.each(function(listData) {
		        var list = Tornado.lists.get(listData.TaskList.id);

		        if (!list) {
		            list = new Tornado.List(listData);
		            Tornado.lists.set(list.id, list);
		        }

		        self.listElements.set(list.id, new Tornado.ListElement(list));
		    });
		}
    },

	populateTaskElements: function(tasksData) {
		var self = this;

		if (tasksData !== undefined){
			tasksData.each(function(taskData) {
				var task = Tornado.tasks.get(taskData.Task.id);

				if (!task) {
					task = new Tornado.Task(taskData);
					Tornado.tasks.set(task.id, task);			
				}
			
				self.taskElements.set(task.id, new Tornado.TaskElement(task));
			});
		}
	},

	populateTagElements: function(tagsData) {
		var self = this;

		if (tagsData !== undefined){
			tagsData.each(function(tagData) {
				var tag = Tornado.tags.get(tagData.Tag.id);

				if (!tag) {
					tag = new Tornado.Tag(tagData);
					Tornado.tags.set(tag.id, tag);			
				}
			
				//self.tagElements.set(tag.id, new Tornado.TagElement(tag));
			});
		}
	},

	populateContextElements: function(contextsData) {
		var self = this;

		if (contextsData !== undefined){
			contextsData.each(function(contextData) {
				var context = Tornado.contexts.get(contextData.Context.id);

				if (!context) {
					context = new Tornado.Context(contextData);
					Tornado.contexts.set(context.id, context);			
				}
			
				//self.tagElements.set(tag.id, new Tornado.TagElement(tag));
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
			if (data){
				view.populate(data);
				view.display();
				view.container.fadeIn("slow");
				view.loaded = true;
			}
		});
	},

	// Abstract function 
	getAjaxUrl: function() {},

	itemChanged: function(item) {
		var foundItem = this.taskElements.get(item.id);
		if (foundItem) {
			this.updateItem(foundItem);
		} else {
			this.itemAdded(item);
		}
	},

	itemDeleted: function(item) {
		var foundItem = this.taskElements.get(item.id);

		if (foundItem){			
			foundItem.element.fadeOut("fast", function (){
				$(this).remove();
			});
			this.taskElements.unset(item.id);
		}
	},

	itemAdded: function(task) {
		if (this.includeItem(task)){
            var taskElement = new Tornado.TaskElement(task);
			this.taskElements.set(task.id, taskElement);
            this.addItem(taskElement);
		}
	},

	includeItem: function(item) { return true; },
	
	getModel: function() { return null; }
};
