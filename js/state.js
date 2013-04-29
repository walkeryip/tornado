Tornado.State = Class.create();
Tornado.State.prototype = {
    // Constructor
    initialize: function() {
	this.list = {id: null};
	this.tag = {id: null};
	this.context = {id: null};
	this.user = {id: null};
    },

    // Set the current list
    setList: function(list) {
	this.list = list;
    },

    // Get the current list
    getList: function() {
	return this.list;
    },

    // Set the current tag
    setTag: function(tag) {
	this.tag = tag;
    },

    // Get the current tag
    getTag: function() {
	return this.tag;
    },

    // Set the current context
    setContext: function(context) {
	this.context = context;
    },

    // Get the current context
    getContext: function() {
	return this.context;
    },

    // Set the current user
    setUser: function(user) {
	this.user = user;
    },

    // Get the current user
    getUser: function() {
	return this.user;
    }
};
