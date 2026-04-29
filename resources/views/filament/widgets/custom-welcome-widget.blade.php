<x-filament-widgets::widget>
    <div class="fi-wi-custom-welcome p-12 bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-white/10 shadow-sm" style="padding: 3rem !important;">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-12">
            
            {{-- Content --}}
            <div class="space-y-6">
                <h2 class="text-3xl font-extrabold tracking-tight text-gray-950 dark:text-white sm:text-4xl">
                    ¡Bienvenido, <span class="text-[#6233a4] dark:text-[#9063cf] font-black">{{ auth()->user()->name }}</span>! 👋
                </h2>

                <p class="max-w-2xl text-xl text-gray-500 dark:text-gray-400 leading-relaxed font-light italic">
                    Plataforma de gestión inteligente. Monitorea expedientes, citas y procesos automatizados con identidad corporativa.
                </p>

                <div class="flex flex-wrap gap-4 mt-6">
                    <x-filament::badge icon="heroicon-m-check-badge" color="success" size="lg" class="px-5 py-2">
                        Sistema Operativo
                    </x-filament::badge>
                    <x-filament::badge icon="heroicon-m-bolt" color="info" size="lg" class="px-5 py-2">
                        Bot WhatsApp Activo
                    </x-filament::badge>
                    <x-filament::badge icon="heroicon-m-clock" color="gray" size="lg" class="px-5 py-2">
                        {{ now()->translatedFormat('l, d F Y') }}
                    </x-filament::badge>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex flex-col sm:flex-row lg:flex-col xl:flex-row gap-6 shrink-0 mt-8 lg:mt-0">
                <x-filament::button
                    href="/admin/clients/create"
                    tag="a"
                    icon="heroicon-m-plus"
                    size="xl"
                    class="rounded-2xl shadow-xl shadow-primary-500/20 px-8"
                >
                    Nuevo Expediente
                </x-filament::button>
                
                <x-filament::button
                    href="/agendar-cita"
                    tag="a"
                    icon="heroicon-m-link"
                    color="gray"
                    outlined
                    size="xl"
                    class="rounded-2xl bg-gray-50 dark:bg-white/5 px-8"
                >
                    Enlace de Citas
                </x-filament::button>
            </div>

        </div>
    </div>
</x-filament-widgets::widget>
