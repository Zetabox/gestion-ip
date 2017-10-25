@extends('app')
@section('content')

    <div class="container">
      <div class="content">
                <div class="title_apka">Liste des ressources :</div><BR><BR>
                <div class="navbar-form ">
                    <ul class="nav nav-pills">
                    @foreach ($domaines as $domaine)
                        <li role="presentation" @if ($domaine->id==$id) class="active" @endif><a href="/dashboard/list/{{ $domaine->id }}">{{ $domaine->name}}</A></li>
                    @endforeach
                    </ul>
                </div>
            <?PHP  if(isset($_GET['site'])){
                $selection=$_GET['site'];
                }elseif(isset($select)){ $selection=$select;}else $selection='default'; ?>
                <H3><span class="label label-danger">Ressource(s) en retard</span></H3>
             <div class="table-responsive">
                <table class="table table-hover" style="table-layout:fixed;">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Description</th>
                            <th>Edition</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($results_retard as $result)
                        @if ($result->site->client_id==Auth::user()->id_client)
                            <TR><TD>{{ $result->name}}</TD><TD>{{ $result->description }}</TD><TD><a href="/ressource/show/{{ $result->id }}" class="btn btn-info pull-left" style="margin-right: 3px;">Voir</a>&nbsp;@if ($result->site->client_id<>0 and $result->site->client_id==$client_id ) <a href="/ressource/edit/{{ $result->id }}" class="btn btn-warning pull-left" style="margin-right: 3px;">Editer</a>@endif</TD></TR>
                        @endif
                        @endforeach
                    </tbody>
                </TABLE>
            </div>
            <div align='right'><?php echo $results_retard->render(); ?></div>
            <H3><span class="label label-warning">Ressource(s) à 30 jours</span></H3>
             <div class="table-responsive">
                <table class="table table-hover" style="table-layout:fixed;">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Description</th>
                            <th>Edition</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($results_30 as $result)
                        @if ($result->site->client_id==Auth::user()->id_client)
                            <TR><TD>{{ $result->name}}</TD><TD>{{ $result->description }}</TD><TD><a href="/ressource/show/{{ $result->id }}" class="btn btn-info pull-left" style="margin-right: 3px;">Voir</a>&nbsp;@if ($result->site->client_id<>0 and $result->site->client_id==$client_id ) <a href="/ressource/edit/{{ $result->id }}" class="btn btn-warning pull-left" style="margin-right: 3px;">Editer</a>@endif</TD></TR>
                        @endif
                        @endforeach
                    </tbody>
                </TABLE>
            </div>
            <div align='right'><?php echo $results_30->render(); ?></div>
      </div>
    </div>
@endsection