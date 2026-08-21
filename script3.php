<?php
$file = 'd:\antigravity\e-Aspira\routes\web.php';
$content = file_get_contents($file);

$search = '     = shell_exec("cd \"\" && php artisan migrate --force 2>&1");' . "\n" . '     = shell_exec("cd \"\" && npm install 2>&1");';
$replace = '     = shell_exec("cd \"\" && php artisan migrate --force 2>&1");' . "\n" . '     = shell_exec("cd \"\" && php artisan optimize:clear 2>&1");' . "\n" . '     = shell_exec("cd \"\" && npm install 2>&1");';

// Try replacing with \n
$content = str_replace($search, $replace, $content);

// If it failed, try with \r\n
$search_crlf = '     = shell_exec("cd \"\" && php artisan migrate --force 2>&1");' . "\r\n" . '     = shell_exec("cd \"\" && npm install 2>&1");';
$replace_crlf = '     = shell_exec("cd \"\" && php artisan migrate --force 2>&1");' . "\r\n" . '     = shell_exec("cd \"\" && php artisan optimize:clear 2>&1");' . "\r\n" . '     = shell_exec("cd \"\" && npm install 2>&1");';

$content = str_replace($search_crlf, $replace_crlf, $content);

file_put_contents($file, $content);
echo "Replaced lines via PHP";
