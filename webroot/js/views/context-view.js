Tornado.ContextView = Class.create(Tornado.MixedView, {
	initialize: function($super, id, name, containerId){
		$super(id, name, containerId);
	},

	getAjaxUrl: function() {
		return "/tornado/contexts/view/" + this.id;
	}
});
