@extends('layout.default')

@section('title') Drug Search and Tracker @stop

@section('content')

<div class="container py-4">
    <header class="pb-3 mb-4 border-bottom">
        <div class="row">
            <div class="col-md-11">
                <!-- <a href="/" class="d-flex align-items-center text-dark text-decoration-none">
                    <img src="#" alt="BootstrapBrain Logo" width="300">
                </a> -->          
            </div>
            <div class="col-md-1">
                <a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
      
    </header>

    <div class=" bg-light rounded-3">
      <div class="container-fluid py-5">
           <h4>Drug Search</h4>

            @if(Session::has('error'))
                  <div class="alert alert-danger" role="alert"> 
                    {{ Session::get('error') }}
                  </div>
              @endif


                <form action="{{ route('userfinddrug') }}" method="post">
                    @csrf                      
                        <div class="form-group row">
                          <div class="col-3 col-md-3 col-lg-3">
                            <input type="text" name="namedrug" class="form-control"  required="">
                          </div>
                          <div class="col-2 col-md-2 col-lg-2">
                            <button class="btn btn-primary">Search</button>
                          </div>
                        </div>
                </form>
                      
                <table class="table table-bordered table-md">
                <tr>
                    <th>ID</th>
                    <th>Drug name</th>
                    <th>Ingredient</th>
                    <th>Dosage</th>
                </tr>
                
                @if($datadrug)
                    @foreach ($datadrug as $concept)
                        <tr>
                            <td>{{ $concept['id'] }}</td>
                            <td>{{ $concept['name'] }}</td>
                            <td>{{ $concept['baseName'] }}</td>
                            <td>{{ $concept['doseFormGroupName'] }}</td>
                        </tr>
                    @endforeach
                @endif
                
                </table>
      </div>
    </div>

  </div>

@stop