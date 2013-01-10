Tornado.List = Class.create(Tornado.Item, {
    initialize: function($super, data){
        $super(data);
    },

    getModelName: function(){
        return "task_list";
    },

    populate: function($super, data){
        $super(data);

        var list = data.TaskList;

        this.id = list.id;
	this.description = escapeString(list.description);
        this.name = escapeString(list.name);
		this.parent_id = list.parent_id;
    },

    getSubmitData: function(compactMode) {
        var data = {"data[TaskList][name]": this.name,
            "data[TaskList][id]": this.id,
			"data[TaskList][description]": this.description};

        if (compactMode){
            Object.extend(data, {"data[TaskList][tags]": this.tagsString,
                                 "data[TaskList][contexts]": this.contextsString,
                                 "data[TaskList][users]": this.usersString});
		} else {
            Object.extend(data, {"data[TaskList][tags]": this.getTagsString(),
                                 "data[TaskList][contexts]": this.getContextsString(),
                                 "data[TaskList][users]": this.getUsersString()});
		}

		if (this.parent_id !== null) {
			Object.extend(data, {"data[TaskList][parent_id]": this.parent_id});
		}

        return data;
    },

	getClass: function() {
		return Tornado.List;
	},

	getContainer: function() {
		return Tornado.lists;
	}
});
