@extends('app')
@section('content')

		<div class="container">
			<div class="content">
                <div class="title_apka">Edition d'un utilisateur</div><BR><BR>
               

                <BR><BR>
     
				    @foreach ($errors->all() as $error)
				        <p class="error">{{ $error }}</p>
				    @endforeach
				    {!! Form::open(array('url' => '/utilisateur/update/'.$user->id)) !!}
                <div class="form-group">
                        {!! Form::label('Nom') !!}
                        {!! Form::text('name', $user->name, 
                            array('required', 
                                  'class'=>'form-control', 
                                  'placeholder'=>'Nom')) !!}
                </div>
                <div class="form-group">
                        {!! Form::label('Email') !!}
                        {!! Form::text('email', $user->email, 
                            array('required', 
                                  'class'=>'form-control', 
                                  'placeholder'=>'Email')) !!}
                </div><div class="form-group">
                        {!! Form::label('Mot de passe') !!}
                        {!! Form::text('password', null, 
                            array('', 
                                  'class'=>'form-control', 
                                  'placeholder'=>'Mot de passe')) !!}
                </div>
                <div class="form-row">
                        {!! Form::label('Affecté au site :') !!}
                        {!! Form::select('site_id', $sites,$SiteUser, 
                            array('', 
                                  'class'=>'form-control')) !!}
                </div>
                <div class="form-group">
                        {!! Form::label('Actif') !!}
                        {!! Form::checkbox('actif', 1, $user->actif) !!}
                </div>Selection multiple autorisée
                <div class="form-group">
                    {!! Form::label('Rôles de l\'utilisateur') !!}<BR>
                    <select multiple="multiple" name="roles[]" id="roles" style="width: 400px">
                        @foreach($roles as $role)
                                <option value="{!! $role->id !!}" @if(in_array($role->name,$userroles)) selected @endif >{!! $role->name !!}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    {!! Form::label('Sites autorisés') !!}<BR>
                    <select multiple="multiple" name="sites[]" id="sites" style="width: 400px">
                        @foreach($sitesListe as $site)
                                <option value="{!! $site->id !!}" @if(in_array($site->name,$usersites)) selected @endif >{!! $site->name !!}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    {!! Form::label('Domaines autorisés') !!}<BR>
                    <select multiple="multiple" name="domaines[]" id="domaines" style="width: 400px">
                        @foreach($domainesListe as $domaine)
                                <option value="{!! $domaine->name !!}" @if(in_array($domaine->name,$userdomaines)) selected @endif >{!! $domaine->name !!}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                        {!! Form::submit('Enregistrer', 
                          array('class'=>'btn btn-primary')) !!}&nbsp;@if($supp==1)<a href="/utilisateur/destroy/{{ $user->id }}" class="btn btn-danger pull-left" style="margin-right: 3px;" onclick="if(!confirm('Etes-vous sûr de vouloire supprimer cet utilisateur ?')){return false;};">Supprimer</a>@endif&nbsp;<a href="/utilisateur/list">Retour</A><BR>
                    </div>
                {!! Form::close() !!}

				
			</div>
		</div>
@endsection
