Tornado.TagView = Class.create(Tornado.MixedView, {
    initialize: function($super, id, containerId){
        $super(id, containerId);
    },

    getAjaxUrl: function() {
        return "/tornado/tags/view/" + this.id;
    },

	includeItem: function(item) {
		if (item instanceof Tornado.Task){
			if (item.checked == "0" && item.hasTag(this.model.name)){
				return true;
			}
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
