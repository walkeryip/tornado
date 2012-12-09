Tornado.TaskElement = Class.create(Tornado.Element, {
	initialize: function($super, task){
		$super(task);
		
		this.hasTags = true;
		this.hasUsers = true;
		this.hasContexts = true;
		this.hasCheckbox = true;
		this.hasDescription = true;
		
		this.tags = task.tags;
		this.users = task.users;
		this.contexts = task.contexts;		
	},
	
	getBody: function() {
		return "<span>" + this.model.name + "</span>";
	},

	toggle: function() {
		var self = this;
		this.model.toggle(function (data){
			Tornado.viewManager.dataUpdated(data);
			//Tornado.viewManager.itemChanged(self.model);
		});
	},
	
	getInfoBoxContent: function() {
		return "<p>" + this.model.created + "</p>" +
				"<p>parent</p>";
	},
	
	deleteModel: function() {
		Tornado.tasks.unset(this.model.id);
	}
});
