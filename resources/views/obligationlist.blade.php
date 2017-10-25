@extends('app')
@section('content')

		<div class="container">
			<div class="content">
                <div class="title_apka">Liste des obligations par domaine</div><BR><BR>
                <div class="navbar-form ">
                    <ul class="nav nav-pills">
                        @foreach ($domaines as $domaine)
                        <li role="presentation" @if ($domaine->id==$id) class="active" @endif><a href="/obligation/list/{{ $domaine->id }}">{{ $domaine->name}}</A></li>
                         @endforeach
                    </ul>

                </div>
        		
				<BR>@if (Entrust::hasRole('Admin') || Entrust::hasRole('Admin Obligations'))<a href="/obligation/create/{{ $id }}" class="btn btn-warning pull-left" style="margin-right: 3px;">Nouvelle obligation</a>@endif
                    <div class="padding">
                {!! Form::open(['action' => 'ObligationController@search', 'method' => 'POST']) !!} <input type="HIDDEN" name="domaine_id" value="{{$id}}">
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
                    <table class="table table-hover" style="table-layout:fixed;" >
                        <thead><TR><th><a href='?<?PHP echo 'sort=name&sens='.$sens     ?>'>Nom&nbsp;▾</a></TH><TH>Description</TH><TH>Edition</TH></TR></thead>
                        @foreach ($results as $result)
                            <TR><TD>{{ $result->name}}</TD><TD>{{ $result->description }}</TD><TD><a href='/obligation/show/{{ $result->id }}' class="btn btn-info pull-left" style="margin-right: 3px;">Voir</a>&nbsp;@if (Entrust::hasRole('Admin') || Entrust::hasRole('Admin Obligations')) @if ($result->client_id<>0 and $result->client_id==$client_id ) <a href='/obligation/edit/{{ $result->id }}' class="btn btn-warning pull-left" style="margin-right: 3px;">Editer</a>@endif @endif</TD></TR>
                        @endforeach
                    </TABLE>
                </div>
            <div align='right'><?php echo $results->appends(['sort' => $sort,'sens'=>$sens])->render(); ?></div>
			</div>
		</div>
@endsection