<?php
$file = 'd:\antigravity\e-Aspira\routes\web.php';
$content = file_get_contents($file);

$content = str_replace(
    '$output4 = shell_exec("cd \".$repoDir.\" && php artisan migrate --force 2>&1");',
    '$output4 = shell_exec("cd \".$repoDir.\" && php artisan migrate --force 2>&1");' . "\n" . '      $output_clear = shell_exec("cd \".$repoDir.\" && php artisan optimize:clear 2>&1");',
    $content
);

$content = str_replace(
    '[DATABASE MIGRATE]\n  " . htmlspecialchars((string) $output4) . "',
    '[DATABASE MIGRATE]\n  " . htmlspecialchars((string) $output4) . "\n\n  [CLEAR CACHE]\n  " . htmlspecialchars((string) $output_clear) . "',
    $content
);

file_put_contents($file, $content);
echo "Replaced successfully.";
