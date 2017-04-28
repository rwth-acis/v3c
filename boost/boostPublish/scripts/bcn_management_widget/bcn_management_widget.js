var space;
var bcnsList;
var employeesList;
var iwcClient;

gadgets.util.registerOnLoadHandler(init);

function init(){
	/*
		Here we get the space resource.
		It is the top level resource which is shared by all users.
	*/
	space = new openapp.oo.Resource(openapp.param.space());

	iwcClient = new iwc.Client();
	iwcClient.connect(iwcCallback);
}

/* Shorthand for $( document ).ready() */

$(function(){
	$('#newBcnModal').on('hidden.bs.modal', function (e) {
		$('#newBcnModal').find('input[type="text"],input[type="email"],textarea,select').val('');
		$('#newBcnModal').find('.additionalLI').remove();
	});
	$("#addNewBcnButton").click(function(){
		prepareBcnModal(-1);
		clearInputNewBCNWarning();
		$("#newBcnModal").modal();

	});

	$("#showOverallProgressButton").click(function(){
		publishShowOverallBcnProgress();
	});

	var newBcnTooltipOptions = {};
	newBcnTooltipOptions.title = "Add a new goal for your business.";
	newBcnTooltipOptions.placement = "right";
	$("#addNewBcnButton").tooltip(newBcnTooltipOptions);

	var showOverallGraphTooltipOptions = {};
	showOverallGraphTooltipOptions.title = "Show the overall progress for all your goals.";
	showOverallGraphTooltipOptions.placement = "left";
	$("#showOverallProgressButton").tooltip(showOverallGraphTooltipOptions);

	var addLiTooltipOptions = {};
	addLiTooltipOptions.title = "Add an additional learning indicator.";
	addLiTooltipOptions.placement = "right";
	$("#addLIButton").tooltip(addLiTooltipOptions);

	$("#panel").append("<img id='loader' src='http://127.0.0.1:8073/role/BOOSTRepository/henm1314g3/resources/loader.gif'>")
	retrieveAllBcns(space, function(bcns){
		bcnsList = bcns;
		retrieveAllEmployees(space, function(employees){
			employeesList = employees;
			$("#loader").remove();
			renderAllBcns();
		});
	});

	/* Assign color, name and index to the priority pushpins */

	for (var i = 0; i < 3; i++) {
		$('#priority' + i).css({'color':priorityColors[i]});
		$('#prioritytext' + i).append(priorityNames[i]);
		$('#prioritytext' + i).data('priorityIndex', i);				
		};			
});

function updateEmployeesForNewBcn(bcn, callback){
	var updateCount = 0;
	//Directly return if no employees are defined
	if(employeesList.length == 0){
		callback();
		return;
	}
	for(var i = 0; i < employeesList.length; i++){
		var learningLevelsForBcn = employeesList[i].learningLevels[bcn.uri] = {};
		learningLevelsForBcn.isRelevant = true;
		for(var j = 0; j < bcn.learningIndicators.length; j++){
			learningLevelsForBcn[bcn.learningIndicators[j].id] = {};
			learningLevelsForBcn[bcn.learningIndicators[j].id].start = 0;
			learningLevelsForBcn[bcn.learningIndicators[j].id].current = 0;
			learningLevelsForBcn[bcn.learningIndicators[j].id].end = llevel.length -1;
		}
		updateEmployee(employeesList[i], function(){
			updateCount++;
			if(updateCount == employeesList.length)
				callback();
		});
	}
}

function updateEmployeesForUpdateBcn(bcn, callback){
	var updateCount = 0;
	for(var i = 0; i < employeesList.length; i++){
		var learningLevelsForBcn = employeesList[i].learningLevels[bcn.uri];
		for(var j = 0; j < bcn.learningIndicators.length; j++){
			if(!learningLevelsForBcn.hasOwnProperty(bcn.learningIndicators[j].id))
				learningLevelsForBcn[bcn.learningIndicators[j].id] = {};
			learningLevelsForBcn[bcn.learningIndicators[j].id].start = 0;
			learningLevelsForBcn[bcn.learningIndicators[j].id].current = 0;
			learningLevelsForBcn[bcn.learningIndicators[j].id].end = llevel.length -1;
		}
		//TODO: Need to check if learning indicators have been removed, so they can be removed from the employees
		updateEmployee(employeesList[i], function(){
			updateCount++;
			if(updateCount == employeesList.length)
				callback();
		});
	}
}

