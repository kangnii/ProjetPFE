@extends('template')
@section('client_activation')
    active
@endsection

@section('content')
    <div class="container mt-4">
        <h3 class="mb-3 fw-bold mt-3">Liste des clients </h3>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

    @can('Ajouter client')
        <div class="mt-3">
            <a href="{{route('client.create')}}" class="btn btn-success mt-3 d-inline-block">
                <i class="bi bi-plus-circle"></i> Ajouter client
            </a>
        </div>
        @endcan


        <table id="clientsTable" class="table table-striped text-center mt-3">
            <thead>
            <tr>
                <th>numéro</th>
                <th>Nom</th>
                <th>Prénoms</th>
                <th>Numéro Whatsapp</th>
                <th>Numéro Client</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>

            @forelse($clients as $client)
                <tr>
                <td>{{$loop ->iteration}}</td>
                <td>{{$client ->nom}}</td>
                <td>{{$client ->prenoms}}</td>
                <td>{{$client ->numero_whatsapp}}</td>
                <td>{{$client ->numeroclient}}</td>
                    <td> @can('Modifier client')
                        <form action="{{ route('client.edit', $client->id) }}" method="POST"
                              class="clientModify">
                        @csrf
                        @method('GET')
                        <button class="btn btn-sm btn-primary w-25"><i class="bi bi-pencil"></i></button>
                    </form>
                        @endcan

                        @can('Supprimer client')
                    <form action="{{ route('client.destroy', $client->id) }}" method="POST" class="clientDelete">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger mt-2 w-25"><i class="bi bi-trash"></i></button>
                    </form>
                        @endcan

                </td>
                </tr>
            @empty
                <tr ><td colspan="6">Aucun client ajouté.</td>.</tr>
            @endforelse

            </tbody>

        </table>

    </div>
    @push('clients')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const forms = document.querySelectorAll('.clientModify');
                const formsDelete = document.querySelectorAll('.clientDelete');

                forms.forEach(form => {
                    form.addEventListener('submit', function (e) {
                        e.preventDefault();

                        Swal.fire({
                            title: 'Confirmation',
                            text: "Voulez-vous vraiment modifier ce client ?",
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
                            text: "Voulez-vous vraiment supprimer ce client ?",
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
