<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\VisitResource;
use App\Models\Visit;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VisitController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        VisitResource::make(Visit::create(['ip_address' => $request->ip()]));

        return response()->json('Visite enregistrée avec succès', Response::HTTP_CREATED);
    }
}