function updateEmployeesForDeletedBcn(bcn, callback){
	var updateCount = 0;
	for(var i = 0; i < employeesList.length; i++){
		delete employeesList[i].learningLevels[bcn.uri];
		updateEmployee(employeesList[i], function(){
			updateCount++;
			if(updateCount == employeesList.length)
				callback();
		});
	}
}

function checkInputNewBcn(){
	var name = $("#inputNewBcnName").val();
	if(name == ""){
		$("#inputNewBcnName").parent().addClass("has-error");
		$("#inputNewBcnNameWarning").text("Error: Name must be filled out!");					
		return false
	}
	return true;
}

function clearInputNewBCNWarning(){
	$("#inputNewBcnName").parent().removeClass("has-error");
	$("#inputNewBcnNameWarning").text("");
}

function iwcCallback(intent){
	if(intent.action == "EMPLOYEE_CREATE"){
		
	}
}

function publishBcnCreated(bcnUri){
	var intent = {
		component: "",
		data: bcnUri,
		dataType: "text/json",
		flags :["PUBLISH_GLOBAL"],
		action: "BCN_CREATE"
	};

	iwcClient.publish(intent);
}

function publishBcnUpdated(bcnUri){
	var intent = {
		component: "",
		data: bcnUri,
		dataType: "text/json",
		flags :["PUBLISH_GLOBAL"],
		action: "BCN_UPDATE"
	};

	iwcClient.publish(intent);
}

function publishBcnDeleted(bcnUri){
	var intent = {
		component: "",
		data: bcnUri,
		dataType: "text/json",
		flags :["PUBLISH_GLOBAL"],
		action: "BCN_DELETE"
	};

	iwcClient.publish(intent);
}

function publishShowBcnProgress(bcnUri){
	var intent = {
		component: "",
		data: bcnUri,
		dataType: "text/json",
		action: "SHOW_BCN_PROGRESS"
	};

	iwcClient.publish(intent);
}

function publishShowOverallBcnProgress(){
	var intent = {
		component: "",
		data: "",
		dataType: "text/json",
		action: "SHOW_OVERALL_BCN_PROGRESS"
	};

	iwcClient.publish(intent);
}

