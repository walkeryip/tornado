Tornado.NavigationTree = Class.create();
Tornado.NavigationTree.prototype = {
	initialize: function() {
	    this.loaded = false;
	    this.error = false;
	    this.tree = new Hash();
	    this.parents = new Hash();
	},

	populate: function (callback) {
		var self = this;
		this.loading = true;

		jq.ajax({			
		    type: "get",
		  	cache: false,
			dataType: "json",
			error: function(data){
				Tornado.error(data);
				self.error = true;
			}, 
		  	url: "/tornado/task_lists/tree"
		}).done(function (data) {
			if (data){	
				self.loaded = true;
				self.parseTreeData(data);

				if (callback !== undefined) {
					callback(self.tree);
				}

			    self.display(jq("body"));
			} 
		});
	},

    getListTree: function(id) {
	var self = this;
	var result;
	var children = this.parents.get(id);

	if (id && children && children.length > 0) {

	    var container;
	    if (id !== "root") {
		result = jq("<li><ul></ul></li>");
		container = result.find("ul");
	    } else {
		result = jq("<ul></ul>");
		container = result;
	    }
	    
	    children.each(function(item) {
		var listItem = jq("<li><a href=\"/tornado/task_lists/view/" + item.id + "\">" + item.name + "</a></li>");
		listItem.attr("data-id", item.id);
		listItem.droppable({
		    activeClass: "ui-state-hover",
		    hoverClass: "ui-state-active",
		    greedy: true,
		    tolerance: 'pointer',
		    drop: Tornado.listDropFunction
		});

		container.append(listItem);
		container.append(self.getListTree(item.id));
	    });
	}

	return result;
    },

	parseTreeData: function(data) {
	    var self = this;
	    data.each(function(obj) {
		var item = obj["TaskList"];
		var parent = item.parent_id || "root";
		var parentList = self.parents.get(parent);
		self.tree[item.id] = item;
		if (!parentList) {
		    parentList = new Array();
		    self.parents.set(parent, parentList);
		}

		parentList.push(item);
	    });

	    var result = this.getListTree("root");
	    jq("body").append(jq("<div id=\"tree-view\" class=\"view\"></div>").append(result));
	},

	getNavigationTree: function(callback) {
		if (this.error) {
			callback(null);
		} else if (this.loaded) {
			callback(this.tree);
		} else {
			this.populate(callback);
		}
	},

    display: function(container) {
	var list = jq("<ul></ul>");
	this.tree.each(function(item){
	    list.append("<li>" + item.value.name + "</li>");
	});
	container.append(list);
    }

/*var printTree = function(trees, treeChildren, node, object) {
	var list = jq("<ul></ul>");
	for (i in node) {
		var listItem = jq("<li><span>" + node[i].name + "</span></li>");
		listItem.attr("data-id",node[i].id);

		var children = treeChildren[node[i].id];
		if (children !== undefined) {
			listItem.append(printTree(trees, treeChildren, children));
		}

		list.append(listItem);
	}
	return list;
}*/
};
