var Tornado = new function() { return {
	tasks: new Hash(),
	contexts: new Hash(),
	tags: new Hash(),
	lists: new Hash(),
	default: {},
	viewManager: new Tornado.ViewManager(),

	setDefaultTag: function(tag){
		Tornado.default.tag = {};
		Tornado.default.tag.id = tag.id;
		Tornado.default.tag.name = tag.name;
	},

	setDefaultContext: function(context){
		Tornado.default.context = {};
		Tornado.default.context.id = context.id;
		Tornado.default.context.name = context.name;
	},

	setDefaultList: function(list){
		Tornado.default.list = {};
		Tornado.default.list.id = list.id;
		Tornado.default.list.name = list.name;
	},

	getDefaultTag: function() {
		if (Tornado.default.tag){
			return Tornado.default.tag;
		} else {
			return null;
		}
	},

    getDefaultContext: function() {
        if (Tornado.default.context){
            var result = new Array();
            result.push(Tornado.default.context);
            return result;
        } else {
            return null;
        }
    },

    getDefaultList: function() {
        if (Tornado.default.list){
            var result = new Array();
            result.push(Tornado.default.list);
            return result;
        } else {
            return null;
        }
    }
}};
