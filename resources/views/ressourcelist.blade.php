@extends('app')
@section('content')

    <div class="container">
      <div class="content">
                <div class="title_apka">Liste des ressources par domaine</div><BR><BR>
                <div class="navbar-form ">
                    <ul class="nav nav-pills">
                    @foreach ($domaines as $domaine)
                        <li role="presentation" @if ($domaine->id==$id) class="active" @endif><a href="/ressource/list/{{ $domaine->id }}">{{ $domaine->name}}</A></li>
                    @endforeach
                    </ul>
                </div>
            <?PHP  if(isset($_GET['site'])){
                $selection=$_GET['site'];
                }elseif(isset($select)){ $selection=$select;}else $selection='default'; ?>
        <div class="form-group">
            @if (Entrust::hasRole('Admin') || Entrust::hasRole('Admin Ressources'))<a href="/ressource/assistant/?id=1&domaine_id={{ $id }}" class="btn btn-warning pull-left" style="margin-right: 3px;">Nouvelle ressource</a>@endif
            <div class="padding">
                {!! Form::open(['action' => 'RessourceController@search', 'method' => 'POST']) !!} <input type="HIDDEN" name="domaine_id" value="{{$id}}">
                    <div class="form-row" align="right">
                        {!! Form::text('query', null, 
                            array('required','placeholder'=>'Votre recherche')) !!}<input type="hidden" name="site" value="{{ isset($_GET['site']) ? $_GET['site'] : '0' }}"> {!! Form::button('Ok', ['type' => 'submit', 'class' => 'button']) !!}
                    </div>
                    <div class="form-row">
                   
                    </div>
                {!! Form::close() !!}
                    </div>
        </div>
            <div class="form-group">
                {!! Form::open(array('url' => '/ressource/list/'.$id,'method'=>'GET')) !!}{!! Form::label('Site :') !!}{!! Form::select('site',array('default' => 'Tous') + $sites,$selection, array('required','class'=>'small',"onchange" => "this.form.submit();"))!!}{!! Form::close() !!}
            </div>
        
             <div class="table-responsive">
                <table class="table table-hover" style="table-layout:fixed;">
                    <thead>
                        <tr>
                            <th><a href='?<?PHP echo 'sort=name&sens='.$sens     ?>'>Nom&nbsp;▾</a></th>
                            <th>Description</th>
                            <th>Edition</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($results as $result)
                        @if ($result->site->client_id==Auth::user()->id_client)
                            <TR><TD>{{ $result->name}}</TD><TD>{{ $result->description }}</TD><TD><a href="/ressource/show/{{ $result->id }}" class="btn btn-info pull-left" style="margin-right: 3px;">Voir</a>&nbsp;@if (Entrust::hasRole('Admin') || Entrust::hasRole('Admin Ressources')) @if ($result->site->client_id<>0 and $result->site->client_id==$client_id ) <a href="/ressource/edit/{{ $result->id }}" class="btn btn-warning pull-left" style="margin-right: 3px;">Editer</a>@endif @endif</TD></TR>
                        @endif
                        @endforeach
                    </tbody>
                </TABLE>
            </div>
            <div align='right'><?php echo $results->appends(['sort' => $sort,'sens'=>$sens])->render(); ?></div>
      </div>
    </div>
@endsection