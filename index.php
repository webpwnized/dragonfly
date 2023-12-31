<?php

    $l_http_client_ip_address = "";
    $l_http_x_forwarded_for = "";
    $l_http_x_forwarded = "";
    $l_http_forwarded_for = "";
    $l_http_forwarded = "";
    $l_http_remote_address = "";
    

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

    if (isset($_SERVER['HTTP_REMOTE_ADDR'])){
        $l_http_remote_address = $_SERVER['HTTP_REMOTE_ADDR'];
    };  

    phpinfo();

?>


<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Dragonfly</title>
        <link rel="stylesheet" href="styles.css">
    </head>

    <body class="content">
        <h1>Dragonfly</h1>
        <table class="styled-table">
            <thead>
                <tr>
                    <th>Data Point</th>
                    <th>Data</th>
                </tr>
            </thead>
            <tbody>
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
                <tr>
                    <td>HTTP Remote IP Address</td>
                    <td><?php echo htmlspecialchars($l_http_remote_address); ?></td>
                </tr>
            </tbody>
        </table>
    </body>
</html>