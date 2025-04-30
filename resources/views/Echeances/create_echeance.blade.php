@extends('template')
@section('echeances_activation')
    active
@endsection
@section('content')
    <div class="container mt-4">
        <h3 class="mb-3 fw-bold">➕ Ajouter une échéance</h3>
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


        <form action="{{ route('echeance.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="client" class="form-label">Client</label>
                <select name="client" id="client" class="form-control">
                        <option> -- Sélectionner un client --</option>
                 @foreach ($clients as $client)
                        <option value="{{ $client->id }}">{{ $client->nom }} {{ $client->prenoms }}( {{ $client->numero_whatsapp }})</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Numéro Police</label>
                <input type="text" name="numero_police" class="form-control @error('numero_police') is-invalid @enderror" value="{{ old('numero_police') }}" required>
                @error('numero_police') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Type de Contrat</label>
                <input type="text" name="type_contrat" class="form-control @error('type_contrat') is-invalid @enderror" value="{{ old('type_contrat') }}" required>
                @error('type_contrat') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Date d'écheance</label>
                <input type="date" name="date_echeance" class="form-control @error('date_echeance') is-invalid @enderror" value="{{ old('date_echeance') }}" required>
                @error('date_echeance') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <button type="submit" class="btn btn-success me-3"><i class="bi bi-check-circle"></i> Ajouter</button>
            <a class="btn btn-secondary w-auto" href="{{ route('echeance.index') }}">Annuler</a>
        </form>
    </div>
@endsection
