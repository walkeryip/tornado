Tornado.ListPanel = Class.create(Tornado.MixedPanel, {
    initialize: function($super, id, containerId){
        $super(id, containerId);
	this.breadcrumbs = new Tornado.Breadcrumbs(id, "#breadcrumbs");
    },

    getAjaxUrl: function() {
        return "/tornado/task_lists/view/" + this.id;
    },

	includeItem: function(item) {
		if (item instanceof Tornado.Task){
			return item.checked == "0" && item.parent && item.parent.id == this.id;
		} else if (item instanceof Tornado.List){
		    return item.parent_id == this.id; // || item.id == this.id;
		}

		return false;
	},

	getTitle: function() {
		var list = Tornado.lists.get(this.id);
		return "-" + list.name;
	}
});