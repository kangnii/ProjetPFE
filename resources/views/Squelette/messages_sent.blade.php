@extends('template')
@section('messages_sent_activation')
    active
@endsection

@section('content')
    <div class="container mt-5" x-data="{ expanded: false, search: '', statusFilter: '', startDate: '', endDate: '' }">
        <h2>Messages envoyés</h2>

        <div style="width: 50%; margin: auto;">
            <canvas id="messagesChart"></canvas>
            <h5 class="text-center">Messages envoyés par heure et par jour</h5>
        </div>

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
        <table class="table table-striped">
            <thead>
            <tr>
                <th class="w-50">Message</th>
                <th class="w-25">Statut</th>
                <th>Date</th>
            </tr>
            </thead>
            <tbody>
            @php $maxVisible = 5; @endphp
            @forelse($notifications as $index => $notification)
                <tr x-show="(expanded || {{ $index }} < {{ $maxVisible }}) &&
                         ('{{ strtolower($notification->body) }}'.includes(search.toLowerCase())) &&
                         (statusFilter === '' || '{{ $notification->status }}' === statusFilter) &&
                         (!startDate || new Date('{{ $notification->created_at }}') >= new Date(startDate)) &&
                         (!endDate || new Date('{{ $notification->created_at }}') <= new Date(endDate))">
                    <td>{{ $notification->body }}</td>
                    <td>
                        @if($notification->status == 'sent')
                            <span class="badge bg-success ">Livré</span>
                        @endif
                    </td>
                    <td>{{ $notification->created_at->format('d/m/Y H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Aucun message envoyé.</td>
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

        <a href="{{ route('echeances.export') }}" class="btn btn-success mt-4 col-md-2">
            <i class="bi bi-file-earmark-excel me-1"></i> Exporter en Excel
        </a>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Récupérer les données depuis le contrôleur Laravel
                    // Créer un tableau pour les heures, les comptes horaires et les jours
                    const hours = @json($messagesByHour).map(item => item.hour +"h");
                    const countsByHour = @json($messagesByHour).map(item => item.count);
                    const days = @json($messagesByDay).map(item => item.day);
                    const countsByDay = @json($messagesByDay).map(item => item.count);

                    // Créer le graphique avec Chart.js
                    const ctx = document.getElementById('messagesChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'line', // Graphique linéaire
                        data: {
                            labels: [...hours, ...days],  // Heures de la journée
                            datasets: [
                                {
                                    label: 'Messages envoyés par heure',
                                    data: countsByHour, // Le nombre de messages envoyés à chaque heure
                                    borderColor: 'rgba(75, 192, 192, 1)', // Couleur de la ligne
                                    backgroundColor: 'rgba(75, 192, 192, 0.2)', // Couleur de remplissage
                                    fill: true,
                                    tension: 0.4
                                },
                                {
                                    label: 'Messages envoyés par jour',
                                    data: countsByDay, // Nombre total de messages envoyés chaque jour
                                    borderColor: 'rgba(255, 99, 132, 1)', // Couleur différente pour la deuxième ligne
                                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                    fill: false, // Ne pas remplir la zone sous la ligne
                                    tension: 0.4
                                }
                            ]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                })
    </script>



@endsection
