<?php
$file = 'd:\antigravity\e-Aspira\bootstrap\app.php';
$content = file_get_contents($file);

$search = '    ->withMiddleware(function (Middleware ): void {
        // Daftarkan middleware alias custom';
$replace = '    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->trustProxies(at: ''*'');
        // Daftarkan middleware alias custom';

$content = str_replace($search, $replace, $content);
file_put_contents($file, $content);
echo "Added trustProxies";
