Tornado.List = Class.create(Tornado.Item, {
    initialize: function($super, data){
        $super(data);
    },

    getModelName: function(){
        return "list";
    },
    
    populate: function($super, data){
        $super(data);
	
        var list;
	if (data.List) {
	    list = data.List;
	} else if (data.Lists) {
	    list = data.Lists[0].List;
	} else {
	    list = data;
	}

        this.id = list.id && parseInt(list.id);
	this.active = list.active === "1";
	this.description = Tornado.escapeString(list.description);
	this.deleted = list.deleted === "1";
        this.name = Tornado.escapeString(list.name);
	this.parent_id = list.parent_id && parseInt(list.parent_id);
    },
    
    getSubmitData: function(compactMode) {
        var data = {"data[List][name]": this.name,
		    "data[List][id]": this.id,
		    "data[List][active]": this.active,
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
    },
    
    setActive: function(active, callback) {
	var activateFunction = "activate";
	if (!active){
	    activateFunction = "de" + activateFunction;
	}
	
	Tornado.panelManager.loadData(	{url: "/tornado/" + this.getModelUrlName() + "/" + activateFunction + "/" + this.id, 
					 callback: callback, 
					 post: true});
    }
});
