<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class CitaController extends Controller
{
    public function index()
    {
        return Cita::with('centro')
            ->where('user_id', Auth::id())
            ->orderByDesc('fecha')
            ->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'centro_id' => 'required|exists:centros,id',
            'fecha' => 'required|date_format:Y-m-d',
            'hora' => 'required|date_format:H:i',
        ]);

        $fechaCompleta = Carbon::parse("{$request->fecha} {$request->hora}");

        // validar si hay conflicto
        $existe = Cita::where('centro_id', $request->centro_id)
            ->where('fecha', $fechaCompleta)
            ->exists();

        if ($existe) {
            return response()->json(['error' => 'Horario ocupado'], 409);
        }

        $cita = Cita::create([
            'user_id' => Auth::id(),
            'centro_id' => $request->centro_id,
            'fecha' => $fechaCompleta,
            'estado' => 'agendada',
        ]);

        return response()->json($cita, 201);
    }

    public function destroy($id)
    {
        $cita = Cita::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $cita->delete();
        return response()->json(['message' => 'Cita cancelada.']);
    }

    // Para centro
    public function citasDelCentro()
    {
        return Cita::where('centro_id', auth()->user()->centro->id)->get();
    }

    public function showPropio()
    {
        $user = auth()->user();

        if (!$user->centro) {
            return response()->json(['error' => 'Este usuario no tiene centro asignado'], 404);
        }

        return $user->centro; // Relación hasOne en el modelo User
    }
}
