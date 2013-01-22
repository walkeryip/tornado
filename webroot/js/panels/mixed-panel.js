Tornado.MixedPanel = Class.create(Tornado.Panel, {
    initialize: function($super, id, containerId){
	$super(id, containerId);
	var self = this;
	
	var listSorter = jq(Tornado.tpl.tableSorter());
	this.container.append(listSorter);
        this.container.append(Tornado.tpl.panelContainer({model: "list"}));
        this.listsContainer = this.container.find("table.lists");

	var taskSorter = jq(Tornado.tpl.tableSorter());
	this.container.append(taskSorter);
        this.container.append(Tornado.tpl.panelContainer({model: "task"}));
        this.tasksContainer = this.container.find("table.tasks");

/*	taskSorter.find(".sortByName").click(function (e) { 
	    if(jq(this).hasClass("desc")) {
		options = {};
	    }

	    var options = {order: jq(this).hasClass("desc") ? "asc" : "desc"};

	    self.tasksContainer.find("tr").tsort(".item", options); 
	    jq(this).toggleClass("desc"); 
	    return false; 
	});*/
/*
	listSorter.find(".sortByName").click(function (e) { self.listsContainer.find("tr").tsort(".item"); jq(this).toggleClass("desc"); return false; });
	listSorter.find(".sortByDeadline").click(function (e) { self.listsContainer.find("tr").tsort(".deadline"); jq(this).toggleClass("desc"); return false; });
	listSorter.find(".sortByPriority").click(function (e) { self.listsContainer.find("tr").tsort(".priority"); jq(this).toggleClass("desc"); return false; });
	listSorter.find(".sortByEnergy").click(function (e) { self.listsContainer.find("tr").tsort(".energy"); jq(this).toggleClass("desc"); return false; });
	listSorter.find(".sortByTime").click(function (e) { self.listsContainer.find("tr").tsort(".time"); jq(this).toggleClass("desc"); return false; });
	listSorter.find(".sortByCreated").click(function (e) { self.listsContainer.find("tr").tsort(".created"); jq(this).toggleClass("desc"); return false; });
*/
    },

    populate: function($super, data) {
	$super(data);
    },

    getAjaxUrl: function() {
	return "/tornado/task_lists/view/" + this.id;
    },

    addItem: function(element) {
        if (element.model instanceof Tornado.Task){
            element.display(this.tasksContainer, this.loaded);
        } else if (element.model instanceof Tornado.List) {
	    // We don't want to list the current list again
	    if (element.model.id != this.id){
		element.display(this.listsContainer, this.loaded);
	    } else {
		this.container.find(".description").text(element.model.description);
	    }
        }
    },

    updateItem: function(element) {
	if (element.model instanceof Tornado.Task){
	    this.updateModelItem(element, this.tasksContainer, this.taskElements); 
	} else if (element.model instanceof Tornado.List) {
	    if (this.id != element.model.id) {
		this.updateModelItem(element, this.listsContainer, this.listElements);
	    }
	}
    }
});
