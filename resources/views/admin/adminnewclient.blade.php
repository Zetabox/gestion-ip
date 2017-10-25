@extends('admin')
@section('content')


		<div class="container">
			<div class="content"> 
                <div class="title_apka">Nouveau client : </div><BR><BR>
        	       @foreach ($errors->all() as $error)
                        <p class="error">{{ $error }}</p>
                    @endforeach


                
				<BR>

                    {!! Form::open(array('url' => Request::url())) !!}
                    <div class="form-group">
                        {!! Form::label('Société') !!}
                        {!! Form::text('societe', null, 
                            array('required', 
                                  'class'=>'form-control', 
                                  'placeholder'=>'Société')) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('Nom') !!}
                        {!! Form::text('name', null, 
                            array('required', 
                                  'class'=>'form-control', 
                                  'placeholder'=>'Nom')) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('Prénom') !!}
                        {!! Form::text('firstname', null, 
                            array('required', 
                                  'class'=>'form-control', 
                                  'placeholder'=>'Prénom')) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('Adresse E-mail') !!}
                        {!! Form::text('email', null, 
                            array('required', 
                                  'class'=>'form-control', 
                                  'placeholder'=>'Adresse e-mail')) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('Téléphone') !!}
                        {!! Form::text('telephone', null, 
                            array('required', 
                                  'class'=>'form-control', 
                                  'placeholder'=>'Téléphone')) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('Description') !!}
                        {!! Form::textarea('remarque',null, 
                            array('required', 
                                  'class'=>'form-control', 
                                  'placeholder'=>'Description')) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::submit('Enregistrer', 
                          array('class'=>'btn btn-primary')) !!}
                    </div>
                    {!! Form::close() !!}

			</div>
		</div>
@endsection