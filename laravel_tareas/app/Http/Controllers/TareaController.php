<?php

namespace App\Http\Controllers;

use App\Http\Requests\TareaRequest;
use App\Models\Tarea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TareaController extends Controller
{
    public function index()
    {
        $tareas = Tarea::mias()->latest()->get();
        return view('tareas.index', compact('tareas'));
    }

    public function create()
    {
        return view('tareas.create');
    }

    public function store(TareaRequest $request)
    {
        Tarea::create([
            'user_id'     => Auth::id(),
            'titulo'      => $request->titulo,
            'descripcion' => $request->descripcion ?: null,
            'estado'      => $request->estado,
        ]);

        return redirect()->route('tareas.index')->with('flash_success', 'Tarea creada correctamente.');
    }

    public function edit(Tarea $tarea)
    {
        abort_if($tarea->user_id !== Auth::id(), 403);
        return view('tareas.edit', compact('tarea'));
    }

    public function update(TareaRequest $request, Tarea $tarea)
    {
        abort_if($tarea->user_id !== Auth::id(), 403);

        $tarea->update([
            'titulo'      => $request->titulo,
            'descripcion' => $request->descripcion ?: null,
            'estado'      => $request->estado,
        ]);

        return redirect()->route('tareas.index')->with('flash_success', 'Tarea actualizada correctamente.');
    }

    public function destroy(Tarea $tarea)
    {
        abort_if($tarea->user_id !== Auth::id(), 403);
        $tarea->delete();

        return redirect()->route('tareas.index')->with('flash_success', 'Tarea eliminada correctamente.');
    }

    public function cambiarEstado(Request $request, Tarea $tarea)
    {
        abort_if($tarea->user_id !== Auth::id(), 403);

        $estado = $request->input('estado');

        if (!in_array($estado, ['pendiente', 'completada'])) {
            return response()->json(['success' => false, 'error' => 'Estado inválido'], 422);
        }

        $tarea->update(['estado' => $estado]);

        return response()->json(['success' => true, 'estado' => $estado]);
    }
}
