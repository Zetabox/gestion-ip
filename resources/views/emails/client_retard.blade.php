<?php $dateNow = new DateTime() ?>
<H3>Bonjour, {{ $name}} ({{ $email }})</H3>
<H4>Vous avez des échances pour vos contrats</H4><BR>
 <table class="table table-hover" style="table-layout:fixed;" cellspacing="0" cellspading="0">
                        <thead>
                                <TR><th>Société</TH><th>Fin de contrat</th><TH>Début de contrat</TH><TH>Nb Obligations</TH><TH>Nb Sites</TH><TH>Nb Utilisateurs</TH></TR>
                        </thead>
                        <tbody>
                        @foreach ($contrats as $contrat)
                        @if ($contrat->end_contract->diff($dateNow)->days<=7)
                        	 @if ($bgcolor="red") @endif
                        @endif

                        @if($contrat->end_contract<$dateNow)
                        	@if($bgcolor="#FF0000") @endif

                        @else

	                        @if ($contrat->end_contract->diff($dateNow)->days>7 and $contrat->end_contract->diff($dateNow)->days<30)
	                        	@if($bgcolor="orange") @endif
	                        @elseif ($contrat->end_contract->diff($dateNow)->days>30)
	                        	@if($bgcolor="#6CC417") @endif
	                        @endif
	                    @endif
                        
 
                        <TR bgcolor="{{$bgcolor}}">
                            
                            <TD bgcolor="{{$bgcolor}}"><a href="http://<?php echo $_SERVER['SERVER_NAME'];?>/admin/client/edit/{{ $contrat->client_id }}">{{ $contrat->client->societe}}</A></TD>
                            <TD bgcolor="{{$bgcolor}}">{{ date("d-m-Y",strtotime($contrat->end_contract)) }} </TD>
                            <TD bgcolor="{{$bgcolor}}">{{ date("d-m-Y",strtotime($contrat->begin_contract))}}</TD>
                            <TD bgcolor="{{$bgcolor}}">{{ $contrat->nb_obligations}}</TD>
                            <TD bgcolor="{{$bgcolor}}">{{ $contrat->nb_sites}}</TD>
                            <TD bgcolor="{{$bgcolor}}">{{ $contrat->nb_utilisateurs}}</TD>
                        <TR>
                        @endforeach
                        <tbody>
                    </table>