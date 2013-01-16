Tornado.ContextsPanel = Class.create(Tornado.SinglePanel, {
    initialize: function($super, containerId){
	$super("contexts-panel", containerId);
    },
    
    getAjaxUrl: function() {
	return "/tornado/contexts/all";
    },
    
    includeItem: function(item) {
	return item instanceof Tornado.Context;
    },
    
    getTitle: function() {
	return "Contexts";
    }
});
