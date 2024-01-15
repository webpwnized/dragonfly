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
        <script type="text/javascript" src="javascript/console.log(client.base.min.js">
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

                    // Get the client's fingerprint id
                    const fingerprint = client.getFingerprint();

                    // Print the 32bit hash id to the console
                    console.log(fingerprint);

                    console.log(client.getBrowserData());
                    console.log(client.getFingerprint());

                    console.log(client.getUserAgent());
                    console.log(client.getUserAgentLowerCase());

                    console.log(client.getBrowser());
                    console.log(client.getBrowserVersion());
                    console.log(client.getBrowserMajorVersion());
                    console.log(client.isIE());
                    console.log(client.isChrome());
                    console.log(client.isFirefox());
                    console.log(client.isSafari());
                    console.log(client.isOpera());

                    console.log(client.getEngine());
                    console.log(client.getEngineVersion());

                    console.log(client.getOS());
                    console.log(client.getOSVersion());
                    console.log(client.isWindows());
                    console.log(client.isMac());
                    console.log(client.isLinux());
                    console.log(client.isUbuntu());
                    console.log(client.isSolaris());

                    console.log(client.getDevice());
                    console.log(client.getDeviceType());
                    console.log(client.getDeviceVendor());

                    console.log(client.getCPU());

                    console.log(client.isMobile());
                    console.log(client.isMobileMajor());
                    console.log(client.isMobileAndroid());
                    console.log(client.isMobileOpera());
                    console.log(client.isMobileWindows());
                    console.log(client.isMobileBlackBerry());

                    console.log(client.isMobileIOS());
                    console.log(client.isIphone());
                    console.log(client.isIpad());
                    console.log(client.isIpod());

                    console.log(client.getScreenPrint());
                    console.log(client.getColorDepth());
                    console.log(client.getCurrentResolution());
                    console.log(client.getAvailableResolution());
                    console.log(client.getDeviceXDPI());
                    console.log(client.getDeviceYDPI());

                    console.log(client.getPlugins());
                    console.log(client.isSilverlight());
                    console.log(client.getSilverlightVersion());

                    console.log(client.getMimeTypes());
                    console.log(client.isMimeTypes());

                    console.log(client.isFont());
                    console.log(client.getFonts());

                    console.log(client.isLocalStorage());
                    console.log(client.isSessionStorage());
                    console.log(client.isCookie());

                    console.log(client.getTimeZone());

                    console.log(client.getLanguage());
                    console.log(client.getSystemLanguage());

                    console.log(client.isCanvas());
                    console.log(client.getCanvasPrint());
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
            </tbody>
        </table>
    </body>
</html>