<?php

$url = 'https://e-aspiradpm.xie.my.id/login';

// 1. Get the login page to grab CSRF token and session cookie
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, true);
$response = curl_exec($ch);
$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
$headers = substr($response, 0, $header_size);
$body = substr($response, $header_size);
curl_close($ch);

// Extract XSRF-TOKEN and laravel_session from headers
preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $headers, $matches);
$cookies = array();
foreach($matches[1] as $item) {
    parse_str($item, $cookie);
    $cookies = array_merge($cookies, $cookie);
}

// Extract CSRF token from meta tag
preg_match('/<meta name="csrf-token" content="(.*?)">/', $body, $csrf_match);
$csrf = $csrf_match[1] ?? '';

echo "CSRF Token: " . $csrf . "\n";
echo "Cookies: " . print_r($cookies, true) . "\n";

