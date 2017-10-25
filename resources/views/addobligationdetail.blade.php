@extends('app')
@section('content')

		<div class="container">
			<div class="content">
                <div class="title_apka">Ajout d'une obligation pour votre ressource :</div><BR><BR>
                	<div align="right">
                		<a href="/ressource/edit/{{ $ressource_id }}">Retour</A>
                	</div>	

                  <div><font class="title_apka">Obligations disponibles pour : </font><font class="title_apka1">{{ $name }}</font></div><BR><BR>     
				    @foreach ($errors->all() as $error)
				        <p class="error">{{ $error }}</p>
				    @endforeach

            

				
				<BR>
				{!! Form::open(array('url' => '/ressource/store')) !!}
        <input type="hidden" name="ressource_id" value="{{ $ressource_id }}">
        <input type="hidden" name="provenance" value="edition">
          @foreach ($obligations as $obligation)
            <div class="form-group"><font class="text_apka1">{{ $obligation->name }}</font><BR>
              @foreach ($obligation->obligation_detail as $detail)
                        @if(!in_array($detail->id,$tab))
                       
                          {!! Form::checkbox('obligation_detail_id[]', $detail->id  , false) !!}
                          Tous les {{ $detail->frequence}} {{ $detail->frequence_type}} {{ $detail->txt_1}} {{ $detail->txt_2 }}<BR>
                        @endif
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
