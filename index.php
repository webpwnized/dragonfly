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
    $l_user_agent_string = "";

    if (isset($_SERVER['HTTP_USER_AGENT'])){
        $l_user_agent_string = $_SERVER['HTTP_USER_AGENT'];
    };

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
                    
                    client.isWindows();
                    client.isMac();
                    client.isLinux();
                    client.isUbuntu();
                    client.isSolaris();

                    client.getDevice();
                    client.getDeviceType();
                    client.getDeviceVendor();

                    client.getCPU();

                    client.isMobile();
                    client.isMobileMajor();
                    client.isMobileAndroid();
                    client.isMobileOpera();
                    client.isMobileWindows();
                    client.isMobileBlackBerry();

                    client.isMobileIOS();
                    client.isIphone();
                    client.isIpad();
                    client.isIpod();

                    client.getScreenPrint();
                    client.getColorDepth();
                    client.getCurrentResolution();
                    client.getAvailableResolution();
                    client.getDeviceXDPI();
                    client.getDeviceYDPI();

                    client.getPlugins();
                    client.isSilverlight();
                    client.getSilverlightVersion();

                    client.getMimeTypes();
                    client.isMimeTypes();

                    client.isFont();
                    client.getFonts();

                    client.isLocalStorage();
                    client.isSessionStorage();
                    client.isCookie();

                    client.getTimeZone();

                    client.getLanguage();
                    client.getSystemLanguage();

                    client.isCanvas();
                    client.getCanvasPrint();
                }
            });

        </script>
    </head>
    <body class="content">
        <table class="styled-table">
            <thead>
                <tr>
                    <th>Data Point</th>
                    <th>Value</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>User Agent String</th>
                    <td><?php echo htmlspecialchars($l_user_agent_string); ?></td>
                </tr>
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
                    <th>Browser Version</th>
                    <td><span id="id4"></span></td>
                </tr>
                <tr>
                    <th>Browser Engine</th>
                    <td><span id="id5"></span></td>
                </tr>
                <tr>
                    <th>Browser Engine Version</th>
                    <td><span id="id6"></span></td>
                </tr>
                <tr>
                    <th>Operating System</th>
                    <td><span id="id7"></span></td>
                </tr>
                <tr>
                    <th>Operating System Version</th>
                    <td><span id="id8"></span></td>
                </tr>
            </tbody>
        </table>
    </body>
</html>