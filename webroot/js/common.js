// TODO: Refactor this
var expandableDivButtonClick = function (element) {
	$(element).next("div").toggle();

	return false;
};
/*
var modalDivButtonClick = function (element) {
	jq(element).next("div").modal();
};*/

/*var deleteModel = function (id, model, name){
	jq("#message-confirm-box p").text("Are you sure you want to delete " + name + "?");
	jq("#message-confirm-box .yes").click(function () {
		jq(location).attr('href',"/tornado/" + model + "/delete/" + id);
	});
	jq("#message-confirm-box .no").click(function () {
		jq.modal.close();
	});
	jq("#message-confirm-box").modal();
};*/


var compareItem = function(a, b, field) {
		if (!field) {
			field = "name";
		}

		var nameA=a[field].toLowerCase();
		var nameB=b[field].toLowerCase();
 		if (nameA < nameB) {
 			return -1; 
		} else if (nameA > nameB) {
  			return 1;
		} else {
	 		return 0;
		}
	};
/*
var deleteTask = function (id, name) {
	deleteModel(id, "task", name);
};

var deleteList = function (id, name) {
	deleteModel(id, "task_lists", name);
};*/

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

    container.find("span").click(function() {
	changeInputBarIndex(--inputModeIndex);
    });

	button.click(function() {
        submit();
        return false;
	});

	var modelify = function(list, name) {
		var result = new Array();

		if (list) {
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
		var userKeywordObject = extractKeywords(contextKeywordObject.text, "~");

		var listObj = Tornado.state.getList();
	var list;

	if (listObj) {
		list = Tornado.lists.get(listObj.id);
	} else {
	    list = null;
	}

		if (list) {
			list.tags.each(function(item) {
				tagKeywordObject.keywords.push(item.value);
			});
			list.contexts.each(function(item) {
				contextKeywordObject.keywords.push(item.value);
			});
			list.users.each(function(item) {
				userKeywordObject.keywords.push(item.value);
			});
		}

		/*var defaultUser = Tornado.getDefaultTag();
		if (defaultUser) {
			tagKeywordObject.push(defaultTag.name);
		}*/

		if (inputMode === "task"){		
		    data.Task = {}
		    data.Task.name = userKeywordObject.text;
		} else if (inputMode === "list"){
			data.List = {};
			data.List.name = userKeywordObject.text;
		    data.List.parent_id = (Tornado.state.getList()).id;
		}

	    data.Contexts = modelify(contextKeywordObject.keywords, "Context"); 
	data.Lists = modelify([Tornado.state.getList()], "List");
	    data.Tags = modelify(tagKeywordObject.keywords, "Tag");
	    data.Users = modelify(userKeywordObject.keywords, "User");

        Tornado.panelManager.addItem(data);

        inputbar.val("");
    }

});



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


var escapeString = function(text) {
    if (text) {
	return text.replace(/"/g, "&quot;");
    } else {
	return text;
    }
};