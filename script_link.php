<?php
$file = 'd:\antigravity\e-Aspira\routes\web.php';
$content = file_get_contents($file);

$content = str_replace(
    '$output_clear = shell_exec("cd \"$repoDir\" && php artisan optimize:clear 2>&1");',
    '$output_clear = shell_exec("cd \"$repoDir\" && php artisan optimize:clear 2>&1");' . "\n    " . '$output_link = shell_exec("cd \"$repoDir\" && php artisan storage:link 2>&1");',
    $content
);

file_put_contents($file, $content);
echo "Added storage:link";
