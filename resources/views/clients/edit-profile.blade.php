<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Cliente</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter+Tight:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <style>
        :root {
            --brand-primary: #6233a4;
            --brand-primary-light: #9063cf;
            --brand-primary-dark: #20153a;
            --success: #10b981;
            --error: #ef4444;
            --text-main: #1a1523;
            --text-muted: #6b647c;
            --bg-page: #ffffff;
            --bg-card: #ffffff;
            --border: #ece6f5;
            --radius-xl: 24px;
            --radius-lg: 16px;
            --shadow-lg: 0 10px 15px -3px rgba(98, 51, 164, 0.05), 0 4px 6px -4px rgba(98, 51, 164, 0.05);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter Tight', system-ui, -apple-system, sans-serif;
            background-color: var(--bg-page);
            color: var(--text-main);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            background-image: 
                radial-gradient(at 0% 0%, rgba(144, 99, 207, 0.03) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(98, 51, 164, 0.03) 0px, transparent 50%);
            min-height: 100vh;
        }

        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding: 3rem 1rem;
        }

        @media (max-width: 640px) {
            .container {
                padding: 1.5rem 1rem;
            }
        }

        .card {
            background: var(--bg-card);
            border-radius: var(--radius-xl);
            padding: 3rem;
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--border);
            position: relative;
        }

        @media (max-width: 640px) {
            .card {
                padding: 1.5rem;
            }
        }

        .header {
            margin-bottom: 2.5rem;
            text-align: left;
        }

        .header h2 {
            font-size: 2rem;
            font-weight: 800;
            color: var(--brand-primary);
            letter-spacing: -0.025em;
            margin-bottom: 0.5rem;
        }

        .header p {
            color: var(--text-muted);
            font-size: 1.05rem;
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin: 2.5rem 0 1.5rem;
        }

        .section-title {
            font-size: 1.125rem;
            font-weight: 700;
            color: var(--brand-primary-dark);
            white-space: nowrap;
        }

        .section-line {
            height: 1px;
            background: var(--border);
            width: 100%;
        }

        .alert {
            padding: 1rem 1.25rem;
            border-radius: var(--radius-lg);
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 500;
            animation: slideDown 0.4s ease-out;
            background-color: #f0fdf4;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }

        @media (max-width: 640px) {
            .grid {
                grid-template-columns: 1fr;
                gap: 1.25rem;
            }
        }

        .form-field {
            margin-bottom: 0;
        }

        .form-field.full-width {
            grid-column: span 2;
        }

        @media (max-width: 640px) {
            .form-field.full-width {
                grid-column: span 1;
            }
        }

        .label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--text-main);
        }

        .input {
            width: 100%;
            padding: 0.75rem 1rem;
            border-radius: 10px;
            border: 1.5px solid var(--border);
            font-size: 0.95rem;
            font-family: inherit;
            transition: all 0.2s;
            background: #fcfcfc;
            color: var(--text-main);
        }

        .input:focus {
            outline: none;
            border-color: var(--brand-primary);
            background: white;
            box-shadow: 0 0 0 4px rgba(0, 76, 122, 0.1);
        }

        textarea.input {
            min-height: 100px;
            resize: vertical;
        }

        .input[type="file"] {
            padding: 0.5rem;
            cursor: pointer;
        }

        .input::file-selector-button {
            background: var(--brand-primary);
            color: white;
            border: none;
            padding: 0.4rem 1rem;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.8125rem;
            margin-right: 1rem;
            cursor: pointer;
            transition: all 0.2s;
        }

        .input::file-selector-button:hover {
            background: var(--brand-primary-light);
        }

        .error-text {
            color: var(--error);
            font-size: 0.8125rem;
            margin-top: 0.4rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .btn-primary {
            width: 100%;
            background: var(--brand-primary);
            color: white;
            padding: 1.125rem;
            border-radius: var(--radius-lg);
            font-weight: 700;
            border: none;
            cursor: pointer;
            margin-top: 3rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            box-shadow: 0 4px 12px rgba(0, 76, 122, 0.2);
        }

        .btn-primary:hover {
            background: var(--brand-primary-light);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 76, 122, 0.3);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .footer-info {
            margin-top: 3rem;
            text-align: center;
            font-size: 0.875rem;
            color: var(--text-muted);
        }

        .file-hint {
            font-size: 0.75rem;
            color: var(--text-muted);
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card">
        <header class="header">
            <h2>Mi Perfil</h2>
            <p>Mantén tu información personal y legal actualizada para un mejor servicio.</p>
        </header>

        @if(session('success'))
            <div class="alert">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" enctype="multipart/form-data" action="{{ route('cliente.editar-perfil.update', $client) }}">
            @csrf

            <div class="section-header">
                <span class="section-title">Información Personal</span>
                <div class="section-line"></div>
            </div>
            
            <div class="grid">
                <div class="form-field full-width">
                    <label class="label">Nombre completo</label>
                    <input class="input" type="text" name="full_name" value="{{ old('full_name', $client->full_name) }}" placeholder="Ej. Juan Pérez">
                    @error('full_name') <p class="error-text">{{ $message }}</p> @enderror
                </div>

                <div class="form-field">
                    <label class="label">Teléfono</label>
                    <input class="input" type="text" name="phone_number" value="{{ old('phone_number', $client->phone_number) }}" placeholder="10 dígitos">
                    @error('phone_number') <p class="error-text">{{ $message }}</p> @enderror
                </div>

                <div class="form-field">
                    <label class="label">Correo electrónico</label>
                    <input class="input" type="email" name="email" value="{{ old('email', $client->email) }}" placeholder="correo@ejemplo.com">
                    @error('email') <p class="error-text">{{ $message }}</p> @enderror
                </div>

                <div class="form-field full-width">
                    <label class="label">Dirección de contacto</label>
                    <textarea class="input" name="address" placeholder="Calle, número, colonia...">{{ old('address', $client->address) }}</textarea>
                    @error('address') <p class="error-text">{{ $message }}</p> @enderror
                </div>

                <div class="form-field">
                    <label class="label">Ocupación / Oficio</label>
                    <input class="input" type="text" name="occupation" value="{{ old('occupation', $client->occupation) }}" placeholder="Profesión u oficio">
                    @error('occupation') <p class="error-text">{{ $message }}</p> @enderror
                </div>

                <div class="form-field">
                    <label class="label">Fecha de nacimiento</label>
                    <input class="input" type="date" name="date_of_birth" value="{{ old('date_of_birth', $client->date_of_birth) }}">
                    @error('date_of_birth') <p class="error-text">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="section-header">
                <span class="section-title">Documentación Digital</span>
                <div class="section-line"></div>
            </div>
            
            <div class="grid">
                <div class="form-field">
                    <label class="label">INE Frente</label>
                    <input class="input" type="file" name="ine_front">
                    <div class="file-hint">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        JPG, PNG o PDF
                    </div>
                </div>

                <div class="form-field">
                    <label class="label">INE Reverso</label>
                    <input class="input" type="file" name="ine_back">
                    <div class="file-hint">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        JPG, PNG o PDF
                    </div>
                </div>

                <div class="form-field">
                    <label class="label">Acta de Nacimiento</label>
                    <input class="input" type="file" name="birth_certificate">
                </div>

                <div class="form-field">
                    <label class="label">Situación Civil (Acta)</label>
                    <input class="input" type="file" name="marriage_document">
                </div>
            </div>

            <button type="submit" class="btn-primary">
                <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Actualizar información
            </button>
        </form>
    </div>
</div>

</body>
</html>
