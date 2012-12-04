Tornado.Breadcrumbs = Class.create();
Tornado.Breadcrumbs.prototype = {
	initialize: function(listId) {
		this.maxDepth = 20;
		var self = this;

		Tornado.navigationTree.getNavigationTree(function(data){
			var list = self.getBreadcrumbsList(data, listId);
			self.populateBreadcrumbs(list);
		});
	},

	getBreadcrumbsList: function(data, listId) {
		var result = new Array();

		var currentId = listId;
		var counter = 0;
		while (currentId !== null && currentId !== undefined && currentId !== "root") {
			var item = data[currentId];

			if (item === undefined) {
				break;
			}

			result.push({id: item.id, name: item.name});
			currentId = item.parent_id;

			if (counter >= this.maxDepth) {
				break;
			} else {
				counter++;
			}
		}

		return result.reverse();
	},

	populateBreadcrumbs: function(list) {
		var div = jq("<ul class=\"breadcrumbs\"></ul>");
		list.each(function(item) {
			div.append("<li><a href=\"/tornado/task_list/" + item.id + "\">" + item.name + "</a></li>");
		});
		jq("body").append(div);
	}
};
