Tornado.SinglePanel = Class.create(Tornado.Panel, {
    initialize: function($super, id, containerId, parameters){
	$super(id, containerId, parameters);
	
        this.container.append("<ul class=\"items\"></ul>");
        this.itemsContainer = this.container.find(".items");
    },
    
    populate: function($super, data) {
	$super(data);
    },
    
    addItem: function(element) {
    	element.display(this.itemsContainer, this.loaded);
    },
    
    updateItem: function(item) {
	this.updateModelItem(item, this.itemsContainer, this.getElementList(item.model.getModelName()));
    }
});
