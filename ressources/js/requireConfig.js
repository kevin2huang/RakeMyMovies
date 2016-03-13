require.config({
    baseUrl: "",
    paths: {
        "jQuery": "external_plugins/jquery-1.11.3",
        "knockout": "external_plugins/knockout-3.4.0",
        "text":"external_plugins/require_text-2.0.14",
        'komapping': "external_plugins/knockout_mapping-2.4.1"
    },
    shim: {
        "jQuery": {
            exports: "$"
        }
    }
});
require(["ressources/js/main"]);