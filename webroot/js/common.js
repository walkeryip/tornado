var ViewManager = Class.create();
ViewManager.prototype = {
	initialize: function() {
		this.views = new Array();
	},
	
	addView: function(view) {
		this.views.push(view);
		view.load();
	},

	itemChanged: function(item) {
		this.views.each(function(view){
			view.itemChanged(item);
		});
	},

	itemDeleted: function(item) {
		this.views.each(function(view){
			view.itemDeleted(item);
		});
	}
};

var Item = Class.create();
Item.prototype = {
	
};

var Task = Class.create(Item, {

});

var List = Class.create(Item, {

});

var View = Class.create();
View.prototype = {
	initialize: function (id, name) {
		this.id = id;
		this.name = name;

		this.taskElements = new Hash();
		this.labelElements = new Hash();
		this.contextElements = new Hash();

	},

	populate: function (data) {
		var contexts = data.Context;
		var tags = data.Tag;
		var parent = data.Parent;
		this.populateTaskElements(data.Task);
		
		var list = data.TaskList;
		this.created = data.created;
		this.description = data.description;
		this.id = data.id;
		this.name = data.name;
	},

	populateTaskElements: function(tasksData) {
		var self = this;

		tasksData.each(function(taskData) {
			var task = Tornado.tasks.get(taskData.Task.id);

			if (!task) {
				task = new Task(taskData);
				Tornado.tasks.set(task.id, task);			
			}
			
			self.taskElements.set(task.id, new TaskElement(task));
		});
	},

	// Abstract function
	display: function () {},

	load: function () {
		var view = this;

		jq.ajax({
		  	cache: false,
			dataType: 'json',
		  	url: this.getAjaxUrl()
		}).done(function (data) {
			if (data){
				view.populate(data);
				view.display();
				view.loaded = true;
			}
		});
	},

	// Abstract function 
	getAjaxUrl: function() {},

	itemChanged: function(item) {
		var foundItem = this.taskElements.get(item.id);

		if (foundItem){
			this.display(foundItem);
		}
	},

	itemDeleted: function(item) {
		var foundItem = this.taskElements.get(item.id);

		if (foundItem){
			foundItem.remove();
			this.taskElements.unset(item.id);
		}
	}
};

var ListView = Class.create(View, {
	initialize: function($super, id, name){
		$super(id, name);

		jq("#tasks").append("<ul class=\"tasks\"></ul>");
		this.tasksContainer = jq("#tasks > ul");
		this.tasksContainer.id = "tasks";
		jq("#tasks-done").append("<ul class=\"tasks\"></ul>");
		this.tasksDoneContainer = jq("#tasks-done > ul");
		this.tasksDoneContainer.id = "tasks-done";
	},

	getAjaxUrl: function() {
		return "/tornado/task_lists/view/" + this.id;
	},

	displayElement: function(element) {
		if (element.task.checked === "1"){
			element.display(this.tasksDoneContainer);
		} else {
			element.display(this.tasksContainer);
		}
	},

	display: function(item) {
		var self = this;

		if (item){
			self.displayElement(item);
		} else {
			self.taskElements.each(function(data) {
				var taskElement = data.value;
				self.displayElement(taskElement);
			});
		}
	}
});

var ContextView = Class.create(View, {	
	initialize: function($super, id, name){
		$super(id, name);

		jq("#context-tasks").append("<ul class=\"tasks\"></ul>");
		this.tasksContainer = jq("#context-tasks > ul");
		this.tasksContainer.id = "context-tasks";
	},

	getAjaxUrl: function() {
		return "/tornado/contexts/view/" + this.id;
	},

	display: function () {
		var self = this;

		self.taskElements.each(function(data) {
			var taskElement = data.value;
			if (taskElement.task.checked === "0"){
				taskElement.display(self.tasksContainer);
			} 
		});
	},
});

var Item = Class.create();
Item.prototype = {};

