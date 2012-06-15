Tornado.Task = Class.create(Tornado.Item, {
	initialize: function($super, data) {
		$super(data);
		this.populate(data);
	},

	populate: function (data) {
		var self = this;
	
		if (data.Context){
			data.Context.each(function(contextData){
				self.fetchContext(contextData);
			});
		}

        if (data.Tag){
            data.Tag.each(function(tagData){
                self.fetchTag(tagData);
            });
        }

        if (data.List){
            data.List.each(function(listData){
                self.fetchList(listData);
            });
        }

		this.parents = data.TaskList;

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

	delete: function(callback) {
		var task = this;

		jq.ajax({
			cache: false,
			dataType: 'json',
			url: "/tornado/tasks/delete/" + this.id
		}).done(function (data) {
			if (data){
				callback();				
				//task.remove();
			}
		});
	},

    getObjectSubmitString: function(name, data, taskId){
        var result = {};

        if (data){
            data.each(function(item, index){
                var hashString = "data[" + name + "]";
                result[hashString + "[id]"] = item.id;
                //result[hashString + "[name]"] = item.name;
            });
        }
        return result;
    },

    getContextsSubmitString: function(data, taskId){
        return this.getObjectSubmitString("Context", data, taskId);
    },

    getTagsSubmitString: function(data, taskId){
        return this.getObjectSubmitString("Tag", data, taskId);
    },

    getListsSubmitString: function(data, taskId){
        return this.getObjectSubmitString("TaskList", data, taskId);
    },

	create: function(callback) {
		var self = this;
		var data = {"data[Task][name]": self.name,
				   "data[Task][created]": self.created,
				   "data[Task][id]": self.id,
				   "data[Task][description]": self.description,
				   "data[Task][deadline]": self.deadline,
				   "data[Task][priority]": self.priority,
                   "data[Task][tags]": self.getTagsString(),
                   "data[Task][contexts]": self.getContextsString()};
        Object.extend(data, self.getContextsSubmitString(self.contexts, self.id));
        Object.extend(data, self.getTagsSubmitString(self.tags, self.id));
        Object.extend(data, self.getListsSubmitString(self.lists, self.id));

        jq.ajax({
			type: "post",
			cache: false,
			dataType: 'json',
			url: "/tornado/tasks/add/",
			data: data
		}).done(function (result) {
			if (result){
				self.populate(result);
				callback();
			}
		});
	},

	save: function(callback) {
		var self = this;

		jq.ajax({
			type: "post",
			cache: false,
			dataType: 'json',
			url: "/tornado/tasks/edit/" + self.id,
			data: {"data[Task][name]": self.name,
				   "data[Task][created]": self.created,
				   "data[Task][id]": self.id,
				   "data[Task][description]": self.description,
				   "data[Task][deadline]": self.deadline,
				   "data[Task][priority]": self.priority,
				   "data[Task][tags]": self.getTagsString(),
				   "data[Task][contexts]": self.getContextsString()}
		}).done(function (result) {
			if (result){
				self.populate(result);
				callback();
			}
		});
	}
});
