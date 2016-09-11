<?php defined('C5_EXECUTE') or die("Access Denied.");

$c = Page::getCurrentPage();
if ($c->isEditMode()) { ?>
	<div class="ccm-edit-mode-disabled-item" style="width: <?php echo $width; ?>; height: <?php echo $height; ?>">
		<div style="padding: 80px 0px 0px 0px"><?php echo t('Google Map disabled in edit mode.')?></div>
	</div>
<?php  } else { ?>
	<?php  if( strlen($title)>0){ ?><h3><?php echo $title?></h3><?php  } ?>
	<div id="googleMapCanvas<?php echo $unique_identifier?>" class="googleMapCanvas" style="width: <?php echo $width; ?>; height: <?php echo $height; ?>"></div>
<?php  } ?>

<?php 
    $db = \Database::connection();
    $water_data = $db->fetchAll('SELECT * FROM water_quality');

    

?>

<?php
/*
    Note - this goes in here because it's the only way to preserve block caching for this block. We can't
    set these values through the controller
*/
?>

<script type="text/javascript">
    var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    var labelIndex = 0;

    function addMarker(location, map, drinkable,place,more) {
        var color;
        if (drinkable == 1){
            color = '#00FF00';
        }

        if (drinkable == 2){
            color = '#ffb015';
        }

        if (drinkable == 0){
            color = '#FF0000';
        }

        var locationCircle;
        // Construct the circle for each value in location.
        // Note: We scale the area of the circle based on the population.
         var locationOptions = {
            strokeColor: color,
            strokeOpacity: 0.5,
            strokeWeight: 2,
            fillColor: color,
            fillOpacity: 0.6,
            map: map,
            center: location,
            radius:  1000,
            clickable:true
        };
        // Add the circle for this city to the map.
        locationCircle = new google.maps.Circle(locationOptions);
        var infoWindow = new google.maps.InfoWindow({
            content: "<b>"+place+"</b><br>High:"+more
        });


        google.maps.event.addListener(locationCircle, 'click', function(ev){
            infoWindow.setPosition(locationCircle.getCenter());
            infoWindow.open(map);
        });

      // Add the marker at the clicked location, and add the next-available label
      // from the array of alphabetical characters.
      // var marker = new google.maps.Marker({
      //   position: location,
      //   label: labels[labelIndex++ % labels.length],
      //   map: map
      // });
    }


    function googleMapInit<?php echo $unique_identifier?>() {
        try{
            var latlng = new google.maps.LatLng(<?php echo $latitude?>, <?php echo $longitude?>);
            var mapOptions = {
                zoom: <?php echo $zoom?>,
                center: latlng,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                streetViewControl: false,
                scrollwheel: <?php echo !!$scrollwheel ? "true" : "false"?>,
                draggable: <?php echo !!$scrollwheel ? "true" : "false"?>,
                mapTypeControl: false
            };
            var map = new google.maps.Map(document.getElementById('googleMapCanvas<?php echo $unique_identifier?>'), mapOptions);
            // var marker = new google.maps.Marker({
            //     position: latlng,
            //     map: map
            // });



        // for (var i =0; i < locations.length;  i++) {
        //     var latlng1 = new google.maps.LatLng(locations[i][0], locations[i][1]);
        //     addMarker(latlng1, map)
        // }

        <?php
            foreach ($water_data as $key => $value) {
                $long = $value['longitube'];
                $lat = $value['latitude']; 
                $drinkable = $value['drinkable'];
                $place = $value['place'];
                $more = $value['more'];
                ?>
                var latlng2 = new google.maps.LatLng(<?php echo $long?>, <?php echo $lat?>);
addMarker(latlng2,map,<?php echo $drinkable?>,"<?php echo $place?>","<?php echo $more?>");

                
           <?php }
         ?>

        }catch(e){
            $("#googleMapCanvas<?php echo $unique_identifier?>").replaceWith("<p>Unable to display map: "+e.message+"</p>")}
    }
    $(function() {
        var t;
        var startWhenVisible = function (){
            if ($("#googleMapCanvas<?php echo $unique_identifier?>").is(":visible")){
                window.clearInterval(t);
                googleMapInit<?php echo $unique_identifier?>();
                return true;
            }
            return false;
        };
        if (!startWhenVisible()){
            t = window.setInterval(function(){startWhenVisible();},100);
        }
    });
</script>
