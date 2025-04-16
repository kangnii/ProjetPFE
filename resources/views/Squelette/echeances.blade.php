@extends('template')
@section('echeances_activation')
    active
@endsection
@section('content')
    <div class="container mt-3 ">
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
            {{session('success')}}
        @endif
    <h3 >Chargement des avis d'écheance</h3>
        <form action="{{route('echeances.import')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="mb-3 mt-3">
                <button type="button" class="btn btn-outline-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalApercuFichier">
                    <i class="bi bi-eye"></i>
                </button>
            </div>
            <div class="form-group mt-2">
            <label for="file">Sélectionner le fichier excel ou csv : </label>
            <input type="file" name="file" id="file" class="form-control @error('file')is-invalid @enderror mt-3">
                @error('file')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
                <button type="submit" class="btn btn-success mt-3"><i class="bi bi-upload me-1"></i>Charger</button>

{{--                //le modal pour afficher le popup--}}
            </div>
            <div class="modal fade" id="modalApercuFichier" tabindex="-1" aria-labelledby="modalApercuFichierLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalApercuFichierLabel">Aperçu du fichier attendu</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                        </div>
                        <div class="modal-body">
                            <p class="mb-3">Voici les colonnes et l'entête que votre fichier Excel doit contenir :</p>
                            <table class="table table-bordered table-sm text-center">
                                <thead class="table-light">
                                <tr>
                                    <th>nom</th>
                                    <th>prenoms</th>
                                    <th>numero_whatsapp</th>
                                    <th>numero_police</th>
                                    <th>numeroclient</th>
                                    <th>type_contrat</th>
                                    <th>date_echeance</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </form>

        <table class="text-center table table-striped mt-5">
            <thead>
            <tr>
                <th>numéro</th>
                <th>nom</th>
                <th>prénoms</th>
                <th>numéro whatsapp</th>
                <th>numéro police</th>
                <th>numéro client</th>
                <th>type de contrat</th>
                <th>date d'écheance</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($echeances as $echeance)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$echeance->nom}}</td>
                <td>{{$echeance->prenoms}}</td>
                <td>{{$echeance->numero_whatsapp}}</td>
                <td>{{$echeance->numero_police}}</td>
                <td>{{$echeance->numeroclient}}</td>
                <td>{{$echeance->type_contrat}}</td>
                <td>{{ \Carbon\Carbon::parse($echeance->date_echeance)->format('d/m/Y')}}</td>
                <td>
                    <form action="{{ route('echeance.edit', $echeance->id) }}" method="POST" onsubmit="return confirm('Modifier cette échéance ?')">
                        @csrf
                        @method('GET')
                        <button class="btn btn-sm btn-primary w-100">Modifier</button>
                    </form>

                    <form action="{{ route('echeance.destroy', $echeance->id) }}" method="POST" onsubmit="return confirm('Supprimer cette échéance ?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger mt-2 w-100">Supprimer</button>
                    </form>
                </td>
            </tr>
            @empty
                <tr><td colspan="9">Aucune échéance</td></tr>
            @endforelse
            </tbody>
        </table>
            <a href="{{route('echeance.create')}}" class="btn btn-success mt-3">
                <i class="bi bi-plus-circle me-1"></i>Ajouter échéance
            </a>
    </div>
@endsection
