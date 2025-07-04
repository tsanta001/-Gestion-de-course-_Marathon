@extends('home')

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
                  <?php $id_equipe = auth()->guard('equipe')->user()->id; ?>

                  <div class="table-responsive pt-3">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nom</th>
                            <th>Longueur</th>
                            <th>Nbr coureur</th>
                            <th>Ajout coureur</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($etapes as $etape)
                        <tr>
                            <td>{{ $etape->id }}</td>
                            <td>{{ $etape->nom }}</td>
                            <td>{{ $etape->longueur }}</td>
                            <td>{{ $etape->nbr_coureur }}</td>
                            <td><center><a href="{{route('equipe.insert_etape_coureur',['id_equipe'=>$id_equipe,'id_etape'=>$etape->id ])}}"><i class="fas fa-plus"></i></a></center></td>
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