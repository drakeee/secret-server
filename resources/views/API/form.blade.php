<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
	<div id="app">
		<div class="container">
			<form action="<?php echo action('SecretController@ProcessData'); ?>" method="POST">
				{{ csrf_field() }}
				
				<div class="form-group">
					<label for="expireAfter">Expires After (minutes)<input class="form-control" type="number" value="60" id="expireAfter" name="expireAfter"></label>
					

					<label for="expireAfterViews">Expires After Views <input class="form-control" type="number" value="1" id="expireAfterViews" name="expireAfterViews"></label>
				</div>

				<div class="form-group">
					<label>Add a secret message</label>
					<textarea id="secret-editor" name="secret" class="form-control"></textarea>
				</div>

				<input type="submit" name="submitSecret" class="btn btn-primary" />
			</form>
		</div>
	</div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
    <script>
        CKEDITOR.replace( 'secret-editor' );
    </script>
</body>
</html>