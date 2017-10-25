@extends('admin')
@section('content')
<script type="text/javascript">
        //<!--
                function change_onglet(name)
                {
                        document.getElementById('onglet_'+anc_onglet).className = 'onglet_0 onglet';
                        document.getElementById('onglet_'+name).className = 'onglet_1 onglet';
                        document.getElementById('contenu_onglet_'+anc_onglet).style.display = 'none';
                        document.getElementById('contenu_onglet_'+name).style.display = 'block';
                        anc_onglet = name;
                }
        //-->
        </script>
		<div class="container">
			<div class="content"> 
                <div class="title_apka">Edition du client :&nbsp&nbsp&nbsp <font color="#365376">{{ $results->societe}}</font></div><BR><BR>
        	       @foreach ($errors->all() as $error)
                        <p class="error">{{ $error }}</p>
                    @endforeach
                    <div class="form-group"></div><BR>

                
				<BR>
<div class="systeme_onglets">
        <div class="onglets">
            <span class="onglet_0 onglet" id="onglet_profile" onclick="javascript:change_onglet('profile');">Profile</span>
            <span class="onglet_0 onglet" id="onglet_compte" onclick="javascript:change_onglet('compte');">Compte</span>
            <span class="onglet_0 onglet" id="onglet_formule" onclick="javascript:change_onglet('formule');">Formule</span>
            <span class="onglet_0 onglet" id="onglet_contrats" onclick="javascript:change_onglet('contrats');">Contrats</span>
            <span class="onglet_0 onglet" id="onglet_statistiques" onclick="javascript:change_onglet('statistiques');">Statistiques</span>
        </div>
        <div class="contenu_onglets">
            <div class="contenu_onglet" id="contenu_onglet_profile">
                    {!! Form::open(array('url' => Request::url())) !!}
                    <input type="hidden" name="id" value="{{ $results->id}}"></TD></TR>
                    <div class="form-group">
                        {!! Form::label('Société') !!}
                        {!! Form::text('societe', $results->societe, 
                            array('required', 
                                  'class'=>'form-control', 
                                  'placeholder'=>'Société')) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('Nom') !!}
                        {!! Form::text('name', $results->name, 
                            array('required', 
                                  'class'=>'form-control', 
                                  'placeholder'=>'Nom')) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('Prénom') !!}
                        {!! Form::text('firstname', $results->firstname, 
                            array('required', 
                                  'class'=>'form-control', 
                                  'placeholder'=>'Prénom')) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('Adresse E-mail') !!}
                        {!! Form::text('email', $results->email, 
                            array('required', 
                                  'class'=>'form-control', 
                                  'placeholder'=>'Adresse e-mail')) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('Téléphone') !!}
                        {!! Form::text('telephone', $results->telephone, 
                            array('required', 
                                  'class'=>'form-control', 
                                  'placeholder'=>'Téléphone')) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('Description') !!}
                        {!! Form::textarea('remarque', $results->remarque, 
                            array('required', 
                                  'class'=>'form-control', 
                                  'placeholder'=>'Description')) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::submit('Enregistrer', 
                          array('class'=>'btn btn-primary')) !!}<a href="/admin/client/destroy/{{ $id }}" class="btn btn-danger pull-left" style="margin-right: 3px;" onclick="if(!confirm('Etes-vous sûr de vouloire supprimer ce client ?')){return false;};">Supprimer</a>
                    </div>
                    {!! Form::close() !!}
            </div>
            <div class="contenu_onglet" id="contenu_onglet_compte">
                <h1>Liste des comptes ({{ $nb_uti}}/{{ $results->nb_utilisateurs}})</h1>
                <div class="table-responsive">
                    <table class="table table-hover" style="table-layout:fixed;">
                        <thead>
                            <TR><th>Nom&nbsp;▾</TH><TH>Email</TH><TH>Edition</TH></TR>
                    </thead>
                    <tbody>
                @foreach ($utilisateurs as $utilisateur)
            
                    <TR class="tr_apka"><TD>{{ $utilisateur->name}}</TD><TD>{{ $utilisateur->email }}</TD><TD><a href="/admin/user/edit/{{ $utilisateur->id }}" class="btn btn-info pull-left" style="margin-right: 3px;">Edit</A></TD></TR>
                @endforeach
                </tbody>
                </TABLE>
            </div>

                {!! Form::open(array('url' => '/admin/client/createClient/'.$results->id)) !!}
                <input type="hidden" name="id_client" value="{{ $results->id}}"/>
                <div class="form-group">
                        {!! Form::label('Nom') !!}
                        {!! Form::text('name', null, 
                            array('required', 
                                  'class'=>'form-control', 
                                  'placeholder'=>'Nom')) !!}
                </div>
                <div class="form-group">
                        {!! Form::label('Email') !!}
                        {!! Form::text('email', null, 
                            array('required', 
                                  'class'=>'form-control', 
                                  'placeholder'=>'Email')) !!}
                </div><div class="form-group">
                        {!! Form::label('Mot de passe') !!}
                        {!! Form::text('password', null, 
                            array('required', 
                                  'class'=>'form-control', 
                                  'placeholder'=>'Mot de passe')) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('Rôles de l\'utilisateur') !!}<BR>
                    <select multiple="multiple" name="roles[]" id="roles">
                        @foreach($roles as $role)
                                <option value="{!! $role->id !!}">{!! $role->name !!}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                        {!! Form::submit('Enregistrer', 
                          array('class'=>'btn btn-primary')) !!}
                    </div>
                {!! Form::close() !!}
            </div>
            <div class="contenu_onglet" id="contenu_onglet_formule">
                {!! Form::open(array('url' => '/admin/client/updateFormule/'.$results->id)) !!}
                        <input type="hidden" name="id" value="{{ $results->id}}"></TD></TR>
                        <div class="form-group">
                        {!! Form::label('Nombre d\'obligations') !!}
                        {!! Form::text('nb_obligations', $results->nb_obligations, 
                            array('required', 
                                  'class'=>'form-control', 
                                  'placeholder'=>'Nombre d\'obligations')) !!}
                        </div>
                        <div class="form-group">
                        {!! Form::label('Nombre de sites') !!}
                        {!! Form::text('nb_sites', $results->nb_sites, 
                            array('required', 
                                  'class'=>'form-control', 
                                  'placeholder'=>'Nombre de sites')) !!}
                        </div>
                        <div class="form-group">
                        {!! Form::label('Nombre d\'utilisateurs') !!}
                        {!! Form::text('nb_utilisateurs', $results->nb_utilisateurs, 
                            array('required', 
                                  'class'=>'form-control', 
                                  'placeholder'=>'Nombre d\'utilisateurs')) !!}
                        </div>

                      
                     <div class="form-group">
                        {!! Form::submit('Enregistrer', 
                          array('class'=>'btn btn-primary')) !!}
                    </div>
                    {!! Form::close() !!}
            </div>
            <div class="contenu_onglet" id="contenu_onglet_contrats">
                <h1>Liste des contrats</h1>
                <div class="table-responsive">
                    <table class="table table-hover" style="table-layout:fixed;">
                        <thead>
                                <TR><th>Début</TH><th>Fin</th><th>Nb Obligations</TH><TH>Nb Sites</TH><TH>Nb Utilisateurs</TH></TR>
                        </thead>
                        <tbody>
                        @foreach ($contrats as $contrat)
                        <TR>
                            <TD>{{ date('d/m/Y',strtotime($contrat->begin_contract))}}</TD>
                            <TD>{{ date('d/m/Y',strtotime($contrat->end_contract)) }}</TD>
                            <TD align="center">{{ $contrat->nb_obligations }}</TD>
                            <TD align="center">{{ $contrat->nb_sites }}</TD>
                            <TD align="center">{{ $contrat->nb_utilisateurs }}</TD>
                        <TR>
                        @endforeach
                        {!! Form::open(array('url' => '/admin/client/addcontrat')) !!}
                        <input type="hidden" name="client_id" value="{{ $results->id}}">
                        <TR>
                            <!-- <TD bgcolor="#FFFFFF"><input type="text" name="begin_contrat"></TD> -->
                            <TD bgcolor="#FFFFFF">{!! Form::text('begin_contract',null,array('required')) !!}</TD>
                            <TD bgcolor="#FFFFFF">{!! Form::text('end_contract',null,array('required')) !!}</TD>
                            <TD bgcolor="#FFFFFF">{!! Form::text('nb_obligations',null,array('required')) !!}</TD>
                            <TD bgcolor="#FFFFFF">{!! Form::text('nb_sites',null,array('required')) !!}</TD>
                            <TD bgcolor="#FFFFFF">{!! Form::text('nb_utilisateurs',null,array('required')) !!}</TD>
                        </TR>
                        
                        <tbody>
                    </table>
                    <div class="form-group">
                        {!! Form::submit('Enregistrer', 
                          array('class'=>'btn btn-primary')) !!}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
            <div class="contenu_onglet" id="contenu_onglet_statistiques">
                <h1>Stats d'utilisation</h1>
                <div>Nombre d'obligations : {{ $nb_obligations_clients }}<BR></div>
                <div>Liste des sites (Total : {{ $sites->count() }})</div>
                <div class="table-responsive">
                    <table class="table table-hover" style="table-layout:fixed;">
                        <thead>
                                <TR><th>Nom</TH><th>Ressource</th></TR>
                        </thead>
                        <tbody>
                        @foreach ($sites as $site)
                        <TR>
                            <TD>{{ $site->name}}</TD>
                            <TD>{{ $site->ressource->count()}}</TD>
                        <TR>
                        @endforeach
                        <tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        //<!--
                var anc_onglet = '{{ $onglet}}';
                change_onglet(anc_onglet);
        //-->
        </script>

			</div>
		</div>
@endsection