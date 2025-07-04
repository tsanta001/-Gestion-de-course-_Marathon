@extends('homeAdmin')

 @section('realContent')
<div class="content-wrapper">
          <div class="row">
        
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">

                  <h4 class="card-title">Classement general equipe</h4>
                  <div>
                    @if(session()->has('success'))
                        <div>
                            {{ session('success') }}
                        </div>
                    @endif
                  </div>
                  <div class="table-responsive pt-3" style="width:300px ;text-align:center;">
                    <canvas id="pieChart"></canvas>
                  </div>
                  <div class="table-responsive pt-3">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                            <th>Classement</th>
                            <th>Nom</th>
                            <th>Points</th>
                    
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($classement_equipes as $classement_equipe)
                        <tr>
                            <td>{{ $i++; }}</td>
                            <td>{{ $classement_equipe->nom }}</td>
                            <td>{{ $classement_equipe->sum }}</td>
                        </tr>                
                        @endforeach
                      </tbody>
                      <a href="{{route('admin.v_exportPDF')}}">Exporter PDF</a>
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


@endsection
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

