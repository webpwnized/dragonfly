<?php

    /* Enable HSTS - Only available with HTTPS*/
    //header("Strict-Transport-Security: max-age=31536000; includeSubDomains", true);

    // HTTP/1.1 cache control
    header('Cache-Control: no-store, no-cache', true);

    /* Cross-frame scripting and click-jacking */
    header('X-FRAME-OPTIONS: DENY', true);

    /* Client-side Script injection */

    $lContentSecurityPolicy = 
        "Content-Security-Policy: " .
        "default-src 'self'; script-src 'self' " .
        "'nonce-efe3f3d7e23b979ae212c5092469ce195401701a71a00eba0f4f955a068b05e2'";
    header($lContentSecurityPolicy, true);

    /* Content sniffing */
    header('X-Content-Type-Options: nosniff', true);

    /* Referrer Policy */
    header('Referrer-Policy: no-referrer', true);

    /* Server version banners */
    header_remove('X-Powered-By');
    header_remove('Server');

    $l_client_ip_address = "";
    $l_forwarded_for = "";

    if (isset($_SERVER['HTTP_CLIENT_IP'])){
        $l_client_ip_address = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (isset($_SERVER['REMOTE_ADDR'])){
        $l_client_ip_address = $_SERVER['REMOTE_ADDR'];
    }
    
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
        $l_forwarded_for = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } elseif (isset($_SERVER['HTTP_X_FORWARDED'])){
        $l_forwarded_for = $_SERVER['HTTP_X_FORWARDED'];
    } elseif (isset($_SERVER['HTTP_FORWARDED_FOR'])){
        $l_forwarded_for = $_SERVER['HTTP_FORWARDED_FOR'];
    } elseif (isset($_SERVER['HTTP_FORWARDED'])){
        $l_forwarded_for = $_SERVER['HTTP_FORWARDED'];
    }

