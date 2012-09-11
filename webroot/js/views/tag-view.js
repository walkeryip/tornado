Tornado.TagView = Class.create(Tornado.MixedView, {
    initialize: function($super, id, name, containerId){
        $super(id, name, containerId);
    },

    getAjaxUrl: function() {
        return "/tornado/tags/view/" + this.id;
    }
});
