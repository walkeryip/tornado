Tornado.GeneralPanel = Class.create(Tornado.Panel, {
    initialize: function($super, id, containerId, parameters){
	$super(id, containerId, parameters);

	var defaultParams = {
	    breadcrumbs: false,

	    showTasks: false,
	    showLists: false,
	    showContexts: false,
	    showTags: false,
	    showUsers: false,
	    
	    showInlineContexts: true,
	    showInlineTags: true,
	    showInlineUsers: true
	};

	this.parameters = jq.extend({}, defaultParams, parameters);

	this.container = jq("<div></div>");
	jq("#content").append(this.container);
	this.modelString = parameters.type;

	var table = jq(Tornado.tpl.panelContainer({model: "item"}));
	var sorter = jq(Tornado.tpl.tableSorter());
	this.container.append(table);
        table.prepend(sorter);
        this.itemsContainer = table.find("table.items");

	if (this.parameters.breadcrumbs) {
	    this.breadcrumbs = new Tornado.Breadcrumbs(this.parameters.list_id, "#breadcrumbs");
	}
	
    },

    includeItem: function(item) {
	return item.getModelName() === "task" && this.parameters.showTasks ||
	    item.getModelName() === "list" && this.parameters.showLists && this.parameters.list_id != item.id ||
	    item.getModelName() === "context" && this.parameters.showContexts ||
	    item.getModelName() === "tag" && this.parameters.showTags;
    },
    
    getAjaxUrl: function() {
	var argumentString = "";

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
	}

        return "/tornado/" + this.modelString + "s/view/?" + argumentString;
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
