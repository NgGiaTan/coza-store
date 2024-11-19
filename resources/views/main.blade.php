<!DOCTYPE html>
<html lang="en">
<head>
	@include('head')
</head>
<body class="animsition"><!--class="animsition" -->
	<!-- header -->
    @include('header')

    <!-- cart    -->
    @include('cart')

	@yield('content')


	
	@include('footer')
</body>
</html>