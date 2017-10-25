@extends('admin')
@section('content')


        <div class="container">
            <div class="content">
                <!-- Titla_Obligation (Shape) -->
                <div class="title_apka">Edition d'une obligation<BR><BR>
                </div>
                

            
                    @foreach ($errors->all() as $error)
                        <p class="error">{{ $error }}</p>
                    @endforeach

                    {!! Form::open(array('url' => '/admin/obligation/update')) !!}
                        <input type="hidden" name="id" value="{{ $results->id }}" />
                        <input type="hidden" name="domaine_id" value="{{ $results->domaine_id }}" />
                        <div class="form-group">
                            {!! Form::label('Domaine') !!}
                            {!! Form::text('name', $domaine->name, 
                                array('readonly', 
                                      'class'=>'form-control', 
                                      'placeholder'=>'Domaine')) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('Nom') !!}
                            {!! Form::text('name', $results->name, 
                                array('required', 
                                      'class'=>'form-control', 
                                      'placeholder'=>'Nom')) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('Catégorie') !!}
                            {!! Form::select('categorie', $categories, $results->categorie_id,array('required', 
                                  'class'=>'form-control')) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('Source') !!}
                            {!! Form::text('source', $results->source, 
                                array('required', 
                                      'class'=>'form-control', 
                                      'placeholder'=>'Source')) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('Texte de référence') !!}
                            {!! Form::text('txtref', $results->txtref, 
                                array('required', 
                                      'class'=>'form-control', 
                                      'placeholder'=>'Texte de référence')) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('Date de mise en applcation') !!}
                            {!! Form::text('dma', $results->dma, 
                                array('required', 
                                      'class'=>'form-control', 
                                      'placeholder'=>'Date de mise en application')) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('Description') !!}
                            {!! Form::textarea('description', $results->description, 
                                array('required', 
                                      'class'=>'form-control', 
                                      'placeholder'=>'Description')) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('Texte de loi') !!}
                            {!! Form::textarea('law', $results->law, 
                                array('required', 
                                      'class'=>'form-control', 
                                      'placeholder'=>'Texte de loi')) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('Commentaires') !!}
                            {!! Form::textarea('comment', $results->comment, 
                                array('', 
                                      'class'=>'form-control', 
                                      'placeholder'=>'Commentaire')) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('Actif') !!}
                            {!! Form::checkbox('actif', 1, $results->actif) !!}
                        </div>
                        <div class="form-group">
                        {!! Form::submit('Enregistrer', 
                          array('class'=>'btn btn-primary')) !!} @if($suppObligation=='ok') <a href="/admin/obligation/destroy/{{ $results->id }}" class="btn btn-danger pull-left" style="margin-right: 3px;" onclick="if(!confirm('Etes-vous sûr de vouloire supprimer cette obligation ?')){return false;};">Supprimer</a> @endif ou <a href="/admin/obligation/list/{{ $results->domaine_id }}">Retour</a>
                         
                          
                        </div>
                       
                    {!! Form::close() !!}


                <BR>
                <div class="table-responsive">
                    <table class="table table-hover" style="table-layout:fixed;" >
                        <thead><tr><th>Fréquence</th><th>Type</th><th>texte</th><th>texte</th><th>Edition</th></thead>
                        <tbody>
                            @foreach ($obligationdetails as $obligationdetail)
                            <TR><TD>{{ $obligationdetail->frequence}}</TD><TD>{{ $obligationdetail->frequence_type}}</TD><TD>{{ $obligationdetail->txt_1}}</TD><TD>{{ $obligationdetail->txt_2}}</TD><TD> @if($detailSupp[$obligationdetail->id]=='ok') <a href='/admin/obligationdetail/destroy/{{ $obligationdetail->id }}' class="btn btn-danger pull-left" style="margin-right: 3px;">Supprimer</a> @endif</TD></TR>
                            @endforeach
                            <TR><TD bgcolor="#FFFFFF">
                                <form method="post" action="/admin/obligation/adddetail" name="obligationForm"><input type="hidden" name="_token" value="{{{ csrf_token() }}}" /><input type="hidden" name="obligation_id" value="{{ $results->id}}">
                                    <input name="frequence" value="0"></TD><TD bgcolor="#FFFFFF"><select name="frequence_type"><option value="ans" selected>ans</option> <option value="mois">mois</option><option value="jours">jours</option></select></TD><TD bgcolor="#FFFFFF"><input name="txt_1"></TD><TD bgcolor="#FFFFFF"><input name="txt_2">
                                </form>
                                </TD><TD bgcolor="#FFFFFF"><a href="javascript:document.obligationForm.submit();" class="btn btn-info pull-left" style="margin-right: 3px;">Ajouter</a></TD></TR>
                        </tbody>
                    </TABLE>
                </div>
                
            </div>
        </div>
@endsection
