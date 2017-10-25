@extends('app')
@section('content')

		<div class="container">
			<div class="content">
                <div class="title_apka">Liste de vos sites</div><BR><BR>
                @if(Session::has('error'))
                <div class="alert alert-info alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>Attention!</strong> {{ Session::get('error') }}
                </div>
                @endif
                <div><a href="/site/create" class="btn btn-warning pull-left" style="margin-right: 3px;">Ajouter un site</A></div></br></br></br>
                <div class="table-responsive">
                    <table class="table table-hover" style="table-layout:fixed;">
                        <thead><TR><th style="white-space:pre-wrap ; word-wrap:break-word;">Nom&nbsp;▾</TH><TH>Adresse</TH><TH style="white-space:pre-wrap ; word-wrap:break-word;">Responsable</TH><TH style="white-space:pre-wrap ; word-wrap:break-word;">Edition</TH></TR></thead>
                        <tbody>
                            @foreach ($sites as $site)
                                <TR>
                                    <TD style="white-space:pre-wrap ; word-wrap:break-word;">{{ $site->name}}</TD>
                                    <TD style="white-space:pre-wrap ; word-wrap:break-word;">{{ $site->address }}&nbsp;{{ $site->zip }}&nbsp;{{ $site->city }}</TD>
                                    <TD>{{ $site->responsable->name }}</TD>
                                    <TD><a href="/site/edit/{{ $site->id }}" class="btn btn-info pull-left" style="margin-right: 3px;">Edit</A></TD>
                                </TR>
                            @endforeach
                        </tbody>
                    </TABLE>
                </div>
        
			</div>
		</div>
@endsection
