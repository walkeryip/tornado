Tornado.ListElement = Class.create(Tornado.Element, {
	initialize: function($super, list){
		$super(list);
		
		this.hasTags = true;
		this.hasContexts = true;
		
		this.tags = list.tags;
		this.contexts = list.contexts;	
	},

	display: function($super, container) {

		this.element.attr("data-id", this.model.id);
		this.element.droppable({
        	activeClass: "ui-state-hover",
        	hoverClass: "ui-state-active",
            greedy: true,
            drop: function(event, ui) {
				//event.revert = false;
				var item = ui.draggable[0].model;
				var destId = jq(this).attr("data-id");
				item.move(destId, 
					function (data) {
						Tornado.viewManager.dataUpdated(data);
					},
					function () {
						ui.draggable.revert();
					});    		
            }
        });

		$super(container);
	},
	
	getBody: function(){
		return "<a href=\"/tornado/task_lists/view/" + this.model.id + "\">" + this.model.name + "</a>"
	},
	
	getInfoBoxContent: function() {
		return "<p>" + this.model.created + "</p>" +
				"<p>parent</p>";
	},

	deleteModel: function() {
		Tornado.lists.unset(this.model.id);
	}
});
