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

                        @if(session()->has('error'))
                        <div style="color:red">
                            {{ session('error') }}
                        </div>
                        @endif
                    </div>
                    <div class="table-responsive pt-3">
                        <?php $id_equipe = auth()->guard('equipe')->user()->id; ?>
                        
                        <form method="post" action="{{ route('equipe.v_EtapeCoureur') }}">
                            @csrf
                            <input type="hidden" name="id_etape" value="{{ $id_etape }}">
                            <input type="hidden" name="id_equipe" value="{{ $id_equipe }}">
                            <input type="hidden" name="nbr_coureur_inscri" value="{{ count($coureurs) }}">
                            <input type="hidden" name="nbr_coureur" value="{{ $nbr_coureur }}">

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nom</th>
                                        <th>Temps</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                @foreach($coureurs as $coureur)
                                    <tr>
                                        <td>{{ $coureur->coureur_nom }}</td>
                                        <td>{{ $coureur->temps }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            </div>
                            <button type="submit" class="btn btn-primary">Add</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
