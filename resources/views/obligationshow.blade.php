@extends('app')
@section('content')


        <div class="container">
            <div class="content">
                <!-- Titla_Obligation (Shape) -->
                <div class="title_apka">Consultation d'une obligation<BR><BR>
                </div>

                
                    @foreach ($errors->all() as $error)
                        <p class="error">{{ $error }}</p>
                    @endforeach

                    <div align="right"</div><a href="/obligation/list/{{ $results->domaine_id }}">Retour</a></div><BR>
                    
                    <div class="table-responsive">
                        <table class="table table-bordered table-condensed table-body-center" >
                        <thead><TR><TD class="bgapkaTop" colspan="2">Détail</TD></thead>
                        <tbody>
                        <TR><TD class="bgapka" cellpadding="20" width="30%" ><label>Domaine</label></TD><TD bgcolor="#FFFFFF">
                                @foreach ($domaines as $domaine)
                                    @if ($results->domaine_id==$domaine->id) {{ $domaine->name}} @endif
                                @endforeach
                        </TD></TR>
                        <TR><TD class="bgapka" ><label>Nom</label></TD><TD bgcolor="#FFFFFF">{{ $results->name}}</TD></TR>
                         <TR><TD class="bgapka" ><label>Catégorie</label></TD><TD bgcolor="#FFFFFF">
                                @foreach ($categories as $categorie)
                                    @if ($results->categorie_id==$categorie->id) {{ $categorie->name}} @endif
                                @endforeach
                        </TD></TR>
                        <TR><TD class="bgapka" ><label>Source</label></TD><TD bgcolor="#FFFFFF">{{ $results->source}}</TD></TR>
                        <TR><TD class="bgapka" ><label>Texte de référence</label></TD><TD bgcolor="#FFFFFF">{{ $results->txtref}}</TD></TR>
                        <TR><TD class="bgapka" ><label>Date de mise en application</label></TD><TD bgcolor="#FFFFFF">{{ $results->dma}}</TD></TR>
                        <TR><TD class="bgapka" ><label>Description</label></TD><TD bgcolor="#FFFFFF">{{ $results->description}}</TD></TR>
                        <TR><TD class="bgapka" ><label>Texte de loi</label></TD><TD bgcolor="#FFFFFF">{{ $results->txtloi}}</TD></TR>
                        <TR><TD class="bgapka" ><label>Commentaires</label></TD><TD bgcolor="#FFFFFF">{{ $results->comment}}</TD></TR>
                        <TR><TD class="bgapka" ><label>Actif</label></TD><TD bgcolor="#FFFFFF">@if ($results->actif==1) oui @endif</TD></TR>
                    
                       
                        </tbody>
                       </TABLE>
                   </div>
                    
              
                
                
                    <div class="table-responsive">
                    <table class="table table-hover" style="table-layout:fixed;" >
                        <thead><tr><th>Fréquence</th><th>Type</th><th>texte</th><th>texte</th></th></thead>
                        <tbody>
                            @foreach ($obligationdetails as $obligationdetail)
                            <TR><TD>{{ $obligationdetail->frequence}}</TD><TD>{{ $obligationdetail->frequence_type}}</TD><TD>{{ $obligationdetail->txt_1}}</TD><TD>{{ $obligationdetail->txt_2}}</TD></TR>
                            @endforeach
                        </tbody>
                        </TABLE>
                    </div>
              
            </div>
        </div>
@endsection
