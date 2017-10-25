@extends('admin')
@section('content')

        <div class="container">
            <div class="content">
                <div class="title_apka">Edition de la lettre</div><BR><BR>

                  @if(Session::has('success'))
                    <div class="alert-box success">
                      <h2>{!! Session::get('success') !!}</h2>
                    </div>
                  @endif
                  <div class="form-group">Edition de la lettre</div>
                  {!! Form::open(array('url'=>'admin/lettre/update','method'=>'POST', 'files'=>true)) !!}
                  <input type="hidden" name="id" value="{{ $lettre->id }}">
                  <div class="form-group">
                        {!! Form::label('Nom') !!}
                        {!! Form::text('name', $lettre->name, 
                            array('required', 
                                  'class'=>'form-control', 
                                  'placeholder'=>'Nom')) !!}
                  </div>
                  <div class="form-group">
                        {!! Form::label('Description') !!}
                        {!! Form::text('description', $lettre->description, 
                            array('required', 
                                  'class'=>'form-control', 
                                  'placeholder'=>'Description')) !!}
                  </div>
                  <div class="form-group">
                    <a href="/admin/lettre/show/{{ $lettre->filename }}">{{ $lettre->original_filename}}</a>
                  </div>
                  <div class="form-group">
                    {!! Form::file('image') !!}
                    <p class="errors">{!!$errors->first('image')!!}</p>
                    @if(Session::has('error'))
                      <p class="errors">{!! Session::get('error') !!}</p>
                    @endif
                  
                    <div id="success"> </div>
                  </div>
                   <div class="form-group">
                    {!! Form::submit('Enregistrer', array('class'=>'btn btn-primary')) !!} 
                     &nbsp;<a href="/admin/lettre/list/{{ $lettre->domaine_id }}">&nbsp; Retour</A>
                     <a href="/admin/lettre/destroy/{{ $lettre->id }}" class="btn btn-danger pull-left" style="margin-right: 3px;" onclick="if(!confirm('Etes-vous sûr de vouloire supprimer cette lettre ?')){return false;};">Supprimer</a>
                   
                  </div>      
                  {!! Form::close() !!}           
            </div>
        </div>
@endsection