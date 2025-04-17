@extends('template')
@section('failed_sent_activation')
    active
@endsection

@section('content')
    <div class="container mt-5" x-data="{ expanded: false, search: '', statusFilter: '', startDate: '', endDate: '' }">

        <h2>Envois échoués</h2>

        <!-- Filtres -->
        <div class="row mb-3" style="margin-top: 7%">
            <div class="col-md-4">
                <input type="text" class="form-control" placeholder="Rechercher un message..." x-model="search">
            </div>
            <div class="col-md-4">
                <input type="date" class="form-control" x-model="startDate">
            </div>
            <div class="col-md-4">
                <input type="date" class="form-control" x-model="endDate">
            </div>
        </div>

        <!-- Tableau des messages -->
        <table class=" table table-striped">
            <thead>
            <tr>
                <th class="w-50">Message</th>
                <th>Statut</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @php $maxVisible = 5; @endphp
            @forelse($notifications as $index => $notification)
                <tr x-show="(expanded || {{ $index }} < {{ $maxVisible }}) &&
                         ('{{ strtolower($notification->body) }}'.includes(search.toLowerCase())) &&
                         (!startDate || new Date('{{ $notification->created_at }}') >= new Date(startDate)) &&
                         (!endDate || new Date('{{ $notification->created_at }}') <= new Date(endDate))">
                    <td>{{ $notification->body }}</td>
                    <td>
                        @if($notification->status == 'failed')
                            <span class="badge bg-danger">Échec</span>
                        @endif
                    </td>
                    <td>{{ $notification->created_at->format('d/m/Y H:i') }}</td>
                    <td><form action={{ route('message.renvoi', ['id' => $notification->id]) }} method="POST">
                            @csrf
                            @method('POST')
                            <button class="btn btn-sm btn-primary w-75"><i class="bi bi-repeat me-2"></i>Renvoyer</button>
                        </form></td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Aucun envoi échoué.</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        <!-- Bouton voir plus / moins -->
        @if(count($notifications) > $maxVisible)
            <div class="text-center mt-3">
                <button class="btn btn-outline-primary btn-sm" @click="expanded = !expanded">
                    <span x-show="!expanded">Voir plus <i class="bi bi-chevron-down"></i></span>
                    <span x-show="expanded">Réduire <i class="bi bi-chevron-up"></i></span>
                </button>
            </div>
        @endif
    </div>



@endsection
