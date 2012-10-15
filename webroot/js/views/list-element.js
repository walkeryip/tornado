Tornado.ListElement = Class.create(Tornado.Element, {
	initialize: function($super, list){
		$super(list);
	},
	
	getBody: function(){
		return "<a href=\"/tornado/task_lists/view/" + this.model.id + "\">" + this.model.name + "</a>"
	},
	
	getInfoBoxContent: function() {
		return "<p>" + this.model.created + "</p>" +
				"<p>parent</p>";
	},

	deleteModel: function() {
		Tornado.lists.unset(self.model.id);
	}
});
