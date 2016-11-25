<?php
   
	include("fusionchart/fusioncharts.php");
   	include 'crawler.php';
?>
<html>

   <head>
    <title>مقایسه محصولات</title>
    <script src="fusionchart/js/fusioncharts.js"></script>
   </head>
   <body>
    <?php
		$i=0;
    	foreach ($properties as $prop => $data) {
	    
    		$chart_id = "chart-" . $i++;
	        $columnChart = new FusionCharts("Column2D", "my$chart_id" , 300, 300, $chart_id, "json",
	            '{
	                "chart": {
	                    "caption": "مقایسه فاکتورهای مختلف دو محصول",
	                    "subCaption": "' . $prop . '",
	                    "xAxisName": "نام محصول",
	                    "yAxisName": "نمره",
	                    "numberPrefix": "",
	                    "theme": "zune"
	                },
	                "data": ' . json_encode($data) . '
	                }');
	
	        $columnChart->render();
	    echo '<div id="' . $chart_id . '"><!-- Fusion Charts will render here--></div>';
	    }
	    ?>
   </body>
</html>