@extends('homeAdmin')

 @section('realContent')
<div class="content-wrapper">
          <div class="row">
        
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">

                  <h4 class="card-title">Les Etapes</h4>
                  <div>
                    @if(session()->has('success'))
                        <div>
                            {{ session('success') }}
                        </div>
                    @endif
                  </div>
                  <div class="table-responsive pt-3">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nom</th>
                            <th>Longueur</th>
                            <th>Nbr coureur</th>
                            <th>Rang</th>
                            <th>Resultat</th>
                            <th>Ajout Temps</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($etapes as $etape)
                        <tr>
                            <td>{{ $etape->id }}</td>
                            <td>{{ $etape->nom }}</td>
                            <td>{{ $etape->longueur }}</td>
                            <td>{{ $etape->nbr_coureur }}</td>
                            <td>{{ $etape->rang }}</td>
                            <td><center><a href="{{route('admin.liste_resultat',['id_etape'=>$etape->id])}}">voir resultat</a></center></td>
                            <td><center><a href="{{route('admin.maj_temps_coureur',['id_etape'=>$etape->id])}}"><i class="fas fa-plus"> <i class="fas fa-stopwatch"> </i></a></center></td>
                            

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
@endsection