<?php
    // Enable HSTS (HTTP Strict Transport Security) - Only available with HTTPS
    // header("Strict-Transport-Security: max-age=31536000; includeSubDomains", true);

    // HTTP/1.1 cache control
    header('Cache-Control: no-store, no-cache', true);

    // Cross-frame scripting and click-jacking
    header('X-FRAME-OPTIONS: DENY', true);

    // Client-side Script injection
    $contentSecurityPolicy = "Content-Security-Policy: " .
        "default-src 'self'; script-src 'self' 'nonce-efe3f3d7e23b979ae212c5092469ce195401701a71a00eba0f4f955a068b05e2'";
    header($contentSecurityPolicy, true);

    // Content sniffing prevention
    header('X-Content-Type-Options: nosniff', true);

    // Referrer Policy
    header('Referrer-Policy: no-referrer', true);

    // Remove server version banners
    header_remove('X-Powered-By');
    header_remove('Server');

    // Get client IP address
    $clientIpAddress = isset($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : 
        (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '');

    // Get forwarded IP address
    $forwardedFor = '';
    foreach (['HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED'] as $header) {
        if (isset($_SERVER[$header])) {
            $forwardedFor = $_SERVER[$header];
            break;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dragonfly</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="javascript/client.base.min.js"></script>
    <script nonce="efe3f3d7e23b979ae212c5092469ce195401701a71a00eba0f4f955a068b05e2">
        // Credit to https://github.com/JackSpirou/ClientJS?tab=readme-ov-file#bundles
        String.prototype.left = function(n) {
            return this.substr(0,n);
        };

        function sanitizeValue(pValue) {
            if ($pValue === "null" || $pValue === null || $pValue === "undefined" || $pValue === undefined) {
                return "";
            } else if (typeof pValue === 'undefined') {
                return "";
            } else if ($pValue === "true" || $pValue === true) {
                return "Yes";
            } else if ($pValue === "false" || $pValue === false) {
                return "No";
            } else {
                return $pValue;
            }
        }

        function outputDataPoint(pSpanId, pKey, pValue) {
            const sessionStorage = window.sessionStorage;
            const previousValue = sanitizeValue(sessionStorage.getItem(pKey));
            const currentValue = sanitizeValue(pValue);
            const span = document.getElementById(pSpanId);
            span.innerText = currentValue;
            if (previousValue !== currentValue) {
                span.style.color = "blue";
            }
            sessionStorage.setItem(pKey, currentValue);
        }

        document.addEventListener('readystatechange', event => {
            if (event.target.readyState === "complete") {
                const client = new ClientJS();
                const lClientIP = "<?php echo htmlspecialchars($clientIpAddress); ?>";
                const lForwardedFor = "<?php echo htmlspecialchars($forwardedFor); ?>";

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
        <img src="images/blue-dragonfly-icon.jpg" height="175px" width="175px" alt="">
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