?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Dragonfly</title>
        <link rel="stylesheet" href="css/styles.css">
        <script type="text/javascript" src="javascript/client.base.min.js">
            /* Credit to https://github.com/JackSpirou/ClientJS?tab=readme-ov-file#bundles */
        </script>
        <script type="text/javascript" nonce="efe3f3d7e23b979ae212c5092469ce195401701a71a00eba0f4f955a068b05e2">

            String.prototype.left = function(n) {
                return this.substr(0,n);
            };

            function sanitizeValue (/* any */ pValue) {

                if (pValue === "null" || pValue === null || pValue === "undefined" || pValue === undefined) {
                    return "";
                } else if (typeof pValue === 'undefined') {
                    return "";
                } else if (pValue === "true" || pValue === true) {
                    return "Yes";
                } else if (pValue === "false" || pValue === false) {
                    return "No";
                } else {
                    return pValue;
                };
            
            };

            function outputDataPoint (
                /*string*/ pSpanId,
                /*string*/ pKey,
                /*string*/ pValue) {

                    lSessionStorage = window.sessionStorage;

                    lPreviousValue = sanitizeValue(lSessionStorage.getItem(pKey));
                    lCurrentValue = sanitizeValue(pValue);
                    lSpan = window.document.getElementById(pSpanId);    // Get the output span
                    lSpan.innerText = lCurrentValue;   // Output the value into the span

                    // If the value has changes, change the font color to blue
                    if (lPreviousValue != lCurrentValue) {
                        lSpan.style.color = "blue";
                    };

                    // Store the new value in the HTML5 web storage table
                    lSessionStorage.setItem(pKey, lCurrentValue);
            };

            document.addEventListener('readystatechange', event => {
                // When window loaded ( external resources are loaded too- `css`,`src`, etc...)
                if (event.target.readyState === "complete") {
                    // in a browser, when using a script tag:
                    const ClientJS = window.ClientJS;

                    // Create a new ClientJS object
                    const client = new ClientJS();

                    lClientIP = "<?php echo htmlspecialchars($l_client_ip_address); ?>";
                    lForwardedFor = "<?php echo htmlspecialchars($l_forwarded_for); ?>";

                    outputDataPoint("id1", "BrowserFingerprint", client.getFingerprint());
                    outputDataPoint("id32", "ClientIPAddress", lClientIP);
                    outputDataPoint("id33", "ForwardedFor", lForwardedFor);
                    outputDataPoint("id2", "UserAgent", client.getUserAgent());
                    outputDataPoint("id3", "Browser", client.getBrowser());
                    outputDataPoint("id5", "Engine", client.getEngine());
                    outputDataPoint("id6", "EngineVersion", client.getEngineVersion());
                    outputDataPoint("id7", "OS", client.getOS());
                    outputDataPoint("id9", "Device", client.getDevice());
                    outputDataPoint("id10", "DeviceType", client.getDeviceType());
                    outputDataPoint("id11", "DeviceVendor", client.getDeviceVendor());
                    outputDataPoint("id12", "CPU", client.getCPU());
                    outputDataPoint("id13", "isMobile", client.isMobile());
                    outputDataPoint("id14", "isMobileMajor", client.isMobileMajor());
                    outputDataPoint("id15", "ScreenPrint", client.getScreenPrint());
                    outputDataPoint("id21", "BrowserPlugins", client.getPlugins());
                    outputDataPoint("id22", "SilverlightVersion", client.getSilverlightVersion());
                    outputDataPoint("id23", "MimeTypes", client.getMimeTypes());
                    outputDataPoint("id24", "Fonts", client.getFonts());
                    outputDataPoint("id25", "LocalStorage", client.isLocalStorage());
                    outputDataPoint("id26", "SessionStorage", client.isSessionStorage());
                    outputDataPoint("id27", "Cookie", client.isCookie());
                    outputDataPoint("id28", "TimeZone", client.getTimeZone());
                    outputDataPoint("id29", "Language", client.getLanguage());
                    outputDataPoint("id30", "SystemLanguage", client.getSystemLanguage());
                    outputDataPoint("id31", "CanvasPrint", client.getCanvasPrint().left(64));
                }
            });

        </script>
    </head>
    <body class="content">
        <div class="page-header">
            <img src="images/blue-dragonfly-icon.jpg" height="175px" width="175px" alt="" />
            <span>Dragonfly</span>
        </div>
        <table class="styled-table">
            <caption></caption>
            <thead>
                <tr>
                    <th scope="row">Data Point</th>
                    <th scope="row">Value</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">HTTP Client IP Address</th>
                    <td><span id="id32"></span></td>
                </tr>
                <tr>
                    <th scope="row">Forwarded For</th>
                    <td><span id="id33"></span></td>
                </tr>
                <tr>
                    <th scope="row">Browser Tracking Fingerprint</th>
                    <td><span id="id1"></span></td>
                </tr>
                <tr>
                    <th scope="row">User Agent</th>
                    <td><span id="id2"></span></td>
                </tr>
                <tr>
                    <th scope="row">Browser Engine</th>
                    <td>
                        <span id="id7"></span>&nbsp;
                        <span id="id3"></span>&nbsp;
                        <span id="id5"></span>&nbsp;
                        <span id="id6"></span>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Plugins</th>
                    <td><span id="id21"></span></td>
                </tr>
                <tr>
                    <th scope="row">CPU</th>
                    <td><span id="id12"></span></td>
                </tr>
                <tr>
                    <th scope="row">Screen Print</th>
                    <td><span id="id15"></span></td>
                </tr>
                <tr>
                    <th scope="row">Mime Types</th>
                    <td><span id="id23"></span></td>
                </tr>
                <tr>
                    <th scope="row">Fonts</th>
                    <td><span id="id24"></span></td>
                </tr>
                <tr>
                    <th scope="row">Local Storage</th>
                    <td><span id="id25"></span></td>
                </tr>
                <tr>
                    <th scope="row">Session Storage</th>
                    <td><span id="id26"></span></td>
                </tr>
                <tr>
                    <th scope="row">Cookies</th>
                    <td><span id="id27"></span></td>
                </tr>
                <tr>
                    <th scope="row">Time Zone</th>
                    <td><span id="id28"></span></td>
                </tr>
                <tr>
                    <th scope="row">Language</th>
                    <td><span id="id29"></span></td>
                </tr>
                <tr>
                    <th scope="row">System Language</th>
                    <td><span id="id30"></span></td>
                </tr>
                <tr>
                    <th scope="row">Canvas Print</th>
                    <td><span id="id31"></span></td>
                </tr>
                <tr>
                    <th scope="row">Silverlight Version</th>
                    <td><span id="id22"></span></td>
                </tr>
                <tr>
                    <th scope="row">Device</th>
                    <td><span id="id9"></span></td>
                </tr>
                <tr>
                    <th scope="row">Device Type</th>
                    <td><span id="id10"></span></td>
                </tr>
                <tr>
                    <th scope="row">Device Vendor</th>
                    <td><span id="id11"></span></td>
                </tr>
                <tr>
                    <th scope="row">Is Mobile</th>
                    <td><span id="id13"></span></td>
                </tr>
                <tr>
                    <th scope="row">Mobile Vendor</th>
                    <td><span id="id14"></span></td>
                </tr>
            </tbody>
        </table>
    </body>
</html>