$(function() {
	function saveForm(notGetThisNames) {
	  	var $formNames;
	 	notGetThisNames = notGetThisNames || "meta";
	  	$formNames = $("[name]").not(notGetThisNames);

	  	$.each($formNames, function (key, value) {
		    var name = $(value).attr("name");
		    // Rellenar formulario
		    if (localStorage.getItem(name) !== null) {
		        $(value).val(localStorage.getItem(name));
		    }
	  	});

	  	$formNames.on("change", function (ev) {
	    	// Guardar datos del formulario cuando cambian
	    	localStorage.setItem($(ev.currentTarget).attr("name"), $(ev.currentTarget).val());
	  	});
	}

	saveForm()

})
