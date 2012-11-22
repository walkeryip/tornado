Tornado.ContextsView = Class.create(Tornado.SingleView, {
	initialize: function($super, containerId){
		$super("contexts-view", containerId);
	},

	getAjaxUrl: function() {
		return "/tornado/contexts/all";
	},
	
	includeItem: function(item) {
		if (item instanceof Tornado.Context){
			return true;
		}
		
		return false;
	},
	
	getModelList: function() {
		return this.contextElements;
	},

	getTitle: function() {
		return "Contexts";
	}
});
