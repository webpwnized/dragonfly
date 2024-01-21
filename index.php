<?php

    /* Enable HSTS - Only available with HTTPS*/
    //header("Strict-Transport-Security: max-age=31536000; includeSubDomains", TRUE);

    // HTTP/1.1 cache control
    header('Cache-Control: no-store, no-cache', TRUE);

    /* Cross-frame scripting and click-jacking */
    header('X-FRAME-OPTIONS: DENY', TRUE);

    /* Client-side Script injection */
    header("Content-Security-Policy: default-src 'self'; script-src 'self' 'nonce-efe3f3d7e23b979ae212c5092469ce195401701a71a00eba0f4f955a068b05e2'", TRUE);

    /* Content sniffing */
    header('X-Content-Type-Options: nosniff', TRUE);

    /* Referrer Policy */
    header('Referrer-Policy: no-referrer', TRUE);

    /* Server version banners */
    header_remove('X-Powered-By');
    header_remove('Server');

    $l_client_ip_address = "";
    $l_forwarded_for = "";

    if (isset($_SERVER['HTTP_CLIENT_IP'])){
        $l_client_ip_address = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (isset($_SERVER['REMOTE_ADDR'])){
        $l_client_ip_address = $_SERVER['REMOTE_ADDR'];
    };
    
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
        $l_forwarded_for = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } elseif (isset($_SERVER['HTTP_X_FORWARDED'])){
        $l_forwarded_for = $_SERVER['HTTP_X_FORWARDED'];
    } elseif (isset($_SERVER['HTTP_FORWARDED_FOR'])){
        $l_forwarded_for = $_SERVER['HTTP_FORWARDED_FOR'];
    } elseif (isset($_SERVER['HTTP_FORWARDED'])){
        $l_forwarded_for = $_SERVER['HTTP_FORWARDED'];
    };  

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

            document.addEventListener('readystatechange', event => {
                // When window loaded ( external resources are loaded too- `css`,`src`, etc...) 
                if (event.target.readyState === "complete") {
                    // in a browser, when using a script tag:
                    const ClientJS = window.ClientJS;

                    // Create a new ClientJS object
                    const client = new ClientJS();

                    window.document.getElementById("id1").innerText = client.getFingerprint();
                    window.document.getElementById("id2").innerText = client.getUserAgent();
                    window.document.getElementById("id3").innerText = client.getBrowser();
                    window.document.getElementById("id4").innerText = client.getBrowserVersion();
                    window.document.getElementById("id5").innerText = client.getEngine();
                    window.document.getElementById("id6").innerText = client.getEngineVersion();
                    window.document.getElementById("id7").innerText = client.getOS();
                    window.document.getElementById("id8").innerText = client.getOSVersion();
                    window.document.getElementById("id9").innerText = client.getDevice();
                    window.document.getElementById("id10").innerText = client.getDeviceType();
                    window.document.getElementById("id11").innerText = client.getDeviceVendor();
                    window.document.getElementById("id12").innerText = client.getCPU();
                    window.document.getElementById("id13").innerText = client.isMobile();
                    window.document.getElementById("id14").innerText = client.isMobileMajor();
                    window.document.getElementById("id15").innerText = client.getScreenPrint();
                    window.document.getElementById("id16").innerText = client.getColorDepth();
                    window.document.getElementById("id17").innerText = client.getCurrentResolution();
                    window.document.getElementById("id18").innerText = client.getAvailableResolution();
                    window.document.getElementById("id19").innerText = client.getDeviceXDPI();
                    window.document.getElementById("id20").innerText = client.getDeviceYDPI();
                    window.document.getElementById("id21").innerText = client.getPlugins();
                    window.document.getElementById("id22").innerText = client.getSilverlightVersion();
                    window.document.getElementById("id23").innerText = client.getMimeTypes();
                    window.document.getElementById("id24").innerText = client.getFonts();
                    window.document.getElementById("id25").innerText = client.isLocalStorage();
                    window.document.getElementById("id26").innerText = client.isSessionStorage();
                    window.document.getElementById("id27").innerText = client.isCookie();
                    window.document.getElementById("id28").innerText = client.getTimeZone();
                    window.document.getElementById("id29").innerText = client.getLanguage();
                    window.document.getElementById("id30").innerText = client.getSystemLanguage();
                    window.document.getElementById("id31").innerText = client.getCanvasPrint().left(64);
                }
            });

        </script>
    </head>
    <body class="content">
        <div class="page-header">
            <img src="images/blue-dragonfly-icon.jpg" height="75px" width="75px" alt="" />
            <span>Dragonfly</span>
        </div>
        <table class="styled-table">
            <thead>
                <tr>
                    <th>Data Point</th>
                    <th>Value</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>HTTP Client IP Address</th>
                    <td><?php echo htmlspecialchars($l_client_ip_address); ?></td>
                </tr>
                <tr>
                    <th>Forwarded For</th>
                    <td><?php echo htmlspecialchars($l_forwarded_for); ?></td>
                </tr>
                <tr>
                    <th>Browser Tracking Fingerprint</th>
                    <td><span id="id1"></span></td>
                </tr>
                <tr>
                    <th>User Agent</th>
                    <td><span id="id2"></span></td>
                </tr>
                <tr>
                    <th>Browser</th>
                    <td><span id="id3"></span></td>
                </tr>
                <tr>
                    <th>Browser Engine</th>
                    <td>
                        <span id="id7"></span>&nbsp;&lpar;<span id="id8"></span>&rpar;&nbsp;
                        <span id="id5"></span>&nbsp;
                        <span id="id6"></span>
                    </td>
                </tr>
                <tr>
                    <th>Plugins</th>
                    <td><span id="id21"></span></td>
                </tr>
                <tr>
                    <th>CPU</th>
                    <td><span id="id12"></span></td>
                </tr>
                <tr>
                    <th>Screen Print</th>
                    <td><span id="id15"></span></td>
                </tr>
                <tr>
                    <th>Color Depth</th>
                    <td><span id="id16"></span></td>
                </tr>
                <tr>
                    <th>Current Resolution</th>
                    <td><span id="id17"></span></td>
                </tr>
                <tr>
                    <th>Available Resolution</th>
                    <td><span id="id18"></span></td>
                </tr>
                <tr>
                    <th>Mime Types</th>
                    <td><span id="id23"></span></td>
                </tr>
                <tr>
                    <th>Fonts</th>
                    <td><span id="id24"></span></td>
                </tr>
                <tr>
                    <th>Local Storage</th>
                    <td><span id="id25"></span></td>
                </tr>
                <tr>
                    <th>Session Storage</th>
                    <td><span id="id26"></span></td>
                </tr>
                <tr>
                    <th>Cookies</th>
                    <td><span id="id27"></span></td>
                </tr>
                <tr>
                    <th>Time Zone</th>
                    <td><span id="id28"></span></td>
                </tr>
                <tr>
                    <th>Language</th>
                    <td><span id="id29"></span></td>
                </tr>
                <tr>
                    <th>System Language</th>
                    <td><span id="id30"></span></td>
                </tr>
                <tr>
                    <th>Canvas Print</th>
                    <td><span id="id31"></span></td>
                </tr>
                <tr>
                    <th>Device XPDI</th>
                    <td><span id="id19"></span></td>
                </tr>
                <tr>
                    <th>Device YPDI</th>
                    <td><span id="id20"></span></td>
                </tr>
                <tr>
                    <th>Silverlight Version</th>
                    <td><span id="id22"></span></td>
                </tr>
                <tr>
                    <th>Device</th>
                    <td><span id="id9"></span></td>
                </tr>
                <tr>
                    <th>Device Type</th>
                    <td><span id="id10"></span></td>
                </tr>
                <tr>
                    <th>Device Vendor</th>
                    <td><span id="id11"></span></td>
                </tr>
                <tr>
                    <th>Is Mobile</th>
                    <td><span id="id13"></span></td>
                </tr>
                <tr>
                    <th>Mobile Vendor</th>
                    <td><span id="id14"></span></td>
                </tr>
            </tbody>
        </table>
    </body>
</html>