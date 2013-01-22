/*
 TODO: replace html in this file with a template
*/

Tornado.NavigationTree = Class.create();
Tornado.NavigationTree.prototype = {
    initialize: function() {
	this.loaded = false;
	this.error = false;
	this.tree = new Hash();
	this.parents = new Hash();
    },

    // Get the navigation tree data
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
		
		if (callback) {
		    callback(self.tree);
		}
		
		self.display(jq("body"));
	    } 
	});
    },

    // Get a tree from id to all its children
    getListTree: function(id) {
	var self = this;
	var result;
	var children = this.parents.get(id);

	if (id && children && children.length > 0) {

	    var container;
	    if (id !== "root") {
		result = jq('<ul class="dropdown-menu"></ul>');
		container = result; //result.find("ul");
	    } else {
		result = jq('<ul id="tree-view" class="dropdown-menu" role="menu"></ul>');
		container = result;
	    }
	    
	    children.each(function(item) {
		var listItem = jq(Tornado.tpl.navigationTreeItem({id:item.id, name:item.name}));
		listItem.attr("data-id", item.id);
		listItem.droppable({
		    activeClass: "ui-state-hover",
		    hoverClass: "ui-state-active",
		    greedy: true,
		    tolerance: 'pointer',
		    drop: Tornado.listDropFunction
		});
		var tree = self.getListTree(item.id);
		
		if (tree) {
		    listItem.addClass("dropdown-submenu");
		}

		container.append(listItem.append(tree));
		//container.append();
	    });
	}

	return result;
    },

    // Parse the retrieved data
    parseTreeData: function(data) {
	var self = this;
	data.each(function(obj) {
	    var item = obj["List"];
	    var parent = item.parent_id || "root";
	    var parentList = self.parents.get(parent);
	    self.tree[item.id] = item;
	    if (!parentList) {
		parentList = new Array();
		self.parents.set(parent, parentList);
	    }
	    
	    parentList.push(item);
	});
    },
    
    // Get and or load the data
    getNavigationTree: function(callback) {
	if (this.error) {
	    callback(null);
	} else if (this.loaded) {
	    callback(this.tree);
	} else {
	    this.populate(callback);
	}
    },
    
    // Display the tree
    display: function(container) {
	var result = this.getListTree("root");
	container.append(result);
    }
};
