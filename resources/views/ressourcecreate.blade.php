@extends('app')
@section('content')

<style type="text/css">
.enjoy-css {
  -webkit-box-sizing: content-box;
  -moz-box-sizing: content-box;
  box-sizing: content-box;
  width: 160px;
  padding: 8px;
  overflow: hidden;
  border: none;
  font: normal 23px/1 "Times New Roman", Times, serif;
  color: rgba(255,255,255,1);
  text-align: center;
  -o-text-overflow: ellipsis;
  text-overflow: ellipsis;
  background: #365376;
  -webkit-box-shadow: 1px 1px 1px 0 rgba(0,0,0,0.3) ;
  box-shadow: 1px 1px 1px 0 rgba(0,0,0,0.3) ;
  text-shadow: 1px 1px 1px rgba(0,0,0,0.2) ;
}
a:link 
{ 
 text-decoration:none; 
}
.enjoy-css:hover {
  background: #FAA61A;
}
</style>


		<div class="container">
			<div class="content">
                <div class="title_apka">Assistant création d'une ressource :</div><BR><BR>
                @if (Session::has('message'))
                    <div class="alert alert-info">{{ Session::get('message') }}</div>
                @endif
                	<div align="right">
                		<a href="/home">Retour</A>
                	</div>	
                <div class="title_apka">Choix du domaine</div><BR><BR>
                <div class="tab-content ">
                    @foreach ($domaines as $domaine)
                        <a href="/ressource/assistant/?id=1&domaine_id={{ $domaine->id }}">  <font class="enjoy-css">{{ $domaine->name }}</font> </A>
                    @endforeach
                </div>
				
			</div>
		</div>
@endsection
