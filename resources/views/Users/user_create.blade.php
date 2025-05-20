@extends('template')
@section('user_activation')
    active
@endsection

@section('content')
    <div class="container">
        <h1>Créer un utilisateur</h1>

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
            <div class="form-group">
                <label for="name">Nom</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
            </div>


            <button type="submit" class="btn btn-success">Enregistrer</button>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
@endsection
