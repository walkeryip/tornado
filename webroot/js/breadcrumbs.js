Tornado.Breadcrumbs = Class.create();
Tornado.Breadcrumbs.prototype = {
	initialize: function(listId, containerId) {
		this.maxDepth = 20;
		this.container = jq(containerId);
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
		var div = jq("<ul></ul>");
		var length = list.length;
		var index = 0;
		
		div.append("<li><a href=\"/tornado/task_lists/\">Home</a><p>&gt;</p></li>");
		list.each(function(item) {
			if (index++ < length - 1) {
				var element = jq("<li><a href=\"/tornado/task_lists/view/" + item.id + "\">" + item.name + "</a><p>&gt;</p></li>");
				element.attr("data-id", item.id);
				element.droppable({
					activeClass: "ui-state-hover",
					hoverClass: "ui-state-active",
					greedy: true,
					tolerance: 'pointer',
					drop: Tornado.listDropFunction
				});
				div.append(element);
			} else {
				div.append("<li>" + item.name + "</li>");
			}
		});
		this.container.append(div);
	}
};
