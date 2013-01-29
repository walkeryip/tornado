Tornado.Context = Class.create(Tornado.Item, {
    initialize: function($super, data) {
	$super(data);
	},
    
    getModelName: function(){
        return "context";
    },

    populate: function($super, data) {
	$super(data);
	
	var context = data.Context;
	
	if (context) {
	    this.id = context.id && parseInt(context.id);
	    this.name = Tornado.escapeString(context.name);
	} else {
	    this.name = Tornado.escapeString(data.name);
	}
    },
    
    getSubmitData: function(compactMode) {
        var data = {"data[Context][name]": this.name,
		    "data[Context][id]": this.id};
	
        return data;
    }
});
