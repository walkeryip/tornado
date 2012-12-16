Tornado = {
	initialize: function() {
		this.tasks = new Hash();
		this.contexts = new Hash();
		this.tags = new Hash();
		this.lists = new Hash();
		this.users = new Hash();

		this.defaultModel = {};

		this.navigationTree = new Tornado.NavigationTree();
		this.viewManager = new Tornado.ViewManager();
	},

	setDefaultTag: function(tag){
		Tornado.defaultModel.tag = {};
		Tornado.defaultModel.tag.id = tag.id;
		Tornado.defaultModel.tag.name = tag.name;
	},

	setDefaultContext: function(context){
		Tornado.defaultModel.context = {};
		Tornado.defaultModel.context.id = context.id;
		Tornado.defaultModel.context.name = context.name;
	},

	setDefaultUser: function(user){
		Tornado.defaultModel.user = {};
		Tornado.defaultModel.user.id = user.id;
	},

	setDefaultList: function(list){
		Tornado.defaultModel.list = {};
		Tornado.defaultModel.list.id = list.id;
		Tornado.defaultModel.list.name = list.name;

		this.breadcrumbs = new Tornado.Breadcrumbs(list.id, "#breadcrumbs");
	},

	getDefaultTag: function() {
		if (Tornado.defaultModel.tag){
			return Tornado.defaultModel.tag;
		} else {
			return null;
		}
	},

	getDefaultUser: function() {
		if (Tornado.defaultModel.user){
			return Tornado.defaultModel.user;
		} else {
			return null;
		}
	},

    getDefaultContext: function() {
        if (Tornado.defaultModel.context){
            return Tornado.defaultModel.context;
        } else {
            return null;
        }
    },

    getDefaultList: function() {
        if (Tornado.defaultModel.list){
            var result = new Array();
            result.push(Tornado.defaultModel.list);
            return result;
        } else {
            return null;
        }
    },

	getDefaultListId: function() {
		return Tornado.defaultModel.list !== undefined ? Tornado.defaultModel.list.id : null;
	},

	error: function(data) {
		jq.modal("<div id=\"error\">" + data.responseText + "</div>");
	},

	listDropFunction: function(event, ui) {
		//event.revert = false;
		var item = ui.draggable[0].model;
		var destId = jq(this).attr("data-id");
		if (item.id !== destId) {
			item.move(destId, 
				function (data) {
					Tornado.viewManager.dataUpdated(data);
				},
				function () {
					ui.draggable.draggable('option','revert',true);
				});    		
		} else {
			ui.draggable.draggable('option','revert',true);
		}
    }
};

(function() { 
	function Hash_clear() { 
		this._object = {}; 
	} 

	Hash.prototype.clear = Hash_clear;
})(); 
