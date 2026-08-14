<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'e-Aspira DPM Polmed') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('images/icon_dpm.png') }}">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-slate-800 bg-slate-50 flex h-screen overflow-hidden">
        
        <!-- Sidebar Dashboard -->
        <livewire:layout.sidebar />

        <!-- Main Content -->
        <div class="flex-1 flex flex-col h-screen overflow-hidden bg-slate-50 relative">
            
            <!-- Blob Background Effect (Premium UI) -->
            <div class="absolute top-0 left-0 w-full h-96 overflow-hidden -z-10 pointer-events-none opacity-40">
                <div class="absolute -top-24 -left-24 w-96 h-96 rounded-full bg-brand-300 blur-3xl animate-blob"></div>
                <div class="absolute top-12 right-24 w-80 h-80 rounded-full bg-violet-300 blur-3xl animate-blob" style="animation-delay: 2s;"></div>
            </div>

            <!-- Header Dashboard -->
            <livewire:layout.header />

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-6 sm:p-8 animate-fade-in z-0 relative pb-20">
                
                @if (isset($header))
                    <div class="mb-8">
                        <h1 class="text-2xl font-heading font-bold text-slate-800 flex items-center gap-3">
                            {{ $header }}
                        </h1>
                    </div>
                @endif

                {{ $slot }}
                
            </main>
        </div>
    </body>
</html>
