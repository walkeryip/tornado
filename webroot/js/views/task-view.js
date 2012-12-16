Tornado.TaskView = Class.create(Tornado.View, {
	initialize: function($super, containerId, parameters){
		$super(containerId, containerId, parameters);
		this.defaultParameters(this.parameters);
        this.container.append("<ul class=\"tasks\"></ul>");
        this.tasksContainer = this.container.find(".tasks");
	},

	defaultParameters: function(parameters) {
		parameters.checked = parameters.checked || false; 
		parameters.shared = parameters.shared || false; 
		parameters.title = parameters.title || "Tasks";
	},

	populate: function($super, data) {
		$super(data);
	},

	getAjaxUrl: function() {
		var mode = this.parameters.shared ? "shared" : "all";
		if (this.parameters.checked === false) {
			return "/tornado/tasks/" + mode + "/false";
		} else {
			return "/tornado/tasks/" + mode + "/true";
		}
	},

    addItem: function(element) {
        if (element.model && this.includeItem){
            element.display(this.tasksContainer, this.loaded);
        }
    },

	includeItem: function(item) {
		if (item instanceof Tornado.Task){
			if (item.checked == this.parameters.checked){
				return true;
			}
		}

		return false;
	},

	getTitle: function() {
		return this.parameters.title;
	},

	updateItem: function(item) {
		if (this.includeItem(item.model)){
			item.display(this.tasksContainer);
		} else {
			item.element.fadeOut("fast", function (){
				$(this).remove();
			});
			this.taskElements.unset(item.id);
		}
	}
});
