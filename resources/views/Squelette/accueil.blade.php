@extends('template')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@section('accueil_activation')
    active
@endsection
@section('content')

        <div class="container mt-4 ">
            <h2 class="mb-4 text-center">📊 Tableau de bord - Statistiques des Messages</h2>

            <div class="row">
                <div class="w-25 col-md-4 offset-md-2">
                    <canvas id="messagePieChart"></canvas>
                </div>
                <div class="col-md-4 offset-md-2">
                    <div class="card text-center shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title ">Envois programmés</h5>
                            <p class="fs-1 fw-bold text-bg-warning" id="counter">0</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tableau des messages programmés -->
            <div style="margin-top: 7%">
                <h2 class="mb-3"><i class="bi bi-alarm"></i> Échéances à venir</h2>
                <div class="table-responsive">
                    <table class=" table table-striped mt-4">
                        <thead >
                        <tr>
                            <th> numéro</th>
                            <th> Clients</th>
                            <th>Type du contrat</th>
                            <th> Dates d'échéance</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($echeances as $echeance)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$echeance->nom}} {{$echeance->prenoms}}</td>
                                <td>{{$echeance->type_contrat}}</td>
                                <td>{{ \Carbon\Carbon::parse($echeance->date_echeance)->format('d/m/Y')}}</td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="4">Aucune échéance à venir.</td>
                                </tr>
                        @endforelse

                        </tbody>
                    </table>





                    <h2 style="margin-top: 7%">
                        <i class="bi bi-bell"></i> Notifications WhatsApp (délai 3 jours)
                    </h2>

                    <div x-data="{ expanded: false }">
                        <table class="table table-striped mt-4">
                            <thead>
                            <tr>
                                <th>Numéro Whatsapp</th>
                                <th>Message</th>
                                <th>Statut</th>
                                <th>Date d'envoi</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php $maxVisibleRows = 7; @endphp
                            @forelse($messages as $index => $message)
                                <tr x-show="expanded || {{ $index }} < {{ $maxVisibleRows }}">
                                    <td>{{ $message->phone }}</td>
                                    <td>{{ $message->body }}</td>
                                    <td>
                                        @if($message->status == 'pending')
                                            <span class="badge bg-warning">En attente</span>
                                        @elseif($message->status == 'sent')
                                            <span class="badge bg-success w-75">Livré</span>
                                        @elseif($message->status == 'failed')
                                            <span class="badge bg-danger w-75">Echec</span>
                                        @endif
                                    </td>
                                    <td>{{ $message->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">Aucune notification.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>

                        @if(count($messages) > $maxVisibleRows)
                            <div class="text-center mt-2">
                                <button
                                    class="btn btn-outline-primary btn-sm"
                                    @click="expanded = !expanded"
                                >
                <span x-show="!expanded">
                    Afficher plus <i class="bi bi-chevron-right"></i>
                </span>
                                    <span x-show="expanded">
                    Réduire <i class="bi bi-chevron-down"></i>
                </span>
                                </button>
                            </div>
                        @endif
                    </div>
                    </div>
                </div>
            </div>

        <script>
            const pieCtx = document.getElementById('messagePieChart')?.getContext('2d');

            if (pieCtx) {
                const messagePieChart = new Chart(pieCtx, {
                    type: 'pie',
                    data: {
                        labels: ['Envoyés', 'Échoués'],
                        datasets: [{
                            data: [{{ $success }}, {{ $fail }}],
                            backgroundColor: ['#28a745cc', '#dc3545cc'],
                            borderColor: ['#28a745', '#dc3545'],
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        animation: {
                            animateRotate: true,
                            animateScale: true,
                            duration: 1500,
                            easing: 'easeOutBounce'
                        },
                        plugins: {
                            legend: { position: 'bottom' },
                            title: {
                                display: true,
                                text: 'Répartition des messages'
                            }
                        }
                    }
                });
            } else {
                console.error("Canvas introuvable !");
            }
        </script>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const counter = document.getElementById('counter');
                const finalValue = 1000; // ex: 42
                let current = 0;
                const speed = Math.ceil(finalValue / 50); // ajuster la vitesse si besoin

                const interval = setInterval(() => {
                    current += speed;
                    if (current >= finalValue) {
                        current = finalValue;
                        clearInterval(interval);
                    }
                    counter.textContent = current;
                }, 30); // toutes les 30 ms
            });
        </script>
@endsection
