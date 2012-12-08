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
		if (data.Task !== undefined){
			task = data.Task;
		} else if (data.Tasks[0].Task !== undefined) {
			task = data.Tasks[0].Task;
		}

		this.checked = task.checked;
		this.created = task.created;
		this.deadline = task.deadline;
		this.description = task.description;
		this.id = task.id;
		this.name = task.name;
		this.priority = task.priority;
		this.todo = task.todo;
	},

	getSubmitData: function(compactMode) {
        var data = {"data[Task][name]": this.name,
            "data[Task][created]": this.created,
            "data[Task][id]": this.id,
            "data[Task][description]": this.description,
            "data[Task][deadline]": this.deadline,
            "data[Task][priority]": this.priority};

        if (compactMode){
            Object.extend(data, {"data[Task][tags]": this.tagsString,
                                 "data[Task][contexts]": this.contextsString});
		} else {
            Object.extend(data, {"data[Task][tags]": this.getTagsString(),
                                 "data[Task][contexts]": this.getContextsString()});
		}
        
        Object.extend(data, this.getListsSubmitString());

        return data;
    },

	/*toggle: function(callback) {
		var checkFunction = "check";
		var self = this;

		if (this.checked != "0"){
			checkFunction = "un" + checkFunction;
		}

		jq.ajax({
            type: "post",
            cache: false,
            dataType: 'json',
            url: "/tornado/" + this.getModelUrlName() + "/" + checkFunction + "/" + this.id
        }).done(function (result) {
                if (result){
                    self.populate(result);
					callback();
                }
            });
	},*/


    toggle: function(callback) {var checkFunction = "check";
		if (this.checked != "0"){
			checkFunction = "un" + checkFunction;
		}

		Tornado.viewManager.loadData(	{url: "/tornado/" + this.getModelUrlName() + "/" + checkFunction + "/" + this.id, 
										callback: callback,  
										post: true});
    },

	getClass: function() {
		return Tornado.Task;
	},

	getContainer: function() {
		return Tornado.tasks;
	}
});
