// Abstract class
Tornado.View = Class.create();
Tornado.View.prototype = {
	initialize: function (id, name, containerId) {
		this.id = id;
		this.name = name;

		this.taskElements = new Hash();
		this.labelElements = new Hash();
        this.contextElements = new Hash();
        this.listElements = new Hash();

		this.container = jq(containerId);
	},

	populate: function (data) {
        this.populateTaskElements(data.Tasks);
        this.populateListElements(data.TaskLists);
        //this.populateContextElements(data.Context);
        //this.populateTagElements(data.Tag);
    },

    populateListElements: function(listsData) {
        var self = this;

        listsData.each(function(listData) {
            var list = Tornado.lists.get(listData.TaskList.id);

            if (!list) {
                list = new Tornado.List(listData);
                Tornado.lists.set(list.id, list);
            }

            self.listElements.set(list.id, new Tornado.ListElement(list));
        });
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

	includeItem: function(item) { return true; }
};
