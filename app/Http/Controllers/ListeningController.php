<?php

namespace App\Http\Controllers;

use App\Http\Requests\ListeningRequest;
use App\Http\Resources\ListeningResource;
use App\Models\Listening;

class ListeningController extends Controller
{
    public function index()
    {
        return ListeningResource::collection(Listening::all());
    }

    public function store(ListeningRequest $request)
    {
        return new ListeningResource(Listening::create($request->validated()));
    }

    public function show(Listening $listening)
    {
        return new ListeningResource($listening);
    }

    public function update(ListeningRequest $request, Listening $listening)
    {
        $listening->update($request->validated());

        return new ListeningResource($listening);
    }

    public function destroy(Listening $listening)
    {
        $listening->delete();

        return response()->json();
    }
}
