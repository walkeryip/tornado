Tornado.ContextElement = Class.create(Tornado.Element, {
	initialize: function($super, context){		
		$super(context);		
	},
	
	getBody: function() {
		return "<a href=\"/tornado/contexts/view/" + this.model.id + "\">" + this.model.name + "</span>";
	},
	
	deleteModel: function() {
		Tornado.contexts.unset(this.model.id);
	},
	
	getInfoBoxContent: function() {
		return "<p>" + this.model.created + "</p>";
	}

	
});
