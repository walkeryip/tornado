Tornado.TagsView = Class.create(Tornado.SingleView, {
	initialize: function($super, containerId){
		$super("tags-view", containerId);
	},

	getAjaxUrl: function() {
		return "/tornado/tags/all";
	},
	
	includeItem: function(item) {
		if (item instanceof Tornado.Tag){
			return true;
		}
		
		return false;
	},
	
	getModelList: function() {
		return this.tagElements;
	},

	getTitle: function() {
		return "Tags";
	}
});
