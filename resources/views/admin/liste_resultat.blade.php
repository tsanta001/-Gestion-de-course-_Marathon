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
                                    <th>Coureur</th>
                                    <th>Genre</th>
                                    <th>Chrono</th>
                                    <th>Penalite</th>
                                    <th>Temps Final</th>
                                    <th>Rang</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($classementCoureurs as $classementCoureur)
                                <tr>
                                    <td>{{ $classementCoureur->nom_coureur }}</td>
                                    <td>{{ $classementCoureur->genre }}</td>
                                    <td>{{ $classementCoureur->temps }}</td>
                                    <td>{{ $classementCoureur->penalite }}</td>
                                    <td>{{ $classementCoureur->temps_final }}</td>
                                    <td>{{ $classementCoureur->classement }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- Ajouter les liens de pagination -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
