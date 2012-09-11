Tornado.Task = Class.create(Tornado.Item, {
	initialize: function($super, data) {
		$super(data);
	},

    getModelUrlName: function(){
        return "tasks";
    },

	populate: function($super, data) {
        $super(data);

		var task = data.Task;

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
            Object.extend(data, {"data[Task][tags]": this.getTagsString(),
                                 "data[Task][contexts]": this.getContextsString()});
        } else {
            Object.extend(data, this.getContextsSubmitString());
            Object.extend(data, this.getTagsSubmitString());
            Object.extend(data, this.getListsSubmitString());
        }

        return data;
    }
});
