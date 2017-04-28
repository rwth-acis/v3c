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
        jquery: "http://virtus-vet.eu/boost/translated/js/jquery-1.10.2.min",
        jqueryUi: "//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min",
        async: "http://virtus-vet.eu/boost/translated/js/async",
        bootstrap: "http://virtus-vet.eu/boost/translated/js/bootstrap.min",
        boostShared: "http://virtus-vet.eu/boost/translated/js/boostShared",
        bootstrapSlider: "http://virtus-vet.eu/boost/translated/js/bootstrap-slider",
        tree: "http://virtus-vet.eu/boost/translated/js/tree",
        spin: "http://virtus-vet.eu/boost/translated/ladda/spin.min",
        ladda: "http://virtus-vet.eu/boost/translated/ladda/ladda.min",
        ractive: "http://virtus-vet.eu/boost/translated/js/Ractive",
        ractiveValidator: "http://virtus-vet.eu/boost/translated/js/ractive-validator",
        moment: "http://virtus-vet.eu/boost/translated/js/moment.min",
        bootbox: "http://virtus-vet.eu/boost/translated/js/bootbox.min",
        rivets: "http://virtus-vet.eu/boost/translated/js/rivets.min",
        repositories: "http://virtus-vet.eu/boost/translated/js/repositories",
        search_youtube: "http://virtus-vet.eu/boost/translated/js/search_youtube",
        search_slideshare: "http://virtus-vet.eu/boost/translated/js/search_slideshare",
        search_scribd: "http://virtus-vet.eu/boost/translated/js/search_scribd",
        search_wikipedia: "http://virtus-vet.eu/boost/translated/js/search_wikipedia",
        linkify: "http://virtus-vet.eu/boost/translated/js/linkify",
        scribd_api: "http://www.scribd.com/javascripts/scribd_api",
        highcharts: "http://virtus-vet.eu/boost/translated/highcharts/js/highcharts",
        highcharts_exporting: "http://virtus-vet.eu/boost/translated/highcharts/js/modules/exporting",
        lodash: "http://virtus-vet.eu/boost/translated/js/lodash",
        i18n: "http://virtus-vet.eu/boost/translated/js/i18n",

        UserManager: "http://virtus-vet.eu/boost/translated/js/UserManager",
        BCNManager: "http://virtus-vet.eu/boost/translated/js/BCNManager",
        LearningDocumentsManager: "http://virtus-vet.eu/boost/translated/js/LearningDocumentsManager",
        ExpertsManager: "http://virtus-vet.eu/boost/translated/js/ExpertsManager",
        EmployeeManager: "http://virtus-vet.eu/boost/translated/js/EmployeeManager",
        WidgetsManager: "http://virtus-vet.eu/boost/translated/js/WidgetsManager",
        AccessRightsManager: "http://virtus-vet.eu/boost/translated/js/AccessRightsManager",
        ConfigManager: "http://virtus-vet.eu/boost/translated/js/ConfigManager",
        iwc : "http://dbis.rwth-aachen.de/gadgets/iwc/lib/iwc",
        google_api: "https://apis.google.com/js/client",
        bootstrapDatepicker: "http://virtus-vet.eu/boost/translated/js/bootstrap-datepicker",
        utils: "http://virtus-vet.eu/boost/translated/js/utils"

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
            deps: ['boostShared', 'bootbox']
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