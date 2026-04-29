<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter+Tight:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

        <style>
            :root {
                --color-primary: #6233a4;
                --color-primary-light: #9063cf;
                --color-primary-dark: #20153a;
            }
            body {
                font-family: 'Inter Tight', sans-serif;
            }
        </style>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-white text-[#1a1523] min-h-screen">
        {{-- Navigation --}}
        <nav class="flex items-center justify-between px-8 py-6 max-w-7xl mx-auto">
            <div class="flex items-center gap-2">
                <div class="w-10 h-10 bg-[#6233a4] rounded-xl flex items-center justify-center shadow-lg shadow-purple-500/20">
                    <x-filament::icon icon="heroicon-m-identification" class="w-6 h-6 text-white" />
                </div>
                <span class="text-xl font-black tracking-tighter uppercase">DEMO <span class="text-[#6233a4]">SaaS</span></span>
            </div>
            
            <div class="flex items-center gap-4">
                @if (Route::has('login'))
                    @auth
                        <x-filament::button href="/admin" tag="a" color="gray" outlined>
                            Dashboard
                        </x-filament::button>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-semibold hover:text-[#6233a4] transition-colors">Iniciar Sesión</a>
                        @if (Route::has('register'))
                            <x-filament::button href="{{ route('register') }}" tag="a">
                                Registrarse
                            </x-filament::button>
                        @endif
                    @endauth
                @endif
            </div>
        </nav>

        {{-- Hero Section --}}
        <main class="max-w-7xl mx-auto px-8 py-20 lg:py-32">
            <div class="grid lg:grid-cols-2 gap-20 items-center">
                <div class="space-y-8">
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-purple-50 text-[#6233a4] text-sm font-bold border border-purple-100">
                        <span class="relative flex h-2 w-2">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-purple-400 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-2 w-2 bg-[#6233a4]"></span>
                        </span>
                        Nueva Versión v2.0
                    </div>
                    
                    <h1 class="text-5xl lg:text-7xl font-black tracking-tight leading-[1.1]">
                        Gestión Legal e Inteligente con <span class="text-[#6233a4]">WhatsApp</span>
                    </h1>
                    
                    <p class="text-xl text-gray-500 max-w-xl leading-relaxed">
                        Optimiza la atención a tus clientes, automatiza tus expedientes y agenda citas profesionales de manera automática. La solución SaaS definitiva para despachos modernos.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4 pt-4">
                        <x-filament::button href="/admin" tag="a" size="xl" color="gray" outlined class="rounded-2xl bg-gray-50">
                            Explorar el Panel
                        </x-filament::button>
                    </div>
                </div>

                {{-- Feature Cards --}}
                <div class="grid sm:grid-cols-2 gap-6 relative">
                    <div class="absolute inset-0 bg-purple-100/50 blur-3xl rounded-full -z-10"></div>
                    
                    <div class="p-8 bg-white rounded-3xl border border-gray-100 shadow-xl shadow-purple-500/5 space-y-4 translate-y-8">
                        <div class="w-12 h-12 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600">
                            <x-filament::icon icon="heroicon-o-chat-bubble-left-right" class="w-6 h-6" />
                        </div>
                        <h3 class="text-xl font-bold">Automatización</h3>
                        <p class="text-gray-500 text-sm">Responde automáticamente a tus clientes vía WhatsApp 24/7.</p>
                    </div>

                    <div class="p-8 bg-white rounded-3xl border border-gray-100 shadow-xl shadow-purple-500/5 space-y-4">
                        <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600">
                            <x-filament::icon icon="heroicon-o-identification" class="w-6 h-6" />
                        </div>
                        <h3 class="text-xl font-bold">Expedientes</h3>
                        <p class="text-gray-500 text-sm">Control total de la información y documentos de tus clientes.</p>
                    </div>

                    <div class="p-8 bg-white rounded-3xl border border-gray-100 shadow-xl shadow-purple-500/5 space-y-4 translate-y-8">
                        <div class="w-12 h-12 bg-purple-50 rounded-2xl flex items-center justify-center text-[#6233a4]">
                            <x-filament::icon icon="heroicon-o-banknotes" class="w-6 h-6" />
                        </div>
                        <h3 class="text-xl font-bold">Pagos</h3>
                        <p class="text-gray-500 text-sm">Seguimiento de cobranza y recibos automatizados.</p>
                    </div>

                    <div class="p-8 bg-white rounded-3xl border border-gray-100 shadow-xl shadow-purple-500/5 space-y-4">
                        <div class="w-12 h-12 bg-amber-50 rounded-2xl flex items-center justify-center text-amber-600">
                            <x-filament::icon icon="heroicon-o-calendar-days" class="w-6 h-6" />
                        </div>
                        <h3 class="text-xl font-bold">Citas</h3>
                        <p class="text-gray-500 text-sm">Calendario inteligente sincronizado con tus procesos.</p>
                    </div>
                </div>
            </div>
        </main>

        {{-- Footer --}}
        <footer class="border-t border-gray-100 py-12 mt-20">
            <div class="max-w-7xl mx-auto px-8 flex flex-col md:row items-center justify-between gap-6">
                <span class="text-gray-400 text-sm">© {{ now()->year }} Demo Panel SaaS. Todos los derechos reservados.</span>
                <div class="flex gap-8">
                    <a href="#" class="text-gray-400 hover:text-[#6233a4] transition-colors text-sm">Términos</a>
                    <a href="#" class="text-gray-400 hover:text-[#6233a4] transition-colors text-sm">Privacidad</a>
                    <a href="#" class="text-gray-400 hover:text-[#6233a4] transition-colors text-sm">Soporte</a>
                </div>
            </div>
        </footer>
    </body>
</html>
