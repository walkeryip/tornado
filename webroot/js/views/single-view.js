Tornado.SingleView = Class.create(Tornado.View, {
	initialize: function($super, id, containerId){
		$super(id, containerId);

        this.container.append("<ul class=\"items\"></ul>");
        this.itemsContainer = this.container.find(".items");
	},

	populate: function($super, data) {
		$super(data);

		//this.itemsContainer.find("li").tsort();
	},

    addItem: function(element) {
    	element.display(this.itemsContainer);
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
