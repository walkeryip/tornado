Tornado.User = Class.create(Tornado.Item, {
	initialize: function($super, data) {
		$super(data);
	},

    getModelName: function(){
        return "user";
    },

	populate: function($super, data) {
        $super(data);

		var user;
		if (data.User !== undefined){
			user = data.User;
		} else if (data.Users[0].User !== undefined) {
			user = data.Users[0].User;
		}

		this.name = user.name;
		this.id = user.id;
	},

	getSubmitData: function(compactMode) {
       /* var data = {"data[Task][name]": this.name,
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

        return data;*/
    },

	getClass: function() {
		return Tornado.User;
	},

	getContainer: function() {
		return Tornado.users;
	}
});
