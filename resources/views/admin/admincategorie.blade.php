@extends('admin')
@section('content')

		<div class="container">
			<div class="content">
                <div class="title_apka">Liste des catégories par domaine</div><BR><BR>
                <div class="navbar-form ">
                    @foreach ($domaines as $domaine)
                        <a href="/admin/categorie/{{ $domaine->id }}">{{ $domaine->name}}</A>&nbsp;
                    @endforeach
                </div>
        		
				<BR>
				
			</div>
		</div>
@endsection