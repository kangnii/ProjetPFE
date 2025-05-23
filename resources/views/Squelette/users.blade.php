@extends('template')
@section('user_activation')
    active
@endsection

@section('content')
    <div class="container mt-4">

        <h3 class="mb-3 fw-bold mt-3">Liste des utilisateurs </h3>
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

        @can('Creer utilisateur')
        <div class="mt-3">
            <a href="{{ route('users.create') }}" class="btn btn-success mt-3 d-inline-block">
                <i class="bi bi-plus-circle"></i>Ajouter utilisateur</a>
        </div>
        @endcan

        <table class="table table-striped text-center mt-3" id="userTable">
            <thead >
            <tr>
                <th>numéro</th>
                <th>nom</th>
                <th>email</th>
                <th>rôle</th>
                <th>statut</th>
                <th>actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->getRoleNames()->implode(', ') ?: '—' }}</td>
                    <td>@if($user->is_active)
                            <span class="badge bg-success">Actif</span>
                        @else
                            <span class="badge bg-danger">Inactif</span>
                        @endif</td>
                    <td><div class="d-flex justify-content-center flex-wrap gap-2">
                        @if($user->email != 'wisdomfollygan@gmail.com')
                                @if($user->id != 12)
                                    <button class="btn btn-sm mb-0 btn btn-primary" data-bs-toggle="modal" data-bs-target="#editRoleModal-{{ $user->id }}">
                                            <i class="bi bi-pencil"></i>
                                    </button>
                               @endif
                        @can('Supprimer utilisateur')
                        <form action="{{ route('users.destroy', $user) }}" class="form-inline formSup" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm mb-0"><i class="bi bi-trash"></i></button>
                        </form>
                            @endcan

                            <form method="POST" class="form-inline" action="{{ route('admin.users.toggle', $user->id) }}">
                                @csrf
                                @method('PATCH')
                                <button class="btn btn-sm {{ $user->is_active ? 'btn-warning' : 'btn-success' }}">
                                    {{ $user->is_active ? 'Désactiver' : 'Activer' }}
                                </button>
                            </form>
                        @else

                        @endif
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <!-- Modal Bootstrap -->
        <div class="modal fade" id="editRoleModal-{{ $user->id }}" tabindex="-1" aria-labelledby="editRoleModalLabel-{{ $user->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('users.update-role', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="modal-header">
                            <h5 class="modal-title" id="editRoleModalLabel-{{ $user->id }}">Modifier le rôle de {{ $user->name }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                        </div>

                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="role-{{ $user->id }}" class="form-label">Rôle</label>
                                <select name="role" id="role-{{ $user->id }}" class="form-select" required>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                            {{ ucfirst($role->name) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-success">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{ $users->links() }}

    </div>

    @push('users')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const formSupp = document.querySelectorAll('.formSup');

                formSupp.forEach(form => {
                    form.addEventListener('submit', function (e) {
                        e.preventDefault();

                        Swal.fire({
                            title: 'Confirmation',
                            text: "Voulez-vous vraiment supprimer cet utilisateur ?",
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
