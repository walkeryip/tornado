Tornado.TagView = Class.create(Tornado.MixedView, {
    initialize: function($super, id, name, containerId){
        $super(id, name, containerId);
    },

    getAjaxUrl: function() {
        return "/tornado/tags/view/" + this.id;
    },

	includeItem: function(item) {
		if (item instanceof Tornado.Task){
			if (item.checked == "1"){
				return false;
			}
		}

		return true;
	}
});
