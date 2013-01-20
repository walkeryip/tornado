Tornado.Element = Class.create();
Tornado.Element.prototype = {
    initialize: function(model) {
	this.visible = false;
	this.model = model;
	this.element = jq(Tornado.tpl.elementContainer({model: this.model.getModelName(), id: this.model.id}));
	this.hasCheckbox = false;
	this.hasTags = false;
	this.hasUsers = false;
	this.hasDescription = false;
	this.hasContexts = false;
	this.hasUsers = false;
	this.hasTime = false;
	this.hasEnergy = false;
	this.hasDeadline = false;
	this.hasPriority = false;
	this.hasActive = false;
    },

    remove: function() {
	this.fadeOut("fast", function () {
	    this.element.remove();
	    this.visible = false; 
	});
    },

    flash: function () {
	this.element.effect("highlight", {}, 2000);
    },

    getLabelModels: function(labels, defaultLabel) {
	var labelsArray = new Array();
	labels.each(function(label){
	    if (!defaultLabel || label.value.id != defaultLabel.id) {
		labelsArray.push({id: label.value.id, name: label.value.name});	
	    }
	});
	
	return labelsArray;
    },

    display: function (container, loaded, after) {
	var self = this;

	this.visible = true;

	var tagsArray = this.getLabelModels(this.model.tags, Tornado.state.getTag());
	var contextsArray = this.getLabelModels(this.model.contexts, Tornado.state.getContext());
	var usersArray = this.getLabelModels(this.model.users, Tornado.state.getUser());

	var viewElement = jq(Tornado.tpl.elementView(
	    {model: this.model.getModelName(), id: this.model.id, name: Tornado.capitalizeFirst(this.model.name), users: usersArray,
	     hasCheckbox: this.hasCheckbox, checked: this.model.checked, tags: tagsArray, contexts: contextsArray, 
	     link: this.model.getModelName() == "list", hasDeadline: this.hasDeadline && this.model.deadline, 
	     hasEnergy: this.hasEnergy && this.model.energy, hasTime: this.hasTime && this.model.time, 
	     hasPriority: this.hasPriority && this.model.priority, deadline: this.model.deadline, energy: this.model.energy,
	     time: this.model.time, priority: this.model.priority}));

	viewElement.find(".dropdown-toggle").dropdown();

	viewElement.find(".edit").click(function() {
	    self.edit(container);
	    return false;
	});		

	viewElement.find(".delete").click(function() {
	    self.model.remove();
	    return false;
	});

	viewElement.find("input[type=checkbox]").click(function () {
	    self.toggle();
	});

	viewElement.draggable(
	    {revert: "invalid",
	     distance: 5,
	     handle: ".handle",
	     opacity: 0.7, 
	     helper: "clone",
	     create: function(event, ui){ 
		 this.model = self.model; 
	     }});

	// Prevent events when clicking a link or interacting with an input tag
	viewElement.find("a, input").click(function(e) {
	    e.stopPropagation();
   	    e.stopImmediatePropagation();
	});

	var existingElement = container.find(this.element);

	if (existingElement.length == 1){
	    existingElement.html(viewElement);
	} else {
	    this.element.html(viewElement);

	    // We assume that the initial item list is sorted
	    if (loaded) {
		var foundElement = false;
		container.find("tr").each(function(index, item) {
		    if (Tornado.compareItem(self.getItemFromElement(jq(item)), self.model) > 0){
			foundElement = true;
			self.element.insertBefore(item);
			return false;
		    }
		});
	    }
	    
	    if (!foundElement) {
		container.append(this.element);
	    }

	    this.element.hide().fadeIn();
	}

	if (this.hasActive) {
	    if (this.model.active) {
		this.element.removeClass("inactive");
	    } else {
		this.element.addClass("inactive");
	    }
	}

	// Only flash if the element is loaded
	if (loaded === true) {
	    this.flash();
	}
    },
    
    edit: function(container) {
	var self = this;

	var tagsString = Tornado.Label.arrayToLabelString(self.model.tags);
	var contextsString = Tornado.Label.arrayToLabelString(self.model.contexts);
	var usersString = Tornado.Label.arrayToLabelString(self.model.users);

	var editElement = jq(Tornado.tpl.elementEditView(
	    {name: this.model.name, description: this.model.description, users: usersString, 
	     tags: tagsString, contexts: contextsString, hasTags: this.hasTags, hasContexts: this.hasContexts,
	     hasUsers: this.hasUsers, hasDescription: this.hasDescription, hasDeadline: this.hasDeadline,
	     hasEnergy: this.hasEnergy, hasTime: this.hasTime, hasPriority: this.hasPriority,
	     energy: this.model.energy, time: this.model.time, priority: this.model.priority, deadline: this.model.priority,
	     active: this.model.active, hasActive: this.hasActive}));

	this.element.html(editElement);
	
	editElement.find(".save").click(function() {
	    submit();
	    return false;
	});

	editElement.find(".cancel").click(function() {
	    self.display(container);
	    return false;
	});

	editElement.find("input").keydown(function(e){
	    if(e.keyCode == 13){
		submit();
		return false;
	    }
	});

	var submit = function (){
	    self.model.name = jq('input[name="name"]').val();
	    self.model.description = jq('input[name="description"]').val();
	    
	    if (self.hasTags){ self.model.tagsString = jq('input[name="tags"]').val(); }
	    if (self.hasContexts){ self.model.contextsString = jq('input[name="contexts"]').val(); }
	    if (self.hasUsers){ self.model.usersString = jq('input[name="users"]').val(); }
	    if (self.hasDeadline){ self.model.deadline = jq('input[name="deadline"]').val(); }
	    if (self.hasTime){ self.model.time = jq('input[name="time"]').val(); }
	    if (self.hasEnergy){ self.model.energy = jq('input[name="energy"]').val(); }
	    if (self.hasPriority){ self.model.priority = jq('input[name="priority"]').val(); }
	    if (self.hasActive){ self.model.active = jq('input[name="active"]').attr("checked") === "checked" ? 1 : 0; }

	    self.model.save(function(data) {
		Tornado.panelManager.dataUpdated(data);
	    });
	}
    },

    getItemFromElement: function(element) {
	var modelType = element.attr("data-model-type");
	var modelId = element.attr("data-model-id");

	return Tornado.getItem(modelType, modelId);
    }
};
