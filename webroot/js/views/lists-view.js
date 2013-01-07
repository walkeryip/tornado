Tornado.ListsView = Class.create(Tornado.SingleView, {
    initialize: function($super, containerId, parameters){
	$super("lists-view", containerId, parameters);		
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
	
	getModelList: function() {
		return this.listElements;
	},

	getTitle: function() {
		return this.parameters.title;
	}
});
