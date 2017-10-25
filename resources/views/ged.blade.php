@extends('app')
@section('content')

        <div class="container">
            <div class="content">
                <div class="title_apka">Nouveau document</div><BR><BR>

                  @if(Session::has('success'))
                    <div class="alert-box success">
                      <h2>{!! Session::get('success') !!}</h2>
                    </div>
                  @endif
                  <div class="form-group">Chargement du document</div>
                  {!! Form::open(array('url'=>'/ged/store','method'=>'POST', 'files'=>true)) !!}
                  <input type="hidden" name="ressource_id" value="{{ $ressource_id }}">
                  <div class="form-group">
                        {!! Form::label('Nom') !!}
                        {!! Form::text('name', null, 
                            array('required', 
                                  'class'=>'form-control', 
                                  'placeholder'=>'Nom')) !!}
                  </div>
                  <div class="form-group">
                        {!! Form::label('Description') !!}
                        {!! Form::text('description', null, 
                            array('required', 
                                  'class'=>'form-control', 
                                  'placeholder'=>'Description')) !!}
                  </div>

                  <div class="form-group">
                    {!! Form::file('image') !!}
                    <p class="errors">{!!$errors->first('image')!!}</p>
                    @if(Session::has('error'))
                      <p class="errors">{!! Session::get('error') !!}</p>
                    @endif
                  </div>
                  <div id="success"> </div>
                   <div class="form-group">
                    {!! Form::submit('Enregistrer', array('class'=>'btn btn-primary')) !!}<a href="/ressource/edit/{{ $ressource_id }}">&nbsp;Retour</A>
                    {!! Form::close() !!}
                  </div>                
            </div>
        </div>
@endsection