@extends('homeAdmin')

 @section('realContent')
<div class="content-wrapper">
          <div class="row">
        
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">

                  <h4 class="card-title">Classement general categorie</h4>
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
                  <form action="{{route('admin.liste_categorie_classement')}}" method="post">
                    @csrf
                        <select name="categorie">
                            @foreach($nomCategories as $nomCategorie)
                            <option value="{{$nomCategorie->nom}}">{{$nomCategorie->nom}}</option>
                            @endforeach
                        </select>

                        <button type="submit">ok</button>
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
                        @php
                           for($j=0;$j<count($classement_categories);$j++){
                        @endphp
                                <tr>
                                    <td>{{ $i++; }}</td>
                                    <td>{{ $classement_categories[$j]->equipe }}</td>
                                    <td>{{ $classement_categories[$j]->categorie }}</td>
                                    <td>{{ $classement_categories[$j]->total_points }} </td>
                                </tr>
                        @php  
                           }
                        @endphp
                      </tbody>
                    </table>
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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