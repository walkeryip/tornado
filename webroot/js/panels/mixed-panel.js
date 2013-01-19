Tornado.MixedPanel = Class.create(Tornado.Panel, {
    initialize: function($super, id, containerId){
	$super(id, containerId);

        this.container.append("<table class=\"table table-hover lists\"></table>");
        this.listsContainer = this.container.find("table.lists");
        this.container.append("<table class=\"table table-hover tasks\"></table>");
        this.tasksContainer = this.container.find("table.tasks");
    },

    populate: function($super, data) {
	$super(data);
    },

    getAjaxUrl: function() {
	return "/tornado/task_lists/view/" + this.id;
    },

    addItem: function(element) {
        if (element.model instanceof Tornado.Task){
            element.display(this.tasksContainer, this.loaded);
        } else if (element.model instanceof Tornado.List) {
	    // We don't want to list the current list again
	    if (element.model.id != this.id){
		element.display(this.listsContainer, this.loaded);
	    } else {
		this.container.prepend("<p>" + element.model.description + "</p>");
	    }
        }
    },

    updateItem: function(element) {
	if (element.model instanceof Tornado.Task){
	    this.updateModelItem(element, this.tasksContainer, this.taskElements); 
	} else if (element.model instanceof Tornado.List) {
	    if (this.id != element.model.id) {
		this.updateModelItem(element, this.listsContainer, this.listElements);
	    }
	}
    }
});
