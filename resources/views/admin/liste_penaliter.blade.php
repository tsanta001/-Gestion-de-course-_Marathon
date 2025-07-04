@extends('homeAdmin')

 @section('realContent')
<div class="content-wrapper">
          <div class="row">
        
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">

                  <h4 class="card-title">Liste Penaliter</h4>
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
                            <th>Etape</th>
                            <th>Equipe</th>
                            <th>Supprimer</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($penalites as $penalite)
                        <tr>
                            <td>{{ $penalite->etape_nom }}</td>
                            <td>{{ $penalite->equipe_nom}}</td>
                            <td>{{ $penalite->temps }}</td>
                            <td><form action="{{ route('admin.suppression', ['penalite' => $penalite->id]) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete()">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            </td>

                        </tr>                
                        @endforeach
                      </tbody>
                    </table>
                    <a href="{{route('admin.v_insertion_penaliter')}}">Ajouter Penaliter</a>
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>

        <script>
function confirmDelete() {
    return confirm('Êtes-vous sûr de vouloir supprimer cette pénalité ?');
}
</script>
@endsection