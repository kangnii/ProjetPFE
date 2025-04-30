@extends('template')
@section('client_activation')
    active
@endsection

    @section('content')
        <div class="container mt-4">
            <h2 class="mb-3">🖌️ Modifier le Client</h2>

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
            <form action="{{ route('client.update', $client->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="nom">Nom</label>
                    <input type="text" class="form-control" id="nom" name="nom" value="{{ old('nom', $client->nom) }}" required>
                </div>

                <div class="form-group">
                    <label for="prenoms">Prénoms</label>
                    <input type="text" class="form-control" id="prenoms" name="prenoms" value="{{ old('prenoms', $client->prenoms) }}" required>
                </div>

                <div class="form-group">
                    <label for="numero_whatsapp">Numéro Whatsapp</label>
                    <input type="text" class="form-control" id="numero_whatsapp" name="numero_whatsapp" value="{{ old('numero_whatsapp', $client->numero_whatsapp) }}" required>
                </div>

                <div class="form-group">
                    <label for="numeroclient">Numéro Client</label>
                    <input type="text" class="form-control" id="numeroclient" name="numeroclient" value="{{ old('numeroclient', $client->numeroclient) }}" required>
                </div>


                <button type="submit" class="btn btn-primary mt-3 me-3">Mettre à jour</button>
                <a class="btn btn-secondary w-auto mt-3" href="{{ route('client.index') }}">Annuler</a>
            </form>
        </div>
    @endsection
