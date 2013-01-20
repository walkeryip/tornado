Tornado.TaskPanel = Class.create(Tornado.Panel, {
    initialize: function($super, containerId, parameters){
	$super(containerId, containerId, parameters);
	
	this.defaultParameters(this.parameters);
        this.container.append(Tornado.tpl.panelContainer({model: "task"}));
        this.tasksContainer = this.container.find("table.tasks");
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
		if (this.parameters.shared) {
		    // items.users.size() == 1 if the user is the only one with access to that item
		    return item.users.size() > 1;
		} else {
		    return true;
		}
	    }
	}
	
	return false;
    },

    getTitle: function() {
	return this.parameters.title;
    },
    
    updateItem: function(item) {
	this.updateModelItem(item, this.tasksContainer, this.taskElements);
    }
});
