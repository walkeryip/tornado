Tornado.TagPanel = Class.create(Tornado.MixedPanel, {
    initialize: function($super, id, containerId){
        $super(id, containerId);
    },
    
    getAjaxUrl: function() {
        return "/tornado/tags/view/" + this.id;
    },
    
    includeItem: function(item) {
	if (item instanceof Tornado.Task){
	    if (item.checked == "0" && item.hasTagId(this.id)){
		return true;
	    }
	} else if (item instanceof Tornado.List){
	    return item.tags.get(this.id);
	}
	
	return false;
    },
    
    getTitle: function() {
	var tag = this.model;
	return "#" + tag.name;
    },
    
    getModel: function() {
	return Tornado.tags.get(this.id);
    }
});
