@extends('admin')
@section('content')

        <div class="container">
            <div class="content">
                <div class="title_apka">Nouvelle lettre</div><BR><BR>

                  @if(Session::has('success'))
                    <div class="alert-box success">
                      <h2>{!! Session::get('success') !!}</h2>
                    </div>
                  @endif
                  <div class="form-group">Chargement de la lettre</div>
                  {!! Form::open(array('url'=>'admin/lettre/store','method'=>'POST', 'files'=>true)) !!}
                  <input type="hidden" name="domaine_id" value="{{ $domaine->id }}">
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
                    {!! Form::submit('Enregistrer', array('class'=>'btn btn-primary')) !!}<a href="/admin/lettre/list/{{ $domaine->id }}">&nbsp;Retour</A>
                    {!! Form::close() !!}
                  </div>                
            </div>
        </div>
@endsection