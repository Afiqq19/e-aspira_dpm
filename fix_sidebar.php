<?php
$c = file_get_contents('d:/antigravity/e-Aspira/resources/views/livewire/layout/sidebar.blade.php');
$c = preg_replace('/(\s*<a href="\{\{ route\(''admin\.uu-kema\.index''\) \}\}".*?<\/a>)/s', '', $c);
$replacement = '\' . "
              <a href=\"{{ route('admin.uu-kema.index') }}\" wire:navigate class=\"flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ \->isActive('admin.uu-kema.index') }}\">
                  <svg class=\"w-5 h-5\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z\"></path></svg>
                  <span class=\"font-medium\">Kelola UU Kema</span>
              </a>";
$c = preg_replace('/(\s*<span class="font-medium">Log Aktivitas<\/span>\s*<\/a>)/s', $replacement, $c);
file_put_contents('d:/antigravity/e-Aspira/resources/views/livewire/layout/sidebar.blade.php', $c);

