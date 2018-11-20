<?php
require('../../../../../wp-load.php');
wp_head(); 
$args = array(
'post_type'      => 'eventos',
'order'          => 'ASC',
'posts_per_page' => -1,
		'meta_query' => array(
            array(
                'key' => 'evento_principal', 
                'value' => '12565', //9820
                'compare' => '=='
            ))
		);

$events = new WP_Query($args);
$fch22 = array();
$fch23 = array();
$fch24 = array();

print_r($events);
echo "<br>-----------------------<br>";
foreach ($events->posts as $post){
	if (substr($post->post_date, 0, 10)=="2017-07-22") {
			$fch22[]=$post->post_title;
	}else if (substr($post->post_date, 0, 10)=="2017-07-23") {
			$fch23[]=$post->post_title;
	}
	else if (substr($post->post_date, 0, 10)=="2017-07-24") {
			$fch24[]=$post->post_title;
	}
}
print_r($fch22); echo "<br>------<br>";
print_r($fch23); echo "<br>------<br>";
print_r($fch24);


foreach ($events->posts as $post){
	echo "<a href='".$post->guid."'>".$post->post_title."</a></br>";	
	echo $post->post_date."</br></br>";	
}

//?>
<div class="tab">
  <button class="tablinks" onclick="openCity(event, '22')">22/07/2017</button>
  <button class="tablinks" onclick="openCity(event, '23')">23/07/2017</button>
  <button class="tablinks" onclick="openCity(event, '24')">24/07/2017</button>
</div>

<div id="22" class="tabcontent">
  <h3>Subeventos</h3>
</div>

<div id="23" class="tabcontent">
  <h3>Subeventos</h3>
</div>

<div id="24" class="tabcontent">
  <h3>Subeventos</h3>
</div>

<style type="text/css">
/* Style the tab */
div.tab {
    overflow: hidden;
    border: 1px solid #ccc;
    background-color: #f1f1f1;
}

/* Style the buttons inside the tab */
div.tab button {
    background-color: inherit;
    float: left;
    border: none;
    outline: none;
    cursor: pointer;
    padding: 14px 16px;
    transition: 0.3s;
}

/* Change background color of buttons on hover */
div.tab button:hover {
    background-color: #ddd;
}

/* Create an active/current tablink class */
div.tab button.active {
    background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
    display: none;
    padding: 6px 12px;
    border: 1px solid #ccc;
    border-top: none;
}
</style>

<script type="text/javascript">
function openCity(evt, cityName) {
    // Declare all variables
    var i, tabcontent, tablinks;

    // Get all elements with class="tabcontent" and hide them
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    // Get all elements with class="tablinks" and remove the class "active"
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    // Show the current tab, and add an "active" class to the button that opened the tab
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
}
</script>