function renderAllBcns(){
	$("#bcnOverviewTable").empty();

	/* Sort accord. priority, then alphabet */

	bcnsList.sort(function(a, b){
		if (a.priority==b.priority) {if(a.name.toLowerCase() < b.name.toLowerCase()) return -1; else return 1;}
		if(a.priority > b.priority)  return -1; else return 1;
		
		
	});
	for(var i = 0; i < bcnsList.length; i++){
		var bcn = bcnsList[i];
		var editButton = $("<button class='btn btn-default edit-bcn-btn'><span class='glyphicon glyphicon-edit'></span></button>");
		editButton.data("bcnIndex", i);
		var deleteButton = $("<button class='btn btn-default delete-bcn-btn'><span class='glyphicon glyphicon-trash'></span></button>");
		deleteButton.data("bcnIndex", i);
		var graphButton = $("<button class='btn btn-default show-graph-btn'><span class='glyphicon glyphicon-stats'></span></button>");
		graphButton.data("bcnIndex", i);

		/* Added pushpin before the name in main BCN modal */

		var template = 	"<tr>" +
							"<td><span class='glyphicon glyphicon-pushpin' style='color:#{priorityPushpin}'></span> #{bcnName}</td>" +
							"<td style='width:150px' align='center'>" +
								"<div class='btn-group'>" +
								"</div>" +
							"</td>" +
						"</tr>";

		/* Replaced priorityPushpin with the value from priorityColors array according to it index */				

		var entry = $(template.replace(/#{bcnName}/g, bcn.name).replace(/#{priorityPushpin}/g, priorityColors[bcn.priority]));

		entry.find(".btn-group").append(editButton);
		entry.find(".btn-group").append(deleteButton);
		entry.find(".btn-group").append(graphButton);
		$("#bcnOverviewTable").append(entry);
	}

	var deleteBcnTooltipOptions = {};
	deleteBcnTooltipOptions.title = "Delete";
	deleteBcnTooltipOptions.container = "body";
	$(".delete-bcn-btn").tooltip(deleteBcnTooltipOptions);

	var editBcnTooltipOptions = {};
	editBcnTooltipOptions.title = "View/Edit";
	editBcnTooltipOptions.container = "body";
	$(".edit-bcn-btn").tooltip(editBcnTooltipOptions);

	var showGraphTooltipOptions = {};
	showGraphTooltipOptions.title = "Show progress";
	showGraphTooltipOptions.container = "body";
	$(".show-graph-btn").tooltip(showGraphTooltipOptions);

	$(".show-graph-btn").click(function(){
		var bcnIndex = $(this).data("bcnIndex");
		publishShowBcnProgress(bcnsList[bcnIndex].uri);
	});

	$(".edit-bcn-btn").click(function(){
		var bcnIndex = $(this).data("bcnIndex");
		prepareBcnModal(bcnIndex);
		$("#newBcnModal").modal();
	});

	$(".delete-bcn-btn").click(function(){
		// confirm delete first.
		var bcnIndex = $(this).data("bcnIndex");
		//$("#confirmDeleteButton").button("reset");
		$("#alertInModal").alert();
		$("#deleteAlertMessage").text("Do you really want to delete \"" + bcnsList[bcnIndex].name +"\"?");
		$("#deleteAlertModal").modal();
		$("#confirmDeleteButton").off().click(function(){
			var l = Ladda.create(this);
			l.start();
			//$("#confirmDeleteButton").button("loading");
			var bcnToDelete = bcnsList[bcnIndex];
			bcnToDelete.delete(function(){
				publishBcnDeleted(bcnToDelete.uri);
				bcnsList.splice(bcnIndex, 1);
				renderAllBcns();
				$("#deleteAlertModal").modal("hide");
				l.stop();
			});
		});
	});
}

function renderAdditionalLiInput(bcn, li){
	var liInput = $("#liInput").clone();
	liInput.find("input[type='text']").val(li.name);
	liInput.id = "liInput" + li.id;
	liInput.addClass("additionalLI");
	liInput.find("input[type='text']").off("input").on("input", function(){
		li.name = $(this).val();
	});
	var removeLi = $("<span class='input-group-btn'><button class='btn btn-default' type='button'>x</button></span>");
	liInput.append(removeLi);
	$("#inputNewBcnLi").append(liInput);
	removeLi.find("button").click(function(){
		bcn.removeLI(li.id);
		$(this).closest(".additionalLI").remove();
	});
}

function prepareBcnModal(bcnIndex){
	//If bcnIndex < 0 then we prepare the create new bcn modal
	//Otherwise we create the update modal for bcn stored at the index
	var bcn;
	if(bcnIndex < 0){
		bcn = new BCN({});
		$("#newBcnModalLabel").text("Create a new goal");
	}
	else{
		$("#newBcnModalLabel").text("View/Update goal");
		bcn = bcnsList[bcnIndex].clone();
	}

	
	$("#inputNewBcnName").val(bcn.name);
	$("#inputNewBcnDescription").val(bcn.description);
	
	$("#inputNewBcnName").off("input").on("input", function(){
		bcn.name = $(this).val();
	});
	$("#inputNewBcnDescription").off("input").on("input", function(){
		bcn.description = $(this).val();
	});

	/* Added click event on the drop-down pushpins */

	$('.priorityClass').click(function(){
		
			$('#mainPushpin').css({'color':priorityColors[$(this).data('priorityIndex')]});
			bcn.priority = $(this).data('priorityIndex');	
		  });
	$('#mainPushpin').css({'color':priorityColors[bcn.priority]});


	if(bcn.learningIndicators.length == 0)
		bcn.addLI("");
	//Update LIs
	$("#liInput").find("input[type='text']").val(bcn.learningIndicators[0].name);
	$("#liInput").find("input[type='text']").off("input").on("input", function(){
		bcn.learningIndicators[0].name = $(this).val();
	});
	for(var i = 1; i < bcn.learningIndicators.length; i++){
		renderAdditionalLiInput(bcn, bcn.learningIndicators[i]);
	}

	$("#addLIButton").off("click").click(function(){
		renderAdditionalLiInput(bcn, bcn.addLI(""));
	});

	$("#saveNewBcnButton").off("click");
	$("#saveNewBcnButton").click(function(){
		//$(this).button("loading");
		var l = Ladda.create(this);
		if(checkInputNewBcn()){					
		l.start();
		if(bcnIndex < 0){
			bcn.create(function(){
				updateEmployeesForNewBcn(bcn, function(){
					publishBcnCreated(bcn.uri);
					bcnsList.push(bcn);
					renderAllBcns();
					$('#newBcnModal').modal("hide");
					l.stop();
				});
			});
		}
		else{
			bcn.update(function(){
				updateEmployeesForUpdateBcn(bcn, function(){
					publishBcnUpdated(bcn.uri);
					bcnsList[bcnIndex] = bcn;
					renderAllBcns();
					$('#newBcnModal').modal("hide");
					l.stop();
				});
			});
		}
		}
	});
}