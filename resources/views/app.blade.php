<html>
	
	<head>
		
		<meta name="viewport" content="height=1080, user-scalable=no, shrink-to-fit=no">

		<script>
			// Makes development easier
			console.clear();	
		</script>

		<script src="{{ URL::asset('js/lib/jquery/jquery-1.11.3.js') }}"></script>
		<script src="{{ URL::asset('/js/lib/jquery/pep.js') }}"></script>
		<script src="{{ URL::asset('/js/lib/jquery/cover.js') }}"></script>
		<script src="{{ URL::asset('/js/lib/jquery/rwdImageMaps.js') }}"></script>
		<script src="{{ URL::asset('js/lib/jquery-ui/jquery-ui.js') }}"></script>
		
		<script src="{{ URL::asset('js/lib/backbone/underscore.js') }}"></script>	
		<script src="{{ URL::asset('js/lib/backbone/backbone.js') }}"></script>	
		
		<script src="{{ URL::asset('js/lib/open-layers/ol-debug.js') }}"></script>
		<script src="{{ URL::asset('js/lib/highstock/highstock.src.js') }}"></script>
		
		<script src="{{ URL::asset('js/models/appModel.js') }}"></script>
		<script src="{{ URL::asset('js/models/pageModels.js') }}"></script>
		
		<script src="{{ URL::asset('js/views/menuViews.js') }}"></script>
		<script src="{{ URL::asset('js/views/pageViews.js') }}"></script>
		<script src="{{ URL::asset('js/views/map.js') }}"></script>
		<script src="{{ URL::asset('js/views/chart.js') }}"></script>
		
		<script src="{{ URL::asset('/js/lib/idle-timer/idle-timer.js') }}"></script>
		
		<script src="{{ URL::asset('js/lib/paper/paper.js') }}"></script>
		<script src="{{ URL::asset('js/lib/chipmunk/cp.js') }}"></script>
		<script src="{{ URL::asset('js/views/splash.js') }}"></script>
		
		<script src="{{ URL::asset('js/views/imageslider.js') }}"></script>
		<script src="{{ URL::asset('js/views/holdandpress.js') }}"></script>
		
		<link rel="stylesheet" href="{{ URL::asset('css/font-awesome/css/font-awesome.css') }}">
		<link rel="stylesheet" href="{{ URL::asset('css/normalize.css') }}" type="text/css" media="screen" charset="utf-8">
		<link rel="stylesheet" href="{{ URL::asset('css/boilerplate.css') }}" type="text/css" media="screen" charset="utf-8">
		<link rel="stylesheet" href="{{ URL::asset('css/page.css') }}" type="text/css" media="screen" charset="utf-8">
		<link rel="stylesheet" href="{{ URL::asset('css/jquery.cover.css') }}" type="text/css" media="screen" charset="utf-8">
		
	</head>
	
	<body touch-action="none">

		<div id="page"> 
	
			<div class="spread"></div>
			
			<div class="intro"></div>
			
			<div class="topic">
				
				<div class="row" id="topicmenu">

					<div class='controls'>
						<div class='chooser button'><span>&nbsp;</span><i class="fa fa-chevron-down pull-right"></i></div>
						<div class="dropdown"></div>
						<div class="text"></div>
					</div>
					<div class="detail block"></div>
				</div>
				
				<div class="cameras"></div>
				
			</div>
			
			<div class="attribution" style="display:none;"></div>

		</div>
		
		<div id="mask"></div>
		
		<div id="credits">
			<img src="{{ URL::asset('img/logos/nhmu.svg') }}" alt="NHMU Logo" width="36" height="36">
			<img src="{{ URL::asset('img/logos/iutahepscor.svg') }}" alt="iUtah EPSCoR Logo" width="81" height="36">
			<img src="{{ URL::asset('img/logos/nsf.svg') }}" alt="NSF Logo" width="36" height="36">
			<div class="text">
				This application was developed by the Natural History Museum of Utah with<br>
				support from iUTAH and The National Science Foundation
			</div>
		</div>
		
		<div id="pagemenu">
			<div class="chooser button big"><span>&nbsp;</span><i class="fa fa-chevron-down pull-right"></i></div>
			<div class="dropdown"></div>
		</div>
		
		<div id="splash">
			<canvas id="canvas" resize hidpi="off" touch-action="none" keepalive="true"></canvas>
		</div>
		
	</body>
	
</html>