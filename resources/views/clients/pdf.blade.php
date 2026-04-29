@extends('layouts.pdf')

@section('title', 'Expediente del Cliente')

@section('content')
    <div class="section">
        <div class="section-header">
            <h2 class="section-title">Información del Cliente</h2>
        </div>
        <table class="data-grid">
            <tr>
                <td class="label">Nombre Completo</td>
                <td class="value">{{ $client->full_name }}</td>
                <td class="label">Folio de Sistema</td>
                <td class="value font-bold">#{{ str_pad($client->id, 5, '0', STR_PAD_LEFT) }}</td>
            </tr>
            <tr>
                <td class="label">Personalidad Jurídica</td>
                <td class="value">{{ match($client->person_type) { 'persona_fisica' => 'Persona Física', 'persona_moral' => 'Persona Moral', default => ucfirst($client->person_type) } }}</td>
                <td class="label">Nivel de Cuenta</td>
                <td class="value"><span class="badge {{ $client->client_type === 'cliente' ? 'badge-success' : 'badge-warning' }}">{{ $client->client_type === 'cliente' ? 'Activo' : 'Prospecto' }}</span></td>
            </tr>
            <tr>
                <td class="label">Línea Telefónica</td>
                <td class="value">{{ $client->phone_number }}</td>
                <td class="label">Correo Electrónico</td>
                <td class="value">{{ $client->email ?: 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">Identificación (CURP)</td>
                <td class="value">{{ $client->curp ?: 'N/A' }}</td>
                <td class="label">Registro Fiscal (RFC)</td>
                <td class="value">{{ $client->rfc ?: 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">Actividad / Oficio</td>
                <td class="value">{{ $client->occupation ?? 'No especificada' }}</td>
                <td class="label">Fecha de Nacimiento</td>
                <td class="value">{{ $client->date_of_birth ? \Carbon\Carbon::parse($client->date_of_birth)->format('d/m/Y') : 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">Domicilio Registrado</td>
                <td class="value" colspan="3">{{ $client->address ?? 'No proporcionado en el sistema' }}</td>
            </tr>
        </table>
    </div>

    @php
        $totalPaid = 0;
        $totalPending = 0;
        $allPayments = $client->payments()->get();
        foreach($allPayments as $p) {
            if($p->payment_status === \App\Enums\PaymentStatus::Paid) $totalPaid += $p->amount;
            elseif($p->payment_status === \App\Enums\PaymentStatus::Pending || $p->payment_status === \App\Enums\PaymentStatus::Partial) $totalPending += $p->amount;
        }
    @endphp

    <div class="summary-wrapper">
        <div class="summary-card">
            <table class="summary-table">
                <tr>
                    <td class="summary-col">
                        <span class="summary-label">Total Recaudado</span>
                        <span class="summary-value">$ {{ number_format($totalPaid, 2) }}</span>
                    </td>
                    <td class="summary-col" style="border-left: 1px solid rgba(255,255,255,0.1); border-right: 1px solid rgba(255,255,255,0.1);">
                        <span class="summary-label">Cargos Pendientes</span>
                        <span class="summary-value">$ {{ number_format($totalPending, 2) }}</span>
                    </td>
                    <td class="summary-col">
                        <span class="summary-label">Proyección Total</span>
                        <span class="summary-value">$ {{ number_format($totalPaid + $totalPending, 2) }}</span>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    @if($allPayments->count() > 0)
    <div class="section" style="margin-top: 40px;">
        <div class="section-header">
            <h2 class="section-title">Historial de Cobranza y Transacciones</h2>
        </div>
        <table class="content-table">
            <thead>
                <tr>
                    <th>Concepto de Pago</th>
                    <th>Fecha Registro</th>
                    <th>Vencimiento</th>
                    <th class="text-right">Monto</th>
                    <th class="text-center">Estatus</th>
                </tr>
            </thead>
            <tbody>
                @foreach($allPayments->sortByDesc('created_at')->take(15) as $payment)
                <tr>
                    <td class="font-bold">{{ $payment->concept }}</td>
                    <td style="color: #6b647c">{{ $payment->created_at->format('d/m/Y') }}</td>
                    <td>{{ $payment->due_date ? $payment->due_date->format('d/m/Y') : '-' }}</td>
                    <td class="text-right font-bold">$ {{ number_format($payment->amount, 2) }}</td>
                    <td class="text-center">
                        <span class="badge {{ 
                            $payment->payment_status === \App\Enums\PaymentStatus::Paid ? 'badge-success' : 
                            ($payment->payment_status === \App\Enums\PaymentStatus::Pending ? 'badge-warning' : 'badge-primary') 
                        }}">
                            {{ $payment->payment_status->label() }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
@endsection
