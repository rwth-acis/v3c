require.config({
    paths: {
        jquery: "http://virtus-vet.eu/boost/boostNovember/js/jquery-1.10.2.min",
        jqueryUi: "//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min",
        async: "http://virtus-vet.eu/boost/boostNovember/js/async",
        bootstrap: "http://virtus-vet.eu/boost/boostNovember/js/bootstrap.min",
        boostShared: "http://virtus-vet.eu/boost/boostNovember/js/boostShared",
        bootstrapSlider: "http://virtus-vet.eu/boost/boostNovember/js/bootstrap-slider",
        tree: "http://virtus-vet.eu/boost/boostNovember/js/tree",
        spin: "http://virtus-vet.eu/boost/boostNovember/ladda/spin.min",
        ladda: "http://virtus-vet.eu/boost/boostNovember/ladda/ladda.min",
        ractive: "http://virtus-vet.eu/boost/boostNovember/js/Ractive",
        ractiveValidator: "http://virtus-vet.eu/boost/boostNovember/js/ractive-validator",
        moment: "http://virtus-vet.eu/boost/boostNovember/js/moment.min",
        bootbox: "http://virtus-vet.eu/boost/boostNovember/js/bootbox.min",
        rivets: "http://virtus-vet.eu/boost/boostNovember/js/rivets.min",
        repositories: "http://virtus-vet.eu/boost/boostNovember/js/repositories",
        search_youtube: "http://virtus-vet.eu/boost/boostNovember/js/search_youtube",
        search_slideshare: "http://virtus-vet.eu/boost/boostNovember/js/search_slideshare",
        search_scribd: "http://virtus-vet.eu/boost/boostNovember/js/search_scribd",
        search_wikipedia: "http://virtus-vet.eu/boost/boostNovember/js/search_wikipedia",
        linkify: "http://virtus-vet.eu/boost/boostNovember/js/linkify",
        scribd_api: "http://www.scribd.com/javascripts/scribd_api",
        highcharts: "http://virtus-vet.eu/boost/boostNovember/highcharts/js/highcharts",
        highcharts_exporting: "http://virtus-vet.eu/boost/boostNovember/highcharts/js/modules/exporting",
        lodash: "http://virtus-vet.eu/boost/boostNovember/js/lodash",

        UserManager: "http://virtus-vet.eu/boost/boostNovember/js/UserManager",
        BCNManager: "http://virtus-vet.eu/boost/boostNovember/js/BCNManager",
        LearningDocumentsManager: "http://virtus-vet.eu/boost/boostNovember/js/LearningDocumentsManager",
        ExpertsManager: "http://virtus-vet.eu/boost/boostNovember/js/ExpertsManager",
        EmployeeManager: "http://virtus-vet.eu/boost/boostNovember/js/EmployeeManager",
        WidgetsManager: "http://virtus-vet.eu/boost/boostNovember/js/WidgetsManager",
        AccessRightsManager: "http://virtus-vet.eu/boost/boostNovember/js/AccessRightsManager",
        ConfigManager: "http://virtus-vet.eu/boost/boostNovember/js/ConfigManager",
        iwc : "http://dbis.rwth-aachen.de/gadgets/iwc/lib/iwc",
        google_api: "https://apis.google.com/js/client",
        bootstrapDatepicker: "http://virtus-vet.eu/boost/boostNovember/js/bootstrap-datepicker",
        utils: "http://virtus-vet.eu/boost/boostNovember/js/utils"

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