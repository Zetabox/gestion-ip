@extends('app')
@section('content')

    <div class="container">
        <div class="content">
            <div>
                <font class="title_apka">Edition de la ressource : </font><font class="title_apka1">{{ $ressource->name }}</font>
            </div>
            <BR><BR>
            <div align="right">
                <a href="/intervention/create/{{ $ressource->id}}" class="btn btn-warning pull-left" style="margin-right: 3px;">Nouvelle intervention</a>&nbsp;<a href="/ressource/list/{{ $ressource->domaine_id }}">Retour</a>
            </div>
            <BR>
                        @if(Session::has('message'))
                            <div class="alert-box success">
                                <h4>{{ Session::get('message') }}</h4>
                            </div>
                        @endif
                        @foreach ($errors->all() as $error)
                            <p class="error">{{ $error }}</p>
                        @endforeach

            <div class="table-responsive">
                {!! Form::open(array('url' => '/ressource/update')) !!}<input type="hidden" name="id" value="{{ $ressource->id }}">
                <table class="table table-bordered table-condensed table-body-center" >
                    <thead><TR><TD class="bgapkaTop" colspan="2">Détail</TD></thead>         
                    <tbody>
                        <TR><TD class="bgapka" cellpadding="20" width="25%" >{!! Form::label('Nom') !!}</TD><TD bgcolor="#FFFFFF">{!! Form::text('name', $ressource->name,  array('required', 'class'=>'form-control',  'placeholder'=>'Nom')) !!}</TD></TR>
                        <TR><TD class="bgapka" >{!! Form::label('Site') !!}</TD><TD bgcolor="#FFFFFF">{!! Form::select('site_id', $sites,$ressource->site_id, array('required','class'=>'small'))!!}</TD></TR>
                        <TR><TD class="bgapka" >{!! Form::label('Domaine') !!}</TD><TD bgcolor="#FFFFFF">{{ $domaine->name}}</TD></TR>
                        <TR><TD class="bgapka" >{!! Form::label('Catégorie') !!}</TD><TD bgcolor="#FFFFFF">{{ $categorie->name }}</TD></TR>
                        <TR><TD class="bgapka" >{!! Form::label('Date de mise en service') !!}</TD><TD bgcolor="#FFFFFF">{!! Form::text('date_service', date("d/m/Y",strtotime($ressource->date_service)),  array('required', 'class'=>'form-control',  'placeholder'=>'Date de Service')) !!}</TD></TR>
                        <TR><TD class="bgapka" >{!! Form::label('Référence') !!}</TD><TD bgcolor="#FFFFFF">{!! Form::text('reference', $ressource->reference,  array('required', 'class'=>'form-control',  'placeholder'=>'Référence')) !!}</TD></TR>
                        <TR><TD class="bgapka" >{!! Form::label('Commentaire') !!}</TD><TD bgcolor="#FFFFFF">{!! Form::text('comment', $ressource->comment,  array(null, 'class'=>'form-control',  'placeholder'=>'Commentaire')) !!}</TD></TR>
                        <TR><TD class="bgapka" >{!! Form::label('Actif') !!}</TD><TD bgcolor="#FFFFFF">{!! Form::checkbox('actif', 1, $ressource->actif) !!}</TD></TR>
                    </tbody>
                </TABLE>
                <div class="form-group">
                            {!! Form::submit('Enregistrer', 
                              array('class'=>'btn btn-primary')) !!}{!! Form::close() !!}<a href="/ressource/destroy/{{ $ressource->id }}" class="btn btn-danger pull-left" style="margin-right: 3px;" onclick="if(!confirm('Etes-vous sûr de vouloire supprimer cette ressource ?')){return false;};">Supprimer</a>
                </div>
            </div>
            <div align="right"><a href="/ressource/addobligation/{{ $ressource->id}}" class="btn btn-warning pull-left" style="margin-right: 3px;">Nouvelle obligation</a>&nbsp;<a href="/ressource/list/{{ $ressource->domaine_id }}">Retour</a></div><BR>
            <div class="panel panel-default" id="pan1">
                <div class="panel-heading">
                    <h3 class="panel-title">Liste des obligations</h3>
                </div>
                
                    <div class="table-responsive">
                        <table class="table table-hover" style="table-layout:fixed;">
                            <thead>
                                <tr>
                                    <th style="white-space:pre-wrap ; word-wrap:break-word;">Obligation</th>
                                    <th style="white-space:pre-wrap ; word-wrap:break-word;">Fréquence</th>
                                    <th style="white-space:pre-wrap ; word-wrap:break-word;">Intervention</th>
                                    <th style="white-space:pre-wrap ; word-wrap:break-word;">Echéance</th>
                                    <th style="white-space:pre-wrap ; word-wrap:break-word;">Etat</th>
                                    <th style="white-space:pre-wrap ; word-wrap:break-word;">Créer</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!empty($echeance))
                                    @foreach ($echeance as $detail_e)
                                        <TR>
                                            @foreach ($detail_e as $detail)
                                                <TD style="white-space:pre-wrap ; word-wrap:break-word;">@if ($detail=='Retard') <font color='red'>{{ $detail }}</font>@elseif ($detail=='Ok') <font color='green'>{{ $detail }}</font>@elseif ($detail=='30') <font color='orange'>{{ $detail }}</font> @elseif(($detail_e['interventioncreer']!=$detail)==1) {{ $detail }} @endif @if(($detail_e['interventioncreer']!=$detail)!=1)  <a href='/intervention/createUnique/{{$ressource->id}}?obligation_detail_id={{$detail}}' class="btn btn-warning pull-left" style="margin-right: 3px;">Creer</A>@endif</TD>
                                            @endforeach
                                        </TR>
                                    @endforeach
                                @endif
                            </tbody>
                        <table>
                    </div>
            </div><BR>
            <div class="panel panel-default" id="pan2">
                <div class="panel-heading">
                    <h3 class="panel-title">Liste des interventions</h3>
                </div>
                    <div class="table-responsive">
                        <table class="table table-hover" style="table-layout:fixed;">
                            <thead>
                                <tr>
                                    <th style="white-space:pre-wrap ; word-wrap:break-word;">Date</th>
                                    <th style="white-space:pre-wrap ; word-wrap:break-word;">Obligation</th>
                                    <th style="white-space:pre-wrap ; word-wrap:break-word;">Commentaire</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($interventions as $intervention)
                                    <TR>
                                        <TD style="white-space:pre-wrap ; word-wrap:break-word;">{{ date('d-m-Y',strtotime($intervention->date_intervention)) }}</TD><TD>{{ $intervention->obligation_detail->txt_1 }}</TD><TD>{{ $intervention->comment }} </TD>
                                    </TR>
                                @endforeach
                            </tbody>
                        <table>
                    </div>

            </div><BR>
            <div class="panel panel-default" id="pan3">
                <div class="panel-heading">
                    <h3 class="panel-title">Liste des documents</h3>
                </div>
                    <div class="table-responsive">
                        <table class="table table-hover" style="table-layout:fixed;">
                            <thead>
                                <tr>
                                    <th style="white-space:pre-wrap ; word-wrap:break-word;">Nom</th>
                                    <th style="white-space:pre-wrap ; word-wrap:break-word;">Description</th>
                                    <th style="white-space:pre-wrap ; word-wrap:break-word;">Téléchargement</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($geds as $ged)
                                    <TR>
                                        <TD style="white-space:pre-wrap ; word-wrap:break-word;">{{ $ged->name}}</TD><TD>{{ $ged->description }}</TD><TD><a href="/ged/show/{{ $ged->filename }}">{{ $ged->original_filename }}</a> </TD><TD><a href="/ged/destroy/{{ $ged->id }}" class="btn btn-danger pull-left" style="margin-right: 3px;" onclick="if(!confirm('Etes-vous sûr de vouloire supprimer ce document ?')){return false;};">X</a></TD
                                    </TR>
                                @endforeach
                            </tbody>
                        <table>
                    </div>

            </div><BR>
            <div align="right">
                <a href="/ged/create/{{ $ressource->id}}" class="btn btn-warning pull-left" style="margin-right: 3px;">Nouveau document</a>
            </div><BR>


        </diV>
    </div>
@endsection