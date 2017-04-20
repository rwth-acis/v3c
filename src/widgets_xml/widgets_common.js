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
