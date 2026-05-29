@extends('layouts.app')

@section('content')
<div class="form-card">

    <a href="{{ route('tareas.index') }}" class="btn-back">
        <i class="bi bi-arrow-left"></i> Volver al listado
    </a>

    <div class="card">
        <div class="card-header-bar">
            <h5><i class="bi bi-pencil-square me-1"></i> Editar tarea</h5>
            <span class="count-badge" style="background:#f0fdf4;color:#059669">ID #{{ $tarea->id }}</span>
        </div>
        <div style="padding:1.75rem">
            <form method="POST" action="{{ route('tareas.update', $tarea->id) }}" novalidate>
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="titulo" class="form-label">
                        Título <span class="text-danger">*</span>
                    </label>
                    <input
                        type="text"
                        id="titulo"
                        name="titulo"
                        class="form-control {{ $errors->has('titulo') ? 'is-invalid' : '' }}"
                        value="{{ old('titulo', $tarea->titulo) }}"
                        placeholder="Título de la tarea…"
                        maxlength="255"
                        required
                    >
                    @error('titulo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="descripcion" class="form-label">
                        Descripción
                        <span class="text-muted fw-normal" style="font-size:.78rem">(opcional)</span>
                    </label>
                    <textarea
                        id="descripcion"
                        name="descripcion"
                        class="form-control"
                        rows="4"
                        placeholder="Agrega más detalles…"
                    >{{ old('descripcion', $tarea->descripcion) }}</textarea>
                </div>

                <div class="mb-4">
                    <label for="estado" class="form-label">Estado</label>
                    <select id="estado" name="estado" class="form-select">
                        @php $estadoActual = old('estado', $tarea->estado); @endphp
                        <option value="pendiente"  {{ $estadoActual === 'pendiente'  ? 'selected' : '' }}>⏳ Pendiente</option>
                        <option value="completada" {{ $estadoActual === 'completada' ? 'selected' : '' }}>✅ Completada</option>
                    </select>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn-submit" style="width:auto;flex:1">
                        <i class="bi bi-floppy"></i> Guardar cambios
                    </button>
                    <a href="{{ route('tareas.index') }}" class="btn-action edit" style="padding:.6rem 1rem;font-size:.875rem">
                        Cancelar
                    </a>
                </div>

            </form>
        </div>
    </div>

    @if($tarea->updated_at)
        <p class="text-center mt-3" style="font-size:.75rem;color:var(--muted)">
            <i class="bi bi-clock-history me-1"></i>
            Última actualización: {{ $tarea->updated_at->format('d/m/Y H:i') }}
        </p>
    @endif

</div>
@endsection
