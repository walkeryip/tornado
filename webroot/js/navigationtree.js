Tornado.NavigationTree = Class.create();
Tornado.NavigationTree.prototype = {
	initialize: function() {
		this.loaded = false;
		this.error = false;
		this.tree = null;
	},

	populate: function (callback) {
		var self = this;
		this.loading = true;

		jq.ajax({			
		    type: "get",
		  	cache: false,
			dataType: "json",
			error: function(data){
				Tornado.error(data);
				self.error = true;
			}, 
		  	url: "/tornado/task_lists/tree"
		}).done(function (data) {
			if (data){	
				self.loaded = true;
				self.parseTreeData(data);

				if (callback !== undefined) {
					callback(self.tree);
				}
			} 
		});
	},

	parseTreeData: function(data) {
		var tree = {}

		data.each(function(obj) {
			var item = obj["TaskList"];
			tree[item.id] = item;
		});

		this.tree = tree;
	},

	getNavigationTree: function(callback) {
		if (this.error) {
			callback(null);
		} else if (this.loaded) {
			callback(this.tree);
		} else {
			this.populate(callback);
		}
	}
};
