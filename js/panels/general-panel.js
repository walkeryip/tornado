Tornado.GeneralPanel = Class.create(Tornado.Panel, {
    initialize: function($super, id, containerId, parameters){
	$super(id, containerId, parameters);

	var self = this;

	this.id = parameters.list_id || parameters.context_id || parameters.tag_id;

	this.selectedElements = {};
	this.currentElement = null;

	this.container.append(
	    jq(['<div id="context-menu">',
		'<ul class="dropdown-menu" role="menu">',
		'<li><a class="delete" tabindex="-1" href="#">Delete</a></li>',
		'<li><a tabindex="-1" href="#">Move</a></li>',
		'<li><a tabindex="-1" href="#">Edit</a></li>',
		'<li class="divider"></li>',
		'<li><a tabindex="-1" href="#">Separated link</a></li>',
		'</ul>',
		'</div>'].join('')));
	
	this.container.find("#context-menu .delete").click(function(e){
	    for (key in self.selectedElements) {
		var element = self.selectedElements[key];
		var modelType = element.attr("data-model-type");
		var modelId = element.attr("data-model-id");
		var item = Tornado.getItem(modelType, modelId);
		if (item) { item.remove(); }
	    }
	    jq("#context-menu").removeClass("open");
	    return false;
	});


	this.container = jq("<div></div>");
	jq("#content").append(this.container);
	this.modelString = parameters.type;

	var table = jq(Tornado.tpl.panelContainer({model: "item"}));
	var sorter = jq(Tornado.tpl.tableSorter());
	this.container.append(table);
        table.prepend(sorter);
        this.itemsContainer = table.find("table.items");

	jq(document).click(function(e) {
	    var container = jq(e.target).parents("table");

	    if (container.length == 0) {
		self.unselect();
	    }
	});

	this.container.on("mousedown", "tr", function (e) {
	    var element = jq(this);
	    var uniqueId = element.attr("data-model-type") + element.attr("data-model-id");
	    var selected = element.hasClass("selected");
	    var rightClickOnSelected = e.which === 3 && self.selectedElements[uniqueId] !== undefined;

	    if (!e.ctrlKey && !e.shiftKey && !rightClickOnSelected) {
		self.unselect();
	    }

	    if (e.shiftKey) {
		var shiftFunction = function (item) {
		    var element = jq(this);
		    var uniqueId = element.attr("data-model-type") + element.attr("data-model-id");
		    
		    if (self.selectedElements[uniqueId]) {
			delete self.selectedElements[uniqueId];
		    } else {		
			self.selectedElements[uniqueId] = element;
		    }
		    
		    element.toggleClass("selected");
		};

		if (!element.hasClass("current")) {
		    if (element.prevAll(".current").length === 1) {
			element.prevUntil(".current").each(shiftFunction);
		    } else  {
			element.nextUntil(".current").each(shiftFunction);
		    }
		}
	    }
	    
	    if (!rightClickOnSelected) {
		self.container.find("tr").removeClass("current");
		
		if (selected || self.selectedElements[uniqueId]) {
		    delete self.selectedElements[uniqueId];
		    element.removeClass("selected");
		    
		} else {		
		    self.selectedElements[uniqueId] = element;
		    element.addClass("selected");
		    self.currentElement = element;
		    self.currentElement.addClass("current");

		}
			
	    } else if (!self.selectedElements[uniqueId]) {
		self.selectedElements[uniqueId] = element;
		self.currentElement = element;
		self.currentElement.addClass("current");
		element.addClass("selected");
	    }
/*
	    e.stopPropagation();
   	    e.stopImmediatePropagation();
	    e.preventDefault();
	  
	    return false;*/
	});
    },

    unselect: function() {
	var self = this;

	for (key in self.selectedElements) {
	    self.selectedElements[key].removeClass("selected");
	    self.selectedElements[key].removeClass("current");
	    delete self.selectedElements[key];
	}
    },

    includeItem: function(item) {
	var itemName = item.getModelName();
	if (itemName === "task") {
	    if (!this.parameters.showTasks) { return false; }
	    if (this.parameters.checked !== undefined && item.checked !== this.parameters.checked) { return false; }
	    if (this.parameters.list_id) {
		var list = Tornado.lists.get(this.parameters.list_id);
		return list.tasks.get(item.id) !== undefined; 
	    }
	}

	if (itemName === "list") {
	    if (!this.parameters.showLists) { return false; }
	    if (this.parameters.parent_id !== undefined && this.parameters.parent_id !== item.parent_id) { return false; }
	    if (this.parameters.list_id !== undefined && this.parameters.list_id === item.id) { return false; }
	}

	if (itemName === "tag") {
	    if (!this.parameters.showTags) { return false; }
	}

	if (itemName === "context") {
	    if (!this.parameters.showContexts) { return false; }
	}

	if (this.parameters.deleted !== undefined && item.deleted !== this.parameters.deleted) { return false; }
	if (this.parameters.shared !== undefined && item.users.size() > 1 !== this.parameters.shared) { return false }

	return true;
    },

    getAjaxUrlArguments: function() {
	var argumentString = "&";
	
	if (this.parameters != null) {
	    var params = this.parameters;
	    
	    if (params.active !== undefined) { argumentString += "active=" + params.active + "&"; }
	    if (params.deleted !== undefined) { argumentString += "deleted=" + params.deleted + "&"; }
	    if (params.tag !== undefined) { argumentString += "tag=" + params.tag + "&"; }
	    if (params.context !== undefined) { argumentString += "context=" + params.context + "&"; }
	    if (params.children !== undefined) { argumentString += "children=" + params.children + "&"; }
	    if (params.list_id !== undefined) { argumentString += "list_id=" + params.list_id + "&"; }
	    if (params.task_id !== undefined) { argumentString += "task_id=" + params.task_id + "&"; }
	    if (params.tag_id !== undefined) { argumentString += "tag_id=" + params.tag_id + "&"; }
	    if (params.context_id !== undefined) { argumentString += "context_id=" + params.context_id + "&"; }
	    if (params.parent_id !== undefined) { argumentString += "parent_id=" + params.parent_id + "&"; }
	    if (params.checked !== undefined) { argumentString += "checked=" + params.checked + "&"; }
	    if (params.limit !== undefined) { argumentString += "limit=" + params.limit + "&"; }
	    if (params.page !== undefined) { argumentString += "page=" + params.page + "&"; }
	    if (params.shared !== undefined) { argumentString += "shared=" + params.shared + "&"; }
	}
	
	return argumentString;
    },
    
    getAjaxUrl: function() {
        return "/tornado/" + this.modelString + "s/view/?" + this.getAjaxUrlArguments();
    },

    populate: function($super, data) {
	$super(data);
    },
    
    addItem: function(element) {
    	element.display(this.itemsContainer, this.loaded);
    },
    
    updateItem: function(item) {
	this.updateModelItem(item, this.itemsContainer, this.getElementList(item.model.getModelName()));
    },
    
    getTitle: function() {
	return this.parameters.title;
    },
    
    getModel: function() {
	return Tornado[this.modelString + "s"].get(this.id);
    }
});
