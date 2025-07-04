@extends('homeAdmin')

@section('realContent')
<div class="content-wrapper">
          <div class="row">
         
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">          
                  <h4 class="card-title">Importation</h4>
                  @if($errors->any())
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    @endif
                  <form class="forms-sample" method="post" action="{{route('admin.importCSVEtapeResultat')}}" enctype="multipart/form-data">
                  @csrf 
            

                    <div class="form-group row">
                      <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Etapes</label>
                      <div class="col-sm-9">
                        <input type="file" class="form-control" id="file" name="file" accept=".csv" >
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Resultat</label>
                      <div class="col-sm-9">
                        <input type="file" class="form-control" id="file2" name="file2" accept=".csv" >
                      </div>
                    </div>
                
                    
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <button class="btn btn-light">Cancel</button>
                  </form>

                </div>
              </div>
            </div>
          </div>
        </div>
@endsection