@extends('app')
@section('content')

		<div class="container">
			<div class="content">
                <div class="title_apka">Liste des lettres par domaine</div><BR><BR>
                <div class="navbar-form ">
                    <ul class="nav nav-pills">
                        @foreach ($domaines as $domaine)
                        <li role="presentation" @if ($domaine->id==$id) class="active" @endif><a href="/lettre/list/{{ $domaine->id }}">{{ $domaine->name}}</A></li>
                         @endforeach
                    </ul>

                </div>
        		
				<BR>
                    <div class="padding">
                        {!! Form::open(['action' => 'LettreTypeController@search', 'method' => 'POST']) !!} <input type="HIDDEN" name="domaine_id" value="{{$id}}">
                        <div class="form-row" align="right">
                            {!! Form::text('query', null, 
                                array('required','placeholder'=>'Votre recherche')) !!} {!! Form::button('Ok', ['type' => 'submit', 'class' => 'button']) !!}
                        </div>
                        <div class="form-row">
                   
                        </div>
                        {!! Form::close() !!}
                    </div>
				    <BR><BR>
                    <div class="table-responsive">
                        <table class="table table-hover" style="table-layout:fixed;">
                            <thead><TR><th>Nom</TH><TH>Description</TH><TH>Téléchargement</TH></TR></thead>
                            <tbody>
                                @foreach ($results as $result)
                                    <TR><TD style="white-space:pre-wrap ; word-wrap:break-word;">{{ $result->name}}</TD>
                                        <TD style="white-space:pre-wrap ; word-wrap:break-word;">{{ $result->description }}</TD>
                                        <TD><a href="/lettre/show/{{ $result->filename }}">{{ $result->original_filename}}</a></TD>
                                    </TR>
                                @endforeach
                            </tbody>
                        </TABLE>
                    </div>
                <div align='right'><?php echo $results->appends(['sort' => $sort,'sens'=>$sens])->render(); ?></div>
			 </div>
		</div>
@endsection