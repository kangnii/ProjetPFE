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

        @if(session('danger'))
            <div class="alert alert-danger">{{ session('danger') }}</div>
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
                              onsubmit="return confirm('Modifier ce client ?')">
                        @csrf
                        @method('GET')
                        <button class="btn btn-sm btn-primary w-25"><i class="bi bi-pencil"></i></button>
                    </form>
                        @endcan

                        @can('Supprimer client')
                    <form action="{{ route('client.destroy', $client->id) }}" method="POST" onsubmit="return confirm('Supprimer ce client ?')">
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




@endsection
