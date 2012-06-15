Tornado.ListElement = Class.create(Tornado.ItemElement, {
	initialize: function(list){
		this.list = list;
		this.element = jq("<li></li>");
	},

	display: function (container) {
		var self = this;

		var listContainer = jq("<div class=\"list\"></div>");

		var list = jq("<a href=\"/tornado/task_lists/view/" + this.list.id + "\">" + this.list.name + "</a>");

		// Info
		var info = jq("<a href=\"#\" class=\"info-button expandable-div-button\" \">I</a>");
		
		info.click(function () { 
			expandableDivButtonClick(info); 
			return false;
		});
		
		var infoBox = jq("<div class=\"info expandable-div\" style=\"display: none; \"></div>");
		infoBox.append("<p>" + this.list.created + "</p>");
		infoBox.append("<p>tags</p>");
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
			self.list.delete(function () {
				Tornado.viewManager.itemDeleted(self.list);
				Tornado.lists.unset(self.list.id);
			});
			return false;
		});

		actionsBox.append(editButton).append(deleteButton);

		listContainer.append(jq("<p></p>").append(list));
		listContainer.append(info);
		listContainer.append(infoBox);
		listContainer.append(actions);
		listContainer.append(actionsBox);

		var existingElement = container.find(this.element);

		if (existingElement.length == 1){
			existingElement.html(listContainer);
		} else {	
			this.element.html(listContainer);
			container.append(this.element);
		}
	},

	edit: function(container) {
		var self = this;
		
		var listContainer = jq("<div class=\"list edit\"></div>");
		var input = Array();
		input.name = jq("<input type=\"text\" value=\"" + this.list.name + "\" name=\"name\" />");

		var saveButton = jq("<button>Save</button>");
		saveButton.click(function() {
			self.list.name = jq(input.name).val();

			self.list.save(function() {
				//self.display(container);
				Tornado.viewManager.itemChanged(self.list);
			});
		});

		var cancelButton = jq("<button>Cancel</button>");
		cancelButton.click(function() {
			self.display(container);
		});

		listContainer.append(jq("<p></p>").append(input.name));
		listContainer.append(saveButton);
		listContainer.append(cancelButton);

		this.element.html(listContainer);
	}
});
