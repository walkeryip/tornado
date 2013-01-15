Tornado.NavigationTree = Class.create();
Tornado.NavigationTree.prototype = {
    // Constructor
    initialize: function() {
	this.loaded = false;
	this.error = false;
	this.tree = new Hash();
	this.parents = new Hash();

	this.templates = {
	    listItem: "<li><a href=\"/tornado/task_lists/view/{{id}}\">{{name}}</a></li>",
	    navigationContainer: "<div id=\"tree-view\" class=\"panel\"></div>"
	};
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
		result = jq("<li><ul></ul></li>");
		container = result.find("ul");
	    } else {
		result = jq("<ul></ul>");
		container = result;
	    }
	    
	    children.each(function(item) {
		var listItem = jq(Mustache.render(self.templates.listItem, {id:item.id, name:item.name}));
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
	container.append(jq(this.templates.navigationContainer).append(result));
    }
};
