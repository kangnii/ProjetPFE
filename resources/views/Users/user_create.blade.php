@extends('template')
@section('user_activation')
    active
@endsection

@section('content')
    <div class="container mt-4">
        <h3 class="mb-3 fw-bold">➕ Ajouter un utilisateur</h3>

        <nav aria-label="breadcrumb" class="mt-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Utilisateurs</a></li>
                <li class="breadcrumb-item active" aria-current="page">Ajouter utilisateur</li>
            </ol>
        </nav>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Nom</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
            </div>

            <div class="mb-3">
                <label for="role_id" class="form-label">Rôle</label>
                <select name="role_id" id="role_id" class="form-control" required>
                    <option value="" disabled selected>— Choisir un rôle —</option>
                    @foreach($roles as $id => $name)
                        <option value="{{ $id }}"
                            {{ old('role_id') == $id ? 'selected' : '' }}>
                            {{ ucfirst($name) }}
                        </option>
                    @endforeach
                </select>
            </div>


            <button type="submit" class="btn btn-success me-3">Enregistrer</button>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
@endsection
