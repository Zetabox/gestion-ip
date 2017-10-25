@extends('admin')
@section('content')

		<div class="container">
			<div class="content">
                <div class="title_apka">Edition de la catégorie : <font color="#365376">{{ $categorie->name }}</font></div><BR><BR>

                
                {!! Form::open(array('url' => '/admin/categorie/update')) !!}
                <input type="hidden" name="id" value="{{ $categorie->id }}"/>
                <div class="form-group">
                        {!! Form::label('Nom') !!}
                        {!! Form::text('name', $categorie->name, 
                            array('required', 
                                  'class'=>'form-control', 
                                  'placeholder'=>'Nom')) !!}
                </div>
                <div class="form-group">
                        {!! Form::submit('Enregistrer', 
                          array('class'=>'btn btn-primary')) !!} @if($suppCategorie==0)<a href="/admin/categorie/destroy/{{ $categorie->id }}" class="btn btn-danger pull-left" style="margin-right: 3px;" onclick="if(!confirm('Etes-vous sûr de vouloire supprimer cette catégorie ?')){return false;};">Supprimer</a>@endif<a href="/admin/categorie/list/{{ $categorie->domaine_id }}">Retour</A>
                    </div>
                {!! Form::close() !!}
			</div>
		</div>
@endsection