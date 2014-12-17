<script type="text/javascript" charset="utf-8">
    $(window).load(function () {
        $('.flexslider').flexslider();
    });

	var lat = <?php echo $step->end_location->lat ?>; 
	var lng = <?php echo $step->end_location->lng ?>; 
</script>

<div class="container">
    <div class="flexslider">
        <ul class="slides">
            <li>
                <img id="banner-left" border="0" src="http://maps.googleapis.com/maps/api/streetview?size=640x300&location=<?php echo $step->end_location->lat ?>,<?php echo $step->end_location->lng ?>8&fov=120&pitch=0&heading=0&sensor=false&key=AIzaSyDE_HtWXSjaSvlmyQvNcYpr3WFpSe2C68Y">
            </li>
            <li>
                <img id="banner-left" border="0" src="http://maps.googleapis.com/maps/api/streetview?size=640x300&location=<?php echo $step->end_location->lat ?>,<?php echo $step->end_location->lng ?>8&fov=120&pitch=0&heading=90&sensor=false&key=AIzaSyDE_HtWXSjaSvlmyQvNcYpr3WFpSe2C68Y">
            </li>
            <li>
                <img id="banner-left" border="0" src="http://maps.googleapis.com/maps/api/streetview?size=640x300&location=<?php echo $step->end_location->lat ?>,<?php echo $step->end_location->lng ?>8&fov=120&pitch=0&heading=180&sensor=false&key=AIzaSyDE_HtWXSjaSvlmyQvNcYpr3WFpSe2C68Y">
            </li>
            <li>
                <img id="banner-left" border="0" src="http://maps.googleapis.com/maps/api/streetview?size=640x300&location=<?php echo $step->end_location->lat ?>,<?php echo $step->end_location->lng ?>8&fov=120&pitch=0&heading=270&sensor=false&key=AIzaSyDE_HtWXSjaSvlmyQvNcYpr3WFpSe2C68Y">
            </li>
        </ul>
    </div>

    <form action="/play" method="get">
        <input type="hidden" name="direction_id" value="<?php echo $direction_id ?>" />
        <input type="hidden" name="step_id" value="<?php echo $step_id ?>" />
    	<input type="submit" class="btn btn-info btn-lg" value="スポット到着！" style="width:100%;" />
    </form>
	<br><br>

    <form action="/like" method="get">
        <input type="hidden" name="direction_id" value="<?php echo $direction_id ?>" />
        <input type="hidden" name="step_id" value="<?php echo $previous_step_id ?>" />
    	<input type="submit" class="btn btn-info btn-lg" value="ナイススポット発見！" style="width:100%;" />
    </form>
    <br><br>

</div>
