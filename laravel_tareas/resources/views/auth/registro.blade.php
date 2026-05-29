@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="card shadow-sm mt-4">
            <div class="card-body p-4">
                <h2 class="card-title text-center mb-4">Crear cuenta</h2>

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('registro') }}" novalidate>
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre completo</label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            class="form-control"
                            value="{{ old('name') }}"
                            required
                        >
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo electrónico</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-control"
                            value="{{ old('email') }}"
                            required
                        >
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-4">
                        <label for="confirmar_password" class="form-label">Confirmar contraseña</label>
                        <input type="password" id="confirmar_password" name="confirmar_password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Registrarse</button>
                </form>

                <p class="text-center mt-3 mb-0">
                    ¿Ya tienes cuenta?
                    <a href="{{ route('login') }}">Inicia sesión aquí</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
