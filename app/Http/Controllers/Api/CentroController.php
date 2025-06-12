<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Centro;
use Illuminate\Http\Request;

class CentroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Centro::with(['user:id,name']) // ← trae nombre desde users
            ->select('id', 'user_id', 'direccion', 'telefono', 'latitud', 'longitud')
            ->get()
            ->map(function ($centro) {
                return [
                    'id' => $centro->id,
                    'nombre' => $centro->user->name ?? 'Sin nombre',
                    'direccion' => $centro->direccion,
                    'telefono' => $centro->telefono,
                    'latitud' => $centro->latitud,
                    'longitud' => $centro->longitud,
                ];
            });
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
