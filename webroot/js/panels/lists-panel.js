Tornado.ListsPanel = Class.create(Tornado.SinglePanel, {
    initialize: function($super, containerId, parameters){
	$super("lists-panel", containerId, parameters);		
	this.defaultParameters(this.parameters);	
    },
    
    defaultParameters: function(parameters) {
	parameters.shared = parameters.shared || false; 
	parameters.title = parameters.title || "Lists";
    },

    getAjaxUrl: function() {
	var mode = this.parameters.shared ? "shared" : "all";
	return "/tornado/task_lists/" + mode;
    },
    
    includeItem: function(item) {
	if (item instanceof Tornado.List){
	    if (item.parent_id == null) {
		if (this.parameters.shared) {
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
    }
});
