Tornado.Element = Class.create();
Tornado.Element.prototype = {
    initialize: function(model) {
	this.templates = {
	    element: "<li data-model-type=\"{{model}}\" data-model-id=\"{{id}}\"></li>",
	    elementContainer: "<div class=\"element{{#edit}} edit{{/edit}}\"></div>",
	    elementLabel: "<span class=\"{{model}}\" data-model-type=\"{{model}}\" data-model-id=\"{{id}}\"><a href=\"/tornado/{{model}}s/view/{{id}}\">{{name}}</a></span>",
	    actionsContainer: "<a href=\"#\" class=\"settings-button expandable-div-button\">O</a>",
	    actionsBox: "<div class=\"settings expandable-div\" style=\"display: none\"></div>",
	    button: "<a class=\"{{class}}\" href=\"#\">{{label}}</a>",
	    handle: "<p class=\"handle\"></p>",
	    checkbox: "<input type=\"checkbox\" {{#checked}}checked=\"yes\"{{/checked}} />",
	    elementActions: "<p class=\"actions\"></p>",
	    descriptionLink: "<a class=\"description-link\" href=\"#\">D</a>",
	    infoBox:"<div class=\"infobox\"><p>{{description}}</p></div>",
	    textBox: "<input type=\"text\" value=\"{{name}}\" name=\"name\" />",
	    button: "<button>{{label}}</button>"};

	this.visible = false;
	this.element = jq(Mustache.render(this.templates.element, {model: model.getModelName(), id: model.id}));
	this.model = model;
	this.hasCheckbox = false;
	this.hasTags = false;
	this.hasUsers = false;
	this.hasDescription = false;
	this.hasContexts = false;
	this.hasUsers = false;
    },

    remove: function() {
	this.element.remove();
	this.visible = false;
    },

    flash: function () {
	this.element.effect("highlight", {}, 2000);
    },

    display: function (container, loaded, after) {
	var self = this;
	self.visible = true;

	var elementContainer = jq(Mustache.render(this.templates.elementContainer, {edit: false}));

	var body = this.getBody();

	if (self.hasTags){
	    var tagsString = "";
	    var defaultTag = Tornado.state.getTag();
	    self.tags.each(function(tag){
		if (defaultTag === undefined || tag.value.id != defaultTag.id) {
		    tagsString += Mustache.render(self.templates.elementLabel, {model:"tag", id: tag.value.id, name: "#" + tag.value.name});	
		}
	    });

	    body += tagsString; 
	}

	if (self.hasContexts){
	    var contextsString = "";
	    var defaultContext = Tornado.state.getContext();
	    self.contexts.each(function(context){
		if (defaultContext === undefined || context.value.id != defaultContext.id) {
		    contextsString += Mustache.render(self.templates.elementLabel, {model:"context", id:context.value.id, name: "@" + context.value.name}); //"<span class=\"context\" data-model-type=\"context\" data-model-id=\"" + context.value.id + "\"><a href=\"/tornado/contexts/view/" + context.value.id + "\">@" + context.value.name + "</a></span>";	
		}
	    });

	    body += contextsString;
	}

	if (self.hasUsers){
	    var usersString = "";
	    var defaultUser = Tornado.state.getUser();
	    self.users.each(function(user){
		if (defaultUser === undefined || user.value.id != defaultUser.id) {
		    usersString += Mustache.render(self.templates.elementLabel, {model:"user", id:user.value.id, name: "~" + user.value.name}); //"<span class=\"user\" data-model-type=\"user\" data-model-id=\"" + user.value.id + "\"><a href=\"/tornado/users/view/" + user.value.id + "\">~" + user.value.name + "</a></span>";	
		}
	    });

	    body += usersString;
	}


	// Actions
	var actions = jq(Mustache.render(this.templates.actionsContainer)); //"<a href=\"#\" class=\"settings-button expandable-div-button\">O</a>");
	var actionsBox = jq(Mustache.render(this.templates.actionsBox)); //"<div class=\"settings expandable-div\" style=\"display: none\"></div>");
	var editButton = jq(Mustache.render(this.templates.button, {class:"edit", label:"Edit"}));//"<a class=\"edit\" href=\"#\">Edit</a>");
	var deleteButton = jq(Mustache.render(this.templates.button, {class:"delete", label:"Delete"}));//"<a class=\"delete\" href=\"#\">Delete</a>");

	actions.click(function () { 
	    expandableDivButtonClick(actions); 

	    elementContainer.mouseleave(function () {
		actionsBox.hide();
		elementContainer.unbind("mouseleave");
	    });

	    return false;
	});
	actions.disableSelection();

	editButton.click(function() {
	    self.edit(container);
	    return false;
	});		
	editButton.disableSelection();

	deleteButton.click(function() {
	    self.model.remove();
	    return false;
	});
	deleteButton.disableSelection();

	actionsBox.append(editButton).append(deleteButton);
	actionsBox.disableSelection();
	
	elementContainer.append(jq(Mustache.render(this.templates.handle)));
	
	if (self.hasCheckbox){
	    /*var checkboxString = "<input type=\"checkbox\" ";
	    if(this.model.checked){
		checkboxString += "checked=\"yes\"";
	    }
	    checkboxString += " />";*/
	    var checkbox = jq(Mustache.render(this.templates.checkbox, this.model.checked));
	    
	    checkbox.click(function () {
		self.toggle();
	    });
	    checkbox.disableSelection();
	    elementContainer.append(jq(Mustache.render(this.templates.elementActions))).append(checkbox);
	}		

	elementContainer.append(jq("<p></p>").append(body));
	elementContainer.append(actions);
	elementContainer.append(actionsBox);

	// Infobox
	if (self.hasDescription && this.model.description) {
	    var descriptionLink = jq(Mustache.render(this.templates.descriptionLink));
	    var infoBox = jq(Mustache.render(this.templates.infoBox, {description: this.model.description}));
	    descriptionLink.click(function() {
		infoBox.toggle("fast");
		return false;
	    });
	    elementContainer.append(descriptionLink);
	    elementContainer.append(infoBox);
	}

	elementContainer.draggable(
	    {revert: "invalid",
	     distance: 5,
	     handle: ".handle",
	     opacity: 0.7, 
	     helper: "clone",
	     create: function(event, ui){ 
		 this.model = self.model; 
	     }});
	//elementContainer.disableSelection();

	// Prevent events when clicking a link or interacting with an input tag
	elementContainer.find("a, input").click(function(e) {
	    e.stopPropagation();
   	    e.stopImmediatePropagation();
	});

	var existingElement = container.find(this.element);

	if (existingElement.length == 1){
	    existingElement.html(elementContainer);
	} else {	
	    this.element.html(elementContainer);
	    
	    // We assume that the initial item list is sorted
	    if (loaded) {
		var foundElement = false;
		container.children().each(function(index, item) {
		    if (compareItem(self.getModelFromElement(jq(item)), self.model) > 0){
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

	if (loaded !== undefined && loaded == true) {
	    this.flash();
	}
    },
    
    edit: function(container) {
	var self = this;
	
	var elementContainer = jq(Mustache.render(this.templates.elementContainer, {edit: true}));
	
	var input = Array();
	input.name = jq(Mustache.render(this.templates.textBox, {name: this.model.name}));
	
	var saveButton = jq(Mustache.render(this.templates.button, {label: "Save"}));
	saveButton.click(function() {
	    submit();
	    return false;
	});

	var cancelButton = jq(Mustache.render(this.templates.button, {label: "Cancel"}));
	cancelButton.click(function() {
	    self.display(container);
	    return false;
	});
	
	elementContainer.append(jq("<p><label>Name:</label></p>").append(input.name)); 
	
	if (self.hasTags){
	    var tagsArray = Tornado.Label.arrayToLabelString(self.model.tags);
	    input.tags = jq("<input type=\"text\" value=\"" + tagsArray + "\" name=\"tags\" />");	
	    elementContainer.append(jq("<p><label>Tags:</label></p>").append(input.tags)); 
	}
	
	if (self.hasContexts){
	    var contextsArray = Tornado.Label.arrayToLabelString(self.model.contexts);
	    input.contexts = jq("<input type=\"text\" value=\"" + contextsArray + "\" name=\"contexts\" />");
	    elementContainer.append(jq("<p><label>Contexts:</label></p>").append(input.contexts)); 
	}
	
	if (self.hasUsers){
	    var usersArray = Tornado.Label.arrayToLabelString(self.model.users);
	    input.users = jq("<input type=\"text\" value=\"" + usersArray + "\" name=\"users\" />");
	    elementContainer.append(jq("<p><label>Users:</label></p>").append(input.users)); 
	}

	if (self.hasDescription) {
	    input.description = jq("<textarea name=\"description\">" + self.model.description + "</textarea>");
	    elementContainer.append(jq("<p><label>Description:</label></p>").append(input.description)); 
	}

	elementContainer.append(saveButton); 
	elementContainer.append(cancelButton); 

	this.element.html(elementContainer);

	elementContainer.find("input").keydown(function(e){
	    if(e.keyCode == 13){
		submit();
		return false;
	    }
	});

	var submit = function (){
	    self.model.name = jq(input.name).val();
	    self.model.description = jq(input.description).val();
	    
	    if (self.hasTags){
		self.model.tagsString = jq(input.tags).val();
	    }
	    
	    if (self.hasContexts){
		self.model.contextsString = jq(input.contexts).val();
	    }
	    
	    if (self.hasUsers){
		self.model.usersString = jq(input.users).val();
	    }

	    self.model.save(function(data) {
		Tornado.panelManager.dataUpdated(data);
	    });
	}
    },

    getModelFromElement: function(element) {
	var modelType = element.attr("data-model-type");
	var modelId = element.attr("data-model-id");

	if (modelType === "task") {
	    return Tornado.tasks.get(modelId);
	} else if (modelType === "list") {
	    return Tornado.lists.get(modelId);
	} else if (modelType === "tag") {
	    return Tornado.tags.get(modelId);
	} else if (modelType === "context") {
	    return Tornado.contexts.get(modelId);
	} else {
	    throw new Error("Model type " + modelType + " unknown.");
	}
    }
};
