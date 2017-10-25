@extends('app')

@section('content')
  <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["gauge","bar"]});
      
      google.setOnLoadCallback(drawChart);
      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Label', 'Value'],
          ['Conformité', {{ $taux_conformite }}],
        ]);

        var options = {
          width: 500, height: 220,
          redFrom: 0, redTo: 25,
          yellowFrom: 25, yellowTo: 75,
          greenFrom: 75, greenTo: 100,
          minorTicks: 5
        };

        var chart = new google.visualization.Gauge(document.getElementById('chart_div'));

        chart.draw(data, options);

        setInterval(function() {
          data.setValue(10);
          chart.draw(data, options);
        }, 13000);


      }

 
     // google.load("visualization", "1.1", {packages:["bar"]});

      google.setOnLoadCallback(drawChart1);
      function drawChart1() {
        var data1 = google.visualization.arrayToDataTable([
          ['Domaines', 'Total', 'Retard', '30 jours','link'],
          @foreach($domaines as $domaine)
            ['<?PHP echo str_replace('&eactue;','é',$domaine->name)?>', {{$nb_obligations[$domaine->id]}}, {{$nb_obligations_retard[$domaine->id]}}, {{$nb_obligations_30[$domaine->id] }},'/dashboard/list/{{$domaine->id}}/?site={{$selection}}'],
          @endforeach

          //['Véhicules', 1170, 460, 250,'/ressource/list/2'],
          //['Matériels', 660, 1120, 300,'/ressource/list/3'],
          //['RH', 1030, 540, 350,'/ressource/list/4'],
          //['v&eacute;hicule',1340,456,100,'/ressource/list/5']
        ]);
        var view = new google.visualization.DataView(data1);
        view.setColumns([0,1, 2,3]);

        var options1 = {
          chart: {
            title: 'Rapport de vos obligation',
            subtitle: ' ',
          },
          bars: 'horizontal' // Required for Material Bar Charts.
        };

        var chart1 = new google.charts.Bar(document.getElementById('barchart_material'));
		//chart1.draw(data1, google.charts.Bar.convertOptions(options1));
        chart1.draw(view, options1);
        google.visualization.events.addListener(chart1, 'select', function() {
          window.location = data1.getValue(chart1.getSelection()[0]['row'], 4 );
        });
        google.setOnLoadCallback(initialize);
      }
    </script>


<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-primary">
				<div class="panel-heading">Tableau de board</div>
            <div class="form-group">
                &nbsp;&nbsp;{!! Form::open(array('url' => '/','method'=>'GET')) !!}&nbsp;&nbsp;&nbsp;&nbsp;{!! Form::label('Site :') !!}{!! Form::select('site',array('0' => 'Tous') + $sites,$selection, array('required','class'=>'small',"onchange" => "this.form.submit();"))!!}{!! Form::close() !!}
            </div>
				<div class="panel-body">
          @if($retard<>0)
  					<div class="alert alert-danger alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Attention!</strong> Vous avez des obligations en retard.
            </div>
          @endif
					<?php //echo Entrust::hasRole('Admin') ?>
					  <div id="chart_div" style="width: 500px; height: 220px;" align="center"></div><BR>
					  <div id="barchart_material" style="width: 900px; height: 500px;"></div>


				</div>
			</div>
		</div>
	</div>
</div>
@endsection
