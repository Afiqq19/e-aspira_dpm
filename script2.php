<?php
$file = 'd:\antigravity\e-Aspira\routes\web.php';
$content = file_get_contents($file);

// Replace the execution block
$content = preg_replace(
    '/php artisan migrate --force 2>&1"\);\s+$output5 = shell_exec\("cd "\\" && npm install 2>&1"\);/s',
    'php artisan migrate --force 2>&1");' . "\n" . '    $output_clear = shell_exec("cd \"$repoDir\" && php artisan optimize:clear 2>&1");' . "\n" . '    $output5 = shell_exec("cd \"$repoDir\" && npm install 2>&1");',
    $content
);

file_put_contents($file, $content);
echo "PHP RegEx Replace Done";
