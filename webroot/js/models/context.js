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
	    this.id = context.id;
	    this.name = escapeString(context.name);
	} else {
	    this.name = escapeString(data.name);
	}
    },
    
    getSubmitData: function(compactMode) {
        var data = {"data[Context][name]": this.name,
		    "data[Context][id]": this.id};
	
        return data;
    }
});
