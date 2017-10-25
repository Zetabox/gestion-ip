@extends('app')
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
                <div class="title_apka">Obligations</div><BR><BR>
        <div class="systeme_onglets">
        <div class="onglets">
            <span class="onglet_0 onglet" id="onglet_batiment" onclick="javascript:change_onglet('batiment');">Bâtiment</span>
            <span class="onglet_0 onglet" id="onglet_vehicule" onclick="javascript:change_onglet('vehicule');">Véhicule</span>
            <span class="onglet_0 onglet" id="onglet_materiel" onclick="javascript:change_onglet('materiel');">Matériel</span>
            <span class="onglet_0 onglet" id="onglet_rh" onclick="javascript:change_onglet('rh');">RH</span>
            <span class="onglet_0 onglet" id="onglet_fiscal" onclick="javascript:change_onglet('fiscal');">Fiscal</span>
        </div>
        <div class="contenu_onglets">
            <div class="contenu_onglet" id="contenu_onglet_batiment">
                <BR><BR>
               <TABLE border='1' class="table">
                    <TR><th><a href='?<?PHP echo 'onglet=batiment&sort=name&sens='.$sens     ?>'>Nom&nbsp;▾</a></TH><TH>Description</TH><TH>Edition</TH></TR>
                @foreach ($batiments as $batiment)
            
                    <TR class="tr_apka"><TD>{{ $batiment->name}}</TD><TD>{{ $batiment->description }}</TD><TD><a href='/obligation/show/{{ $batiment->id }}'>Show</a>&nbsp;@if ($batiment->client_id<>0) <a href='/obligation/{{ $batiment->id }}'>Edit</a>@endif</TD></TR>
                @endforeach
                </TABLE>
            <div align='right'><?php echo $batiments->appends(['sort' => $sort,'sens'=>$sens,'onglet'=>'batiment'])->render(); ?></div>
            </div>
            <div class="contenu_onglet" id="contenu_onglet_vehicule">
                 <BR><BR>
               <TABLE border='1' class="table">
                    <TR><th><a href='?<?PHP echo 'onglet=vehicule&sort=name&sens='.$sens     ?>'>Nom&nbsp;▾</a></TH><TH>Description</TH><TH>Edition</TH></TR>
                @foreach ($vehicules as $vehicule)
            
                    <TR class="tr_apka"><TD>{{ $vehicule->name}}</TD><TD>{{ $vehicule->description }}</TD><TD><a href='/obligation/show/{{ $batiment->id }}'>Show</a>&nbsp;@if ($vehicule->client_id<>0) <a href='/obligation/{{ $vehicule->id }}'>Edit</a>@endif</TD></TR>
                @endforeach
                </TABLE>
            <div align='right'><?php echo $vehicules->appends(['sort' => $sort,'sens'=>$sens,'onglet'=> 'vehicule'])->render(); ?></div>
            </div>
            <div class="contenu_onglet" id="contenu_onglet_materiel">
                <BR><BR>
               <TABLE border='1' class="table">
                    <TR><th><a href='?<?PHP echo 'onglet=materiel&sort=name&sens='.$sens     ?>'>Nom&nbsp;▾</a></TH><TH>Description</TH><TH>Edition</TH></TR>
                @foreach ($materiels as $materiel)
            
                    <TR class="tr_apka"><TD>{{ $materiel->name}}</TD><TD>{{ $materiel->description }}</TD><TD><a href='/obligation/show/{{ $batiment->id }}'>Show</a>&nbsp;@if ($materiel->client_id<>0) <a href='/obligation/{{ $materiel->id }}'>Edit</a>@endif</TD></TR>
                @endforeach
                </TABLE>
            <div align='right'><?php echo $materiels->appends(['sort' => $sort,'sens'=>$sens,'onglet'=> 'materiel'])->render(); ?></div>
            </div>
            <div class="contenu_onglet" id="contenu_onglet_rh">
                <BR><BR>
               <TABLE border='1' class="table">
                    <TR><th><a href='?<?PHP echo 'onglet=rh&sort=name&sens='.$sens     ?>'>Nom&nbsp;▾</a></TH><TH>Description</TH><TH>Edition</TH></TR>
                @foreach ($rhs as $rh)
            
                    <TR class="tr_apka"><TD>{{ $rh->name}}</TD><TD>{{ $rh->description }}</TD><TD><a href='/obligation/show/{{ $batiment->id }}'>Show</a>&nbsp;@if ($rh->client_id<>0) <a href='/obligation/{{ $rh->id }}'>Edit</a>@endif</TD></TR>
                @endforeach
                </TABLE>
            <div align='right'><?php echo $rhs->appends(['sort' => $sort,'sens'=>$sens,'onglet'=> 'rh'])->render(); ?></div>
            </div>
            <div class="contenu_onglet" id="contenu_onglet_fiscal">
                <BR><BR>
               <TABLE border='1' class="table">
                    <TR><th><a href='?<?PHP echo 'onglet=fiscal&sort=name&sens='.$sens     ?>'>Nom&nbsp;▾</a></TH><TH>Description</TH><TH>Edition</TH></TR>
                @foreach ($fiscals as $fiscal)
            
                    <TR class="tr_apka"><TD>{{ $fiscal->name}}</TD><TD>{{ $fiscal->description }}</TD><TD><a href='/obligation/show/{{ $batiment->id }}'>Show</a>&nbsp;@if ($fiscal->client_id<>0) <a href='/obligation/{{ $fiscal->id }}'>Edit</a>@endif</TD></TR>
                @endforeach
                </TABLE>
            <div align='right'><?php echo $fiscals->appends(['sort' => $sort,'sens'=>$sens,'onglet'=> 'fiscal'])->render(); ?></div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        //<!--
                var anc_onglet = '{{ $onglet}}';
                change_onglet(anc_onglet);
        //-->
        </script>
				
				<BR>
				
			</div>
		</div>
@endsection
