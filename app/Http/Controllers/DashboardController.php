<?php
// app/Http/Controllers/DashboardController.php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $user = Auth::user();

        return match ($user->role) {
            UserRole::Admin => redirect()->route('admin.dashboard'),
            UserRole::Donante => redirect()->route('donante.dashboard'),
            UserRole::Centro => redirect()->route('centro.dashboard'),
            // añade aquí más roles…
            default => abort(403),
        };
    }
}
