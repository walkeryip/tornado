Tornado.Breadcrumbs = Class.create();
Tornado.Breadcrumbs.prototype = {
    // Constructor
    initialize: function(listId, containerId) {
	var self = this;

	// Max depth to avoid an infinite loop
	this.maxDepth = 20;
	this.container = jq(containerId);

	// Create the bread crumbs list
	Tornado.navigationTree.getNavigationTree(function(data){
	    var list = self.getBreadcrumbsList(data, listId);
	    self.populateBreadcrumbs(list);
	});
    },

    // Get a breadcrumbs list from the root to current node, for example "Home > list1 > list1.1 > list1.1.1"
    getBreadcrumbsList: function(data, listId) {
	var result = new Array();
	var currentId = listId;
	var counter = 0;

	while (currentId !== null && currentId && currentId !== "root") {
	    var item = data[currentId];
	    if (!item) {
		break;
	    }
	    var node = {name: item.name, id: item.id};
	    
	    if (currentId === listId) {
		node.link = false;
		node.current = true;
	    } else {
		node.link = true;
	    }

	    result.push(node);
	    currentId = item.parent_id;
	    
	    if (counter >= this.maxDepth) {
		break;
	    } else {
		counter++;
	    }
	}

	result.push({id: null, name: "Home", link: true});

	// TODO: This is quite expensive, it could be avoided. The list is often very short, but still...
	return result.reverse();
    },

    // Display the breadcrumbs
    populateBreadcrumbs: function(list) {
	var self = this;
	var breadcrumbs = jq(Tornado.tpl.breadcrumbs({links: list}));

	breadcrumbs.find("li").not(".active").droppable({
	    activeClass: "ui-state-hover",
	    hoverClass: "ui-state-active",
	    greedy: true,
	    tolerance: 'pointer',
	    drop: Tornado.listDropFunction
	});

	this.container.append(breadcrumbs);
    }
};
