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
use OpenApi\Annotations as OA;

class EnregistrementController extends Controller
{
    /**
     * @OA\Post(
     *      path="/api/v1/audio",
     *      operationId="store",
     *      tags={"Enregistrement"},
     *      summary="Génère un enregistrement audio",
     *      description="Retourne le nom du fichier généré",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Record data and attachment file",
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="File uploaded successfully",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="path",
     *                 description="File path",
     *                 type="string"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid file format or missing file"
     *     )
     * )
     */
    public function store(EnregistrementRequest $request): JsonResource|EnregistrementResource
    {
        if (!File::isFile($request->validated()['attachment'])) {
            return JsonResource::make([]);
        }

        return DB::transaction(function () use ($request) {
            $attachment = $request->file('attachment');

            // Génère un nom unique pour le fichier audio
            $filename = Str::uuid() . '.' . $attachment->getClientOriginalExtension();

            // Stocke le fichier dans le disque vozecho-audios
            $storedFile = $attachment->storeAs('/', $filename, 'vozecho-audios');

            // Persistence des données
            $record = new Enregistrement();
            $record->path = 'storage/' . config('app.vozecho_audios_directory_name') . '/' . $storedFile;
            $record->size = $attachment->getSize();
            $record->save();

            return new EnregistrementResource($record);
        });
    }

    /**
     * @OA\Get(
     *     path="/api/audio/{audio}",
     *     tags={"Enregistrement"},
     *     summary="Get audio file",
     *     description="Get the audio file associated with the specified record.",
     *     @OA\Parameter(
     *         name="uuid",
     *         in="path",
     *         description="ID of the record",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\MediaType(
     *             mediaType="audio/mpeg",
     *             @OA\Schema(
     *                 type="file"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not Found",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Fichier inexistant"
     *             )
     *         )
     *     )
     * )
     */
    public function show(Enregistrement $audio)
    {
        $filePath = public_path($audio->path);

        // Vérifie si le fichier existe
        if (!File::exists($filePath)) {
            return response()->json(['message' => 'Fichier inexistant'], 404);
        }

        // Récupère le MIME type du fichier
        $mimeType = File::mimeType($filePath);

        // Headers de la réponse
        $headers = [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'attachment; filename="audio.' . $mimeType . '"',
        ];

        // Retourne le fichier comme réponse
        return response()->file($filePath, $headers);
    }
}
