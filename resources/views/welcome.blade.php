{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}


<!doctype html>
<html lang="en">
  <head>
  	<title>Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="{{asset('SelainLogin/plugins/google-font/font3.css')}}">

    <link rel="stylesheet" href="{{asset('SelainLogin/plugins/fontawesome-free/css/all.min.css')}}">

	<link rel="stylesheet" href="{{ asset('pepe/css/style.css') }}">

	</head>
	<body class="img js-fullheight" style="background-image: url(pepe/images/bg_white.png);">
	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-6 text-center mb-5">
					<h2 class="heading-section"><b>PPU AUTOMATION</b></h2>
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-md-6 col-lg-4">
					<div class="login-wrap p-0">
		      	<h3 class="mb-4 text-center"><b style="color: black !important;">Login</b></h3>
            <form method="POST" action="{{ route('login') }}">
              @csrf
		      		<div class="form-group">
                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" placeholder="Username" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>
		      		</div>
	            <div class="form-group">
	              <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password"  name="password" required autocomplete="current-password">
	              <span id="password-field" {{-- class="fa fa-fw fa-eye field-icon "--}}></span>
	            </div>
	            <div class="form-group">
	            	<button type="submit" class="form-control btn btn-primary submit px-3">Sign In</button>
	            </div>

                <div class="col-12 text-center mt-5">
                    <img height="200px" src="{{asset('SelainLogin/dist/img/load.png')}}" alt="">
                </div>

	            </div>
	          </form>

		      </div>
				</div>
			</div>
		</div>
	</section>

	<script src="pepe/js/jquery.min.js"></script>
  <script src="pepe/js/popper.js"></script>
  <script src="pepe/js/bootstrap.min.js"></script>
  <script src="pepe/js/main.js"></script>

    <script>
        $("#password-field").on('click', function(event) {
            event.preventDefault();
            if($('#password').attr("type") == "text"){
                $('#password').attr('type', 'password');
                $('#password-field').removeClass( "fa-eye-slash" );
                $('#password-field').addClass( "fa-eye" );
            }else if($('#password').attr("type") == "password"){
                $('#password').attr('type', 'text');
                $('#password-field').addClass( "fa-eye-slash" );
                $('#password-field').removeClass( "fa-eye" );
            }
        });
    </script>

	</body>
</html>






