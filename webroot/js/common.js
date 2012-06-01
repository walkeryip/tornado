var expandableDivButtonClick = function (element) {
	$(element).next("div").toggle();
	return false;
};

var modalDivButtonClick = function (element) {
	jq(element).next("div").modal();
};

jq(document).ready(function () {

	
	/*jq(".expandable-div-button").click(function () {
		expandableDivButtonClick(this);
	});*/
});

