Tornado.List = Class.create(Tornado.Item, {
    initialize: function($super, data){
        $super(data);
    },

    getModelUrlName: function(){
        return "task_lists";
    },

    populate: function($super, data){
        $super(data);

        var list = data.TaskList;

        this.id = list.id;
        this.name = list.name;
    },

    getSubmitData: function(compactMode) {
        var data = {"data[TaskList][name]": this.name,
            "data[TaskList][id]": this.id};

        if (compactMode){
            Object.extend(data, {"data[TaskList][tags]": this.getTagsString(),
                "data[TaskList][contexts]": this.getContextsString()});
        } else {
            Object.extend(data, this.getContextsSubmitString());
            Object.extend(data, this.getTagsSubmitString());
            Object.extend(data, this.getListsSubmitString());
        }

        return data;
    }
});
