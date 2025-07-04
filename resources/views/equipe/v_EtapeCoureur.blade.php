@extends('home')

@section('realContent')
<div class="content-wrapper">
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Ajout Etape-Coureur</h4>
                    <div>
                        @if(session()->has('success'))
                        <div>
                            {{ session('success') }}
                        </div>
                        @endif
                    </div>
                    <?php $id_equipe = auth()->guard('equipe')->user()->id; ?>

                    <div class="table-responsive pt-3">
                        <form method="post" action="{{ route('equipe.createEtapeCoureur') }}">
                            @csrf
                            <input type="hidden" name="id_etape" value="{{ $id_etape }}">
                            <input type="hidden" name="id_equipe" value="{{ $id_equipe }}">
                            <input type="hidden" name="nbr_coureur_inscri" value="{{ $nbr_coureur_inscri }}">
                            <input type="hidden" name="nbr_coureur" value="{{ $nbr_coureur }}">

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Nom</th>
                                        <th>Ajout coureur</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($coureurs as $coureur)
                                    <tr>
                                        <td>{{ $coureur->id }}</td>
                                        <td>{{ $coureur->nom }}</td>
                                        <td>
                                            <input type="checkbox" name="id_coureur[]" value="{{ $coureur->id }}">
                                        </td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <button type="submit" class="btn btn-primary">Ajouter</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
