@extends('template')
@section('accueil_activation')
    active
@endsection
@section('content')

        <div class="container mt-3 ">
            <h3 class="mb-4 text-center fw-bold mt-3"><i class="bi bi-graph-up"></i> Tableau de bord - Statistiques des Messages</h3>

            <div class="row">

                <div class="col-md-4">
                    <div class="card text-center shadow-sm card-border-glow green-glow">
                        <div class="card-body position-relative">
                            <h5 class="card-title">Messages envoyés</h5>
                            <p class="fs-1 fw-bold">
                                <span class="counter-highlight bg-green" id="counter_messages_envoyes">0</span>
                            </p>
                            <div class="spinner-wrapper">
                                <div class="spinner-circle-success">
                                    <i class="fas fa-check"></i>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card text-center shadow-sm card-border-glow red-glow">
                        <div class="card-body position-relative">
                            <h5 class="card-title">Messages échoués</h5>
                            <p class="fs-1 fw-bold">
                                <span class="counter-highlight bg-red" id="counter_envois_echoues">0</span>
                            </p>
                            <div class="spinner-wrapper">
                                <div class="spinner-circle-error">
                                    <i class="fas fa-times"></i>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card text-center shadow-sm card-border-glow orange-glow">
                        <div class="card-body position-relative">
                            <h5 class="card-title">Messages programmés</h5>
                            <p class="fs-1 fw-bold">
                                <span class="counter-highlight bg-orange" id="counter_messages_programmes">0</span>
                            </p>
                            <div class="spinner-wrapper">
                                <div class="spinner-circle-planned">
                                    <i class="fas fa-hourglass"></i>
                                </div>
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
                                <th class="w-50">Message</th>
                                <th class="w-25">Statut</th>
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
                                            <span class="badge bg-success">Livré</span>
                                        @elseif($message->status == 'failed')
                                            <span class="badge bg-danger">Echec</span>
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
            document.addEventListener("DOMContentLoaded", function () {
                const counter = document.getElementById('counter_messages_envoyes');
                const finalValue = {{ count($success) }};
                let current = 0;
                const speed = Math.ceil(finalValue / 20); // ajuster la vitesse

                const interval = setInterval(() => {
                    current += speed;
                    if (current >= finalValue) {
                        current = finalValue;
                        clearInterval(interval);
                    }
                    counter.textContent = current;
                }, 150); // toutes les 100 ms
            });
        </script>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const counter = document.getElementById('counter_envois_echoues');
                const finalValue = {{ count($fail) }};
                let current = 0;
                const speed = Math.ceil(finalValue / 50); // ajuster la vitesse

                const interval = setInterval(() => {
                    current += speed;
                    if (current >= finalValue) {
                        current = finalValue;
                        clearInterval(interval);
                    }
                    counter.textContent = current;
                }, 150); // toutes les 100 ms
            });
        </script>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const counter = document.getElementById('counter_messages_programmes');
                const finalValue = {{ count($echeances) }};
                let current = 0;
                const speed = Math.ceil(finalValue / 50); // ajuster la vitesse

                const interval = setInterval(() => {
                    current += speed;
                    if (current >= finalValue) {
                        current = finalValue;
                        clearInterval(interval);
                    }
                    counter.textContent = current;
                }, 150); // toutes les 200 ms
            });
        </script>
@endsection
