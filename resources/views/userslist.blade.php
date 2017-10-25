@extends('app')

@section('content')
		<div class="container">
			<div class="content">
                <div class="title_apka">Liste de vos utilisateurs</div><BR><BR>
                @if(Session::has('error'))
                <div class="alert alert-info alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>Attention!</strong> {{ Session::get('error') }}
                </div>
                @endif
                <div><a href="/utilisateur/create" class="btn btn-warning pull-left" style="margin-right: 3px;">Ajouter un utilisateur</A></div></br></br></br>
                <div class="table-responsive">
                    <table class="table table-hover" style="table-layout:fixed;">
                        <thead><TR><th>Nom&nbsp;▾</TH><TH>Email</TH><TH>Edition</TH></TR></thead>
                        <tbody>
                            @foreach ($users as $user)
                                <TR ><TD>{{ $user->name}}</TD><TD>{{ $user->email }}</TD><TD><a href="/utilisateur/edit/{{ $user->id }}" class="btn btn-info pull-left" style="margin-right: 3px;">Edit</A></TD></TR>
                            @endforeach
                        </tbody>
                    </TABLE>
                </div>
        
			</div>
		</div>
@endsection