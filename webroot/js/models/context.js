Tornado.Context = Class.create(Tornado.Label, {
	initialize: function($super, data) {
		$super(data);
	},

    getModelUrlName: function(){
        return "contexts";
    },

	populate: function($super, data) {
        $super(data);

		var context = data.Context;

		if (context) {
			this.id = context.id;
			this.name = context.name;
		} else {
			this.name = data.name;
		}
	}
});
