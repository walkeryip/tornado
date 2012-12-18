Tornado.ListsView = Class.create(Tornado.SingleView, {
    initialize: function($super, containerId, parameters){
	    $super("lists-view", containerId);		
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
				return true;
			}
		}
		
		return false;
	},
	
	getModelList: function() {
		return this.listElements;
	},

	getTitle: function() {
		return "Lists";
	}
});
