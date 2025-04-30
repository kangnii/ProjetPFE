@extends('template')
@section('echeances_activation')
    active
@endsection
@section('content')
    <div class="container mt-3 ">
        <h3 class="fw-bold mt-3">Gestion des avis d'écheance</h3>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{route('echeances.import')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="mb-3 mt-3">
                <button type="button" class="btn btn-outline-info btn-sm" data-bs-toggle="modal"
                        data-bs-target="#modalApercuFichier">
                    <i class="bi bi-eye"></i>
                </button>
            </div>
            <div class="form-group mt-2">
                <label for="file">Sélectionner le fichier excel ou csv : </label>
                <div class="input-group" style="width: auto;">
                    <input type="file" name="file" id="file"
                           class="form-control w-75 me-3 @error('file')is-invalid @enderror mt-3">
                    @can('Charger un fichier excel echeance')
                        <button type="submit" class="btn btn-success mt-3"><i class="bi bi-upload me-1"></i>Charger
                        </button>
                    @endcan
                </div>
                @error('file')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror

                {{--                //le modal pour afficher le popup--}}
            </div>
            <div class="modal fade" id="modalApercuFichier" tabindex="-1" aria-labelledby="modalApercuFichierLabel"
                 aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalApercuFichierLabel">Aperçu du fichier attendu</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Fermer"></button>
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

        <div class="mt-3">
            {{-- Flash messages --}}
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
        </div>

        @can('Ajouter echeance')
            <a href="{{route('echeance.create')}}" class="btn btn-success mt-5">
                <i class="bi bi-plus-circle me-1"></i>Ajouter échéance
            </a>
        @endcan
        <table id="echeancesTable" class="text-center table table-striped ">
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
                        @can('Modifier echeance')
                            <form action="{{ route('echeance.edit', $echeance->id) }}" method="POST"
                                  class="echeanceModify">
                                @csrf
                                @method('GET')
                                <button class="btn btn-sm btn-primary w-50"><i class="bi bi-pencil"></i></button>
                            </form>
                        @endcan

                        @can('Supprimer echeance')
                            <form action="{{ route('echeance.destroy', $echeance->id) }}" method="POST"
                                  class="echeanceDelete">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger mt-2 w-50"><i class="bi bi-trash"></i></button>
                            </form>
                        @endcan
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9">Aucune échéance</td>
                </tr>
            @endforelse
            </tbody>
        </table>

    </div>
    @push('echeances')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const forms = document.querySelectorAll('.echeanceModify');
                const formsDelete = document.querySelectorAll('.echeanceDelete');

                forms.forEach(form => {
                    form.addEventListener('submit', function (e) {
                        e.preventDefault();

                        Swal.fire({
                            title: 'Confirmation',
                            text: "Voulez-vous vraiment modifier cette échéance ?",
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonText: 'Oui, modifier',
                            cancelButtonText: 'Annuler',
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                form.submit(); // Soumet le formulaire si confirmé
                            }
                        });
                    });
                });
                formsDelete.forEach(form => {
                    form.addEventListener('submit', function (e) {
                        e.preventDefault();

                        Swal.fire({
                            title: 'Confirmation',
                            text: "Voulez-vous vraiment supprimer cette échéance ?",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Oui, supprimer',
                            cancelButtonText: 'Annuler',
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                form.submit(); // Soumet le formulaire si confirmé
                            }
                        });
                    });
                });
            });
        </script>

    @endpush
@endsection
