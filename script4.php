<?php
$file = 'd:\antigravity\e-Aspira\resources\views\layouts\publik.blade.php';
$content = file_get_contents($file);

// Replace </head> with @livewireStyles </head>
$content = str_replace('</head>', "        @livewireStyles\n    </head>", $content);

// Replace </body> with @livewireScripts </body>
$content = str_replace('</body>', "        @livewireScripts\n    </body>", $content);

file_put_contents($file, $content);
echo "Injected Livewire into publik layout.";
