@extends('app')
@section('content')
<style type="text/css">


</style>
    <div class="container">
      <div class="content">
        <div><font class="title_apka">Ressource : </font><font class="title_apka1">{{ $ressource->name }}</font></div><BR><BR>
        <div align="right"><a href="/intervention/create/{{ $ressource->id}}" class="btn btn-warning pull-left" style="margin-right: 3px;">Nouvelle intervention</a>&nbsp;<a href="/ressource/list/{{ $ressource->domaine_id }}">Retour</a></div>
        <BR>

        <div class="table-responsive">
            <table class="table table-bordered table-condensed table-body-center" >
                <thead><TR><TD class="bgapkaTop" colspan="2">Détail</TD></thead>         
                <tbody>
                    <TR><TD class="bgapka" cellpadding="20" width="30%" ><label>Nom</label></TD><TD bgcolor="#FFFFFF">{{ $ressource->name }}</TD></TR>
                    <TR><TD class="bgapka" ><label>Domaine</label></TD><TD bgcolor="#FFFFFF">{{ $domaine->name}}</TD></TR>
                    <TR><TD class="bgapka" ><label>Catégorie</label></TD><TD bgcolor="#FFFFFF">{{ $categorie->name }}</TD></TR>
                    <TR><TD class="bgapka" ><label>Date de mise en service</label></TD><TD bgcolor="#FFFFFF">{{ date("d/m/Y",strtotime($ressource->date_service)) }}</TD></TR>
                    <TR><TD class="bgapka" ><label>Référence</label></TD><TD bgcolor="#FFFFFF">{{ $ressource->reference}}</TD></TR>
                    <TR><TD class="bgapka" ><label>Commentaires</label></TD><TD bgcolor="#FFFFFF">{{ $ressource->comment}}</TD></TR>
                    <TR><TD class="bgapka" ><label>Actif</label></TD><TD bgcolor="#FFFFFF">@if ($ressource->actif==1) oui @endif</TD></TR>
                </tbody>
            </TABLE>
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
                        </tr>
                    </thead>
                    <tbody>
                        @if(!empty($echeance))
                         @foreach ($echeance as $detail_e)
                            <TR>
                                @foreach ($detail_e as $detail)
                                    <TD style="white-space:pre-wrap ; word-wrap:break-word;">@if ($detail=='Retard') <font color='red'>{{ $detail }}</font>@elseif ($detail=='Ok') <font color='green'>{{ $detail }}</font>@elseif($detail=='30') <font color='orange'>{{ $detail }} </font>@else {{ $detail }} @endif</TD>
                                @endforeach
                            </TR>
                        @endforeach
                        @endif
                    </tbody>
                <table>
            </div>
      </div>
    </div>
@endsection