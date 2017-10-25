@extends('app')
@section('content')

		<div class="container">
			<div class="content">
                <div class="title_apka">Assistant création d'une ressource :</div><BR><BR>
                	<div align="right">
                		<a href="/ressource/create">Retour</A>
                	</div>	

                <BR><BR>
            <div class="form-group">Domaine : {{ $domaine_name }} </div>
				    @foreach ($errors->all() as $error)
				        <p class="error">{{ $error }}</p>
				    @endforeach

					{!! Form::open(array('url' => '/ressource/create')) !!}
				  <input type="hidden" name="id" value="2">
          <input type="hidden" name="domaine_id" value="{{ $domaine_id }}">
            <div class="form-group">
                        {!! Form::label('Site') !!}
                        {!! Form::select('site_id', $sites  , 
                            array('required', 
                                  'class'=>'form-control')) !!}
            </div>
          <div class="form-group">
                        {!! Form::label('Catégorie') !!}
                        {!! Form::select('categorie_id', $categories  , 
                            array('required', 
                                  'class'=>'form-control')) !!}
            </div>
				     <div class="form-group">
                        {!! Form::label('Nom') !!}
                        {!! Form::text('name', null, 
                            array('required', 
                                  'class'=>'form-control', 
                                  'placeholder'=>'Nom')) !!}
                	</div>
                	<div class="form-group">
                        {!! Form::label('Immatriculation ou numéro de série') !!}
                        {!! Form::text('reference', null, 
                            array('required', 
                                  'class'=>'form-control', 
                                  'placeholder'=>'Référence')) !!}
                	</div>
                	<div class="form-group">
                        {!! Form::label('Date de mise en service') !!}
                        {!! Form::text('date_service', null, 
                            array('required', 
                                  'class'=>'form-control', 
                                  'placeholder'=>'Date')) !!}
                	</div>
                	<div class="form-group">
                        {!! Form::submit('Enregistrer', 
                          array('class'=>'btn btn-primary')) !!}{!! Form::close() !!}
                     </div>

				
				<BR>
				
			</div>
		</div>
@endsection
