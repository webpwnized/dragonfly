<?php

    /* Built-in user-agent defenses */
    header("X-XSS-Protection: 1; mode=block;", TRUE);

    /* Enable HSTS - Only available with HTTPS*/
    //header("Strict-Transport-Security: max-age=31536000; includeSubDomains", TRUE);

    // HTTP/1.1 cache control
    header('Cache-Control: no-store, no-cache', TRUE);

    /* Cross-frame scripting and click-jacking */
    header('X-FRAME-OPTIONS: DENY', TRUE);

    /* Client-side Script injection */
    header('Content-Security-Policy: default-src \'self\';', TRUE);

    /* Content sniffing */
    header('X-Content-Type-Options: nosniff', TRUE);

    /* Referrer Policy */
    header('Referrer-Policy: no-referrer', TRUE);

    /* Server version banners */
    header_remove('X-Powered-By');
    header_remove('Server');

    $l_http_client_ip_address = "";
    $l_http_x_forwarded_for = "";
    $l_http_x_forwarded = "";
    $l_http_forwarded_for = "";
    $l_http_forwarded = "";
    $l_user_agent_string = "";

    if (isset($_SERVER['HTTP_USER_AGENT'])){
        $l_user_agent_string = $_SERVER['HTTP_USER_AGENT'];
    };

    if (isset($_SERVER['HTTP_CLIENT_IP'])){
        $l_client_ip_address = $_SERVER['HTTP_CLIENT_IP'];
    };
        
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
        $l_http_x_forwarded_for = $_SERVER['HTTP_X_FORWARDED_FOR'];
    };

    if (isset($_SERVER['HTTP_X_FORWARDED'])){
        $l_http_x_forwarded = $_SERVER['HTTP_X_FORWARDED'];
    };
    
    if (isset($_SERVER['HTTP_FORWARDED_FOR'])){
        $l_http_forwarded_for = $_SERVER['HTTP_FORWARDED_FOR'];
    };

    if (isset($_SERVER['HTTP_FORWARDED'])){
        $l_http_forwarded = $_SERVER['HTTP_FORWARDED'];
    };  

    if (isset($_SERVER['REMOTE_ADDR'])){
        $l_http_remote_address = $_SERVER['REMOTE_ADDR'];
    };

?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Dragonfly</title>
        <link rel="stylesheet" href="css/styles.css">
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
                    <td>User Agent String</td>
                    <td><?php echo htmlspecialchars($l_user_agent_string); ?></td>
                </tr>
                <tr>
                    <td>HTTP Remote IP Address</td>
                    <td><?php echo htmlspecialchars($l_http_remote_address); ?></td>
                </tr>
                <tr>
                    <td>HTTP Client IP Address</td>
                    <td><?php echo htmlspecialchars($l_http_client_ip_address); ?></td>
                </tr>
                <tr>
                    <td>X Forwarded For</td>
                    <td><?php echo htmlspecialchars($l_http_x_forwarded_for); ?></td>
                </tr>
                <tr>
                    <td>X Forwarded</td>
                    <td><?php echo htmlspecialchars($l_http_x_forwarded); ?></td>
                </tr>
                <tr>
                    <td>Forwarded For</td>
                    <td><?php echo htmlspecialchars($l_http_forwarded_for); ?></td>
                </tr>
                <tr>
                    <td>Forwarded</td>
                    <td><?php echo htmlspecialchars($l_http_forwarded); ?></td>
                </tr>
            </tbody>
        </table>
    </body>
</html>