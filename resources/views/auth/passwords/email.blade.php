<!doctype html>
<html lang="en">
  <head>
  	<title>Reset Password</title>
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
		      	<h3 class="mb-4 text-center"><b style="color: black !important;">Reset Password</b></h3>
                @if (session('status'))
                    <div class="alert alert-success text-center" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
		      		<div class="form-group">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email Address" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
		      		</div>
	            <div class="form-group">
	            	<button type="submit" class="form-control btn btn-primary submit px-3">Send Password Reset Link</button>
	            </div>
                <div class="col-12 text-center mt-5">
                    <img height="200px" src="{{asset('SelainLogin/dist/img/load.png')}}" alt="">
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

	</body>
</html>
