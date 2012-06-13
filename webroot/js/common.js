// TODO: split into separate files
// TODO: support for adding tasks through javascript
// TODO: view sorting and filtering
// TODO: move functions and attributes up to abstract classes
// TODO: namespacing
// TODO: add buttons for every view
// TODO: sorting

Tornado = {};

var expandableDivButtonClick = function (element) {
	$(element).next("div").toggle();

	return false;
};

var modalDivButtonClick = function (element) {
	jq(element).next("div").modal();
};

var deleteModel = function (id, model, name){
	jq("#message-confirm-box p").text("Are you sure you want to delete " + name + "?");
	jq("#message-confirm-box .yes").click(function () {
		jq(location).attr('href',"/tornado/" + model + "/delete/" + id);
	});
	jq("#message-confirm-box .no").click(function () {
		jq.modal.close();
	});
	jq("#message-confirm-box").modal();
};

var deleteTask = function (id, name) {
	deleteModel(id, "task", name);
};

var deleteList = function (id, name) {
	deleteModel(id, "task_lists", name);
};

jq(document).ready(function () {
    var self = this;
	var container = jq("#inputbar");
	var button = container.find("button");
	var inputbar = container.find("input");

    inputbar.keypress(function(e){
        if(e.which == 13){
            submit();
            return false;
        }
    });

	button.click(function() {
        submit();
        return false;
	});

    var submit = function() {
        var text = inputbar.val();

        var data = {};
        data.Task = {}

        data.Task.name = text;
        data.Context = Tornado.getDefaultContext();
        data.List = Tornado.getDefaultList();
        data.Tag = Tornado.getDefaultTag();

        Tornado.viewManager.addItem(data);

        inputbar.val("");
    }
});
