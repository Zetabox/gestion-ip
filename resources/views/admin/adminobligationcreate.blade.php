@extends('admin')
@section('content')


		<div class="container">
			<div class="content">
                <!-- Titla_Obligation (Shape) -->
      <div class="title_apka">Création d'une obligation ({{ $domaine->name}})</div><BR><BR>

                <BR><BR>
     
				    @foreach ($errors->all() as $error)
				        <p class="error">{{ $error }}</p>
				    @endforeach

                    {!! Form::open(array('url' => '/admin/obligation/create')) !!}
                    <input type="hidden" name="domaine_id" value="{{ $domaine->id }}" />

                    <div class="form-group">
                        {!! Form::label('Nom') !!}
                        {!! Form::text('name', null, 
                            array('required', 
                                  'class'=>'form-control', 
                                  'placeholder'=>'Nom')) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('Catégorie') !!}
                        {!! Form::select('categorie', $categories,null,array('', 
                                  'class'=>'form-control')) !!}
                     
                    </div>
                    <div class="form-group">
                        {!! Form::label('Source') !!}
                        {!! Form::text('source', null, 
                            array('required', 
                                  'class'=>'form-control', 
                                  'placeholder'=>'Source')) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('Texte de référence') !!}
                        {!! Form::text('txtref', null, 
                            array('required', 
                                  'class'=>'form-control', 
                                  'placeholder'=>'Texte de référence')) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('Date de mise en application') !!}
                        {!! Form::text('dma', null, 
                            array('required', 
                                  'class'=>'form-control', 
                                  'placeholder'=>'Date')) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('Description') !!}
                        {!! Form::text('description', null, 
                            array('required', 
                                  'class'=>'form-control', 
                                  'placeholder'=>'Description')) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('Texte de loi') !!}
                        {!! Form::textarea('txtloi', null, 
                            array('required', 
                                  'class'=>'form-control', 
                                  'placeholder'=>'Texte de loi')) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('Commentaire') !!}
                        {!! Form::textarea('comment', null, 
                            array('required', 
                                  'class'=>'form-control', 
                                  'placeholder'=>'Commentaire')) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('Actif') !!}
                        {!! Form::checkbox('actif', 1, False) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::submit('Enregistrer', 
                          array('class'=>'btn btn-primary')) !!}  ou <a href="/admin/obligation/list/{{ $domaine->id }}">Annuler</a>
                    </div>
                        
                    {!! Form::close() !!}


				
				<BR>
				
			</div>
		</div>
@endsection