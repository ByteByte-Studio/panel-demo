<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expediente Digital</title>
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
            --shadow-sm: 0 1px 2px 0 rgba(98, 51, 164, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(98, 51, 164, 0.1), 0 2px 4px -2px rgba(98, 51, 164, 0.1);
            --shadow-lg: 0 20px 25px -5px rgba(98, 51, 164, 0.05), 0 8px 10px -6px rgba(98, 51, 164, 0.05);
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
            max-width: 680px;
            margin: 0 auto;
            padding: 3rem 1.5rem;
        }

        @media (max-width: 640px) {
            .container {
                padding: 0;
            }
            .card {
                border-radius: 0 !important;
                border: none !important;
                box-shadow: none !important;
            }
        }

        .card {
            background: var(--bg-card);
            border-radius: var(--radius-xl);
            padding: 3.5rem;
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--border);
            position: relative;
        }

        @media (max-width: 640px) {
            .card {
                padding: 2rem;
            }
        }

        .header {
            margin-bottom: 3rem;
        }

        .header h2 {
            font-size: 2.25rem;
            font-weight: 800;
            color: var(--brand-primary-dark);
            letter-spacing: -0.04em;
            margin-bottom: 0.75rem;
        }

        .header p {
            color: var(--text-muted);
            font-size: 1.125rem;
        }

        .client-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-top: 1.5rem;
            padding: 0.75rem 1.25rem;
            background: #fdfaff;
            border: 1px dashed var(--brand-primary-light);
            border-radius: 12px;
            width: fit-content;
        }

        .client-avatar {
            width: 32px;
            height: 32px;
            background: var(--brand-primary);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.875rem;
        }

        .client-name {
            font-weight: 600;
            color: var(--brand-primary-dark);
            font-size: 0.9375rem;
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
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .alert-success {
            background-color: #f0fdf4;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .document-group {
            background: #ffffff;
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            animation: fadeIn 0.4s ease-out forwards;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .document-group:hover {
            border-color: var(--brand-primary-light);
            box-shadow: var(--shadow-md);
        }

        .group-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.25rem;
        }

        .group-title {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--brand-primary);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-remove {
            background: #fee2e2;
            color: var(--error);
            border: none;
            cursor: pointer;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            transition: all 0.2s;
        }

        .btn-remove:hover {
            background: var(--error);
            color: white;
            transform: rotate(90deg);
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.25rem;
        }

        .form-field {
            position: relative;
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
            font-size: 0.9375rem;
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

        .actions {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin-top: 2.5rem;
        }

        .btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.625rem;
            padding: 1rem 1.5rem;
            border-radius: var(--radius-lg);
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 1rem;
            border: none;
            width: 100%;
        }

        .btn-primary {
            background: var(--brand-primary);
            color: white;
            box-shadow: 0 4px 12px rgba(0, 76, 122, 0.2);
        }

        .btn-primary:hover {
            background: var(--brand-primary-light);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 76, 122, 0.3);
        }

        .btn-secondary {
            background: white;
            color: var(--brand-primary);
            border: 2px solid var(--brand-primary);
        }

        .btn-secondary:hover {
            background: var(--brand-primary);
            color: white;
        }

        .footer-info {
            margin-top: 2.5rem;
            text-align: center;
            font-size: 0.875rem;
            color: var(--text-muted);
        }

        .footer-info strong {
            color: var(--brand-primary);
        }

        .info-text {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.75rem;
            color: var(--text-muted);
            margin-top: 0.5rem;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card">
        <header class="header">
            <h2>Expediente Digital</h2>
            <p>Sube la documentación necesaria para completar tu registro.</p>
            
            <div class="client-info">
                <div class="client-avatar">
                    {{ substr($client->full_name, 0, 1) }}
                </div>
                <span class="client-name">{{ $client->full_name }}</span>
            </div>
        </header>

        @if(session('success'))
            <div class="alert alert-success">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" enctype="multipart/form-data" action="{{ route('cliente.documentos.store', $client) }}">
            @csrf

            <div id="documents-wrapper">
                <div class="document-group" id="group-0">
                    <div class="group-header">
                        <span class="group-title">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Documento 1
                        </span>
                    </div>

                    <div class="form-grid">
                        <div class="form-field">
                            <label class="label">Tipo de documento</label>
                            <select name="documents[0][type]" class="input" required>
                                <option value="">Seleccione el tipo...</option>
                                @foreach($documentTypes as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('documents.0.type')
                                <p class="error-text">
                                    <svg width="14" height="14" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="form-field">
                            <label class="label">Archivo</label>
                            <input type="file" name="documents[0][file]" class="input" required>
                            <div class="info-text">
                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Formatos aceptados: PDF, JPG, PNG (Max. 10MB)
                            </div>
                            @error('documents.0.file')
                                <p class="error-text">
                                    <svg width="14" height="14" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="actions">
                <button type="button" class="btn btn-secondary" onclick="addDocument()">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Añadir otro archivo
                </button>

                <button type="submit" class="btn btn-primary">
                    Finalizar y enviar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
let index = 1;
const documentTypes = @json($documentTypes);

function addDocument() {
    const wrapper = document.getElementById('documents-wrapper');
    const groupDiv = document.createElement('div');
    groupDiv.className = 'document-group';
    groupDiv.id = `group-${index}`;

    let optionsHtml = '<option value="">Seleccione el tipo...</option>';
    for (const [value, label] of Object.entries(documentTypes)) {
        optionsHtml += `<option value="${value}">${label}</option>`;
    }

    groupDiv.innerHTML = `
        <div class="group-header">
            <span class="group-title">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Documento ${index + 1}
            </span>
            <button type="button" class="btn-remove" onclick="removeDocument(${index})" title="Eliminar">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="form-grid">
            <div class="form-field">
                <label class="label">Tipo de documento</label>
                <select name="documents[${index}][type]" class="input" required>
                    ${optionsHtml}
                </select>
            </div>

            <div class="form-field">
                <label class="label">Archivo</label>
                <input type="file" name="documents[${index}][file]" class="input" required>
                <div class="info-text">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Formatos aceptados: PDF, JPG, PNG
                </div>
            </div>
        </div>
    `;

    wrapper.appendChild(groupDiv);
    index++;
}

function removeDocument(idx) {
    const group = document.getElementById(`group-${idx}`);
    if (group) {
        group.style.opacity = '0';
        group.style.transform = 'scale(0.95)';
        setTimeout(() => group.remove(), 200);
    }
}
</script>

</body>
</html>
