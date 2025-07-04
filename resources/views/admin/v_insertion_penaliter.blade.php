@extends('homeAdmin')

@section('realContent')


<div class="content-wrapper">
          <div class="row">
         
            <div class="col-md-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">          
                  <h2 class="">Insertion Penaliter</h2>
                  @if($errors->any())
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    @endif
                  <form class="forms-sample" method="post" action="{{route('admin.insertion_penaliter')}}">
                  @csrf

                    <br>
                    <br><br>
                    <p class="card-description">Etape </p>
                    <div class="form-group row">
                        <select class="js-example-basic-single w-100" name="id_etape">
                            @foreach($etapes as $etape)
                                <option value="{{ $etape->id }}">{{ $etape->nom}}</option>
                            @endforeach
                        </select>
                    </div>
            
                    <p class="card-description">Equipe </p>
                    <div class="form-group row">
                        <select class="js-example-basic-single w-100" name="id_equipe">
                            @foreach($equipes as $equipe)
                                <option value="{{ $equipe->id }}">{{ $equipe->nom}}</option>
                            @endforeach
                        </select>
                    </div>
                    <br>

                    Temps <input type="text" class="form-control" name="temps" placeholder="00:00:00">
                    <br>
                    
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <button class="btn btn-light">Cancel</button>
                  </form>

                 

                </div>
              </div>
            </div>
          </div>
        </div>

<style>
.radio-container {
    display: inline-block;
    cursor: pointer;
    margin-right: 10px;
}

.radio-input {
    display: none;
}

.radio-label {
    display: inline-block;
    width: 240px;
    height: 300px;
    line-height: 80px;
    text-align: center;
    background-color: #e8eff9;
    border: 1px solid #aaa;
    border-radius: 20px;
    color: #333;
    transition: background-color 0.3s ease;
}

.radio-input:checked + .radio-label {
    background-color: #007bff;
    color: #fff;
}

.radio-label:hover {
    background-color: #e0e0e0;
}


</style>        
@endsection