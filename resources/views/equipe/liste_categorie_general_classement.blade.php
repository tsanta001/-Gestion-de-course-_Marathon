@extends('homeAdmin')

@section('realContent')
<div class="content-wrapper">
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Classement général catégorie</h4>
                    <div>
                        @if(session()->has('success'))
                            <div>
                                {{ session('success') }}
                            </div>
                        @endif
                    </div>
                    <div class="table-responsive pt-3" style="width:300px; text-align:center;">
                        <canvas id="pieChart"></canvas>
                    </div>
                    <div class="table-responsive pt-3">
                        <form action="{{ route('admin.liste_categorie_classement') }}" method="post">
                            @csrf
                            <select name="categorie">
                                @foreach($nomCategories as $nomCategorie)
                                    <option value="{{ $nomCategorie->nom }}">{{ $nomCategorie->nom }}</option>
                                @endforeach
                            </select>
                            <button type="submit">OK</button>
                        </form>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Classement</th>
                                    <th>Nom</th>
                                    <th>Genre</th>
                                    <th>Points</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($classement_categories as $classement_categorie)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $classement_categorie->equipe }}</td>
                                        <td>{{ $classement_categorie->categorie }}</td>
                                        <td style="border: 1px solid; color: {{ $colors[$classement_categorie->total_points] }}">
                                            {{ $classement_categorie->total_points }}
                                        </td>
                                    </tr>                
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Récupérez les données de répartition des points depuis votre contrôleur
var labels = {!! json_encode($labels) !!};
var points = {!! json_encode($points) !!};

// Obtenez le contexte du canvas
var ctx = document.getElementById('pieChart').getContext('2d');

// Créez le graphique en camembert
var myPieChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: labels, // Noms des équipes
        datasets: [{
            label: 'Points par équipe',
            data: points, // Points par équipe
            borderWidth: 1
        }]
    },
    options: {
        // Ajoutez des options supplémentaires ici si nécessaire
    }
});
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@endsection
