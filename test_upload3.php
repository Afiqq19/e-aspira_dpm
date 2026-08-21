<?php

$url = 'https://e-aspiradpm.xie.my.id/login';

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

$dummyFile = 'dummy.pdf';

$uploadUrl = 'https://e-aspiradpm.xie.my.id/livewire/upload-file?expires=' . time() . '&signature=dummy';
$ch2 = curl_init();
curl_setopt($ch2, CURLOPT_URL, $uploadUrl);
curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch2, CURLOPT_POST, true);

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
$error = curl_error($ch2);
curl_close($ch2);

echo "HTTP Status: " . $status_code . "\n";
echo "cURL Error: " . $error . "\n";
echo "Response: " . $response2 . "\n";

