Tornado.ContextView = Class.create(Tornado.MixedView, {
	initialize: function($super, id, containerId){
		$super(id, containerId);
	},

	getAjaxUrl: function() {
		return "/tornado/contexts/view/" + this.id;
	},

	includeItem: function(item) {
		if (item instanceof Tornado.Task){
			if (item.checked == "0" && item.hasContext(this.model.name)){
				return true;
			}
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
