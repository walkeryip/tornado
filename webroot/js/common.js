// TODO: split into separate files
// TODO: support for adding tasks through javascript
// TODO: view sorting and filtering
// TODO: move functions and attributes up to abstract classes
// TODO: namespacing
// TODO: add buttons for every view
// TODO: sorting

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
    inputbar.focus();

	var inputMode = new Array();
	inputMode[0] = "task";
	inputMode[1] = "list";

	var inputModeIndex = 0;

	inputbar.change(function(e){
	});

	var changeInputBarIndex = function(index){
		if (index >= inputMode.length){
			index = 0;
		} else if (index < 0){
			index = inputMode.length - 1;
		}
		container.find("span").text(inputMode[index]);	

		inputModeIndex = index;
	}

    inputbar.keydown(function(e){
        if(e.keyCode == 13){
            submit();
            return false;
        } else if (e.keyCode == 40) { 
			changeInputBarIndex(++inputModeIndex);
       		return false;
    	} else if (e.keyCode == 38) {
			changeInputBarIndex(--inputModeIndex);
			return false;	
		} else {
			
			/*if (!inputbar.initialized) {
				inputbar.val(inputbar.val() + " @test #dator");
					
				inputbar.initialized = true;
			}*/
		}
    });

	button.click(function() {
        submit();
        return false;
	});

	var modelify = function(list, name) {
		var result = new Array();

		if (list !== null) {
		list.each(function(item){
			var n = new Array();
			n[name] = item;
			result.push(n);
		});	
		}

		return result;
	}

    var submit = function() {
        var text = inputbar.val();

        var data = {};

		var inputMode = jq("#inputbar").find("span").text();

		var tagKeywordObject = extractKeywords(text, "#");
		var contextKeywordObject = extractKeywords(tagKeywordObject.text, "@");

		if (inputMode === "task"){		
		    data.Task = {}
		    data.Task.name = contextKeywordObject.text;
		} else if (inputMode === "list"){
			data.TaskList = {};
			data.TaskList.name = contextKeywordObject.text;
			data.TaskList.parent_id = Tornado.getDefaultListId();
		}

	    data.Contexts = modelify(contextKeywordObject.keywords, "Context"); 
	    data.TaskLists = modelify(Tornado.getDefaultList(), "TaskList");
	    data.Tags = modelify(tagKeywordObject.keywords, "Tag");

        Tornado.viewManager.addItem(data);

        inputbar.val("");
    }

});

var printTree = function(trees, treeChildren, node, object) {
	var list = jq("<ul></ul>");
	for (i in node) {
		var listItem = jq("<li><span>" + node[i].name + "</span></li>");
		listItem.attr("data-id",node[i].id);

		var children = treeChildren[node[i].id];
		if (children !== undefined) {
			listItem.append(printTree(trees, treeChildren, children));
		}

		list.append(listItem);
	}
	return list;
}

/*var getNavigationTree2 = function(data, listId) {
	var trees = {};
	var treeParents = {};

	data.each(function(obj) {
		var item = obj["TaskList"];
		var parent_id = item.parent_id == null ? "root" : item.parent_id;
		var parents = treeParents[item.id];
 
		trees[item.id] = item;

		if (parents == undefined) {
			parents = {};
		}

		parents[parent_id] = item;
		treeParents[item.id] = parents;
	});

	var result = new Array();

	var currentId = listId;
	while (currentId !== null && currentId !== undefined && currentId !== "root") {
		var item = trees[currentId];

		if (item === undefined) {
			break;
		}

		result.push({id: item.id, name: item.name});
		currentId = item.parent_id;
	}

	return result.reverse();
};*/

/*var displayNavigationTree = function(data) {
	var trees = {}
	var treeChildren = {};

	data.each(function(obj) {
		var item = obj["TaskList"];
		var parent_id = item.parent_id == null ? "root" : item.parent_id;
		var children = treeChildren[parent_id];
 
		trees[item.id] = item;

		if (children == undefined) {
			children = {};
		}

		children[item.id] = item;
		treeChildren[parent_id] = children;
	});

	jq("body").append(printTree(trees, treeChildren, treeChildren.root));

	var test = getNavigationTree2(data, 65);

	test.each(function(item) {
		jq("body").append("<p>" + item.name + "</p>");
	});
};*/

/*var displayBreadCrumbs = function(data) {
	
};*/

/*var getNavigationTree = function () {
	var self = this;
	
	jq.ajax({			
        type: "get",
	  	cache: false,
		dataType: "json",
		error: function(data){
			Tornado.error(data);
		}, 
	  	url: "/tornado/task_lists/tree"
	}).done(function (data) {
		if (data){
			displayNavigationTree(data);
		} 
	});

};*/

var extractKeywords = function (text, keywordCharacter) {
	var result = {};
	var keywords = new Array();
	var insideKeyword = false;
	var keyword = "";
	var newText = "";

	for (var index=0; index < text.length; index++){
		var currentChar = text[index];
		
		if (currentChar === keywordCharacter) {
			insideKeyword = true;
			continue;
		} 
		
		if (insideKeyword) {
			if (currentChar === " ") {
				keywords.push({name: keyword});
				keyword = "";
				insideKeyword = false;
				continue;
			} else {
				keyword += currentChar;
			}
		} else {
			newText += currentChar;
		}
	}

	if (insideKeyword){
		keywords.push({name: keyword});
	}

	result.text = newText;
	result.keywords = keywords;
	return result;
};

jq.fn.animateHighlight = function(highlightColor, duration) {
    var highlightBg = highlightColor || "#FFFF9C";
    var animateMs = duration || 1500;
    var originalBg = this.css("backgroundColor");
    this.stop().css("background-color", highlightBg).animate({backgroundColor: originalBg}, animateMs);
};
