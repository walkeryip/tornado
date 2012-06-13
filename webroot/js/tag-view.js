Tornado.TagView = Class.create(Tornado.View, {	
	initialize: function($super, id, name, containerId){
		$super(id, name, containerId);

		this.container.append("<ul class=\"tasks\"></ul>");
		this.tasksContainer = this.container.find("ul.tasks");
		this.tasksContainer.id = containerId;
	},

	getAjaxUrl: function() {
		return "/tornado/tags/view/" + this.id;
	},

	display: function () {
		var self = this;

		self.taskElements.each(function(data) {
			var taskElement = data.value;
			if (taskElement.task.checked === "0"){
				taskElement.display(self.tasksContainer);
			} 
		});
	},

	includeItem: function(item) {
		return true;
	}	
});
