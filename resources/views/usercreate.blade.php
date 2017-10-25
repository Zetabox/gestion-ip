@extends('app')
@section('content')

		<div class="container">
			<div class="content">
                <div class="title_apka">Nouvel utilisateur</div><BR><BR>
               

                <BR><BR>
     
				    @foreach ($errors->all() as $error)
				        <p class="error">{{ $error }}</p>
				    @endforeach
				    {!! Form::open(array('url' => '/utilisateur/store/')) !!}
                <div class="form-group">
                        {!! Form::label('Nom') !!}
                        {!! Form::text('name', null, 
                            array('required', 
                                  'class'=>'form-control', 
                                  'placeholder'=>'Nom')) !!}
                </div>
                <div class="form-group">
                        {!! Form::label('Email') !!}
                        {!! Form::text('email', null, 
                            array('required', 
                                  'class'=>'form-control', 
                                  'placeholder'=>'Email')) !!}
                </div><div class="form-group">
                        {!! Form::label('Mot de passe') !!}
                        {!! Form::text('password', null, 
                            array('required', 
                                  'class'=>'form-control', 
                                  'placeholder'=>'Mot de passe')) !!}
                </div>Selection multiple autorisée
                <div class="form-group">
                    {!! Form::label('Rôles de l\'utilisateur') !!}<BR>
                    <select multiple="multiple" name="roles[]" id="roles" style="width: 400px">
                        @foreach($roles as $role)
                                <option value="{!! $role->id !!}">{!! $role->name !!}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    {!! Form::label('Sites autorisés') !!}<BR>
                    <select multiple="multiple" name="sites[]" id="sites" style="width: 400px">
                        @foreach($sitesListe as $site)
                                <option value="{!! $site->id !!}">{!! $site->name !!}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    {!! Form::label('Domaines autorisés') !!}<BR>
                    <select multiple="multiple" name="domaines[]" id="sites" style="width: 400px">
                        @foreach($domainesListe as $domaine)
                                <option value="{!! $domaine->name !!}">{!! $domaine->name !!}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                        {!! Form::submit('Enregistrer', 
                          array('class'=>'btn btn-primary')) !!}&nbsp;<a href="/utilisateur/list">Retour</A><BR>
                    </div>
                {!! Form::close() !!}

				
			</div>
		</div>
@endsection
