@extends('layouts.basics')

@section('content')


<style>
    .main-header{
      display: none;
    }

    .formi{
      width: 50%;
      margin: 25% auto 0 auto;
      border-top: solid 2px #b343ec;
      padding: 3% 0% 3% 5%;
      border-radius: 1vw;
      background-color: #fff;
      box-shadow: 5px 5px 25px #212020;
    }

    body{
      background-image: url("{{ asset('dist/img/LOG_BG.jpg') }}");
      background-repeat: no-repeat;
      background-size: cover;
    }

    .m-b-md {
        margin-bottom: 30px;
        font-size: 1.3vw;
    }

</style>

<div class="container">
    <div class="row justify-content-center">

        <div class="formi">
            <div class="card">
                <div class="title m-b-md">
                    RECUPERA CONTRASEÑA EN <strong>G-LEARNING</strong>
                </div>
                <div class="card-body">
                       @if(Session::has('errorInicio'))
                            <div class="alert alert-success alert-dismissable" style="border-radius:15px;">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong>{{session('errorInicio')}}</strong> 
                            </div>
                        @endif
                
                    <form method="POST" action="{{ url('/password/forgot') }}">
                        @csrf

                        <div class="form-group row">                            
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Direccion E-Mail') }}</label>
        
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
                
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>                            
                        </div>

                        <div class="form-group row">

                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-11 offset-md-4">                               
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Enviar enlace para recuperar clave') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
