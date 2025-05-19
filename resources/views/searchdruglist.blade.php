<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Search Drug</title>
  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{ asset('assets/css/app.min.css') }}">
  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
  <!-- Custom style CSS -->
  <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
  <link rel='shortcut icon' type='image/x-icon' href='assets/img/favicon.ico' />
</head>

<body>
  <div id="app">
    <div class="main-wrapper drugsearch main-wrapper-1">
      
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-body">
            <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                  <div class="card-header">
                    <a href="{{ route('login') }}" class="btn btn-primary" >Login</a>
                    <h4>Drug Search</h4>
                  </div>
                  <div class="card-body">
                    
                    <form action="{{ route('finddrug') }}" method="post">
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
              </div>
              
            </div>
            
          </div>
        </section>
      </div>
    </div>
  </div>
  <!-- General JS Scripts -->
  <script src="{{ asset('assets/js/app.min.js') }}"></script>
  <!-- JS Libraies -->
  <script src="{{ asset('assets/bundles/jquery-ui/jquery-ui.min.js') }}"></script>
  <!-- Page Specific JS File -->
  <!-- Template JS File -->
  <script src="{{ asset('assets/js/scripts.js') }}"></script>
  <!-- Custom JS File -->
  <script src="{{ asset('assets/js/custom.js') }}"></script>
</body>


</html>