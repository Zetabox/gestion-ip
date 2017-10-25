@extends('admin')
@section('content')

		<div class="container">
			<div class="content">
                <div class="title_apka">Liste des clients</div><BR><BR>
                 <div class="padding">
                {!! Form::open(['action' => 'AdminClientController@search', 'method' => 'POST']) !!}
                    <div class="form-row" align="right">
                        {!! Form::text('query', null, 
                            array('required','placeholder'=>'Votre recherche')) !!} {!! Form::button('Ok', ['type' => 'submit', 'class' => 'button']) !!}
                    </div>
                    <div class="form-row">
                   
                    </div>
                {!! Form::close() !!}
                </div>
        		<div class="table-responsive">
                    <table class="table table-hover" style="table-layout:fixed;">
                        <thead>
                            <TR><th style="white-space:pre-wrap ; word-wrap:break-word;"><a href='/admin/client?<?PHP echo 'sort=societe&sens='.$sens ?>'>Société</a></TH><TH style="white-space:pre-wrap ; word-wrap:break-word;"><a href='/admin/client?<?PHP echo 'sort=name&sens='.$sens?>'>Name</a></TH><TH>Prénom</TH><TH>Téléphone</TH><TH>Actif</TH><TH>Edition</TH></TR>
                        </thead>
                        <tbody>
                        @foreach ($results as $result)
                        <TR>
                            <TD style="white-space:pre-wrap ; word-wrap:break-word;">{{ $result->societe}}</TD><TD style="white-space:pre-wrap ; word-wrap:break-word;">{{ $result->name }}</TD>
                            <TD style="white-space:pre-wrap ; word-wrap:break-word;">{{ $result->firstname }}</TD><TD style="white-space:pre-wrap ; word-wrap:break-word;">{{ $result->telephone }}</TD>
                            <TD style="white-space:pre-wrap ; word-wrap:break-word;">oui</TD><TD style="white-space:pre-wrap ; word-wrap:break-word;"><a href='/admin/client/edit/{{ $result->id }}' class="btn btn-info pull-left" style="margin-right: 3px;">Edit</a></TD></TR>
                        @endforeach
                        </tbody>
                </TABLE>
                </div>
            	<div align='right'><?php echo $results->appends(['sort' => $sort,'sens'=>$sens])->render(); ?></div>
				
				<BR>
				
			</div>
		</div>
@endsection