@extends('app')
@section('content')

		<div class="container">
			<div class="content">
                <div class="title_apka">Edition du site : {{ $results->name}}</div><BR><BR>
                	<div align="right">
                		<a href="/site/list">Retour</A>
                	</div>	
                	@foreach ($errors->all() as $error)
				        <p class="error">{{ $error }}</p>
				    @endforeach
				    {!! Form::open(array('url' => '/site/update')) !!}
				    <input type="hidden" name="id" id="id" value="{{ $results->id }}">
				     <div class="form-group">
                        {!! Form::label('Nom') !!}
                        {!! Form::text('name', $results->name, 
                            array('required', 
                                  'class'=>'form-control', 
                                  'placeholder'=>'Nom')) !!}
                	</div>
                	<div class="form-group">
                        {!! Form::label('Adresse') !!}
                        {!! Form::text('address', $results->address, 
                            array('required', 
                                  'class'=>'form-control', 
                                  'placeholder'=>'Adresse')) !!}
                	</div>
                	<div class="form-group">
                        {!! Form::label('Ville') !!}
                        {!! Form::text('city', $results->city, 
                            array('required', 
                                  'class'=>'form-control', 
                                  'placeholder'=>'Ville')) !!}
                	</div>
                	<div class="form-group">
                        {!! Form::label('Code postal') !!}
                        {!! Form::text('zip', $results->zip, 
                            array('required', 
                                  'class'=>'form-control', 
                                  'placeholder'=>'Code postal')) !!}
                	</div>
                    <div class="form-group">
                        {!! Form::label('Responsable') !!} : &nbsp;
                        {!! Form::select('responsable', $users	, $results->user_id,array('required', 
                                  'class'=>'form-control')) !!}
                	</div>
                	<div class="form-group">
                        {!! Form::submit('Enregistrer!', 
                          array('class'=>'btn btn-primary')) !!}<a href="/site/destroy/{{  $results->id }}" class="btn btn-danger pull-left" style="margin-right: 3px;" onclick="if(!confirm('Etes-vous sûr de vouloire supprimer ce site (et toutes ses ressources) ?')){return false;};">Supprimer</a>
                          {!! Form::close() !!}
                     </div>
				<BR>
				 
			</div>
		</div>
@endsection
