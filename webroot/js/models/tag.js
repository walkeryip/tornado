Tornado.Tag = Class.create(Tornado.Item, {
    initialize: function($super, data) {
	$super(data);
    },
    
    getModelName: function(){
        return "tag";
    },
    
    populate: function($super, data) {
        $super(data);
	
	var tag = data.Tag;
	
	if (tag) {
	    this.id = tag.id && parseInt(tag.id);
	    this.name = Tornado.escapeString(tag.name) || "";
	} else {
	    this.name = Tornado.escapeString(data.name) || "";
	}
    },
    
    getSubmitData: function(compactMode) {
        var data = {"data[Tag][name]": this.name,
		    "data[Tag][id]": this.id};
	
        return data;
    }
});
