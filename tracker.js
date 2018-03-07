/*!
 * Piwik - free/libre analytics platform
 *
 * JavaScript tracking client
 *
 * @link http://piwik.org
 * @source https://github.com/piwik/piwik/blob/master/js/piwik.js
 * @license http://piwik.org/free-software/bsd/ BSD-3 Clause (also in js/LICENSE.txt)
 * @license magnet:?xt=urn:btih:c80d50af7d3db9be66a4d0a86db0286e4fd33292&dn=bsd-3-clause.txt BSD-3-Clause
 */

/**
 * To minify this version call
 * cat tracker.js | java -jar ../../js/yuicompressor-2.4.7/build/yuicompressor-2.4.7.jar --type js --line-break 1000 | sed 's/^[/][*]/\/*!/' > tracker.min.js
 */

(function () {
    
    function init() {
        Piwik.addPlugin("DeviceNetworkInformation", {
            log: function() {
                if (typeof navigator.connection !== 'undefined' && typeof navigator.connection.type !== 'undefined') {
                    return "&networktype=" + encodeURIComponent(navigator.connection.type)
                }
                return "&networktype=unknown"
            }
        })
    }

    if ('object' === typeof window.Piwik) {
        init();
    } else {
        // tracker is loaded separately for sure
        if ('object' !== typeof window.piwikPluginAsyncInit) {
            window.piwikPluginAsyncInit = [];
        }

        window.piwikPluginAsyncInit.push(init);
    }

})();