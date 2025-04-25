@extends('template')
@section('role_activation')
    active
@endsection

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="container">
        <h2 class="mt-3">Modifier un role</h2>
        <form class="row g-3"  method="POST" action="{{ route('roles.update', $role) }}">
            @csrf
            @method('PUT')
            <div class="col-12 mb-4">
                <label class="form-label" >Modifier le nom de rôle</label>
                <input
                    type="text"
                    name="name"
                    class="form-control"
                    value="{{ $role->name }}"
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
                                Administrator Access
                                <i
                                    class="ti ti-info-circle"
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    title="Autorise l'accès complet au système"></i>
                            </td>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="select-all"  name="select-all"/>
                                    <label class="form-check-label" for="select-all" > Tous sélectionner </label>
                                </div>
                            </td>
                        </tr>
                        @foreach($permissions as $permission)
                            <tr>

                                <td class="text-nowrap fw-medium"><label for="perm{{ $permission->id }}">{{ $permission->name }}</label></td>
                                <td>
                                    <div class="d-flex">
                                        <div class="form-check me-3 me-lg-5">
                                            <input class="form-check-input item" value="{{ $permission->id }}" type="checkbox" name="permissions[]" id="perm{{ $permission->id }}" {{ in_array($permission->id, $permissionsSelected) ? 'checked' : '' }} />
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
                    aria-label="Close">
                    Cancel
                </button>
            </div>
        </form>
    </div>
    <!-- Cocher toutes les cases avec le selector all -->
        <script>
            document.getElementById('select-all').addEventListener('change', function (){
                const checkboxes = document.querySelectorAll('.item');

                for(let i=0; i<checkboxes.length; i++){
                    checkboxes[i].checked = this.checked;
                }
            });
        </script>
@endsection
