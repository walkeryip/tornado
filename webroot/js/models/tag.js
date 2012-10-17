Tornado.Tag = Class.create(Tornado.Label, {
	initialize: function($super, data) {
		$super(data);
	},

    getModelUrlName: function(){
        return "tags";
    },

	populate: function($super, data) {
        $super(data);

		var tag = data.Tag;

		if (tag) {
			this.id = tag.id;
			this.name = tag.name;
		} else {
			this.name = data.name;
		}
	},
	
	remove: function(callback) {
        jq.ajax({
            cache: false,
            dataType: 'json',
            url: "/tornado/" + this.getModelUrlName() + "/delete/" + this.id
        }).done(function (data) {
                if (data){
                    callback();
                }
            });
    }
});
