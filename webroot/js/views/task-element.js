Tornado.TaskElement = Class.create(Tornado.ItemElement, {
	initialize: function(task){
		this.task = task;	
		this.tags = task.tags;
		this.contexts = task.contexts;		
		this.element = jq("<li></li>");
	},

	display: function (container) {
		var self = this;

		var taskContainer = jq("<div class=\"task\"></div>");
		var checkboxString = "<input type=\"checkbox\" ";
		if(this.task.checked === "1"){
			checkboxString += "checked=\"yes\"";
		}
		checkboxString += " />";
		var checkbox = jq(checkboxString);
	
		checkbox.click(function () {
			self.toggle();
		});

		var tagsString = "";
		this.task.tags.each(function(tag){
			tagsString += "<li><a href=\"tags/view/" + tag.value.id + "\">#" + tag.value.name + "</a></li>";	
		});

		var contextsString = "";
		this.task.contexts.each(function(context){
			contextsString += "<li><a href=\"contexts/view/" + context.value.id + "\">@" + context.value.name + "</a></li>";	
		});

		var task = jq("<span>" + this.task.name + "</span><ul class=\"tags\">" + tagsString + "</ul><ul class=\"contexts\">" + contextsString + "</ul>");

		// Info
		var info = jq("<a href=\"#\" class=\"info-button expandable-div-button\" \">I</a>");
		
		info.click(function () { 
			expandableDivButtonClick(info); 
			return false;
		});

		
		var infoBox = jq("<div class=\"info expandable-div\" style=\"display: none; \"></div>");
		infoBox.append("<p>" + this.task.created + "</p>");
		infoBox.append("<p>" + tagsString + "</p>");
		infoBox.append("<p>contexts</p>");
		infoBox.append("<p>parent</p>");
		
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
			self.task.delete(function () {
				Tornado.viewManager.itemDeleted(self.task);
				Tornado.tasks.unset(self.task.id);
			});
			return false;
		});

		actionsBox.append(editButton).append(deleteButton);

		taskContainer.append(jq("<p></p>").append(checkbox));
		taskContainer.append(jq("<p></p>").append(task)); 
		taskContainer.append(info);
		taskContainer.append(infoBox);
		taskContainer.append(actions);
		taskContainer.append(actionsBox);

		var existingElement = container.find(this.element);

		if (existingElement.length == 1){
			existingElement.html(taskContainer);
		} else {	
			this.element.html(taskContainer);
			container.append(this.element);
			this.element.hide().fadeIn();
		}
	},

	edit: function(container) {
		var self = this;
		
		var taskContainer = jq("<div class=\"task edit\"></div>");
		var checkbox = jq("<input type=\"checkbox\" />");
		var input = Array();
		input.name = jq("<input type=\"text\" value=\"" + this.task.name + "\" name=\"name\" />");

		var saveButton = jq("<button>Save</button>");
		saveButton.click(function() {
			self.task.name = jq(input.name).val();
			self.task.tagsString = jq(input.tags).val();
			self.task.contextsString = jq(input.contexts).val();

			self.task.save(function() {
				Tornado.viewManager.itemChanged(self.task);
			});
		});

		var cancelButton = jq("<button>Cancel</button>");
		cancelButton.click(function() {
			self.display(container);
		});

		input.tags = jq("<input type=\"text\" value=\"" + Tornado.Label.arrayToLabelString(self.task.tags) + "\" name=\"tags\" />");
		input.contexts = jq("<input type=\"text\" value=\"" + Tornado.Label.arrayToLabelString(self.task.contexts) + "\" name=\"contexts\" />");

		taskContainer.append(jq("<p></p>").append(checkbox));
		taskContainer.append(jq("<p></p>").append(input.name)); 
		taskContainer.append(jq("<p></p>").append(input.tags)); 
		taskContainer.append(jq("<p></p>").append(input.contexts)); 
		taskContainer.append(saveButton); 
		taskContainer.append(cancelButton); 

		this.element.html(taskContainer);
	},

	toggle: function() {
		var self = this;
		this.task.toggle(function (){
			Tornado.viewManager.itemChanged(self.task);
		});
	}
});
