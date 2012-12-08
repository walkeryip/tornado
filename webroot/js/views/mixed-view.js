Tornado.MixedView = Class.create(Tornado.View, {
	initialize: function($super, id, containerId){
		$super(id, containerId);

        this.container.append("<ul class=\"lists\"></ul>");
        this.listsContainer = this.container.find(".lists");
        this.container.append("<ul class=\"tasks\"></ul>");
        this.tasksContainer = this.container.find(".tasks");
	},

	populate: function($super, data) {
		$super(data);

		//this.tasksContainer.find("li").tsort();
		//this.listsContainer.find("li").tsort();
	},

	getAjaxUrl: function() {
		return "/tornado/task_lists/view/" + this.id;
	},

    addItem: function(element) {
        if (element.model instanceof Tornado.Task){
            if (element.model.checked === "1"){
                //element.display(this.tasksDoneContainer);
            } else {
                element.display(this.tasksContainer, this.loaded);
            }
        } else if (element.model instanceof Tornado.List) {
			// We don't want to list the current list again
			if (element.model.id != this.id){
	            element.display(this.listsContainer, this.loaded);
			}
        }
    },

	updateItem: function(element) {
		if (element.model instanceof Tornado.Task){
			if (this.includeItem(element.model)){
				element.display(this.tasksContainer);
			} else {
				element.fadeOut("fast", function (){
					$(this).remove();
				});
				this.taskElements.unset(element.model.id);
			}
		} else if (element.model instanceof Tornado.List) {
			if (this.includeItem(element.model)){
				element.display(this.listsContainer);
			} else {
				element.fadeOut("fast", function (){
					$(this).remove();
				});
				this.listElements.unset(element.model.id);
			}
		}
	}
});
