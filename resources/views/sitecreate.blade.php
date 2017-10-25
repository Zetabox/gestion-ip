@extends('app')
@section('content')

		<div class="container">
			<div class="content">
                <div class="title_apka">Nouveau site</div><BR><BR>
               

                <BR><BR>
     
				    @foreach ($errors->all() as $error)
				        <p class="error">{{ $error }}</p>
				    @endforeach
				    {!! Form::open(array('url' => '/site/create')) !!}
				     <div class="form-group">
                        {!! Form::label('Nom') !!}
                        {!! Form::text('name', null, 
                            array('required', 
                                  'class'=>'form-control', 
                                  'placeholder'=>'Nom')) !!}
                	</div>
                	<div class="form-group">
                        {!! Form::label('Adresse') !!}
                        {!! Form::text('address', null, 
                            array('required', 
                                  'class'=>'form-control', 
                                  'placeholder'=>'Adresse')) !!}
                	</div>
                	<div class="form-group">
                        {!! Form::label('Ville') !!}
                        {!! Form::text('city', null, 
                            array('required', 
                                  'class'=>'form-control', 
                                  'placeholder'=>'Ville')) !!}
                	</div>
                	<div class="form-group">
                        {!! Form::label('Code postal') !!}
                        {!! Form::text('zip', null, 
                            array('required', 
                                  'class'=>'form-control', 
                                  'placeholder'=>'Code postal')) !!}
                	</div>
                    <div class="form-group">
                        {!! Form::label('Responsable') !!}
                        {!! Form::select('responsable', $users	, 
                            array('required', 
                                  'class'=>'form-control')) !!}
                	</div>
                	<div class="form-group">
                        {!! Form::submit('Enregistrer', 
                          array('class'=>'btn btn-primary')) !!} <a href="/site/list"> Retour</a>
                    </div>
                	{!! Form::close() !!}

				
			</div>
		</div>
@endsection
