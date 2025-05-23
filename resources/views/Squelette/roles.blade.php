@extends('template')
@section('role_activation')
    active
@endsection

@section('content')
    <div class="container mt-3">
        <h3 class="mt-3 fw-bold">Rôles</h3>

        {{-- Flash messages --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="mb-3">
            @can('Ajouter role')
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addRoleModal">
                    <i class="ti ti-plus"></i> Ajouter un rôle
                </button>
            @endcan
        </div>

        <!-- Table -->
        <div class="card">
            <div class="card-body table-responsive">
                <table id="usersTable" class="table table-striped">
                    <thead>
                    <tr>
                        <th class="w-25">Numero</th>
                        <th>Nom de rôle</th>
                        <th>Permissions</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($roles as $role)
                        <tr>
                            <td>{{ $loop ->iteration }}</td>
                            <td>{{ $role ->name }}</td>
                            <td>
                                {{--                                @foreach ($role->permissions as $permission)--}}
                                <span class="badge bg-primary my-2 mx-2">{{ $role->permissions->count() }}</span>
                            </td>
                            <td>
                                @if($role->name != 'admin')
                                    @can('Modifier role')
                                        <form action="{{ route('roles.edit', $role) }}" method="POST"
                                              class="roleModify">
                                            @csrf
                                            @method('GET')
                                            <button class="btn btn-sm btn-primary w-25"><i class="bi bi-pencil"></i>
                                            </button>
                                        </form>
                                    @endcan

                                    @can('Supprimer role')
                                        <form action="{{ route('roles.destroy', $role) }}" method="POST"
                                              class="roleDelete">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger mt-2 w-25"><i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    @endcan
                                @else

                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Ajustement du modal  -->
        <div class="modal fade" id="addRoleModal" tabindex="-1" aria-labelledby="addRoleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center mb-4">
                            <h3 class="role-title mb-2">Ajouter nouveau rôle</h3>
                            <p class="text-muted">Gérer les permissions</p>
                            <form id="addRoleForm" class="row g-3"
                                  action="{{ route('roles.store') }}" method="POST">
                                @csrf
                                <div class="col-12 mb-4">
                                    <label class="form-label" for="name">Nom de Rôle</label>
                                    <input
                                        type="text"
                                        id="name"
                                        name="name"
                                        class="form-control"
                                        placeholder="Entrer un nom de rôle"
                                    />
                                </div>
                                <div class="col-12">
                                    <h5>Permissions</h5>
                                    <!-- Permission table -->
                                    <div class="table-responsive">
                                        <table class="table table-flush-spacing">
                                            <tbody>
                                            <tr>
                                                <td class="text-nowrap fw-medium">
                                                    Accès Administrateur
                                                    <i
                                                        class="ti ti-info-circle"
                                                        data-bs-toggle="tooltip"
                                                        data-bs-placement="top"
                                                        title="Autorise l'accès complet au système"></i>
                                                </td>
                                                <td>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="select-all"
                                                               name="select-all"/>
                                                        <label class="form-check-label" for="select-all"> Tous
                                                            sélectionner </label>
                                                    </div>
                                                </td>
                                            </tr>
                                            @foreach($permissions as $permission)
                                                <tr>
                                                    <td class="text-nowrap fw-medium"><label
                                                            for="perm{{ $permission->id }}">{{ $permission->name }}</label>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex">
                                                            <div class="form-check me-3 me-lg-5">
                                                                <input class="form-check-input item" type="checkbox"
                                                                       name="permissions[]"
                                                                       value="{{ $permission->id }}"
                                                                       id="perm{{ $permission->id }}"/>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>

                                    </div>
                                    <!-- Permission table -->
                                </div>
                                <div class="col-12 text-center mt-4">
                                    <button type="submit" class="btn btn-primary me-sm-3 me-1">Soumettre</button>
                                    <button
                                        type="button"
                                        class="btn btn-label-secondary"
                                        data-bs-dismiss="modal"
                                        aria-label="Close">
                                        Annuler
                                    </button>
                                </div>
                            </form>
                            <!-- Cocher toutes les cases avec le selector all -->
                            @push('scripts')
                                <script>
                                    document.getElementById('select-all').addEventListener('change', function () {
                                        const checkboxes = document.querySelectorAll('.item');

                                        for (let i = 0; i < checkboxes.length; i++) {
                                            checkboxes[i].checked = this.checked;
                                        }
                                    });
                                </script>
                            @endpush
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>
    @push('roles')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const forms = document.querySelectorAll('.roleModify');
                const formsDelete = document.querySelectorAll('.roleDelete');

                forms.forEach(form => {
                    form.addEventListener('submit', function (e) {
                        e.preventDefault();

                        Swal.fire({
                            title: 'Confirmation',
                            text: "Voulez-vous vraiment modifier ce rôle ?",
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
                            text: "Voulez-vous vraiment supprimer ce rôle ?",
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


