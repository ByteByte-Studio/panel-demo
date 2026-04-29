<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Document;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ClientProfileController extends Controller
{
    public function downloadPdf(Client $client)
    {
        $pdf = Pdf::loadView('clients.pdf', compact('client'))
            ->setPaper('a4')
            ->setOption('isRemoteEnabled', true)
            ->setOption('defaultFont', 'sans-serif');

        $filename = Str::slug("cliente-{$client->full_name}-{$client->id}").'.pdf';

        return $pdf->download($filename);
    }

    public function edit(Client $client)
    {
        return view('clients.edit-profile', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $data = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
            'occupation' => 'nullable|string',
            'date_of_birth' => 'nullable|date',

            // documentos
            'ine_front' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:4096',
            'ine_back' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:4096',
            'birth_certificate' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:4096',
            'marriage_document' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:4096',
        ]);

        // actualizar datos básicos
        $client->update($data);

        // manejar documentos
        $this->handleDocument($request, $client, 'ine_front', 'INE Frente');
        $this->handleDocument($request, $client, 'ine_back', 'INE Reverso');
        $this->handleDocument($request, $client, 'birth_certificate', 'Acta de Nacimiento');
        $this->handleDocument($request, $client, 'marriage_document', 'Acta Matrimonio/Divorcio');

        return back()->with('success', 'Perfil actualizado correctamente.');
    }

    protected function handleDocument(Request $request, Client $client, string $field, string $type)
    {
        if (! $request->hasFile($field)) {
            return;
        }

        $file = $request->file($field);

        $path = $file->store('client-documents', 'public');

        Document::updateOrCreate(
            [
                'client_id' => $client->id,
                'document_type' => $type,
            ],
            [
                'document_name' => $file->getClientOriginalName(),
                'document_path' => $path,
            ]
        );
    }
}
