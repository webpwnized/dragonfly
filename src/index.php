<?php
    /**
     * Gets the most reliable public IP address of the client for analysis (like Tor check).
     */
    function get_best_guess_ip() {
        $headers_to_check = [
            'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED',
            'HTTP_X_REAL_IP', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_CLIENT_IP', 'REMOTE_ADDR'
        ];
        foreach ($headers_to_check as $header) {
            if (isset($_SERVER[$header])) {
                $ip_list = explode(',', $_SERVER[$header]);
                $potential_ip = trim(reset($ip_list));
                if (filter_var($potential_ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                    return $potential_ip;
                }
            }
        }
        return $_SERVER['REMOTE_ADDR'] ?? false;
    }

    /**
     * Checks if a given IP address is a known Tor exit node.
     */
    function is_tor_exit_node($ip) {
        if (empty($ip) || !filter_var($ip, FILTER_VALIDATE_IP)) {
            return false;
        }
        $reversed_ip = implode('.', array_reverse(explode('.', $ip)));
        $check_host = $reversed_ip . '.dnsel.torproject.org';
        return gethostbyname($check_host) === '127.0.0.2';
    }

    // --- Main Logic ---

    // 1. RESTORED: Get the direct server IP (REMOTE_ADDR)
    $remoteAddr = $_SERVER['REMOTE_ADDR'] ?? '';

    // 2. RESTORED: Get the raw forwarded-for header value
    $forwardedFor = '';
    foreach (['HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED'] as $header) {
        if (isset($_SERVER[$header])) {
            $forwardedFor = $_SERVER[$header];
            break;
        }
    }

    // 3. NEW: Perform the Tor check on the most likely user IP
    $bestIpForAnalysis = get_best_guess_ip();
    $isTorUser = is_tor_exit_node($bestIpForAnalysis);

    // --- Security Headers ---
    // header("Strict-Transport-Security: max-age=31536000; includeSubDomains", true);
    header('Cache-Control: no-store, no-cache', true);
    header('X-FRAME-OPTIONS: DENY', true);
    $contentSecurityPolicy = "Content-Security-Policy: " .
        "default-src 'self'; script-src 'self' 'nonce-efe3f3d7e23b979ae212c5092469ce195401701a71a00eba0f4f955a068b05e2'";
    header($contentSecurityPolicy, true);
    header('X-Content-Type-Options: nosniff', true);
    header('Referrer-Policy: no-referrer', true);
    header_remove('X-Powered-By');
    header_remove('Server');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dragonfly</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="javascript/client.base.min.js"></script>
    <script src="javascript/browserDataStorage.js"></script>
    <script nonce="efe3f3d7e23b979ae212c5092469ce195401701a71a00eba0f4f955a068b05e2">

        String.prototype.left = function(n) {
            return this.substr(0,n);
        };

        function sanitizeValue(pValue) {
            if (typeof pValue === 'undefined' || pValue === null || pValue === "null" || pValue === "undefined") {
                return "";
            }
            if (pValue === true || pValue === "true") return "Yes";
            if (pValue === false || pValue === "false") return "No";
            return pValue;
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
                // Pass all three PHP variables to JavaScript
                const lRemoteAddr = "<?php echo htmlspecialchars($remoteAddr); ?>";
                const lForwardedFor = "<?php echo htmlspecialchars($forwardedFor); ?>";
                const lIsTorUser = <?php echo $isTorUser ? 'true' : 'false'; ?>;
                const lBrowserFingerprint = client.getFingerprint();

                const browserDataStorage = new BrowserDataStorage();
                browserDataStorage.putInCookie(lBrowserFingerprint);
                browserDataStorage.putInLocalStorage(lBrowserFingerprint);
                browserDataStorage.putInSessionStorage(lBrowserFingerprint);
                browserDataStorage.putInIndexedDB(lBrowserFingerprint);

                // Populate original and new data points
                outputDataPoint("id32", "RemoteAddr", lRemoteAddr);
                outputDataPoint("id33", "ForwardedFor", lForwardedFor);
                outputDataPoint("id37", "IsTorUser", lIsTorUser);
                outputDataPoint("id1", "BrowserFingerprint", lBrowserFingerprint);
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
                outputDataPoint("id34", "FingerprintCookie", browserDataStorage.getFromCookie());
                outputDataPoint("id35", "FingerprintLocalStorage", browserDataStorage.getFromLocalStorage());
                outputDataPoint("id36", "FingerprintSessionStorage", browserDataStorage.getFromSessionStorage());
            };
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
                <th scope="row">Direct IP Address (REMOTE_ADDR)</th>
                <td><span id="id32"></span></td>
            </tr>
            <tr>
                <th scope="row">Forwarded-For Header</th>
                <td><span id="id33"></span></td>
            </tr>
            <tr>
                <th scope="row">Using Tor Network 🧅</th>
                <td><span id="id37"></span></td>
            </tr>
            <tr>
                <th scope="row">Browser Tracking Fingerprint</th>
                <td><span id="id1"></span></td>
            </tr>
            <tr>
                <th scope="row">Fingerprint (Cookie)</th>
                <td><span id="id34"></span></td>
            </tr>
            <tr>
                <th scope="row">Fingerprint (Local Storage)</th>
                <td><span id="id35"></span></td>
            </tr>
            <tr>
                <th scope="row">Fingerprint (Session Storage)</th>
                <td><span id="id36"></span></td>
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