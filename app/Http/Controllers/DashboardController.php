<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;  
use App\Models\Ejercicios;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\PlanEntrenamientos;
use App\Models\Evaluaciones;


class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $dia = $request->input('dia', 1);
        return app(PlanEntrenamientosController::class)->mostrarPlan($request, $dia);
    }
}