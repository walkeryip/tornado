Tornado.Element = Class.create();
Tornado.Element.prototype = {
	initialize: function(model) {
		this.visible = false;
		this.element = jq("<li></li>");
		this.model = model;
		this.hasCheckbox = false;
		this.hasTags = false;
		this.hasContexts = false;
	},

	remove: function() {
		this.element.remove();
		this.visible = false;
	},

	flash: function () {
		this.element.effect("highlight", {}, 2000);
	},
	
	display: function (container, loaded) {
		var self = this;
		self.visible = true;

		var elementContainer = jq("<div class=\"element\"></div>");

		var body = this.getBody();
		
		if (self.hasTags){
			var tagsString = "";
			self.tags.each(function(tag){
				tagsString += "<li><a href=\"/tornado/tags/view/" + tag.value.id + "\">#" + tag.value.name + "</a></li>";	
			});
			
			body += "<ul class=\"tags\">" + tagsString + "</ul>"; 
		}
		
		if (self.hasContexts){
			var contextsString = "";
			self.contexts.each(function(context){
				contextsString += "<li><a href=\"/tornado/contexts/view/" + context.value.id + "\">@" + context.value.name + "</a></li>";	
			});
			
			body += "<ul class=\"contexts\">" + contextsString + "</ul>";
		}

		
		// Actions
		var actions = jq("<a href=\"#\" class=\"settings-button expandable-div-button\">O</a>");

		actions.click(function () { 
			expandableDivButtonClick(actions); 
			return false;
		});	

		var actionsBox = jq("<div class=\"settings expandable-div\" style=\"display: none\"></div>");
		var editButton = jq("<a class=\"edit\" href=\"#\">Edit</a>");
		var deleteButton = jq("<a class=\"delete\" href=\"#\">Delete</a>");

		editButton.click(function() {
			self.edit(container);
			return false;
		});		

		deleteButton.click(function() {
			self.model.remove();
			return false;
		});

		actionsBox.append(editButton).append(deleteButton);
		
		if (self.hasCheckbox){
			var checkboxString = "<input type=\"checkbox\" ";
			if(this.model.checked === "1"){
				checkboxString += "checked=\"yes\"";
			}
			checkboxString += " />";
			var checkbox = jq(checkboxString);
		
			checkbox.click(function () {
				self.toggle();
			});

			elementContainer.append(jq("<p></p>").append(checkbox));
		}
		
		// Infobox
		var infoBox = jq("<div class=\"infobox\"><p>" + this.model.description + "</p></div>");
		elementContainer.mouseup(function() {
			infoBox.toggle("fast");
		});

		elementContainer.append(jq("<p></p>").append(jq(body))); 
		elementContainer.append(actions);
		elementContainer.append(actionsBox);
		elementContainer.append(infoBox);
		elementContainer.draggable(
			{revert: "invalid",
			 create: function(event, ui){ 
				this.model = self.model; 
			}});
		elementContainer.disableSelection();

		var existingElement = container.find(this.element);

		if (existingElement.length == 1){
			existingElement.html(elementContainer);
		} else {	
			this.element.html(elementContainer);
			container.append(this.element);
			this.element.hide().fadeIn();
		}

		if (loaded !== undefined && loaded == true) {
			this.flash();
		}
	},
	
	edit: function(container) {
		var self = this;
		
		var elementContainer = jq("<div class=\"element edit\"></div>");
		
		var input = Array();
		input.name = jq("<input type=\"text\" value=\"" + this.model.name + "\" name=\"name\" />");
		
		var saveButton = jq("<button>Save</button>");
			saveButton.click(function() {
				submit();
			});

		var cancelButton = jq("<button>Cancel</button>");
			cancelButton.click(function() {
				self.display(container);
			});
		
		if (self.hasCheckbox){
			var checkbox = jq("<input type=\"checkbox\" />");
			elementContainer.append(jq("<p></p>").append(checkbox));
		}
		
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
		
		input.description = jq("<textarea name=\"description\">" + this.model.description + "</textarea>");
		elementContainer.append(jq("<p><label>Description:</label></p>").append(input.description)); 

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

			self.model.save(function(data) {
				Tornado.viewManager.dataUpdated(data);
			});
		}
	}
};
