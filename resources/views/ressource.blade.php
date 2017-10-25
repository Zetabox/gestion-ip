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
                <div class="title_apka">Ressources</div><BR><BR>
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
                    <TR><th><a href='?<?PHP echo 'sort=name&sens='.$sens     ?>'>Nom&nbsp;▾</a></TH><TH><a href='?<?PHP echo 'sort=comment&sens='.$sens     ?>'>Commentaire</a></TH></TR>
                @foreach ($results as $result)
            
                    <TR class="tr_apka"><TD>{{ $result->name}}</TD><TD>{{ $result->comment }}</TD></TR>
                @endforeach
                </TABLE>
            <div align='right'><?php echo $results->appends(['sort' => $sort,'sens'=>$sens])->render(); ?></div>
            </div>
            <div class="contenu_onglet" id="contenu_onglet_vehicule">
                <h1>Qui?</h1>
                C'est un script r&eacute;alis&eacute; par Ybouane,<br />
                Webmaster du site <a href="http://www.supportduweb.com/">http://www.supportduweb.com/</a>
            </div>
            <div class="contenu_onglet" id="contenu_onglet_materiel">
                <h1>Pourquoi?</h1>
                Pour simplifier la navigation et la diviser en parties
            </div>
            <div class="contenu_onglet" id="contenu_onglet_rh">
                <h1>Pourquoi?</h1>
                Pour simplifier la navigation et la diviser en parties
            </div>
            <div class="contenu_onglet" id="contenu_onglet_fiscal">
                <h1>Pourquoi?</h1>
                Pour simplifier la navigation et la diviser en parties
            </div>
        </div>
    </div>
    <script type="text/javascript">
        //<!--
                var anc_onglet = 'batiment';
                change_onglet(anc_onglet);
        //-->
        </script>
				
				<BR>
				
			</div>
		</div>
@endsection
