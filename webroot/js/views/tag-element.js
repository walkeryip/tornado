Tornado.TagElement = Class.create(Tornado.Element, {
    initialize: function($super, tag){		
	$super(tag);		
    },
    
    getBody: function() {
	return "<a href=\"/tornado/tags/view/" + this.model.id + "\">" + this.model.name + "</span>";
    },
    
    getInfoBoxContent: function() {
	return "<p>" + this.model.created + "</p>";
    }	
});
