// Abstract class
Tornado.Panel = Class.create();
Tornado.Panel.prototype = {
    initialize: function (id, containerId, parameters) {
	this.id = id;
	
	this.parameters = parameters;
	if (!this.parameters) {
	    this.parameters = {};
	}

	var defaultParams = {
	    breadcrumbs: false,

	    showTasks: false,
	    showLists: false,
	    showContexts: false,
	    showTags: false,
	    showUsers: false,
	    showDecription: true,
	    showTitle: true,
	    
	    showInlineContexts: true,
	    showInlineTags: true,
	    showInlineUsers: true
	};
	
	this.parameters = jq.extend({}, defaultParams, parameters);

	this.taskElements = new Hash();
	this.tagElements = new Hash();
        this.contextElements = new Hash();
        this.listElements = new Hash();
        this.userElements = new Hash();
	
	this.breadcrumbs = null;
	this.loaded = false;
	
	this.container = jq(containerId);
	//this.container.hide();
	this.container.addClass("panel");
    },
    

    populate: function (data) {
	var self = this;

	if (this.parameters.breadcrumbs && !(this.breadcrumbs && this.breadcrumbs.loaded)) {
	    this.breadcrumbs = new Tornado.Breadcrumbs(this.parameters.breadcrumbs.id, "#breadcrumbs", this.parameters.breadcrumbs.type);
	    this.breadcrumbs.loaded = true;
	}

        this.populateItemElements(data.contexts.sort(Tornado.compareItem));
        this.populateItemElements(data.tags.sort(Tornado.compareItem));
        this.populateItemElements(data.tasks.sort(Tornado.compareItem));
        this.populateItemElements(data.lists.sort(Tornado.compareItem));
        this.populateItemElements(data.users.sort(Tornado.compareItem));

	this.container.find(".panel-table").each(function (index, value) {
	    var sorter = jq(this).find(".sorter");
	    var table = jq(this).find("table");
	    sorter.find(".sortByName").click(function(e){return self.tableSort(table, this, ".item")});
	    sorter.find(".sortByDeadline").click(function(e){return self.tableSort(table, this, ".deadline")});
	    sorter.find(".sortByPriority").click(function(e){return self.tableSort(table, this, ".priority")});
	    sorter.find(".sortByEnergy").click(function(e){return self.tableSort(table, this, ".energy")});
	    sorter.find(".sortByTime").click(function(e){return self.tableSort(table, this, ".time")});
	    sorter.find(".sortByCreated").click(function(e){return self.tableSort(table, this, ".created")});
	});

    },

    populateItemElement: function(item, itemElements) {
	if (this.includeItem(item)){
	    if (!itemElements.get(item.id)){
		this.itemAdded(item);
	    } else {
		this.itemChanged(item);
	    }
	} else {
	    if (itemElements.get(item.id)){
		this.itemDeleted(item);
	    }
	}
    },

    populateItemElements: function(items) {
	var self = this;
	
	if (items && items.length > 0){
	    var itemElements = this.getElementList(items[0].getModelName());
	    
	    items.each(function(item) {
		self.populateItemElement(item, itemElements);
	    });
	}
    },

    dataUpdated: function (data) {
	var self = this;
	var emptyPanel = false;
	if (this.taskElements.isEmpty() && this.tagElements.isEmpty() && this.contextElements.isEmpty() && this.listElements.isEmpty()){
	    emptyPanel = true;
	}
	
        this.populate(data);
	
	if (!this.loaded) {
	    
	    this.model = this.getModel();
	    var title = this.model ? this.model.name : this.getTitle();
	    var description = this.model ? this.model.description : "";
	    this.container.prepend(Tornado.tpl.panelHeader({title: title, description: description, showDescription: self.parameters.showDescription, showTitle: self.parameters.showTitle}));
	    this.container.find("tr").tsort({sortFunction: Tornado.tableSortFunction});
	    this.container.fadeIn("slow");

	    this.loaded = true;
	} else {
	    this.taskElements.each(function(taskElement) {
		if (!self.includeItem(taskElement.value.model)) {
		    self.itemDeleted(taskElement.value.model);
		}			
	    });
	}
    },

    tableSort: function(table, element, column) {
	if(jq(element).hasClass("desc")) {
	    options = {};
	}
	
	var options = {order: jq(element).hasClass("desc") ? "asc" : "desc", sortFunction: function(a,b) {
	    return Tornado.tableSortFunction(a,b,options); 
	}};
	
	table.find("tr").tsort(column, options); 
	jq(element).toggleClass("desc"); 
	return false; 
    },

    itemChanged: function(item) {
	var foundItem = this.getElement(item.getModelName(), item.id);
	
	if (foundItem) {
	    this.updateItem(foundItem);
	} else {
	    this.itemAdded(item);
	}
    },
    
    itemDeleted: function(item) {
	this.container.find("tr[data-model-type=" + item.getModelName() + "][data-model-id=" + item.id + "]").fadeOut("fast", function() {
	    $(this).remove();
	});
	this.unsetElement(item.getModelName(), item.id);
    },
    
    itemAdded: function(item) {
	this.addItem(this.newItemElement(item));
    },
    
    newItemElement: function(item) {
	var elementClass = this.getElementClass(item.getModelName());
	var element = new elementClass(item, this);
	this.setElement(item.getModelName(), item.id, element);
	
	return element;
    },

    updateModelItem: function (element, container, map) {
	if (this.includeItem(element.model)){
	    element.display(container);
	} else {
	    element.remove();
	    map.unset(element.model.id);
	}
    },
    
    setElement: function(modelName, id, value) {
	this[modelName + "Elements"].set(id, value);
    },
    
    unsetElement: function(modelName, id) {
	this[modelName + "Elements"].unset(id);
    },
    
    getElement: function(modelName, id) {
	return this[modelName + "Elements"].get(id);
    },
    
    getElementList: function(modelName) {
	return this[modelName + "Elements"];
    },
    
    getElementClass: function(modelName) {
	return Tornado[modelName.charAt(0).toUpperCase() + modelName.slice(1) + "Element"];
    },
    
    // Overridable function
    getTitle: function() { return "unknown"; },
    includeItem: function(item) { return true; },
    getModel: function() { return null; },

    // Abstract functions
    addItem: function() { throw new Error("Abstract function not implemented."); },
    updateItem: function() { throw new Error("Abstract function not implemented."); },
    getAjaxUrl: function() { throw new Error("Abstract function not implemented."); },
    getAjaxUrlArgs: function() { throw new Error("Abstract function not implemented."); }
};
