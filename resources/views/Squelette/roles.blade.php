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
                        <th>Nom de l'utilisateur</th>
                        <th>Rôle</th>
                        <th>Permissions</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <!-- Contenu dynamique -->
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
                            <form id="addRoleForm" class="row g-3" onsubmit="return false">
                                <div class="col-12 mb-4">
                                    <label class="form-label" for="modalRoleName">Role Name</label>
                                    <input
                                        type="text"
                                        id="modalRoleName"
                                        name="modalRoleName"
                                        class="form-control"
                                        placeholder="Entrer un nom de rôle"
                                        tabindex="-1" />
                                </div>
                                <div class="col-12">
                                    <h5>Permissions</h5>
                                    <!-- Permission table -->
                                    <div class="table-responsive">
                                        <table class="table table-flush-spacing">
                                            <tbody>
                                            <tr>
                                                <td class="text-nowrap fw-medium">
                                                    Administrator Access
                                                    <i
                                                        class="ti ti-info-circle"
                                                        data-bs-toggle="tooltip"
                                                        data-bs-placement="top"
                                                        title="Allows a full access to the system"></i>
                                                </td>
                                                <td>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="selectAll" />
                                                        <label class="form-check-label" for="selectAll"> Select All </label>
                                                    </div>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- Permission table -->
                                </div>
                                <div class="col-12 text-center mt-4">
                                    <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
                                    <button
                                        type="reset"
                                        class="btn btn-label-secondary"
                                        data-bs-dismiss="modal"
                                        aria-label="Close">
                                        Cancel
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>
@endsection


