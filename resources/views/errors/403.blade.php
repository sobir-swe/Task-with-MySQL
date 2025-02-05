<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>@yield('title', '403 Forbidden')</title>

	<!-- Favicon and Touch Icon -->
	<link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
	<link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

	<!-- Google Fonts -->
	<link href="https://fonts.gstatic.com" rel="preconnect">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

	<!-- Bootstrap and Other Vendor Stylesheets -->
	<link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">

	<!-- Custom Styles -->
	<link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

	<style>
		.btn-back-home {
			background-color: #007bff; /* Ko'k rang */
			color: white; /* Matnni oq qilish */
			border: none;
			padding: 10px 20px;
			border-radius: 5px;
			text-decoration: none;
			font-size: 16px;
		}

		.btn-back-home:hover {
			background-color: #0056b3; /* Hover holatidagi rang */
			text-decoration: none;
		}
	</style>
</head>
<body>

<main>
	<div class="container">

		<section class="section error-403 min-vh-100 d-flex flex-column align-items-center justify-content-center">
			<h1>403</h1>
			<h2>{{ $message }}</h2> <!-- Display the custom error message -->
			<a class="btn-back-home" href="{{ url('/') }}">Back to home</a>
			<img src="{{ asset('assets/img/not-found.svg') }}" class="img-fluid py-5" alt="Forbidden">
		</section>

	</div>
</main>

@extends('components.scripts')

</body>
</html>
