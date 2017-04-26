function sendUserActivity(action, value) {
  var widget_url = getWidgetInstanceUrl();
  $.ajax({ method: 'POST',
     url: `http://virtus-vet.eu/src/php/monitor_service.php?widget_url=${widget_url}&action=${action}&value=${value}`,
     crossDomain: true,
     xhrFields: {
       withCredentials: true
     }
   })
}

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

$( document ).ready(function() {
    $(document).on('click', 'button', function() {
      sendUserActivity('click',$(this).attr('id'));
  });
  $(document).on('click', 'input', function() {
      sendUserActivity('click',$(this).attr('id'));
  });
});
