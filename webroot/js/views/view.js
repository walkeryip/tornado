// Abstract class
Tornado.View = Class.create();
Tornado.View.prototype = {
	initialize: function (id, containerId, parameters) {
		this.id = id;

		this.parameters = parameters;
		if (this.parameters === undefined) {
			this.parameters = {};
		}

		this.taskElements = new Hash();
		this.tagElements = new Hash();
        this.contextElements = new Hash();
        this.listElements = new Hash();
        this.userElements = new Hash();

		this.loaded = false;

		this.container = jq(containerId);
		this.container.hide();
		this.container.addClass("view");
	},
	

	populate: function (data) {
        this.populateItemElements(data.contexts.sort(compareItem));
        this.populateItemElements(data.tags.sort(compareItem));
        this.populateItemElements(data.tasks.sort(compareItem));
        this.populateItemElements(data.lists.sort(compareItem));
        this.populateItemElements(data.users.sort(compareItem));
    },

	populateItemElement: function(item, itemElements) {
		if (this.includeItem(item)){
			if (itemElements.get(item.id) == undefined){
				this.itemAdded(item);
			} else {
				this.itemChanged(item);
			}
		} else {
			if (itemElements.get(item.id) !== undefined){
				this.itemDeleted(item);
			}
		}
	},

	populateItemElements: function(items) {
		var self = this;

		if (items !== undefined){
			var itemElements = this.getModelElementMatrix(items);

			items.each(function(item) {
				self.populateItemElement(item, itemElements);
			});
		}
	},

	dataUpdated: function (data) {
		var self = this;
		var emptyView = false;
		if (this.taskElements.size() == 0 && this.tagElements.size() == 0 && this.contextElements.size() == 0 && this.listElements.size() == 0){
			emptyView = true;
		}
		
        this.populate(data);

		if (!this.loaded) {
			this.model = this.getModel();
			this.container.prepend("<h2>" + this.getTitle() + "</h2>");
			this.container.fadeIn("slow");
			this.loaded = true;
		} else {
			this.taskElements.each(function(taskElement) {
				if (!self.includeItem(taskElement.value.model)) {
					self.itemDeleted(taskElement.value.model);
				}			
			});
		}
	},

	itemChanged: function(item) {
		var foundItem = this.getItemElement(item);

		if (foundItem) {
			this.updateItem(foundItem);
		} else {
			this.itemAdded(item);
		}
	},

	itemDeleted: function(item) {
		/*var foundItem = this.getItemElement(item);

		if (foundItem){			
			foundItem.element.fadeOut("fast", function (){
				$(this).remove();
			});
		}*/
		this.container.find("li[data-model-type=" + item.getModelName() + "][data-model-id=" + item.id + "]").fadeOut("fast", function() {
			$(this).remove();
		});
		this.unsetItemElement(item);
	},

	itemAttributeDeleted: function(item) {
		this.container.find("li[data-model-type=" + item.getModelName() + "][data-model-id=" + item.id + "]").fadeOut("fast", function() {
			$(this).remove();
		});
	},

	itemAdded: function(item) {
		this.addItem(this.newItemElement(item));
	},
	
	getModelElementMatrix: function(o) {
		var item = o;

		// If list
		if (o[0] !== undefined){
			item = o[0];
		}

		if (item instanceof Tornado.Task) {
			return this.taskElements; 
		} else if (item instanceof Tornado.Tag) {
			return this.tagElements;
		} else if (item instanceof Tornado.Context) {
			return this.contextElements;
		} else if (item instanceof Tornado.List) {
			return this.listElements;
		} else if (item instanceof Tornado.User) {
			return this.userElements;
		}
	},
	
	getNewModelElement: function(item) {
		if (item instanceof Tornado.Task) {
			return new Tornado.TaskElement(item);
		} else if (item instanceof Tornado.Tag) {
			return new Tornado.TagElement(item);
		} else if (item instanceof Tornado.Context) {
			return new Tornado.ContextElement(item);
		} else if (item instanceof Tornado.List) {
			return new Tornado.ListElement(item);
		} else if (item instanceof Tornado.User) {
			return new Tornado.UserElement(item);
		}
	},

	getItemElement: function(item) {
		return this.getModelElementMatrix(item).get(item.id);
	},
	
	unsetItemElement: function(item) {
		this.getModelElementMatrix(item).unset(item.id);
	},

	newItemElement: function(item) {
		var element = this.getNewModelElement(item);
		this.getModelElementMatrix(item).set(item.id, element);
		
		return element;
	},

	// Abstract functions
    addItem: function() { throw new Error("Abstract function not implemented."); },
	updateItem: function() { throw new Error("Abstract function not implemented."); },
	getAjaxUrl: function() { throw new Error("Abstract function not implemented."); },

	// Overridable function
	getTitle: function() { return "unknown"; },
	includeItem: function(item) { return true; },
	getModel: function() { return null; }
};
