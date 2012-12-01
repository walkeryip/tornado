var Tornado = new function() { return {
	tasks: new Hash(),
	contexts: new Hash(),
	tags: new Hash(),
	lists: new Hash(),
	defaultModel: {},
	viewManager: new Tornado.ViewManager(),

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
		return Tornado.defaultModel.list.id;
	},

	error: function(data) {
		jq.modal("<div id=\"error\">" + data.responseText + "</div>");
	}
}};

(function() { 
	function Hash_clear() { 
		this._object = {}; 
	} 

	Hash.prototype.clear = Hash_clear;
})(); 
