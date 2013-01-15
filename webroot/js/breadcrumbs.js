Tornado.Breadcrumbs = Class.create();
Tornado.Breadcrumbs.prototype = {
    // Constructor
    initialize: function(listId, containerId) {
	var self = this;

	this.templates =  {
	    breadcrumbsContainer: "<ul></ul>",
	    link: "<li>{{#link}}<a href=\"/tornado/task_lists/{{#id}}view/{{id}}{{/id}}\">{{name}}</a><p>&gt;</p>{{/link}}{{#current}}{{name}}{{/current}}</li>"
	};
	
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
	    
	    result.push({name: item.name, id: item.id});
	    currentId = item.parent_id;
	    
	    if (counter >= this.maxDepth) {
		break;
	    } else {
		counter++;
	    }
	}

	// TODO: This is quite expensive, it could be avoided. The list is often very short, but still...
	return result.reverse();
    },
    
    // Add one breadcrumb link to container
    addBreadcrumbLink: function(container, item, last) {
	if (!last) {
	    var element;

	    if (item === null) {
		element = jq(Mustache.render(this.templates.link, {link: true, name: "Home"} ));
		element.attr("data-id", null);
	    } else {
		element = jq(Mustache.render(this.templates.link, {link: true, name: item.name, id: item.id}));
		element.attr("data-id", item.id);
	    }

	    element.droppable({
		activeClass: "ui-state-hover",
		hoverClass: "ui-state-active",
	    greedy: true,
		tolerance: 'pointer',
		drop: Tornado.listDropFunction
	    });

	    container.append(element);
	} else {
	    container.append(Mustache.render(this.templates.link, {link: false, name: item.name, current: true}));
	}
    },

    // Display the breadcrumbs
    populateBreadcrumbs: function(list) {
	var self = this;
	var div = jq(Mustache.render(this.templates.breadcrumbsContainer));
	var length = list.length;
	var index = 0;

	// Add default Home link
	self.addBreadcrumbLink(div, null, false);
	list.each(function(item) {
	    var last = !(index++ < length - 1);
	    self.addBreadcrumbLink(div, item, last);
	});
	this.container.append(div);
    }
};
