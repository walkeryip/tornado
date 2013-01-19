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
	     checkbox: this.hasCheckbox, checked: this.model.checked, tags: tagsArray, contexts: contextsArray, link: this.model.getModelName() == "list"}));

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

	// Only flash if the element is loaded
	if (loaded === true) {
	    this.flash();
	}
    },
    
    edit: function(container) {
	var self = this;
	
	//var elementContainer = jq(Mustache.render(this.templates.elementContainer, {edit: true}));

	var tagsString = Tornado.Label.arrayToLabelString(self.model.tags);
	var contextsString = Tornado.Label.arrayToLabelString(self.model.contexts);
	var usersString = Tornado.Label.arrayToLabelString(self.model.users);

	//this.element.hide();
	var editElement = jq(Tornado.tpl.elementEditView(
	    {name: this.model.name, description: this.model.description, users: usersString, 
	     tags: tagsString, contexts: contextsString}));

	this.element.html(editElement);
	
	//this.element.html(jq("<tr></tr>"));

	//var input = Array();
	//input.name = jq(Mustache.render(this.templates.textBox, {name: this.model.name}));
	
	//var saveButton = jq(Mustache.render(this.templates.button, {label: "Save"}));
	editElement.find(".save").click(function() {
	    submit();
	    return false;
	});

	//var cancelButton = jq(Mustache.render(this.templates.button, {label: "Cancel"}));
	editElement.find(".cancel").click(function() {
	    self.display(container);
	    return false;
	});
	
	//this.element.append(jq("<p><label>Name:</label></p>").append(input.name)); 
	
	/*if (self.hasTags){
	    var tagsArray = Tornado.Label.arrayToLabelString(self.model.tags);
	    input.tags = jq("<input type=\"text\" value=\"" + tagsArray + "\" name=\"tags\" />");	
	    this.element.append(jq("<p><label>Tags:</label></p>").append(input.tags)); 
	}
	
	if (self.hasContexts){
	    var contextsArray = Tornado.Label.arrayToLabelString(self.model.contexts);
	    input.contexts = jq("<input type=\"text\" value=\"" + contextsArray + "\" name=\"contexts\" />");
	    this.element.append(jq("<p><label>Contexts:</label></p>").append(input.contexts)); 
	}
	
	if (self.hasUsers){
	    var usersArray = Tornado.Label.arrayToLabelString(self.model.users);
	    input.users = jq("<input type=\"text\" value=\"" + usersArray + "\" name=\"users\" />");
	    this.element.append(jq("<p><label>Users:</label></p>").append(input.users)); 
	}

	if (self.hasDescription) {
	    input.description = jq("<textarea name=\"description\">" + self.model.description + "</textarea>");
	    this.element.append(jq("<p><label>Description:</label></p>").append(input.description)); 
	}

	this.element.append(saveButton); 
	this.element.append(cancelButton); 
*/
	//this.element.html(elementContainer);

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

	    self.model.save(function(data) {
		Tornado.panelManager.dataUpdated(data);
	    });
	}
    },

    getItemFromElement: function(element) {
	var modelType = element.attr("data-model-type");
	var modelId = element.attr("data-model-id");

	return Tornado.getItem(modelType, modelId);
    },

    deleteModel: function() {
	Tornado.getItem(this.model.getModelName(), this.model.id);
    }
};
