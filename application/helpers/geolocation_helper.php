<?php

define('LOCAL_IPV6', '::1');
define('LOCAL_IPV4', '127.0.0.1');

/**
 * This function is used to get geolocation data from an ip
 * 
 * @param string $user_ip User ip to get geolocation data
 * @return Array An array with geolocation data
 */
function get_geoplugin_data($user_ip) {
    $CI = get_instance();
    $localServerEnabled = $CI->config->item('local_server');
    if($localServerEnabled && ($user_ip == LOCAL_IPV4 || $user_ip == LOCAL_IPV6)) {
        return $CI->config->item('default_geolocation');
    }
    
    $geo = unserialize(file_get_contents("http://www.geoplugin.net/php.gp?ip=$user_ip"));
    return $geo;
}

/**
 * This function is used to get longitude and latitude from current client
 * 
 * @return Array An array with longitude and latitude
 */
function get_current_location() {
    $user_ip = getenv('REMOTE_ADDR');
    $geo_data = get_geoplugin_data($user_ip);
    return [
        'latitude' => $geo_data['geoplugin_latitude'],
        'longitude' => $geo_data['geoplugin_longitude']
    ];
}

