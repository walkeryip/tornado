Tornado.TaskView = Class.create(Tornado.View, {
	initialize: function($super, containerId){
		$super("done-tasks", containerId);

        this.container.append("<ul class=\"tasks\"></ul>");
        this.tasksContainer = this.container.find(".tasks");
	},

	getAjaxUrl: function() {
		return "/tornado/tasks/all/true";
	},

    addItem: function(element) {
        if (element.task && this.includeItem){
            element.display(this.tasksContainer);
        }
    },   

	display: function(item) {
		var self = this;

		if (item){
			self.displayElement(item);
		} else {
            self.taskElements.each(function(data) {
                var taskElement = data.value;
                self.addItem(taskElement);
            });
		}
	},

	includeItem: function(item) {
		if (item instanceof Tornado.Task){
			if (item.checked == "1"){
				return true;
			}
		}

		return false;
	},

	getTitle: function() {
		var tag = this.model;
		return "Done tasks";
	},

	updateItem: function(item) {
		if (this.includeItem(item.task)){
			item.display(this.container);
		} else {
			item.element.fadeOut("fast", function (){
				$(this).remove();
			});
			this.taskElements.unset(item.id);
		}
	}
});