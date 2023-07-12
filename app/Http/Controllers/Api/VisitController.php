<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\VisitRequest;
use App\Http\Resources\VisitResource;
use App\Models\Visit;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class VisitController extends Controller
{
    public function __invoke(VisitRequest $request): JsonResponse
    {
        VisitResource::make(Visit::create($request->validated()));

        return response()->json('Visite enregistrée avec succès', Response::HTTP_CREATED);
    }
}
