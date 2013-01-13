Tornado.ContextsPanel = Class.create(Tornado.SinglePanel, {
	initialize: function($super, containerId){
		$super("contexts-panel", containerId);
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
