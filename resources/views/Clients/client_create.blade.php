@extends('template')
@section('client_activation')
    active
@endsection
@section('content')
    <div class="container mt-4">
        <h2 class="mb-3">➕ Ajouter un Client</h2>
        <!-- Affichage des erreurs de validation -->
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif


        <form action="{{ route('client.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Nom</label>
                <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror" value="{{ old('nom') }}" required>
                @error('nom') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Prénoms</label>
                <input type="text" name="prenoms" class="form-control @error('prenoms') is-invalid @enderror" value="{{ old('prenoms') }}" required>
                @error('prenoms') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Numéro whatsapp</label>
                <input type="text" name="numero_whatsapp" class="form-control @error('numero_whatsapp') is-invalid @enderror" value="{{ old('numero_whatsapp') }}" required placeholder="format : 229...">
                @error('numero_whatsapp') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Numéro Client</label>
                <input type="text" name="numeroclient" class="form-control @error('numeroclient') is-invalid @enderror" value="{{ old('numeroclient') }}" required>
                @error('numeroclient') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <button type="submit" class="btn btn-success"><i class="bi bi-check-circle"></i> Ajouter</button>
        </form>
    </div>
@endsection
