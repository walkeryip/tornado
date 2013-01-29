jQuery.noConflict();
var jq = jQuery;

Tornado = {
    // Constructor
    initialize: function() {
	this.tasks = new Hash();
	this.contexts = new Hash();
	this.tags = new Hash();
	this.lists = new Hash();
	this.users = new Hash();
	
	this.state = new Tornado.State();
	this.navigationTree = new Tornado.NavigationTree();
	this.panelManager = new Tornado.PanelManager();
	this.commandsbar = new Tornado.CommandBar();
	this.tpl = new Tornado.TemplateManager();

	this.HTTPStatus = {
	    forbidden: 403
	};
    },

    // Error function
    error: function(data) {
	var message;
	if (data.status === Tornado.HTTPStatus.forbidden) {
	    message = this.tpl.logedOutMessage;
	} else {
	    message = data.responseText;
	}

	jq.modal(this.tpl.error({message: message}));
    },

    populate: function() {
	this.commandsbar.populate();

	// Go back on backspace
	jq(document).keydown(function(e){
	    if (e.keyCode == 8) {
		window.history.back();
	    }
	});

	jq("input").live("keydown", function(e) {
	    if (e.keyCode == 8) {
		e.stopPropagation();
	    }
	});

    },

    // Function called when an item is dropped on a list
    listDropFunction: function(event, ui) {
	var item = ui.draggable[0].model;
	var destId = jq(this).attr("data-id");
	if (item.id !== destId) {
	    item.move(destId, 
		      function (data) {
			  Tornado.panelManager.dataUpdated(data);
		      },
		      function () {
			  ui.draggable.draggable('option','revert',true);
		      });    		
	} else {
	    ui.draggable.draggable('option','revert',true);
	}
    },

    // Get an item based on model name
    getItem: function(modelName, id) {
	return Tornado[modelName + "s"].get(id);
    },

    // Unset an item based on model name
    unsetItem: function(modelName, id) {
	return Tornado[modelName + "s"].unset(id);
    },

    // Set an item based on model name
    setItem: function(modelName, id, value) {
	return Tornado[modelName + "s"].set(id, value);
    },


    // TODO: this should not be used
    getItemDataTag: function(modelName) {
	return modelName.charAt(0).toUpperCase() + modelName.slice(1);
    },

    // TODO: this should not be used
    getItemClass: function(modelName) {
	return Tornado[modelName.charAt(0).toUpperCase() + modelName.slice(1)];
    },

    compareItem: function(a, b, field) {
	if (!field) {
	    field = "name";
	}
	
	var nameA=a[field].toLowerCase();
	var nameB=b[field].toLowerCase();
	if (nameA < nameB) {
 	    return -1; 
	} else if (nameA > nameB) {
  	    return 1;
	} else {
	    return 0;
	}
    },

    escapeString: function(text) {
	if (text) {
	    return text.replace(/"/g, "&quot;");
	} else {
	    return text;
	}
    },

    capitalizeFirst: function (string) {
	return string.slice(0, 1).toUpperCase() + string.slice(1);
    },

    tableSortFunction: function(a,b){
	var jqA = jq(a.e), jqB = jq(b.e);

	var test = jqA.attr("data-model-type");
	if (jqA.attr("data-model-type") === "task" && jqB.attr("data-model-type") === "list") return 1;
	if (jqA.attr("data-model-type") === "list" && jqB.attr("data-model-type") === "task") return -1;
	return a.s > b.s ? 1 : ( a.s === b.s ? 0 : -1);
    }
};

jq(document).ready(function() {
    Tornado.populate();
});

/**
 * Extend Hash to include clear, isEmpty and size
 **/
(function() { 
    // Clear a hash
    function Hash_clear() { 
	this._object = {}; 
    }

    // Get hash size
    function Hash_size() {
	var size = 0, key, keys = this.keys();
	for (key in keys) {
            if (keys.hasOwnProperty(key)) size++;
	}
	return size;
    }

    // Find out if the hash is empty
    function Hash_isEmpty() {
	var keys = this.keys();
	for (key in keys) {
            if (keys.hasOwnProperty(key)) 
		return false;
	}
	return true;
    }
    
    Hash.prototype.clear = Hash_clear;
    Hash.prototype.size = Hash_size;
    Hash.prototype.isEmpty = Hash_isEmpty;
})(); 

// jQuery plugin to highlight an element
jq.fn.animateHighlight = function(highlightColor, duration) {
    var highlightBg = highlightColor || "#FFFF9C";
    var animateMs = duration || 1500;
    var originalBg = this.css("backgroundColor");
    this.stop().css("background-color", highlightBg).animate({backgroundColor: originalBg}, animateMs);
};

