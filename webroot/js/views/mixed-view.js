Tornado.MixedView = Class.create(Tornado.View, {
	initialize: function($super, id, containerId){
		$super(id, containerId);

        this.container.append("<ul class=\"lists\"></ul>");
        this.listsContainer = this.container.find(".lists");
        this.container.append("<ul class=\"tasks\"></ul>");
        this.tasksContainer = this.container.find(".tasks");
	},

	getAjaxUrl: function() {
		return "/tornado/task_lists/view/" + this.id;
	},

    addItem: function(element) {
        if (element.task){
            if (element.task.checked === "1"){
                //element.display(this.tasksDoneContainer);
            } else {
                element.display(this.tasksContainer);
            }
        } else if (element.list) {
            element.display(this.listsContainer);
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
            self.listElements.each(function(data) {
                var listElement = data.value;
                self.addItem(listElement);
            });
		}
	},

	updateItem: function(item) {
		if (this.includeItem(item.task)){
			item.display(this.tasksContainer);
		} else {
			item.element.fadeOut("fast", function (){
				$(this).remove();
			});
			this.taskElements.unset(item.id);
		}
	}
});
