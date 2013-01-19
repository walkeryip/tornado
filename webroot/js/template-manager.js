Tornado.TemplateManager = Class.create();
Tornado.TemplateManager.prototype = {
    initialize: function() {
	this.elementContainer = Mustache.compile('<tr data-model-type="{{model}}" data-model-id="{{id}}">{{body}}</tr>');
	this.elementView = Mustache.compile(
	    [  '<td class=\"handle\"><p></p></td>',
               '<td class=\"checkbox\">{{#checkbox}}<input type=\"checkbox\" {{#checked}}checked=\"yes\" {{/checked}}/>{{/checkbox}}</td>',
	       '<td>',
  	         '{{#link}}<a href="/tornado/{{model}}s/view/{{id}}">{{/link}}',
	         '<span class="item {{model}}">{{name}}</span>',
	         '{{#tags}}<span class="label tag"><a href="/tornado/tags/view/{{id}}">{{name}}</a></span>{{/tags}}',
	         '{{#contexts}}<span class="label context"><a href="/tornado/contexts/view/{{id}}">{{name}}</a></span>{{/contexts}}',
	         '{{#users}}<span class="label user"><a href="/tornado/users/view/{{id}}">{{name}}</a></span>{{/users}}',
	         '{{#link}}</a>{{/link}}',
	       '</td>',
  	       '<td class="settings">',
	         '<a href="#" data-toggle="dropdown" role="button" class="dropdown-toggle" id="{{model}}-{{id}}-button"><i class="icon-wrench"></i></a>',
	         '<ul class="dropdown-menu" role="menu" aria-labelledby="{{model}}-{{id}}-button">',
	           '<li><a class="delete" href="#">Delete</a></li>',
	           '<li><a class="edit" href="#">Edit</a></li>',
	         '</ul>',
	       '</td>'].join(''));

	this.elementEditView = Mustache.compile(
	    ['<td colspan="4">',
	     '<p><label>Name:</label></p><input type="text" value="{{name}}" name="name" />',
	     '<p><label>Tags:</label></p><input type="text" value="{{tags}}" name="tags" />',
	     '<p><label>Contexts:</label></p><input type="text" value="{{contexts}}" name="contexts" />',
	     '<p><label>Users:</label></p><input type="text" value="{{users}}" name="users" />',
	     '<p><label>Description:</label></p><textarea name=\"description\">{{description}}</textarea>',
	     '<button class="save">Save</button><button class="cancel">Cancel</button>',
	     '</td>'].join(''));

    }
};