Tornado.ListsView = Class.create(Tornado.SingleView, {
	initialize: function($super, containerId){
		$super("lists-view", containerId);
	},

	getAjaxUrl: function() {
		return "/tornado/task_lists/all";
	},
	
	includeItem: function(item) {
		if (item instanceof Tornado.List){
			return true;
		}
		
		return false;
	},
	
	getModelList: function() {
		return this.listElements;
	}
});
