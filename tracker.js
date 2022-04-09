/*!
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://matomo.org/free-software/ BSD-3 Clause (also in js/LICENSE.txt)
 * @license magnet:?xt=urn:btih:c80d50af7d3db9be66a4d0a86db0286e4fd33292&dn=bsd-3-clause.txt BSD-3-Clause
 */

/**
 * To minify this version call
 * cat tracker.js | java -jar ../../js/yuicompressor-2.4.7/build/yuicompressor-2.4.7.jar --type js --line-break 1000 | sed 's/^[/][*]/\/*!/' > tracker.min.js
 */

(function () {
    
    function init() {
        Matomo.addPlugin("DeviceNetworkInformation", {
            log: function() {
                
                var ret = '';
                
                try {
                    var connection = navigator.connection || navigator.mozConnection || navigator.webkitConnection;
                    
                    if (typeof connection !== 'undefined') {
                        
                        if (typeof connection.type !== 'undefined') {
                            ret += "&nwtype=" + encodeURIComponent(connection.type);
                        }
                        
                        if (typeof connection.effectiveType !== 'undefined') {
                            ret += "&nwefftype=" + encodeURIComponent(connection.effectiveType);
                        }
                    }
                } catch(e) {
                    
                    ret = '';
                }
                    
                return ret;
            }
        })
    }

    if ('object' === typeof window.Matomo) {
        init();
    } else {
        // tracker is loaded separately for sure
        if ('object' !== typeof window.matomoPluginAsyncInit) {
            window.matomoPluginAsyncInit = [];
        }

        window.matomoPluginAsyncInit.push(init);
    }

})();