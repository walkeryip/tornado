Tornado.ContextView = Class.create(Tornado.View, {	
	initialize: function($super, id, name, containerId){
		$super(id, name, containerId);

		this.container.append("<ul class=\"tasks\"></ul>");
		this.tasksContainer = this.container.find("ul.tasks");
		this.tasksContainer.id = containerId;
	},

	getAjaxUrl: function() {
		return "/tornado/contexts/view/" + this.id;
	},

    addItem: function(taskElement) {
        if (taskElement.task.checked === "0"){
            taskElement.display(this.tasksContainer);
        }
    },

	display: function () {
		var self = this;

		self.taskElements.each(function(data) {
			var taskElement = data.value;
            self.addItem(taskElement);
		});
	},

	includeItem: function(item) {
		return true;
	}	
});
