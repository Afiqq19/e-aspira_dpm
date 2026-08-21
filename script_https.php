<?php
$file = 'd:\antigravity\e-Aspira\app\Providers\AppServiceProvider.php';
$content = file_get_contents($file);

$search = 'public function boot(): void
    {
        //
    }';

$replace = 'public function boot(): void
    {
        if (config(''app.env'') !== ''local'') {
            \Illuminate\Support\Facades\URL::forceScheme(''https'');
        } else {
            // Force HTTPS dynamically if the URL contains xie.my.id
            if (str_contains(request()->getHost(), ''xie.my.id'')) {
                \Illuminate\Support\Facades\URL::forceScheme(''https'');
            }
        }
    }';

$content = str_replace($search, $replace, $content);
file_put_contents($file, $content);
echo "Added forceScheme";
