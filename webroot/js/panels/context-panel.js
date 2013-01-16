Tornado.ContextPanel = Class.create(Tornado.MixedPanel, {
    initialize: function($super, id, containerId){
	$super(id, containerId);
    },

    getAjaxUrl: function() {
	return "/tornado/contexts/view/" + this.id;
    },
    
    includeItem: function(item) {
	if (item instanceof Tornado.Task){
	    if (item.checked == "0" && item.hasContextId(this.id)){
		return true;
	    }
	} else if (item instanceof Tornado.List){
	    return item.contexts.get(this.id) !== undefined;
	}
	
	return false;
    },
    
    getTitle: function() {
	var context = this.model;
	return "@" + context.name;
    },
    
    getModel: function() {
	return Tornado.contexts.get(this.id);
    }
});
