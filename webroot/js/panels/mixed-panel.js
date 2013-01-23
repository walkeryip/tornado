Tornado.MixedPanel = Class.create(Tornado.Panel, {
    initialize: function($super, id, containerId){
	$super(id, containerId);
	var self = this;
	
	var listTable = jq(Tornado.tpl.panelContainer({model: "list"}));
	var listSorter = jq(Tornado.tpl.tableSorter());
	this.container.append(listTable);
        listTable.prepend(listSorter);
        this.listsContainer = listTable.find("table.lists");

	var taskTable = jq(Tornado.tpl.panelContainer({model: "task"}));
	var taskSorter = jq(Tornado.tpl.tableSorter());
	this.container.append(taskTable);
        taskTable.prepend(taskSorter);
        this.tasksContainer = taskTable.find("table.tasks");

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
		this.container.find(".description").text(element.model.description);	
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
