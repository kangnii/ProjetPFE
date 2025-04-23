@extends('template')
@section('role_activation')
    active
    @endsection

@section('content')
    <div class="container mt-5">
        <div class="mb-3">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRoleModal">
                <i class="ti ti-plus"></i> Ajouter un rôle
            </button>
        </div>

        <!-- Table -->
        <div class="card">
            <div class="card-body table-responsive">
                <table id="usersTable" class="table table-striped">
                    <thead>
                    <tr>
                        <th>Nom de rôle</th>
                        <th>Permissions</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($roles as $role)
                        <tr>
                            <td>{{ $role ->name }}</td>
                            <td>
                                @foreach ($role->permissions as $permission)
                                    <span class="badge bg-primary my-2 mx-2">{{ $permission->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                <form action="{{ route('roles.edit', $role) }}" method="POST" onsubmit="return confirm('Modifier ce rôle ?')">
                                    @csrf
                                    @method('GET')
                                    <button class="btn btn-sm btn-primary w-75">Modifier</button>
                                </form>

                                <form action="{{ route('roles.destroy', $role) }}" method="POST" onsubmit="return confirm('Supprimer ce rôle ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger mt-2 w-75">Supprimer</button>
                                </form>
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
                        <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center mb-4">
                            <h3 class="role-title mb-2">Ajouter nouveau rôle</h3>
                            <p class="text-muted">Gérer les permissions</p>
                            <form id="addRoleForm" class="row g-3" onsubmit="return confirm('Voulez-vous vraiment créer ce rôle ?')" action="{{ route('roles.store') }}" method="POST" >
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
                                                        <input class="form-check-input" type="checkbox" id="select-all" />
                                                        <label class="form-check-label" for="select-all"> Tous sélectionner </label>
                                                    </div>
                                                </td>
                                            </tr>
                                            @foreach($permissions as $permission)
                                                <tr>
                                                    <td class="text-nowrap fw-medium"><label for="permission{{ $permission->id }}">{{ $permission->name }}</label></td>
                                                    <td>
                                                        <div class="d-flex">
                                                            <div class="form-check me-3 me-lg-5">
                                                                <input class="form-check-input item" type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="permission{{ $permission->id }}" />
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
                                        type="reset"
                                        class="btn btn-label-secondary"
                                        data-bs-dismiss="modal"
                                        aria-label="Close">
                                        Cancel
                                    </button>
                                </div>
                            </form>
                            <!-- Cocher toutes les cases avec le selector all -->
                            <script>
                                document.getElementById('select-all').addEventListener('change', function (){
                                    const checkboxes = document.querySelectorAll('.item');

                                    for(let i=0; i<checkboxes.length; i++){
                                        checkboxes[i].checked = this.checked;
                                    }
                                });
                            </script>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>
@endsection


