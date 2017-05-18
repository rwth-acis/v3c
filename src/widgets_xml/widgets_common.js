// widget url

function getWidgetInstanceUrl() {
 function getQueryVariable(variable) {
     var query = window.location.search.substring(1);
     var vars = query.split('&');
     for (var i = 0; i < vars.length; i++) {
         var pair = vars[i].split('=');
         if (decodeURIComponent(pair[0]) == variable) {
             return decodeURIComponent(pair[1]);
         }
     }
 }
 return getQueryVariable('url').split('?')[0];
}

// language

function getBrowserLanguage() {
  return navigator.languages ? navigator.languages[0] : (navigator.language || navigator.userLanguage);
}

function getUserLanguage(callback) {
  $.ajax({
   url: "http://virtus-vet.eu/src/php/lang.php",
   crossDomain: true,
   xhrFields: {
     withCredentials: true
   }
  })
  .done(function(data) {
    callback(data)
  })
  .fail(function() {
    callback(getBrowserLanguage())
  })
}

// translations

function loadTranslations() {
  $('[data-lang-key]').each(function() {
    var self = this
    $.ajax({
     url: "http://virtus-vet.eu/src/php/langstring.php?key=" + $(this).attr("data-lang-key") + "&default=DEFAULT",
     crossDomain: true,
     xhrFields: {
       withCredentials: true
     }
    })
    .done(function(data) {
      if (data !== "DEFAULT") {
        $(self).html(data)
      }
    })
  })
}

// user activity

function sendUserActivity(action, value) {
  var widget_url = getWidgetInstanceUrl();
  $.ajax({ method: 'POST',
     url: `http://virtus-vet.eu/src/php/monitor_service.php`,
     data: {
       "widget_url": widget_url,
       action: action || '',
       value: value || ''
     },
     crossDomain: true,
     xhrFields: {
       withCredentials: true
     }
   })
}

$( document ).ready(function() {
    $(document).on('click', 'button', function() {
    	sendUserActivity('click',$(this).attr('id'));
	});
	$(document).on('click', 'input', function() {
    	sendUserActivity('click',$(this).attr('id'));
	});
});


// widget flow
var iwcClient;

$(function() {
  initWidgetFlow()

  iwcClient = new iwc.Client();
  iwcClient.connect(intentHandler);
})

function intentHandler(intent){
  if (intent.action == "UNLOCK_WIDGET" && intent.data == getWidgetInstanceUrl()) {
    activateWidget()
  }
}

function initWidgetFlow() {
  $.ajax({
   url: "http://virtus-vet.eu/src/php/widget_flow.php?widget_role_url=" + getWidgetInstanceUrl()
  })
  .done(function(data) {
    var data = JSON.parse(data)
    if (data.order != null && data.order != 0) {
      deactivateWidget()
    }

    if (data.next_widget != null) {
      showButton(data.next_widget, data.next_type)
    }
  })
}

function showButton(nextWidgetUrl, nextWidgetType) {
  $('body').append('<div class="flowlink"><button data-widget="'+nextWidgetUrl+'" onclick="unlockRemoteWidget(\''+nextWidgetUrl+'\')"><span data-lang-key="widget:general:unlock">Unlock</span> <span data-lang-key="widget:type:' + nextWidgetType + '">widget</span></button></div>');
  loadTranslations();

  // TODO get button status
}

function unlockRemoteWidget(widgetUrl) {
  iwcClient.publish({
    "action": "UNLOCK_WIDGET",
    "data": widgetUrl,
    "component": "",
    "dataType": "text/xml",
    "categories": ["", ""],
    "flags": "PUBLISH_GLOBAL",
    "extras": {}
  });

  $('.flowlink button[data-widget="' + widgetUrl + '"]').prop("disabled", true);
}

function deactivateWidget() {
  if ($('.widgetinactive').get(0) == undefined) {
    $('body').append('<div class="widgetinactive" data-lang-key="widget:general:deactivated">This widget is locked. Please work on the other widgets to unlock this widget.</div>');
    loadTranslations();
  }
}

function activateWidget() {
  $('.widgetinactive').remove();
}
