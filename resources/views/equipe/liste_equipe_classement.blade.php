@extends('home')

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
                    </table>
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>
@endsection