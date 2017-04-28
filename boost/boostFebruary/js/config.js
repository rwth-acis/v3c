function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
    }
    return "";
}

var locale = getCookie("locale") || localStorage.getItem("locale") || navigator.language;

require.config({
    locale: locale,
    paths: {
        jquery: "http://virtus-vet.eu/boost/boostFebruary/js/jquery-2.1.4.min",
        jqueryUi: "//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min",
        async: "http://virtus-vet.eu/boost/boostFebruary/js/async",
        bootstrap: "http://virtus-vet.eu/boost/boostFebruary/js/bootstrap.min",
        boostShared: "http://virtus-vet.eu/boost/boostFebruary/js/boostShared",
        bootstrapSlider: "http://virtus-vet.eu/boost/boostFebruary/js/bootstrap-slider",
        bootstrapToggle: "https://gitcdn.github.io/bootstrap-toggle/2.2.0/js/bootstrap-toggle.min",
        tree: "http://virtus-vet.eu/boost/boostFebruary/js/tree",
        spin: "http://virtus-vet.eu/boost/boostFebruary/ladda/spin.min",
        ladda: "http://virtus-vet.eu/boost/boostFebruary/ladda/ladda.min",
        ractive: "http://virtus-vet.eu/boost/boostFebruary/js/Ractive",
        ractiveValidator: "http://virtus-vet.eu/boost/boostFebruary/js/ractive-validator",
        moment: "http://virtus-vet.eu/boost/boostFebruary/js/moment.min",
        bootbox: "http://virtus-vet.eu/boost/boostFebruary/js/bootbox.min",
        rivets: "http://virtus-vet.eu/boost/boostFebruary/js/rivets.min",
        repositories: "http://virtus-vet.eu/boost/boostFebruary/js/repositories",
        search_youtube: "http://virtus-vet.eu/boost/boostFebruary/js/search_youtube",
        search_slideshare: "http://virtus-vet.eu/boost/boostFebruary/js/search_slideshare",
        search_scribd: "http://virtus-vet.eu/boost/boostFebruary/js/search_scribd",
        search_wikipedia: "http://virtus-vet.eu/boost/boostFebruary/js/search_wikipedia",
        linkify: "http://virtus-vet.eu/boost/boostFebruary/js/linkify",
        scribd_api: "http://www.scribd.com/javascripts/scribd_api",
        highcharts: "http://virtus-vet.eu/boost/boostFebruary/highcharts/js/highcharts",
        highcharts_exporting: "http://virtus-vet.eu/boost/boostFebruary/highcharts/js/modules/exporting",
        lodash: "http://virtus-vet.eu/boost/boostFebruary/js/lodash",
        i18n: "http://virtus-vet.eu/boost/boostFebruary/js/i18n",

        UserManager: "http://virtus-vet.eu/boost/boostFebruary/js/UserManager",
        BCNManager: "http://virtus-vet.eu/boost/boostFebruary/js/BCNManager",
        LearningDocumentsManager: "http://virtus-vet.eu/boost/boostFebruary/js/LearningDocumentsManager",
        ExpertsManager: "http://virtus-vet.eu/boost/boostFebruary/js/ExpertsManager",
        EmployeeManager: "http://virtus-vet.eu/boost/boostFebruary/js/EmployeeManager",
        WidgetsManager: "http://virtus-vet.eu/boost/boostFebruary/js/WidgetsManager",
        AccessRightsManager: "http://virtus-vet.eu/boost/boostFebruary/js/AccessRightsManager",
        ConfigManager: "http://virtus-vet.eu/boost/boostFebruary/js/ConfigManager",
        iwc : "http://dbis.rwth-aachen.de/gadgets/iwc/lib/iwc",
        google_api: "https://apis.google.com/js/client",
        bootstrapDatepicker: "http://virtus-vet.eu/boost/boostFebruary/js/bootstrap-datepicker",
        utils: "http://virtus-vet.eu/boost/boostFebruary/js/utils"

    },
    shim: {
        async : {
            exports: 'async'
        },
        UserManager: {
            deps: ['boostShared']
        },
        BCNManager: {
            deps: ['boostShared']
        },
        LearningDocumentsManager: {
            deps: ['boostShared']
        },
        ExpertsManager: {
            deps: ['boostShared']
        },
        EmployeeManager: {
            deps: ['boostShared', 'moment']
        },
        WidgetsManager: {
            deps: ['boostShared']
        },
        AccessRightsManager: {
            deps: ['boostShared', 'bootbox', 'lodash']
        },
        ConfigManager: {
            deps: ['boostShared']
        },
        boostShared: {
            deps: ['async']
        },
        highcharts: {
            exports: "Highcharts",
            deps: ['jquery']
        },
        highcharts_exporting: {
            deps: ['highcharts']
        },
        bootstrap: {
            deps: ['jquery']
        },
        bootstrapToggle: {
            deps: ['jquery']
        },
        bootstrapSwitch: {
            deps: ['jquery']
        },
        jqueryUi: {
            deps: ['jquery']
        },
        tree: {
            deps: ['jquery']
        },
        rivets: {
            deps: ['jquery']
        },
        search_youtube: {
            deps: ['google_api']
        },
        bootstrapDatepicker: {
            deps: ['jquery']
        },
        bootstrapSlider: {
            deps: ['jquery']
        },
        search_scribd: {
            deps: ['scribd_api']
        }
    }
});