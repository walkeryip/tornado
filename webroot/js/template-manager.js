Tornado.TemplateManager = Class.create();
Tornado.TemplateManager.prototype = {
    initialize: function() {
	this.tableSorter = Mustache.compile(['<div class="sorter">',
					       '<a href="#" data-toggle="dropdown" role="button" class="dropdown-toggle">O</a>',
					       '<ul class="dropdown-menu" role="menu">',
					         '<li class="dropdown-submenu">',
					           '<a href="#" tabindex="-1">Sort</a>',
					           '<ul class="dropdown-menu" role="menu">',
					             '<li><a href="#" tabindex="-1">Sort by</a></li>',
					             '<li class="divider"></li>',
					             '<li><a href="#" class="sortByName">Name</a></li>',
					             '<li><a href="#" class="sortByDeadline">Deadline</a></li>',
					             '<li><a href="#" class="sortByPriority">Priority</a></li>',
					             '<li><a href="#" class="sortByEnergy">Energy</a></li>',
					             '<li><a href="#" class="sortByTime">Time</a></li>',
					             '<li><a href="#" class="sortByCreated">Created</a></li>',
					           '</ul>',
					         '</li>',
					       '</ul>',
					     '</div>'].join(''));
					    
	this.elementContainer = Mustache.compile('<tr data-model-type="{{model}}" data-model-id="{{id}}" data-toggle="context" data-target="#context-menu">{{body}}</tr>');
	this.elementView = Mustache.compile(
	    [/*'<td class=\"handle\"><p></p></td>',*/
             '<td class=\"checkbox\">{{#hasCheckbox}}<input type=\"checkbox\" {{#checked}}checked=\"yes\" {{/checked}}/>{{/hasCheckbox}}</td>',
	     '<td>',
  	       '{{#link}}<a href="/tornado/{{model}}s/view/{{id}}">{{/link}}',
	       '<span class="item {{model}}">{{name}}</span>',
	       '{{#link}}</a>{{/link}}',
	       '{{#tags}}<span class="label tag"><a href="/tornado/tags/view/{{id}}">{{name}}</a></span>{{/tags}}',
	       '{{#contexts}}<span class="label context"><a href="/tornado/contexts/view/{{id}}">{{name}}</a></span>{{/contexts}}',
	       '{{#users}}<span class="label user"><a href="/tornado/users/view/{{id}}">{{name}}</a></span>{{/users}}',
	       '{{#hasDeadline}}<span class="badge deadline">{{deadline}}</span>{{/hasDeadline}}',
	       '{{#hasEnergy}}<span class="badge energy">{{energy}}</span>{{/hasEnergy}}',
	       '{{#hasTime}}<span class="badge time">{{time}}</span>{{/hasTime}}',
	       '{{#hasPriority}}<span class="badge priority">{{priority}}</span>{{/hasPriority}}',
	     '</td>',
  	     '<td class="settings">',
	       '<a href="#" data-toggle="dropdown" role="button" class="dropdown-toggle" id="{{model}}-{{id}}-button"><i class="icon-wrench"></i></a>',
	       '<ul class="dropdown-menu" role="menu" aria-labelledby="{{model}}-{{id}}-button">',
	         '<li><a class="delete" href="#">Delete</a></li>',
	         '<li><a class="edit" href="#">Edit</a></li>',
	     '<li class="dropdown-submenu"><a class="move" href="#">Move</a>',
	     '</li>',
	       '</ul>',
	     '</td>'].join(''));
	this.elementEditView = Mustache.compile(
	    ['<td colspan="3">',
	       '<p><label>Name:</label></p><input type="text" value="{{name}}" name="name" />',
	       '{{#hasTags}}<p><label>Tags:</label></p><input type="text" value="{{tags}}" name="tags" />{{/hasTags}}',
	       '{{#hasContexts}}<p><label>Contexts:</label></p><input type="text" value="{{contexts}}" name="contexts" />{{/hasContexts}}',
	       '{{#hasUsers}}<p><label>Users:</label></p><input type="text" value="{{users}}" name="users" />{{/hasUsers}}',
	       '{{#hasDescription}}<p><label>Description:</label></p><textarea name=\"description\">{{description}}</textarea>{{/hasDescription}}',
	       '{{#hasDeadline}}<p><label>Deadline:</label></p><input type="text" value="{{deadline}}" name="deadline" />{{/hasDeadline}}',
	       '{{#hasEnergy}}<p><label>Energy:</label></p><input type="text" value="{{energy}}" name="energy" />{{/hasEnergy}}',
	       '{{#hasTime}}<p><label>Time:</label></p><input type="text" value="{{time}}" name="time" />{{/hasTime}}',
	       '{{#hasPriority}}<p><label>Priority:</label></p><input type="text" value="{{priority}}" name="priority" />{{/hasPriority}}',
	       '{{#hasActive}}<p><label>Active:{{active}}</label><input type="checkbox" {{#active}}checked="yes" {{/active}} name="active"/>{{/hasActive}}',
	       '<button class="save">Save</button><button class="cancel">Cancel</button>',
	     '</td>'].join(''));
	this.breadcrumbs = Mustache.compile(
	    ['<ul class="breadcrumb">',
	       '{{#links}}<li{{#current}} class="active"{{/current}} data-id="{{id}}">{{#link}}',
	         '<a href=\"/tornado/task_lists/{{#id}}view/{{id}}{{/id}}\">{{name}}</a>',
	         '<span class="divider">/</span>{{/link}}{{#current}}{{name}}{{/current}}</li>',
	       '{{/links}}',
	     '</ul>'].join(''));
	this.error = Mustache.compile('<div id="error">{{{message}}}</div>');
	this.navigationTreeItem = Mustache.compile('<li><a href="/tornado/task_lists/view/{{id}}">{{name}}</a></li>');
	this.navigationTreeContainer = '<ul id="tree-view" class="dropdown-menu"></ul>';
	this.panelHeader = Mustache.compile(['<h2>{{title}}</h2><p class="description">{{description}}</p>'].join(''));
	this.panelContainer = Mustache.compile('<div class="panel-table"><table class="table table-hover {{model}}s"></table></div>');

	this.logedOutMessage = 'You have been logged out. Click <a href="/tornado/">here</a> to log in.';
    }
};