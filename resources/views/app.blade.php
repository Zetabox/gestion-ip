<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Apka</title>

	<link href="/css/app.css" rel="stylesheet">
	<link href="/css/apka.css" rel="stylesheet">


	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">Apka</a>
			</div>
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					@if (Auth::check())
					<li><a href="/">Tableau de bord</a></li>
					@if (Entrust::hasRole('Admin') || Entrust::hasRole('Admin Obligations') || Entrust::hasRole('Lecteur Obligations'))<li><a href="/obligation/list/0">Obligation</a></li>@endif
					@if (Entrust::hasRole('Admin') || Entrust::hasRole('Admin Ressources') || Entrust::hasRole('Lecteur Ressources'))
					<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Ressources<span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								@if (Entrust::hasRole('Admin') || Entrust::hasRole('Admin Ressources'))<li><a href="/ressource/create">Créer</a></li>@endif
								<li><a href="/ressource/list/0">Liste</a></li>
							</ul>
					</li>
					@endif
					<li><a href="/lettre/list/0">Lettres types</a></li>
					@if (Entrust::hasRole('Admin'))
					<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Gestion<span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="/utilisateur/list">Utilisateurs</a></li>
								<li><a href="/site/list">Sites</a></li>
							</ul>
					</li>
					@endif
					<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Aide<span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="/tutorial">Tutorial</a></li>
								<li><a href="/support">Support</a></li>
							</ul>
					</li>
					@endif
				</ul>

				<ul class="nav navbar-nav navbar-right">
					@if (Auth::guest())
						<li><a href="/auth/login">Login</a></li>
						<!-- <li><a href="/auth/register">Register</a></li> -->
					@else
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<!-- <li><a href="/auth/logout">Contrat</a></li> -->
								<li><a href="/auth/logout">Logout</a></li>
							</ul>
						</li>
					@endif
				</ul>
			</div>
		</div>
	</nav>

	@yield('content')

	<!-- Scripts -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
</body>
</html>