var Task = Class.create(Item, {
	initialize: function (data) {
		this.populate(data);
		this.elements = new Hash();
	},

	populate: function (data) {
		this.contexts = data.Context;
		this.tags = data.Tag;
		this.parents = data.TaskList;

		var task = data.Task;

		this.checked = task.checked;
		this.created = task.created;
		this.deadline = task.deadline;
		this.description = task.description;
		this.id = task.id;
		this.name = task.name;
		this.priority = task.priority;
		this.todo = task.todo;
	},

	delete: function(callback) {
		var task = this;

		jq.ajax({
			cache: false,
			dataType: 'json',
			url: "/tornado/tasks/delete/" + this.id
		}).done(function (data) {
			if (data){
				callback();				
				//task.remove();
			}
		});
	},

	// TODO: Add contexts and tags also
	save: function(callback) {
		var self = this;

		jq.ajax({
			type: "post",
			cache: false,
			dataType: 'json',
			url: "/tornado/tasks/edit/" + self.id,
			data: {"data[Task][name]": self.name,
				   "data[Task][created]": self.created,
				   "data[Task][id]": self.id,
				   "data[Task][description]": self.description,
				   "data[Task][deadline]": self.deadline,
				   "data[Task][priority]": self.priority,
				   "data[Task][tags]": "a, b, c, dator",
				   "data[Task][contexts]": "a1, b2,b3, dator"}
		}).done(function (result) {
			if (result){
				self.populate(result);
				callback();
				//self.display(container);
			}
		});
	}
});

var ItemElement = Class.create();
ItemElement.prototype = {
	remove: function() {
		this.element.remove();
	}
};

var TaskElement = Class.create(ItemElement, {
	initialize: function(task){
		this.task = task;			
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
		var task = jq("<a href=\"/tornado/tasks/view/" + this.task.id + "\">" + this.task.name + "</a>");

		// Info
		var info = jq("<a href=\"#\" class=\"info-button expandable-div-button\" \">I</a>");
		
		info.click(function () { 
			expandableDivButtonClick(info); 
			return false;
		});
		
		var infoBox = jq("<div class=\"info expandable-div\" style=\"display: none; \"></div>");
		infoBox.append("<p>" + this.task.created + "</p>");
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

			self.task.save(function() {
				//self.display(container);
				Tornado.viewManager.itemChanged(self.task);
			});
		});

		var cancelButton = jq("<button>Cancel</button>");
		cancelButton.click(function() {
			self.display(container);
		});

		taskContainer.append(jq("<p></p>").append(checkbox));
		taskContainer.append(jq("<p></p>").append(input.name)); 
		taskContainer.append(saveButton); 
		taskContainer.append(cancelButton); 

		this.element.html(taskContainer);
	},

	check: function() {
		
	}
});


var expandableDivButtonClick = function (element) {
	$(element).next("div").toggle();

	return false;
};

var modalDivButtonClick = function (element) {
	jq(element).next("div").modal();
};

var deleteModel = function (id, model, name){
	jq("#message-confirm-box p").text("Are you sure you want to delete " + name + "?");
	jq("#message-confirm-box .yes").click(function () {
		jq(location).attr('href',"/tornado/" + model + "/delete/" + id);
	});
	jq("#message-confirm-box .no").click(function () {
		jq.modal.close();
	});
	jq("#message-confirm-box").modal();
};

var deleteTask = function (id, name) {
	deleteModel(id, "task", name);
};

var deleteList = function (id, name) {
	deleteModel(id, "task_lists", name);
};

var Tornado = new function() { return {
	tasks: new Hash(),
	contexts: new Hash(),
	tags: new Hash(),
	lists: new Hash(),
	viewManager: new ViewManager()
}};

jq(document).ready(function () {

	//var test = new Task(86, "Fin task");
	//test.load();

	var listView = new ListView(5, "ListView");
	var contextView = new ContextView(6, "ContextView");
	Tornado.viewManager.addView(listView);
	Tornado.viewManager.addView(contextView);

	/*jq(".expandable-div-button").click(function () {
		expandableDivButtonClick(this);
	});*/
});

