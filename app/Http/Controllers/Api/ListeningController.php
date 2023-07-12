<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ListeningRequest;
use App\Models\Enregistrement;
use App\Models\Listening;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ListeningController extends Controller
{
    public function __invoke(ListeningRequest $request): JsonResponse
    {
        $record = Enregistrement::where('uuid', $request->get('uuid'))->first();

        if (!$record) {
            return response()->json('Enregistrement inexistant', Response::HTTP_NOT_FOUND);
        }

        $data = [
            'enregistrement_id' => $record->id,
            'ip_address' => $request->get('ip_address')
        ];

        Listening::create($data);

        return response()->json('Lecture enregistrée avec succès', Response::HTTP_CREATED);
    }
}
