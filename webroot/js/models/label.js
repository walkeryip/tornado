Tornado.Label = Class.create();
Tornado.Label.prototype = {
	initialize: function(data) {
		this.populate(data);
	},

	populate: function(data) {
		this.name = data.name;
		this.id = data.id;
		this.created = data.created;
	},


};

Tornado.Label.arrayToLabelString = function(data) {
		var result = "";
		var first = true;

		data.each(function(item){
			if (!first){
				result += ", ";
			} else {
				first = false;
			}

			result += item.value.name;
		});

		return result;
	};
