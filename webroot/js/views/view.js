// Abstract class
Tornado.View = Class.create();
Tornado.View.prototype = {
	initialize: function (id, name, containerId) {
		this.id = id;
		this.name = name;

		this.taskElements = new Hash();
		this.labelElements = new Hash();
		this.contextElements = new Hash();

		this.container = jq(containerId);
	},

	populate: function (data) {
		var contexts = data.Context;
		var tags = data.Tag;
		var parent = data.Parent;
		this.populateTaskElements(data.Task);
		
		var list = data.TaskList;
		this.created = data.created;
		this.description = data.description;
		this.id = data.id;
		this.name = data.name;
	},

	populateTaskElements: function(tasksData) {
		var self = this;

		tasksData.each(function(taskData) {
			var task = Tornado.tasks.get(taskData.Task.id);

			if (!task) {
				task = new Tornado.Task(taskData);
				Tornado.tasks.set(task.id, task);			
			}
			
			self.taskElements.set(task.id, new Tornado.TaskElement(task));
		});
	},

	// Abstract function
	display: function() {},

    // Abstract function
    addItem: function() {},

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
				view.loaded = true;
			}
		});
	},

	// Abstract function 
	getAjaxUrl: function() {},

	itemChanged: function(item) {
		if (this.includeItem(item)){
			this.display(foundItem);
		} else {
			var foundItem = this.taskElements.get(item.id);
			
			if (foundItem){
				foundItem.remove();
				this.taskElements.unset(item.id);
			}
		}
	},

	itemDeleted: function(item) {
		var foundItem = this.taskElements.get(item.id);

		if (foundItem){
			foundItem.remove();
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

	includeItem: function(item) {
		return true;
	}
};
