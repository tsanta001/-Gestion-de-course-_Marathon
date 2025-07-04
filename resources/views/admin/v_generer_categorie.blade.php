@extends('homeAdmin')

@section('realContent')
<div class="content-wrapper">
          <div class="row">
         
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">          
                  <h4 class="card-title">Generer Categorie</h4>
                  @if($errors->any())
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    @endif
                  <form class="forms-sample" method="post" action="{{route('admin.generer_categorie')}}" enctype="multipart/form-data">
                  @csrf 
                    
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <button class="btn btn-light">Cancel</button>
                  </form>

                </div>
              </div>
            </div>
          </div>
        </div>
@endsection