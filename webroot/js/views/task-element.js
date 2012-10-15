Tornado.TaskElement = Class.create(Tornado.Element, {
	initialize: function($super, task){
		$super(task);
		
		this.hasTags = true;
		this.hasContexts = true;
		this.hasCheckbox = true;
		
		this.tags = task.tags;
		this.contexts = task.contexts;		
	},
	
	getBody: function() {
		return "<span>" + this.model.name + "</span>";
	},

	toggle: function() {
		var self = this;
		this.model.toggle(function (){
			Tornado.viewManager.itemChanged(self.model);
		});
	},
	
	getInfoBoxContent: function() {
		return "<p>" + this.model.created + "</p>" +
				"<p>parent</p>";
	},
	
	deleteModel: function() {
		Tornado.tasks.unset(self.model.id);
	}
});
