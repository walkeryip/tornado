Tornado.TagsView = Class.create(Tornado.View, {
	initialize: function($super, containerId){
		$super("tags-view", containerId);

        this.container.append("<ul class=\"tasks\"></ul>");
        this.tagsContainer = this.container.find(".tasks");
	},

	getAjaxUrl: function() {
		return "/tornado/tags/all";
	},

    /*addItem: function(element) {
        if (element.tag){
 	       element.display(this.tasksContainer);
        }
    },*/

	display: function(item) {
		var self = this;
	
		this.tagElements.each(function(data) {
			var tagElement = data.value;
			tagElement.display(self.tagsContainer);
		});

	
		//if (item){
		//	self.displayElement(item);
		/*} else {
            self.taskElements.each(function(data) {
                var taskElement = data.value;
                self.addItem(taskElement);
            });
            self.listElements.each(function(data) {
                var listElement = data.value;
                self.addItem(listElement);
            });*/
		
	}/*,

	updateItem: function(item) {
		if (this.includeItem(item.tag)){
			item.display(this.tagsContainer);
		} else {
			item.element.fadeOut("fast", function (){
				$(this).remove();
			});
			this.tagsElements.unset(item.id);
		}
	}*/
});
