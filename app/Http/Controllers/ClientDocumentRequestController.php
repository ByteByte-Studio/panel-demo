<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientDocumentRequestController extends Controller
{
    public function create(Client $client)
    {
        $documentTypes = [
            'acta_nacimiento' => 'Acta de nacimiento',
            'curp' => 'CURP',
            'rfc' => 'RFC',
            'ine_frente' => 'INE Frente',
            'ine_reverso' => 'INE Reverso',
            'comprobante_domicilio' => 'Comprobante de domicilio',
            'acta_matrimonio' => 'Acta de matrimonio',
            'acta_divorcio' => 'Acta de divorcio',
            'pasaporte' => 'Pasaporte',
            'visa' => 'Visa',
            'cartilla_militar' => 'Cartilla militar',
            'titulo_profesional' => 'Título profesional',
            'cedula_profesional' => 'Cédula profesional',
            'estado_cuenta' => 'Estado de cuenta',
            'contrato_arrendamiento' => 'Contrato de arrendamiento',
            'constancia_situacion_fiscal' => 'Constancia situación fiscal',
            'escrituras' => 'Escrituras',
            'poder_notarial' => 'Poder notarial',
            'acta_defuncion' => 'Acta de defunción',
            'otros' => 'Otro documento',
        ];

        return view('clients.documents', compact('client', 'documentTypes'));
    }

    public function store(Request $request, Client $client)
    {
        $request->validate([
            'documents.*.type' => 'required|string',
            'documents.*.file' => 'required|file|max:10240',
        ]);

        foreach ($request->documents as $doc) {

            // Homologamos la carpeta de destino con la que configuramos en Filament ('documents')
            $path = $doc['file']->store('documents', 'public');

            // Usamos la relación morph creada en el modelo Client
            $client->documents()->create([
                // Guardamos el tipo de documento (ej. 'acta_nacimiento') en el campo name
                'name' => $doc['type'],
                'file_path' => $path,
            ]);
        }

        return back()->with('success', 'Documentos enviados correctamente.');
    }
}
