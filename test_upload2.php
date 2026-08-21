<?php

$url = 'https://e-aspiradpm.xie.my.id/login';

// 1. Get the login page to grab CSRF token and session cookie
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$response = curl_exec($ch);
$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
$headers = substr($response, 0, $header_size);
$body = substr($response, $header_size);
curl_close($ch);

preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $headers, $matches);
$cookie_str = '';
foreach($matches[1] as $item) {
    $cookie_str .= $item . '; ';
}

preg_match('/<meta name="csrf-token" content="(.*?)">/', $body, $csrf_match);
$csrf = $csrf_match[1] ?? '';

// 2. Create a dummy 1MB PDF file
$dummyFile = 'dummy.pdf';
file_put_contents($dummyFile, str_repeat('0', 1024 * 1024)); // 1MB

// 3. Upload to Livewire
$uploadUrl = 'https://e-aspiradpm.xie.my.id/livewire/upload-file?expires=' . time() . '&signature=dummy';
$ch2 = curl_init();
curl_setopt($ch2, CURLOPT_URL, $uploadUrl);
curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch2, CURLOPT_POST, true);

// Create CURLFile
$cfile = new CURLFile($dummyFile, 'application/pdf', 'dummy.pdf');
$post = array('files[0]' => $cfile);
curl_setopt($ch2, CURLOPT_POSTFIELDS, $post);

curl_setopt($ch2, CURLOPT_HTTPHEADER, array(
    'X-CSRF-TOKEN: ' . $csrf,
    'Cookie: ' . $cookie_str,
    'Accept: application/json'
));
curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);

$response2 = curl_exec($ch2);
$status_code = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
curl_close($ch2);

echo "HTTP Status: " . $status_code . "\n";
echo "Response: " . $response2 . "\n";

