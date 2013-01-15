Tornado.List = Class.create(Tornado.Item, {
    initialize: function($super, data){
        $super(data);
    },

    getModelName: function(){
        return "list";
    },
    
    populate: function($super, data){
        $super(data);
	
        var list = data.List;
	
        this.id = list.id;
	this.description = escapeString(list.description);
        this.name = escapeString(list.name);
	this.parent_id = list.parent_id;
    },
    
    getSubmitData: function(compactMode) {
        var data = {"data[List][name]": this.name,
		    "data[List][id]": this.id,
		    "data[List][description]": this.description};
	
        if (compactMode){
            Object.extend(data, {"data[List][tags]": this.tagsString,
                                 "data[List][contexts]": this.contextsString,
                                 "data[List][users]": this.usersString});
	} else {
            Object.extend(data, {"data[List][tags]": this.getTagsString(),
                                 "data[List][contexts]": this.getContextsString(),
                                 "data[List][users]": this.getUsersString()});
	}
	
	if (this.parent_id !== null) {
	    Object.extend(data, {"data[List][parent_id]": this.parent_id});
	}
	
        return data;
    }
});
