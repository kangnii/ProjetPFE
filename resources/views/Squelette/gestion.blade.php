@extends('template')
@section('content')
    <div class="container ">
        <h3 class="mt-3 fw-bold">Gestion de profil</h3>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                    @endforeach
            </div>
        @endif

        <hr class="my-4"/>
        <h4 class="mt-3">Modification de mon mot de passe</h4>

        <div class="card-body mt-3">
            <form id="password" action="{{ route('password.update') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label for="password" class="form-label">Ancien mot de passe</label>
                        <input
                            class="form-control @error('password') is-invalid @enderror"
                            type="password"
                            id="password"
                            name="password"
                        />
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror

                    </div>
                    </div>

                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label for="new_password" class="form-label">Nouveau mot de passe</label>
                        <div class="position-relative">

                        <input
                            class="form-control @error('new_password') is-invalid @enderror"
                            type="password"
                            id="new_password"
                            name="new_password"
                        />
                        <i class="bi bi-eye-slash position-absolute end-0 top-50 translate-middle-y me-2 toggle-password"
                           style="cursor: pointer;"
                          ></i>

                        @error('new_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="confirm_password" class="form-label">Confirmer mot de passe</label>
                        <div class="position-relative">
                        <input
                            class="form-control @error('confirm_password') is-invalid @enderror"
                            type="password"
                            id="confirm_password"
                            name="confirm_password"
                        />
                            <i class="bi bi-eye-slash position-absolute end-0 top-50 translate-middle-y me-2 toggle-password"
                               style="cursor: pointer;"
                              ></i>
                        @error('confirm_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-success me-2">Enregistrer changement</button>
                    <button type="reset" class="btn btn-label-secondary">Annuler</button>
                </div>
            </form>
        </div>
        <hr class="my-4"/>
        @if(auth()->user()->can('activer utilisateur') && auth()->user()->can('desactiver utilisateur'))
        <h4 class="mt-3 ">Gérer comptes</h4>

        <table class="mt-3 table">
            <thead>
            <tr>
                <th>Nom</th>
                <th>Email</th>
                <th>Statut</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if($user->is_active)
                            <span class="badge bg-success">Actif</span>
                        @else
                            <span class="badge bg-danger">Inactif</span>
                        @endif
                    </td>
                    <td>
                        <form method="POST" action="{{ route('admin.users.toggle', $user->id) }}">
                            @csrf
                            @method('PATCH')
                            <button class="btn btn-sm {{ $user->is_active ? 'btn-danger' : 'btn-success' }}">
                                {{ $user->is_active ? 'Désactiver' : 'Activer' }}
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @endif
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleButtons = document.querySelectorAll('.toggle-password');

            toggleButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const input = this.previousElementSibling;

                    // Bascule le type de l'input
                    const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                    input.setAttribute('type', type);

                    // Bascule l'icône
                    this.classList.toggle('bi-eye');
                    this.classList.toggle('bi-eye-slash');
                });
            });
        });

    </script>

@endsection

