cordova.define('cordova/plugin_list', function(require, exports, module) {
module.exports = [
    {
        "file": "plugins/com.chariotsolutions.nfc.plugin/www/phonegap-nfc.js",
        "id": "com.chariotsolutions.nfc.plugin.NFC",
        "runs": true
    },
    {
        "file": "plugins/com.chariotsolutions.nfc.plugin.tests/tests.js",
        "id": "com.chariotsolutions.nfc.plugin.tests.tests"
    },
    {
        "file": "plugins/org.apache.cordova.test-framework/www/tests.js",
        "id": "org.apache.cordova.test-framework.cdvtests"
    },
    {
        "file": "plugins/org.apache.cordova.test-framework/www/jasmine_helpers.js",
        "id": "org.apache.cordova.test-framework.jasmine_helpers"
    },
    {
        "file": "plugins/org.apache.cordova.test-framework/www/medic.js",
        "id": "org.apache.cordova.test-framework.medic"
    },
    {
        "file": "plugins/org.apache.cordova.test-framework/www/main.js",
        "id": "org.apache.cordova.test-framework.main"
    }
];
module.exports.metadata = 
// TOP OF METADATA
{
    "com.chariotsolutions.nfc.plugin": "0.6.0",
    "com.chariotsolutions.nfc.plugin.tests": "0.0.1-dev",
    "org.apache.cordova.test-framework": "0.1"
}
// BOTTOM OF METADATA
});