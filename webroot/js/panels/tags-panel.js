Tornado.TagsPanel = Class.create(Tornado.SinglePanel, {
    initialize: function($super, containerId){
	$super("tags-panel", containerId);
    },
    
    getAjaxUrl: function() {
	return "/tornado/tags/all";
    },
    
    includeItem: function(item) {
	return item instanceof Tornado.Tag;
    },
   
    getTitle: function() {
	return "Tags";
    }
});
