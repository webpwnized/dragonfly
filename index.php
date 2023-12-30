<?php
	// create a function to get the client IP
  function get_client_ip_address() {
      $l_client_ip_address = '';
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
  
  // print ip address
  echo get_client_ip_address();
?>