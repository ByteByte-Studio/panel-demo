<div>
<style>
    :root {
        --color-highlight: #6233a4;
        --color-highlight-light: #9063cf;
        --color-highlight-dark: #20153a;
        --color-bg-subtle: #fcfaff;
        --success: #10b981;
        --error: #ef4444;
        --text-main: #1a1523;
        --text-muted: #6b647c;
        --border-subtle: #ece6f5;
        --radius-app: 16px;
    }

    .appointment-page {
        font-family: 'Inter Tight', system-ui, sans-serif;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 3rem 1.5rem;
        background-color: #ffffff;
        background-image: 
            radial-gradient(at 0% 0%, rgba(144, 99, 207, 0.05) 0px, transparent 50%),
            radial-gradient(at 100% 100%, rgba(98, 51, 164, 0.05) 0px, transparent 50%);
    }

    .booking-card {
        background: white;
        border-radius: var(--radius-app);
        padding: 3.5rem;
        max-width: 560px;
        width: 100%;
        border: 1px solid var(--border-subtle);
        box-shadow: 0 20px 25px -5px rgba(98, 51, 164, 0.05), 0 8px 10px -6px rgba(98, 51, 164, 0.05);
    }

    @media (max-width: 640px) {
        .booking-card {
            padding: 2rem;
            border-radius: 0;
            border: none;
            box-shadow: none;
        }
        .appointment-page {
            padding: 0;
            background: white;
        }
    }

    .header-group {
        margin-bottom: 3rem;
        text-align: center;
    }

    .header-group h1 {
        font-size: 2.25rem;
        font-weight: 800;
        color: var(--color-highlight-dark);
        letter-spacing: -0.04em;
        margin-bottom: 0.75rem;
    }

    .header-group p {
        color: var(--text-muted);
        font-size: 1.125rem;
        line-height: 1.6;
    }

    .form-section {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .field-wrapper {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .field-label {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--text-main);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .custom-input {
        width: 100%;
        padding: 0.9rem 1.25rem;
        border-radius: 12px;
        border: 2px solid var(--border-subtle);
        font-size: 1rem;
        font-family: inherit;
        transition: all 0.25s ease;
        background: var(--color-bg-subtle);
        color: var(--text-main);
        box-sizing: border-box;
    }

    .custom-input:focus {
        outline: none;
        border-color: var(--color-highlight);
        background: white;
        box-shadow: 0 0 0 4px rgba(98, 51, 164, 0.08);
    }

    .custom-input::placeholder {
        color: #b1abbf;
    }

    .custom-input:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    .btn-submit {
        width: 100%;
        background: var(--color-highlight);
        color: white;
        padding: 1.25rem;
        border-radius: 14px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        margin-top: 1rem;
        transition: all 0.3s ease;
        font-size: 1.125rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
    }

    .btn-submit:hover {
        background: var(--color-highlight-light);
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(98, 51, 164, 0.2);
    }

    .profile-found {
        background: #fdfaff;
        color: var(--color-highlight);
        padding: 1rem 1.25rem;
        border-radius: 12px;
        border: 1px dashed var(--color-highlight-light);
        font-size: 0.95rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .success-card {
        text-align: center;
        padding: 1rem 0;
        animation: scaleUp 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .success-icon {
        width: 80px;
        height: 80px;
        background: var(--success);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 2rem;
        font-size: 2.5rem;
        box-shadow: 0 10px 20px rgba(16, 185, 129, 0.2);
    }

    @keyframes scaleUp {
        from { opacity: 0; transform: scale(0.8); }
        to { opacity: 1; transform: scale(1); }
    }
</style>

<div class="appointment-page">
    <div class="booking-card">
        @if($success)
            <div class="success-card">
                <div class="success-icon">✓</div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">¡Cita Registrada!</h2>
                <p class="text-gray-500 mb-8">Hemos recibido tu solicitud. Un asesor se pondrá en contacto contigo a la brevedad.</p>
                <x-filament::button color="gray" outlined onclick="window.location.reload()">
                    Agendar otra cita
                </x-filament::button>
            </div>
        @else
            <header class="header-group">
                <h1>Agenda tu consulta</h1>
                <p>Completa el formulario para reservar un espacio en nuestra agenda legal profesional.</p>
            </header>

            <div class="form-section">
                <div class="field-wrapper">
                    <label class="field-label">Teléfono de contacto</label>
                    <input type="text"
                        class="custom-input"
                        placeholder="Ej. 55 1234 5678"
                        wire:model="phone_number"
                        wire:blur="checkPhone">
                </div>

                @if($isExisting)
                    <div class="profile-found">
                        <x-filament::icon icon="heroicon-m-check-badge" class="w-6 h-6" />
                        <span>Reconocemos tu perfil. Tus datos han sido precargados.</span>
                    </div>
                @endif

                <div class="field-wrapper">
                    <label class="field-label">Nombre completo</label>
                    <input type="text"
                        class="custom-input"
                        placeholder="Tu nombre oficial"
                        wire:model="full_name"
                        @disabled($isExisting)>
                </div>

                <div class="field-wrapper">
                    <label class="field-label">Correo electrónico</label>
                    <input type="email"
                        class="custom-input"
                        placeholder="tu@correo.com"
                        wire:model="email"
                        @disabled($isExisting)>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="field-wrapper">
                        <label class="field-label">Fecha deseada</label>
                        <input type="date"
                            class="custom-input"
                            wire:model="date">
                    </div>

                    <div class="field-wrapper">
                        <label class="field-label">Hora</label>
                        <input type="time"
                            class="custom-input"
                            wire:model="time">
                    </div>
                </div>

                <div class="field-wrapper">
                    <label class="field-label">Asunto o notas</label>
                    <textarea
                        class="custom-input h-32 resize-none"
                        placeholder="¿En qué podemos ayudarte?"
                        wire:model="notes"></textarea>
                </div>

                <button class="btn-submit"
                    wire:click="confirmAppointment"
                    wire:loading.attr="disabled">
                    <span wire:loading.remove>Agendar cita profesional</span>
                    <span wire:loading>Procesando...</span>
                </button>
            </div>
        @endif
    </div>
</div>
</div>
