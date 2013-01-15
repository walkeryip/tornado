Tornado.User = Class.create(Tornado.Item, {
    initialize: function($super, data) {
	$super(data);
    },
    
    getModelName: function(){
        return "user";
    },
    
    populate: function($super, data) {
        $super(data);
	
	var user = data.User;
	
	if (user) {
	    this.id = user.id;
	    this.name = user.name;
	} else {
	    this.name = data.name;
	}	
    }
});
