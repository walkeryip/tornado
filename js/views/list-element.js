Tornado.ListElement = Class.create(Tornado.Element, {
    initialize: function($super, list, panel){
	$super(list, panel);
	
	this.hasTags = true;
	this.hasContexts = true;
	this.hasUsers = true;
	this.hasDescription = true;
	this.hasUsers = true;
	this.hasActive = true;
	
	this.tags = list.tags;
	this.contexts = list.contexts;	
	this.users = list.users;	
    },

    display: function($super, container, loaded) {	
	$super(container, loaded);

	this.element.attr("data-id", this.model.id);
	this.element.droppable({
            activeClass: "ui-state-hover",
            hoverClass: "ui-state-active",
            greedy: true,
	    tolerance: 'pointer',
            drop: Tornado.listDropFunction
        });
	
    },
    
    activate: function() {
	var self = this;
	this.model.setActive(true, function (data){
	    Tornado.panelManager.dataUpdated(data);
	});
    },

    deactivate: function() {
	var self = this;
	this.model.setActive(false, function (data){
	    Tornado.panelManager.dataUpdated(data);
	});
    }
});
