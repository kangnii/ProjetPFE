@extends('template')
@section('content')
    <div class="container ">
        <h3 class="mt-3 fw-bold">Profil</h3>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('danger'))
            <div class="alert alert-danger">{{ session('danger') }}</div>
        @endif

        <div class="card-body mt-5">
            <div class="d-flex align-items-start align-items-sm-center gap-4">
                <img
                    src="{{ auth()->user()->photo ?? asset('assets/img/avatars/pp.png') }}"
                    alt="photo de profil"
                    class="d-block w-px-100 h-px-100 rounded "
                    id="uploadedAvatar"/>
                <div class="button-wrapper">
                    <label for="upload" class="btn btn-primary me-2 mb-3" tabindex="0">
                        <span class="d-none d-sm-block">Charger photo</span>
                        <i class="bi bi-upload d-block d-sm-none"></i>
                        <input type="file" name="image" id="upload" class="account-file-input" hidden
                               accept="image/png, image/jpeg"/>
                    </label>
                    <button type="button" class="btn btn-label-secondary account-image-reset mb-3">
                        <i class="ti ti-refresh-dot d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Réinitialiser</span>
                    </button>

                    <div class="text-muted">Autorise JPG ou PNG. Taille maximale de 2 Mo</div>
                </div>
            </div>
        </div>
        <hr class="my-4"/>

        <h4 class="mt-3 fw-bold"><i class="ti ti-pencil"></i>Modifier vos informations personnelles</h4>
        <div class="card-body mt-3">
            <form id="formAccountSettings" action="{{ route('profil.update') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label for="name" class="form-label">Nom complet</label>
                        <input
                            class="form-control"
                            type="text"
                            id="name"
                            name="name"
                            value="{{ auth()->user()->name }}"
                            />
                    </div>

                    <div class="mb-3 col-md-6">
                        <label for="email" class="form-label">E-mail</label>
                        <input
                            class="form-control"
                            type="text"
                            id="email"
                            name="email"
                            value="{{ auth()->user()->email }}"
                        />
                    </div>
                </div>
                <div class="mt-4 mb-5">
                    <button type="submit" class="btn btn-success me-2">Enregistrer changements</button>
                    <button type="reset" class="btn btn-label-secondary">Annuler</button>
                </div>
            </form>
        </div>

        <hr class="my-4"/>

        <h4 class="mt-5 fw-bold"><i class="ti ti-key"></i>Modifier mot de passe</h4>



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
                    <button type="submit" class="btn btn-success me-2">Changer mot de passe</button>
                    <button type="reset" class="btn btn-label-secondary">Annuler</button>
                </div>
            </form>
        </div>



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
    @push('photoscript')
        <script>

            document.addEventListener('DOMContentLoaded', () => {
                const uploadInput = document.getElementById('upload');
                const avatarImg = document.getElementById('uploadedAvatar');
                const firstImage = document.getElementById('firstImage');
                const secondImage = document.getElementById('secondImage');

                // Ajout du gestionnaire d'événements sur le changement de fichier
                uploadInput?.addEventListener('change', async (e) => {
                    const file = e.target.files[0];
                    if (!file) return;

                    // Vérification de la taille du fichier (2Mo = 2 * 1024 * 1024 bytes)
                    if (file.size > 2 * 1024 * 1024) {
                        // iziToast.error({
                        //     message: 'Le fichier est trop volumineux. Taille maximum : 2 Mo',
                        // });
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Le fichier est trop volumineux. Taille maximum : 2 Mo",
                        });
                        // alert('Le fichier est trop volumineux. Taille maximum : 2 Mo');
                        return;
                    }

                    // Vérification du type de fichier
                    if (!['image/jpeg', 'image/png'].includes(file.type)) {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Seuls les fichiers JPG et PNG sont autorisés",
                        });
                        // alert('Seuls les fichiers JPG et PNG sont autorisés');
                        return;
                    }

                    const formData = new FormData();
                    formData.append('image', file);

                    try {
                        // Afficher un indicateur de chargement si souhaité
                        avatarImg.style.opacity = '0.5';

                        const response = await axios.post('profil/photo', formData, {
                            headers: {
                                'Content-Type': 'multipart/form-data',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        });

                        if (response.data.success) {
                            // Mise à jour de l'image
                            avatarImg.src = response.data.url;
                            firstImage.src = response.data.url;
                            secondImage.src = response.data.url;
                            // Animation de fade-in
                            avatarImg.style.opacity = '1';

                            // Message de succès
                            iziToast.success({
                                message: 'Photo mise à jour',
                                position: 'bottomRight',
                            });
                            // alert('Photo mise à jour avec succès !');
                        }
                    } catch (error) {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Erreur lors du téléchargement de la photo",
                        });
                        // alert(error.response?.data?.message || 'Erreur lors du téléchargement de la photo');
                        avatarImg.style.opacity = '1';
                    }
                });

                // Gestion du bouton de réinitialisation
                const resetButton = document.querySelector('.account-image-reset');
                resetButton?.addEventListener('click', async () => {
                    try {
                        const response = await axios.post('/profil/photo/reset', {}, {
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        });

                        if (response.data.success) {
                            avatarImg.src = '{{ asset('assets/img/avatars/pp.png') }}';
                            firstImage.src = '{{ asset('assets/img/avatars/pp.png') }}';
                            secondImage.src = '{{ asset('assets/img/avatars/pp.png') }}';
                            iziToast.success({
                                message: 'Photo réinitialisée avec succès',
                                position: 'bottomRight',
                            });

                            // alert('Photo de profil réinitialisée');
                        }
                    } catch (error) {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Erreur lors du téléchargement de la photo",
                        });
                        // alert('Erreur lors de la réinitialisation de la photo');
                    }
                });
            });
            </script>
    @endpush
@endsection

