@extends('homeAdmin')

@section('realContent')
<div class="content-wrapper">
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Classement général par catégorie</h4>
                    <div>
                        @if(session()->has('success'))
                        <div>
                            {{ session('success') }}
                        </div>
                        @endif
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
                                @foreach($classement_categories as $classement_categorie)
                                <tr>
                                    <td>{{ $i++; }}</td>
                                    <td>{{ $classement_categorie->equipe }}</td>
                                    <td>{{ $classement_categorie->categorie }}</td>
                                    <td style="background-color:red;">{{ $classement_categorie->total_points }}</td>
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
