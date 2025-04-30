@extends('template')
@section('echeances_activation')
    active
@endsection

@section('content')
    <div class="container mt-4">
        <h3 class="mb-3 fw-bold">🖌️ Modifier une échéance</h3>

        <nav aria-label="breadcrumb" class="mt-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('echeance.index') }}">Echeances</a></li>
                <li class="breadcrumb-item active" aria-current="page">Modifier écheance</li>
            </ol>
        </nav>

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

        <!-- Formulaire de mise à jour -->
        <form action="{{ route('echeance.update', $echeance->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="nom">Nom</label>
                <input type="text" class="form-control" id="nom" name="nom" value="{{ old('nom', $echeance->nom) }}" required>
            </div>

            <div class="form-group">
                <label for="prenoms">Prénoms</label>
                <input type="text" class="form-control" id="prenoms" name="prenoms" value="{{ old('prenoms', $echeance->prenoms) }}" required>
            </div>

            <div class="form-group">
                <label for="numero_whatsapp">Numéro Whatsapp</label>
                <input type="text" class="form-control" id="numero_whatsapp" name="numero_whatsapp" value="{{ old('numero_whatsapp', $echeance->numero_whatsapp) }}" required>
            </div>

            <div class="form-group">
                <label for="numero_police">Numéro Police</label>
                <input type="text" class="form-control" id="numero_police" name="numero_police" value="{{ old('numero_police', $echeance->numero_police) }}" required>
            </div>

            <div class="form-group">
                <label for="numeroclient">Numéro Client</label>
                <input type="text" class="form-control" id="numeroclient" name="numeroclient" value="{{ old('numeroclient', $echeance->numeroclient) }}" required>
            </div>

            <div class="form-group">
                <label for="type_contrat">Type de Contrat</label>
                <input type="text" class="form-control" id="type_contrat" name="type_contrat" value="{{ old('type_contrat', $echeance->type_contrat) }}" required>
            </div>

            <div class="form-group">
                <label for="date_echeance">Date d'échéance</label>
                <input type="text" class="form-control" id="date_echeance" name="date_echeance" value="{{ old('date_echeance', $echeance->date_echeance) }}" required>
            </div>

            <button type="submit" class="btn btn-primary mt-3 me-3">Mettre à jour</button>
            <a class="btn btn-secondary w-auto mt-3" href="{{ route('echeance.index') }}">Annuler</a>
        </form>
    </div>
@endsection
