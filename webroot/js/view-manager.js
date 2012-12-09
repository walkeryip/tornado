Tornado.ViewManager = Class.create();
Tornado.ViewManager.prototype = {
	initialize: function() {
		this.views = new Array();
	},
	
	// Add a view to viewmanager
	addView: function(view) {
		this.views.push(view);
		this.loadData({url: view.getAjaxUrl(), callback: function(data) {
			view.dataUpdated(data);
		}});
	},

	/*itemChanged: function(item) {
		this.views.each(function(view){
			view.itemChanged(item);
		});
	},*/

	itemDeleted: function(item) {
		this.views.each(function(view){
			view.itemDeleted(item);
		});
	},

	itemAttributeDeleted: function(item) {
		this.views.each(function(view){
			view.itemAttributeDeleted(item);
		});
	},

	/*itemMoved: function(item) {
		this.views.each(function(view){
			view.itemDeleted(item);
			view.dataUpdated(item);
		});
	},*/

	/*itemAdded: function(item) {
		this.views.each(function(view){
			view.itemAdded(item);
		});
	},*/

	// Called when data is updated
	dataUpdated: function(data) {
		this.views.each(function(view){
			view.dataUpdated(data);
		});
	},

	addItem: function(data) {
		var self = this;
		var item;
		if (data.Task){
			item = new Tornado.Task(data);
		} else if (data.TaskList){
			item = new Tornado.List(data);
		}

		item.create(function(data) {
			self.dataUpdated(data);
		});
		
	},

	populateModels: function(data) {
        var contextModels = this.populateContextModels(data);
        var tagModels = this.populateTagModels(data);
        var userModels = this.populateUserModels(data);
        var taskModels = this.populateTaskModels(data);
        var listModels = this.populateListModels(data);

		return {contexts: contextModels,
				tags: tagModels,
				tasks: taskModels,
				lists: listModels,
				users: userModels};
	},

	//loadData: function(dataURL, callback, data, post) {
	loadData: function(args) {
		var self = this;
		var type = "get";

		if (args === undefined) {
			args = {};
		}

		if (args.post !== undefined && args.post == true){
			type = "post";
		} else {
			type = "get";
		}
		
		jq.ajax({			
            type: type,
		  	cache: false,
			dataType: 'json',
			error: function(data){
				Tornado.error(data);
				
				if (args.error !== undefined) {
					args.error(data);
				}
			}, 
			data: args.data,
		  	url: args.url
		}).done(function (data) {
			if (data && self.containsData(data)){
				var models = self.populateModels(data);

				if (args.callback !== undefined) {
					args.callback(models);
				}
			} else {
				if (args.error !== undefined) {
					args.error(data);
				}
			}
		});
	},

	containsData: function(data){
		return (data.Tags !== undefined && data.Tags.length > 0) || 
				(data.Tasks !== undefined && data.Tasks.length > 0) || 
				(data.TaskLists !== undefined && data.TaskLists.length > 0) || 
				(data.Contexts !== undefined && data.Contexts.length > 0) ||
				(data.ContextsTasks !== undefined && data.ContextsTasks.length > 0) ||
				(data.TagsTasks !== undefined && data.TagsTasks.length > 0) ||
				(data.TaskListsTasks !== undefined && data.TaskListsTasks.length > 0) || 
				(data.ContextsTaskLists !== undefined && data.ContextsTaskLists.length > 0) || 
				(data.TagsTaskLists !== undefined && data.TagsTaskLists.length > 0);
	},

	/* function () {
				Tornado.viewManager.itemDeleted(self.model);
				self.deleteModel();
			}*/

	populateListModels: function(data) {
		var lists = Array();
		var self = this;
		
		var listsData = data.TaskLists;
		if (listsData !== undefined){
		    listsData.each(function(listData) {
		        var list = Tornado.lists.get(listData.TaskList.id);

				if (listData !== undefined && listData.TaskList.deleted) {
					self.itemDeleted(list);
				} else {
				    if (!list) {
				        list = new Tornado.List(listData);
				        Tornado.lists.set(list.id, list);
				    } else {
						list.populate(listData);
					}
				
					lists.push(list);
				}
		    });
		}
		
		var contextsLists = data.ContextsTaskLists;
		if (contextsLists !== undefined){
			contextsLists.each(function(contextListData) {
				var contextList = contextListData.ContextTaskList;
			
				if (contextListData !== undefined && contextListData.ContextTaskList.deleted) {
					//self.itemDeleted(list);
					// TODO: REMOVE RELATION
				} else {
					var list = Tornado.lists.get(contextList.task_list_id);
					var context = Tornado.contexts.get(contextList.context_id);
					if (list !== undefined && context !== undefined){
						list.contexts.set(contextList.context_id, context); 
					}
				}
			});
		}

		var tagsLists = data.TagsTaskLists;
		if (tagsLists !== undefined){
			tagsLists.each(function(tagListData) {
				var tagList = tagListData.TagTaskList;

				if (tagListData !== undefined && tagListData.TagTaskList.deleted) {
					//self.itemDeleted(list);
					// TODO: REMOVE RELATION
				} else {
					var list = Tornado.lists.get(tagList.task_list_id);
					var tag = Tornado.tags.get(tagList.tag_id);
					if (list !== undefined && tag !== undefined){
						list.tags.set(tagList.tag_id, tag); 
					}
				}
			});
		}

		var listsTasks = data.TaskListsTasks;
		if (listsTasks !== undefined){
			listsTasks.each(function(taskListData) {
				var listTask = taskListData.TaskListTask;

				if (taskListData !== undefined && taskListData.TaskListTask.deleted) {
					var list = Tornado.lists.get(listTask.task_list_id);
					var task = Tornado.tasks.get(listTask.task_id);
					list.tasks.unset(task.id);
					task.parent = null;
				} else {
					var list = Tornado.lists.get(listTask.task_list_id);
					var task = Tornado.tasks.get(listTask.task_id);
					if (list !== undefined && task !== undefined){
						list.tasks.set(listTask.task_id, task); 
						task.parent = list;
					}
				}
			});
		}

		var listsUsers = data.TaskListsUsers;
		if (listsUsers !== undefined){
			listsUsers.each(function(listUserData) {
				var listUser = listUserData.TaskListUser;

				if (listUserData !== undefined && listUserData.TaskListUser.deleted) {
					//self.itemDeleted(list);
					// TODO: REMOVE RELATION
				} else {
					var list = Tornado.lists.get(listUser.task_list_id);
					var user = Tornado.users.get(listUser.user_id);
					if (list !== undefined && user !== undefined){
						list.users.set(listUser.user_id, user); 
					}
				}
			});
		}
		
		return lists;
    },

	populateTaskModels: function(data) {
		var tasks = Array();
		var self = this;

		var tasksData = data.Tasks;
		if (tasksData !== undefined){
			tasksData.each(function(taskData) {
				var task = Tornado.tasks.get(taskData.Task.id);

				if (task !== undefined && taskData.Task.deleted) {
					self.itemDeleted(task);
					Tornado.tasks.unset(task.id);
				} else {
					if (!task) {
						task = new Tornado.Task(taskData);
						Tornado.tasks.set(task.id, task);	
					} else {
						task.populate(taskData);
					}

					tasks.push(task);	
				}
	
			});
		}

		var contextsTasks = data.ContextsTasks;
		if (contextsTasks !== undefined){
			contextsTasks.each(function(contextTaskData) {
				var contextTask = contextTaskData.ContextTask;

				if (contextTask !== undefined && contextTask.deleted) {
					//self.itemDeleted(list);
					// TODO: REMOVE RELATION
				} else {
					var task = Tornado.tasks.get(contextTask.task_id);
					var context = Tornado.contexts.get(contextTask.context_id);
					if (task !== undefined && context !== undefined){
						task.contexts.set(contextTask.context_id, context);
					} 
				}
			});
		}

		var tagsTasks = data.TagsTasks;
		if (tagsTasks !== undefined){
			tagsTasks.each(function(tagTaskData) {
				var tagTask = tagTaskData.TagTask;

				if (tagTask !== undefined && tagTask.deleted) {
					//self.itemDeleted(list);
					// TODO: REMOVE RELATION
				} else {
					var task = Tornado.tasks.get(tagTask.task_id);
					var tag = Tornado.tags.get(tagTask.tag_id);
					if (task !== undefined && tag !== undefined){
						task.tags.set(tagTask.tag_id, tag); 
					}
				}
			});
		}

		var tasksUsers = data.TasksUsers;
		if (tasksUsers !== undefined){
			tasksUsers.each(function(taskUserData) {
				var taskUser = taskUserData.TaskUser;

				if (taskUser !== undefined && taskUser.deleted) {
					//self.itemDeleted(list);
					// TODO: REMOVE RELATION
				} else {
					var task = Tornado.tasks.get(taskUser.task_id);
					var user = Tornado.users.get(taskUser.user_id);
					if (task !== undefined && user !== undefined){
						task.users.set(taskUser.user_id, user); 
					}
				}
			});
		}

		return tasks;
	},

	populateTagModels: function(data) {
		var tags = Array();
		var self = this;

		var tagsData = data.Tags;
		if (tagsData !== undefined){
			tagsData.each(function(tagData) {
				var tag = Tornado.tags.get(tagData.Tag.id);

				if (tagData !== undefined && tagData.Tag.deleted) {
					self.itemAttributeDeleted(tag);
				} else {
					if (!tag) {
						tag = new Tornado.Tag(tagData);
						Tornado.tags.set(tag.id, tag);			
					} else {
						tag.populate(tagData);
					}

					tags.push(tag);
				}
			});
		}

		return tags;
	},

	populateContextModels: function(data) {
		var contexts = Array();
		var self = this;

		var contextsData = data.Contexts;
		if (contextsData !== undefined){
			contextsData.each(function(contextData) {
				var context = Tornado.contexts.get(contextData.Context.id);

				if (contextData !== undefined && contextData.Context.deleted) {
					self.itemAttributeDeleted(context);
				} else {
					if (!context) {
						context = new Tornado.Context(contextData);
						Tornado.contexts.set(context.id, context);
					} else {
						context.populate(contextData);
					}

					contexts.push(context);			
				}
			});
		}

		return contexts;
	},

	populateUserModels: function(data) {
		var users = Array();

		var usersData = data.Users;
		if (usersData !== undefined){
			usersData.each(function(userData) {
				var user = Tornado.users.get(userData.User.id);

				if (user !== undefined && user.deleted) {
					self.itemAttributeDeleted(user);
					//context.deleteModel();	
				} else {
					if (!user) {
						user = new Tornado.User(userData);
						Tornado.users.set(user.id, user);
					} else {
						user.populate(userData);
					}

					users.push(user);			
				}
			});
		}

		return users;
	}
};
