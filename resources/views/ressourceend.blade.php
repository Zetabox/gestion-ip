@extends('app')
@section('content')

		<div class="container">
			<div class="content">
                <div class="title_apka">Assistant création d'une ressrouce :</div><BR><BR>
                	<div align="right">
                		<a href="/ressource/edit/{{ $ressource_id }}">Retour</A>
                	</div>	
                  
                  <div>
                    Félicitation votre ressource a bien été créée
                  </div>
                  <div>
                    <p>Vous devez saisir les dernières interventions effectuées sur la ressource pour activer les échéances.</p>
                  </div>
                  <div>
                    {!! Form::open(array('url' => '/ressource/edit/'.$ressource_id,'method' => 'GET')) !!}
                    {!! Form::submit('Editer la ressource', 
                          array('class'=>'btn btn-primary')) !!}{!! Form::close() !!}
                  </div>
                  

				
				<BR>
				

        
			</div>
		</div>
@endsection
