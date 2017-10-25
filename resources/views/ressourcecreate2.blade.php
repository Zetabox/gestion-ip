@extends('app')
@section('content')

		<div class="container">
			<div class="content">
                <div class="title_apka">Assistant création d'une ressource :</div><BR><BR>
                	<div align="right">
                		<a href="/ressource/create?id=1">Retour</A>
                	</div>	
                  <div>
                    <font class="text_apka1">Domaine   :</font><font class="text_apka"> {{ $domaine_name }}</font><BR>
                    <font class="text_apka1">Catégorie :</font><font class="text_apka"> {{ $categorie_name }}</font> <BR>
                    <font class="text_apka1">Référence :</font><font class="text_apka"> {{ $reference}}</font> <BR>
                    <font class="text_apka1">Date de mise en service :</font><font class="text_apka"> {{ $date_service }}</font> <BR><BR><BR>
                  </div>
                  <div><font class="title_apka">Obligations disponibles pour : </font><font class="title_apka1">{{ $name }}</font></div><BR><BR>     
				    @foreach ($errors->all() as $error)
				        <p class="error">{{ $error }}</p>
				    @endforeach

            

				
				<BR>
				{!! Form::open(array('url' => '/ressource/store')) !!}
        <input type="hidden" name="ressource_id" value="{{ $ressource_id }}">
          @foreach ($obligations as $obligation)
            <div class="form-group"><font class="text_apka1">{{ $obligation->name }}</font><BR>
              @foreach ($obligation->obligation_detail as $detail)
                        
                        {!! Form::checkbox('obligation_detail_id[]', $detail->id  , false) !!}
                        Tous les {{ $detail->frequence}} {{ $detail->frequence_type}} {{ $detail->txt_1}} {{ $detail->txt_2 }}<BR>
               @endforeach
            </div>
            @endforeach
                  <div class="form-group">
                        {!! Form::submit('Enregistrer', 
                          array('class'=>'btn btn-primary')) !!}{!! Form::close() !!}
                     </div>

        
			</div>
		</div>
@endsection
