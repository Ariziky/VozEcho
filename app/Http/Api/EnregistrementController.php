<?php

namespace App\Http\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EnregistrementRequest;
use App\Http\Resources\EnregistrementResource;
use App\Models\Enregistrement;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class EnregistrementController extends Controller
{
    public function store(EnregistrementRequest $request): JsonResource|EnregistrementResource
    {
        if (! File::isFile($request->validated()['attachment'])) {
            return JsonResource::make([]);
        }

        return DB::transaction(function () use ($request) {
            $attachment = $request->file('attachment');

            // Génère un nom unique pour le fichier audio
            $filename = Str::uuid().'.'.$attachment->getClientOriginalExtension();

            // Stocke le fichier dans le disque vozecho-audios
            $storedFile = $attachment->storeAs('/', $filename, 'vozecho-audios');

            // Persistence des données
            $record = new Enregistrement();
            $record->path = 'storage/'.config('app.vozecho_audios_directory_name').'/'.$storedFile;
            $record->size = $attachment->getSize();
            $record->save();

            return new EnregistrementResource($record);
        });
    }

    public function show(Enregistrement $audio)
    {
        $filePath = public_path($audio->path);

        // Vérifie si le fichier existe
        if (! File::exists($filePath)) {
            return response()->json(['message' => 'Fichier inexistant'], 404);
        }

        // Récupère le MIME type du fichier
        $mimeType = File::mimeType($filePath);

        // Headers de la réponse
        $headers = [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'attachment; filename="audio.mp3"',
        ];

        // Retourne le fichier comme réponse
        return response()->file($filePath, $headers);
    }
}
