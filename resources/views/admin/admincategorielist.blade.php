@extends('admin')
@section('content')

		<div class="container">
			<div class="content">
                <div class="title_apka">Liste des catégories par domaine</div><BR><BR>
                 <div class="navbar-form ">
                    <ul class="nav nav-pills">
                        @foreach ($domaines as $domaine)
                        <li role="presentation" @if ($domaine->id==$id) class="active" @endif><a href="/admin/categorie/list/{{ $domaine->id }}">{{ $domaine->name}}</A></li>
                         @endforeach
                    </ul>

                </div>

        		
				<BR>
				<BR><BR>
                <div class="table-responsive">
                    <table class="table table-hover" style="table-layout:fixed;" >
                        <thead>
                            <TR><th>Nom&nbsp;▾</a></TH><TH>Edition</a></TH></TR>
                        </thead>
                        <tbody>
                            @foreach ($categories as $categorie)
                            <TR class="tr_apka"><TD>{{ $categorie->name}}</TD><TD><a href='/admin/categorie/edit/{{ $categorie->id }}' class="btn btn-warning pull-left" style="margin-right: 3px;">Edit</a></TD></TR>
                            @endforeach
                        </tbody>
                    </TABLE>
                </div>
                <div align='right'><?php echo $categories->render(); ?></div>
                {!! Form::open(array('url' => '/admin/categorie/store')) !!}
                <input type="hidden" name="id" value="{{ $id }}"/>
                <div class="form-group">
                        {!! Form::label('Nom') !!}
                        {!! Form::text('name', null, 
                            array('required', 
                                  'class'=>'form-control', 
                                  'placeholder'=>'Nom')) !!}
                </div>
                <div class="form-group">
                        {!! Form::submit('Nouvelle catégorie', 
                          array('class'=>'btn btn-primary')) !!}
                    </div>
                {!! Form::close() !!}
			</div>
		</div>
@endsection