Tornado.SinglePanel = Class.create(Tornado.Panel, {
    initialize: function($super, id, containerId, parameters){
	$super(id, containerId, parameters);

        this.container.append("<ul class=\"items\"></ul>");
        this.itemsContainer = this.container.find(".items");
	},

	populate: function($super, data) {
		$super(data);

		//this.itemsContainer.find("li").tsort();
	},

    addItem: function(element) {
    	element.display(this.itemsContainer, this.loaded);
    },
    
    updateItem: function(item) {
		if (this.includeItem(item.model)){
			item.display(this.itemsContainer);
		} else {
			item.element.fadeOut("fast", function (){
				$(this).remove();
			});
			this.getModelList().unset(item.id);;
		}
	}
});
