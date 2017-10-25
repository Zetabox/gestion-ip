@extends('admin')
@section('content')

		<div class="container">
			<div class="content">
                <div class="title_apka">DashBoard Admin</div><BR><BR>
        		<?php $dateNow = new DateTime() ?>
				
				<BR>
				 
				<H3><span class="label label-info">Client à echéance</span></H3>
				 <div class="table-responsive">
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
                            
                            <TD bgcolor="{{$bgcolor}}"><a href="/admin/client/edit/{{ $contrat->client_id }}">{{ $contrat->client->societe}}</A></TD>
                            <TD bgcolor="{{$bgcolor}}">{{ date("d-m-Y",strtotime($contrat->end_contract)) }} </TD>
                            <TD bgcolor="{{$bgcolor}}">{{ date("d-m-Y",strtotime($contrat->begin_contract))}}</TD>
                            <TD bgcolor="{{$bgcolor}}">{{ $contrat->nb_obligations}}</TD>
                            <TD bgcolor="{{$bgcolor}}">{{ $contrat->nb_sites}}</TD>
                            <TD bgcolor="{{$bgcolor}}">{{ $contrat->nb_utilisateurs}}</TD>
                        <TR>
                        @endforeach
                        <tbody>
                    </table>
                </div>
			</div>
		</div>
@endsection