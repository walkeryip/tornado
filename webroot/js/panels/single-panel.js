Tornado.SinglePanel = Class.create(Tornado.Panel, {
    initialize: function($super, id, containerId, parameters){
	$super(id, containerId, parameters);

	var table = jq(Tornado.tpl.panelContainer({model: "item"}));
	var sorter = jq(Tornado.tpl.tableSorter());
	this.container.append(table);
        table.prepend(sorter);
        this.itemsContainer = table.find("table.items");

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
