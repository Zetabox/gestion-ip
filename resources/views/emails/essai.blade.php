<H3>Bonjour, {{ $name}} ({{ $email }})</H3>
<H4>Vous recevez ce mail car vous responsable du site : {{ $site }}</H4><BR>
@if(count($ressource_retard)>1)
	Les ressources en Retard<BR>
	@foreach ($ressource_retard as $dd)
		{{ $dd }}<BR>
	@endforeach
	<BR><BR>
@endif

@if(count($ressource_30)>1)
	Les ressources expirant dans moins de 30 jours<BR>
	@foreach ($ressource_30 as $dd)
		{{ $dd }}<BR>
	@endforeach
@endif