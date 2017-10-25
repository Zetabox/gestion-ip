@extends('app')
@section('content')

		<div class="container">
			<div class="content">
                <div class="title_apka">Nouvelle intervention pour la ressource : <font class="title_apka1">{{ $ressource->name}}</font></div><BR><BR>
               

                <BR><BR>
     
				    @foreach ($errors->all() as $error)
				        <p class="error">{{ $error }}</p>
				    @endforeach

				{!! Form::open(array('url' => '/intervention/store', 'files'=>true)) !!}
        <input type="hidden" name="ressource_id" value="{{ $ressource->id }}">
          @foreach ($obligations as $obligation)
            <div class="form-group"><font class="text_apka1">{{ $obligation->name }}</font><BR>
                        
                        {!! Form::checkbox('obligation_detail[]', $obligation->obligation_detail->id  , false) !!}
                        Tous les {{ $obligation->obligation_detail->frequence}} {{ $obligation->obligation_detail->frequence_type}} {{ $obligation->obligation_detail->txt_1}} {{ $obligation->obligation_detail->txt_2 }}
                    <div class="form-group">
                        {!! Form::label('Date') !!}
                        {!! Form::text('date_'.$obligation->obligation_detail->id, null, 
                            array('class'=>'form-control', 
                                  'placeholder'=>'Date')) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('Commentaire') !!}
                        {!! Form::text('comment_'.$obligation->obligation_detail->id, null, 
                            array('class'=>'form-control', 
                                  'placeholder'=>'Commentaire')) !!}
                    </div>
            </div>
            @endforeach
                  <div class="form-group">
                        {!! Form::submit('Enregistrer', 
                          array('class'=>'btn btn-primary')) !!} <a href="/ressource/edit/{{ $ressource->id }}">Retour</a>
                     </div>
            {!! Form::close() !!}
            @if(Session::has('error'))
  <p class="errors">{!! Session::get('error') !!}</p>
  @endif
			</div>
		</div>
@endsection
