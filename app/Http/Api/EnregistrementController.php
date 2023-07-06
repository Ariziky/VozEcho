<?php

namespace App\Http\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EnregistrementRequest;
use App\Http\Resources\EnregistrementResource;
use App\Models\Enregistrement;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Response;

class EnregistrementController extends Controller
{
    /**
     * @OA\Post(
     *      path="/api/v1/audio",
     *      operationId="store",
     *      tags={"Enregistrement"},
     *      summary="Génère un enregistrement audio",
     *      description="Retourne le nom du fichier généré",
     *      @OA\RequestBody(
     *          required=true,
     *          description="Record data and attachment file",
     *          @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"attachment"},
     *                 @OA\Property(
     *                     property="attachment",
     *                     description="Sélectionnez un fichier audio",
     *                     type="file"
     *                 )
     *             )
     *         ),
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Enregistrment généré avec succès",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="uuid",
     *                  description="Uuid",
     *                  type="string"
     *              ),
     *              @OA\Property(
     *                  property="path",
     *                  description="File path",
     *                  type="string"
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Le format de fichier est invalide (format accepté : audio/webm)"
     *      )
     * )
     */
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
            $storedFile = $attachment->storeAs('/', $filename, config('app.vozecho_audios_directory_name'));

            // Persistence des données
            $record = new Enregistrement();
//            $record->path = 'storage/vozecho-audios/' . $storedFile;
            $record->path = 'storage/'.config('app.vozecho_audios_directory_name').'/'.$storedFile;
            $record->size = $attachment->getSize();
            $record->save();

            return new EnregistrementResource($record);
        });
    }

    /**
     * @OA\Get(
     *     path="/api/v1/audio/{uuid}",
     *     tags={"Enregistrement"},
     *     summary="Retourne un enregistrement audio",
     *     description="Retourne un enregistrement audio pour l'uuid renseigné",
     *     @OA\Parameter(
     *         name="uuid",
     *         in="path",
     *         description="uuid de l'enregistrement",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Fichier retourné avec succès"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Fichier inexistant"
     *      )
     * )
     */
//    public function show(Enregistrement $audio)
//    {
//        $filePath = public_path($audio->path);
//
//        // Vérifie si le fichier existe
//        if (! File::exists($filePath)) {
//            return response()->json(['message' => 'Fichier inexistant'], 404);
//        }
//
//        // Récupère le MIME type du fichier
//        $mimeType = File::mimeType($filePath);
//
//        // Récupère l'extension du fichier
//        $extension = File::extension($filePath);
//
//        // Headers de la réponse
//        $headers = [
//            'Content-Type' => $mimeType,
//            'Content-Disposition' => 'attachment; filename="audio.'.$extension.'"',
//        ];
//
//        // Retourne le fichier comme réponse
//        return response()->file($filePath, $headers);
//    }

    public function show(Enregistrement $audio): JsonResponse|string
    {
        return response()->json(
            data: ['url' => config('app.url').'/'.$audio->path],
            status: Response::HTTP_OK
        );
    }
}
