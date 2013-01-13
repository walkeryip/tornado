Tornado.TaskElement = Class.create(Tornado.Element, {
	initialize: function($super, task){
		$super(task);
		
		this.hasTags = true;
		this.hasUsers = true;
		this.hasContexts = true;
		this.hasCheckbox = true;
		this.hasDescription = true;
		this.hasUsers = true;
		
		this.tags = task.tags;
		this.users = task.users;
		this.contexts = task.contexts;		
	},
	
	getBody: function() {
	    var name = this.model.name.slice(0, 1).toUpperCase() + this.model.name.slice(1);
	    return "<span class=\"item task\">" + name + "</span>";
	},

	toggle: function() {
		var self = this;
		this.model.toggle(function (data){
			Tornado.panelManager.dataUpdated(data);
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
