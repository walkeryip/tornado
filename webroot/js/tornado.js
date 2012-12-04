Tornado = {
	initialize: function() {
		this.tasks = new Hash();
		this.contexts = new Hash();
		this.tags = new Hash();
		this.lists = new Hash();
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

	setDefaultList: function(list){
		Tornado.defaultModel.list = {};
		Tornado.defaultModel.list.id = list.id;
		Tornado.defaultModel.list.name = list.name;

		this.breadcrumbs = new Tornado.Breadcrumbs(list.id);
	},

	getDefaultTag: function() {
		if (Tornado.defaultModel.tag){
			return Tornado.defaultModel.tag;
		} else {
			return null;
		}
	},

    getDefaultContext: function() {
        if (Tornado.defaultModel.context){
            var result = new Array();
            result.push(Tornado.defaultModel.context);
            return result;
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
	}
};

(function() { 
	function Hash_clear() { 
		this._object = {}; 
	} 

	Hash.prototype.clear = Hash_clear;
})(); 
