Tornado.CommandBar = Class.create();
Tornado.CommandBar.prototype = {
    initialize: function() {
    },

    populate: function () {

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
		self.submit();
		return false;
            } else if (e.keyCode == 40) { 
		changeInputBarIndex(++inputModeIndex);
       		return false;
    	    } else if (e.keyCode == 38) {
		changeInputBarIndex(--inputModeIndex);
		return false;	
	    }
	});
	
	container.find("span").click(function() {
	    changeInputBarIndex(--inputModeIndex);
	});
	
	button.click(function() {
            self.submit();
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
	
    },

    extractKeywords: function (text, keywordCharacter) {
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
    },
    
    submit: function() {
        var text = inputbar.val();
	
        var data = {};

	var inputMode = jq("#inputbar").find("span").text();
	
	var tagKeywordObject = this.extractKeywords(text, "#");
	var contextKeywordObject = this.extractKeywords(tagKeywordObject.text, "@");
	var userKeywordObject = this.extractKeywords(contextKeywordObject.text, "~");
	
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
	
	if (inputMode === "task"){		
	    data.Task = {}
	    data.Task.name = userKeywordObject.text;
	} else if (inputMode === "list"){
	    data.List = {};
	    data.List.name = userKeywordObject.text;
	    data.List.parent_id = list ? list.id : null;
	}
	
	data.Contexts = modelify(contextKeywordObject.keywords, "Context"); 
	data.Lists = modelify([Tornado.state.getList()], "List");
	data.Tags = modelify(tagKeywordObject.keywords, "Tag");
	data.Users = modelify(userKeywordObject.keywords, "User");
	
        Tornado.panelManager.addItem(data);
	
        inputbar.val("");
    }
};