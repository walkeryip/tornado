App = Em.Application.create({LOG_TRANSITIONS: true});

App.Store = DS.Store.extend({
    revision: 11,
    adapter: DS.RESTAdapter.create({url: "http://localhost/tornado-php-backend"})
});

App.Task = DS.Model.extend({
    checked: DS.attr("boolean"),
    created: DS.attr("date"),
    deadline: DS.attr("date"),
    energy: DS.attr("number"),
    time: DS.attr("number"),
    deleted: DS.attr("boolean"),
    description: DS.attr("string"),
    name: DS.attr("string"),
    todo: DS.attr("boolean"),
    priority: DS.attr("number"),
    //tags: DS.hasMany("App.Tag"),
    //contexts: DS.hasMany("App.Context"),
    //users: DS.hasMany("App.User")

    taskChanged: function() {
	Ember.run.once(this, function() {
	    this.get("store").commit();
	});
    }.observes('checked')
});

App.TasksController = Ember.ArrayController.extend({
    delete: function(id) {
	var task = App.Task.find(id);
	task.set("deleted", true);
	this.get("store").commit();
    },

    move: function(id, fromList, toList) {
	
    }
});

App.TaskController = Ember.ObjectController.extend({
    editMode: false,
 
    edit: function() {
	this.set('editMode', true);
    },

    save: function() {
	this.get("store").commit();
	this.set('editMode', false);
    }
});

App.Router.map(function(){
    this.resource('tasks');
});

App.TasksRoute = Ember.Route.extend({
    model: function() {
	return App.Task.find({deleted: false, parent_id: "null", checked: false});
    }
});

App.ItemView = Ember.View.extend({
    templateName: 'item',
    toggleChecked: function(e) {
	var item = this.get('model');
    }

});
