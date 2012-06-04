var List = Class.create();

List.prototype = {
	initialize: function (id, name) {
		this.id = id;
		this.name = name;

		this.tasks = new Array();
		this.labels = new Array();
		this.contexts = new Array();

		this.container = jq("#tasks-done");
	},

	populate: function (data) {
		var contexts = data.Context;
		var tags = data.Tag;
		var parent = data.Parent;
		this.populateTasks(data.Task);
		
		var list = data.TaskList;
		this.created = data.created;
		this.description = data.description;
		this.id = data.id;
		this.name = data.name;
	},

	populateTasks: function (tasks) {
		var list = this;

		tasks.each(function(task) {
			list.tasks.push(new Task(task));
		});
	},

	load: function () {
		var list = this;

		jq.ajax({
		  	cache: false,
			dataType: 'json',
		  	url: "/tornado/task_lists/view/" + this.id
		}).done(function (data) {
			if (data){
				list.populate(data);
				list.display(list.container);
				list.loaded = true;
			}
		});
	},

	display: function () {
		var list = this;

		list.tasks.each(function(task) {
			task.display(list.container);
		});
	}
};

var Task = Class.create();

Task.prototype = {
	initialize: function (data) {
		this.populate(data);
		this.elements = new Array();
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

	load: function () {
		var task = this;

		jq.ajax({
		  	cache: false,
			dataType: 'json',
		  	url: "/tornado/tasks/view/" + this.id
		}).done(function (data) {
			if (data){
				task.populate(data);
				task.display();
				task.loaded = true;
			} else {
				task.loaded = false;
			}
		});
	},

	delete: function () {
		var task = this;

		jq.ajax({
			cache: false,
			dataType: 'json',
			url: "/tornado/tasks/delete/" + this.id
		}).done(function (data) {
			if (data){
				task.remove();
			}
		});
	},

	save: function () {
		var self = this;

		jq.ajax({
			cache: false,
			dataType: 'json',
			url: "/tornado/tasks/edit/" + self.id,
			data: {"data[task][name]": self.name,
				   "data[task][created]": self.created,
				   "data[task][id]": self.id,
				   "data[task][description]": self.description,
				   "data[task][deadline]": self.deadline,
				   "data[task][priority]": self.priority,
				   "data[task][tags]": Tag.tagsToString(self.tags),
				   "data[task][contexts]": Context.contextsToString(self.contexts)}
		}).done(function (data) {
			if (data){
				self.load(data);
				self.display
			}
		});
	},

	display: function (container) {
		var self = this;
		var element = this.elements[container];

		if (element){
			element.html(jq("<li></li>"));
		} else {
			element = jq("<li></li>");
			this.elements[container] = element;
		}

		var taskContainer = jq("<div class=\"task\"></div>");
		var checkbox = jq("<input type=\"checkbox\" />");
		var task = jq("<a href=\"/tornado/tasks/view/" + this.id + "\">" + this.name + "</a>");

		// Info
		var info = jq("<a href=\"#\" class=\"info-button expandable-div-button\" \">I</a>");
		
		info.click(function () { 
			expandableDivButtonClick(info); 
			return false;
		});
		
		var infoBox = jq("<div class=\"info expandable-div\" style=\"display: none; \"></div>");
		infoBox.append("<p>" + this.created + "</p>");
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
			self.delete();
			return false;
		});

		actionsBox.append(editButton).append(deleteButton);

		taskContainer.append(jq("<p></p>").append(checkbox));
		taskContainer.append(jq("<p></p>").append(task)); 
		taskContainer.append(info);
		taskContainer.append(infoBox);
		taskContainer.append(actions);
		taskContainer.append(actionsBox);


		this.elements[container] = element;

		var elementObject = container.find(element);

		if (elementObject.length > 0){
			element.html(taskContainer);
		} else {
			element.append(taskContainer);
			container.append(element);
		}
/*		this.element = jq("#test-" + this.id);
		this.element.click(function (){
			task.delete();		
		});*/
	},

	edit: function(container) {
		var self = this;
		var element = this.elements[container];
		
		var taskContainer = jq("<div class=\"task edit\"></div>");
		var checkbox = jq("<input type=\"checkbox\" />");
		var input = Array();
		input.name = jq("<input type=\"text\" value=\"" + this.name + "\" name=\"name\" />");

		var saveButton = jq("<button>Save</button>");
		saveButton.click(function() {
			self.name = jq(input.name).val();
			self.save();
			self.display(container);
		});

		taskContainer.append(jq("<p></p>").append(checkbox));
		taskContainer.append(jq("<p></p>").append(input.name)); 
		taskContainer.append(saveButton); 

		element.html(taskContainer);
	},

	remove: function() {
		this.elements.each(function(element){
			element.remove();
		});
	}
};


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

jq(document).ready(function () {

	//var test = new Task(86, "Fin task");
	//test.load();

	var testlist = new List(5, "test");
	testlist.load();

	/*jq(".expandable-div-button").click(function () {
		expandableDivButtonClick(this);
	});*/
});

