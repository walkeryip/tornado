Tornado.Task = Class.create(Tornado.Item, {
    initialize: function($super, data) {
	$super(data);
    },
    
    getModelName: function(){
        return "task";
    },

    populate: function($super, data) {
        $super(data);

	var task;
	if (data.Task){
	    task = data.Task;
	} else if (data.Tasks[0].Task) {
	    task = data.Tasks[0].Task;
	}
	
	this.checked = task.checked === "1";
	this.created = task.created;
	this.deadline = task.deadline === "0000-00-00" ? null : task.deadline;
	this.energy = task.energy;
	this.time = task.time;
	this.deleted = task.deleted === "1";
	this.description = Tornado.escapeString(task.description);

	if (this.description) this.description.replace(/\n/g,"<br />");

	this.id = task.id && parseInt(task.id);
	this.name = Tornado.escapeString(task.name);
	this.priority = task.priority;
	this.todo = task.todo;
    },

    getSubmitData: function(compactMode) {
        var data = {"data[Task][name]": this.name,
		    "data[Task][created]": this.created,
		    "data[Task][id]": this.id,
		    "data[Task][description]": this.description,
		    "data[Task][deadline]": this.deadline,
		    "data[Task][time]": this.time,
		    "data[Task][energy]": this.energy,
		    "data[Task][priority]": this.priority};
	
        if (compactMode){
            Object.extend(data, {"data[Task][tags]": this.tagsString,
                                 "data[Task][contexts]": this.contextsString,
                                 "data[Task][users]": this.usersString});
	} else {
            Object.extend(data, {"data[Task][tags]": this.getTagsString(),
                                 "data[Task][contexts]": this.getContextsString(),
                                 "data[Task][users]": this.getUsersString()});
	}
        
        Object.extend(data, this.getListsSubmitString());
	
        return data;
    },
    
    toggle: function(callback) {
	var checkFunction = "check";
	if (this.checked != "0"){
	    checkFunction = "un" + checkFunction;
	}
	
	Tornado.panelManager.loadData(	{url: "/tornado/" + this.getModelUrlName() + "/" + checkFunction + "/" + this.id, 
					 callback: callback,  
					 post: true});
    }
});
