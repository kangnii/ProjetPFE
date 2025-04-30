@extends('template')
@section('content')
    <div class="container ">
        <h3 class="mt-3 fw-bold">Profil</h3>
        <div class="card-body mt-5">
            <div class="d-flex align-items-start align-items-sm-center gap-4">
                <img
                    src="{{ auth()->user()->photo ?? asset('assets/img/avatars/1.png') }}"
                    alt="user-avatar"
                    class="d-block w-px-100 h-px-100 rounded"
                    id="uploadedAvatar" />
                <div class="button-wrapper">
                    <label for="upload" class="btn btn-primary me-2 mb-3" tabindex="0">
                        <span class="d-none d-sm-block">Charger photo</span>
                        <i class="ti ti-upload d-block d-sm-none"></i>
                        <input
                            type="file"
                            name="image"
                            id="upload"
                            class="account-file-input"
                            hidden
                            accept="image/png, image/jpeg" />
                    </label>
                    <button type="button" class="btn btn-label-secondary account-image-reset mb-3">
                        <i class="ti ti-refresh-dot d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Réinitialiser</span>
                    </button>
                    <div class="text-muted">Autorise JPG ou PNG. Taille maximale de 2 Mo</div>
                </div>
            </div>
        </div>
        <hr class="my-4" />
        <div class="card-body mt-3">
            <form id="formAccountSettings" method="GET" >
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
                            autofocus />
                    </div>

                    <div class="mb-3 col-md-6">
                        <label for="email" class="form-label">E-mail</label>
                        <input
                            class="form-control"
                            type="text"
                            id="email"
                            name="email"
                            value="{{ auth()-> user()->email }}"
                             />
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-success me-2">Enregistrer changements</button>
                    <button type="reset" class="btn btn-label-secondary">Annuler</button>
                </div>
            </form>
        </div>
    </div>


@endsection

