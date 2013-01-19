Tornado.ListElement = Class.create(Tornado.Element, {
    initialize: function($super, list){
	$super(list);
	
	this.hasTags = true;
	this.hasContexts = true;
	this.hasUsers = true;
	this.hasDescription = true;
	this.hasUsers = true;
	
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
	
    getBody: function(){
	var name = this.model.name.slice(0, 1).toUpperCase() + this.model.name.slice(1);
	return "<a class=\"item list\" href=\"/tornado/task_lists/view/" + this.model.id + "\">" + name + "</a>";
    },
    
    getInfoBoxContent: function() {
	return "<p>" + this.model.created + "</p>" + "<p>parent</p>";
    }
});
