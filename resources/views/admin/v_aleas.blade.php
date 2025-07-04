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
                  <form class="forms-sample" method="post" action="{{route('admin.aleas')}}">
                  @csrf

                    <br>
                    <br><br>
                    
                    Nbr <input type="text" class="form-control" name="nbr">
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