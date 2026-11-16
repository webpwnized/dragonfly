<?php

// Verify that the web server can execute PHP without external dependencies.
http_response_code(200);
header('Content-Type: text/plain; charset=UTF-8');
header('Cache-Control: no-store');
header('X-Content-Type-Options: nosniff');

echo "ok\n";