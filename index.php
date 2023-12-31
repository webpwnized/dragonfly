<?php
    // create a function to get the client IP
    function get_client_ip_address() {
        $l_client_ip_address = "";

        if (getenv('HTTP_CLIENT_IP'))
            $l_client_ip_address = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $l_client_ip_address = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $l_client_ip_address = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $l_client_ip_address = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
            $l_client_ip_address = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $l_client_ip_address = getenv('REMOTE_ADDR');
        else
            $l_client_ip_address = 'UNKNOWN';
        return $l_client_ip_address;
    }
  
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Dragonfly</title>
        <link rel="stylesheet" href="styles.css">
    </head>

    <body>
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
                    <td>Client IP Address</td>
                    <td><?php echo get_client_ip_address(); ?></td>
                </tr>
            </tbody>
        </table>
    </body>
</html>