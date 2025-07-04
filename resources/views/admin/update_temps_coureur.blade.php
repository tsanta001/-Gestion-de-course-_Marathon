@extends('homeAdmin')

@section('realContent')
<div class="content-wrapper">
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Ajout temps</h4>
                    <div>
                        @if(session()->has('success'))
                        <div>
                            {{ session('success') }}
                        </div>
                        @endif
                    </div>
                    <div class="table-responsive pt-3">
                        <form method="post" action="{{route('admin.update_temps_coureur')}}">
                            @csrf
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Nom</th>
                                        <th>Num dossard</th>
                                        <th>Genre</th>
                                        <th>Naissance</th>
                                        <th>Ajouter</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($coureurs as $coureur)
                                    <tr>
                                        <td>{{ $coureur->id }}</td>
                                        <td>{{ $coureur->nom }}</td>
                                        <td>{{ $coureur->num_dossard }}</td>
                                        <td>{{ $coureur->genre }}</td>
                                        <td>{{ $coureur->ddn }}</td>
                                        <td class="text-center">
                                            <input type="text" name="temps[{{ $coureur->id }}]" placeholder="HH:MM:SS.mms">
                                            <input type="hidden" name="id_etape" value="{{ $id_etape }}">
                                        </td>
                                    </tr>
                                    @endforeach
                                    <tr><td></td><td></td><td></td><td></td><td></td><td><button type="submit" class="btn btn-primary btn-block">Add</button></td></tr>
                                </tbody>
                            </table>
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
