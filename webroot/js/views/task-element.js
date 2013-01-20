Tornado.TaskElement = Class.create(Tornado.Element, {
    initialize: function($super, task){
	$super(task);
	
	this.hasTags = true;
	this.hasUsers = true;
	this.hasContexts = true;
	this.hasCheckbox = true;
	this.hasDescription = true;
	this.hasUsers = true;
	this.hasEnergy = true;
	this.hasDeadline = true;
	this.hasTime = true;
	this.hasPriority = true;
	this.tags = task.tags;
	this.users = task.users;
	this.contexts = task.contexts;		
    },
    
    toggle: function() {
	var self = this;
	this.model.toggle(function (data){
	    Tornado.panelManager.dataUpdated(data);
	});
    }
});
