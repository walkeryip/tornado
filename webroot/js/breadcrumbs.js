Tornado.Breadcrumbs = Class.create();
Tornado.Breadcrumbs.prototype = {
    // Constructor
    initialize: function(id, containerId, type) {
	var self = this;

	// Max depth to avoid an infinite loop
	this.maxDepth = 20;
	this.container = jq(containerId);

	// Create the bread crumbs list
	if (type === "list") {
	    if (id) {
	    Tornado.navigationTree.getNavigationTree(function(data){
		var list = self.getBreadcrumbsList(data, id);
		self.populateBreadcrumbs(list);
	    });
	    } else {
		var list = [{name: "Lists", current: true, link: false, id: null, model: "link"}];
		self.populateBreadcrumbs(list);
	    }
	} else if (type === "context") {
	    var context = Tornado.contexts.get(id);
	    var contextList = [{name: "Contexts", current: context === undefined, link: context !== undefined, id: null, model: "context"}];
	    
	    if (context) {
		contextList.push({name: context.name, link: false, current: true, id: context.id, model: "context"});
	    }

	    self.populateBreadcrumbs(contextList);
	} else if (type === "tag") {
	    var tag = Tornado.tags.get(id);
	    var tagList = [{name: "Tags", current: tag === undefined, link: tag !== undefined, id: null, model: "tag"}];
	    
	    if (tag) {
		tagList.push({name: tag.name, link: false, current: true, id: tag.id, model: "tag"});
	    }

	    self.populateBreadcrumbs(tagList);
	}
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
	    var node = {name: item.name, id: item.id, model: "list"};
	    
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

	result.push({id: null, name: "Lists", link: counter > 0, current: counter == 0, model: "list"});

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
