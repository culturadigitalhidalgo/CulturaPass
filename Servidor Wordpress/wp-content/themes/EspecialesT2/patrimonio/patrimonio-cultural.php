<?php
/*
* Patrimonio Cultural de Hidalgo
* Name: patrimonio cultural de hidalgo app
* Author: Eloy Monter Hernández
* Author URI: http://cultura.hidalgo.gob.mx
* @since Versión 1.0, revisión 10 Febrero 2018
*/
?>

<html>
<head>
<meta charset="utf-8">
<style type="text/css">
@import url('https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800');
@import url('https://fonts.googleapis.com/css?family=Roboto:400,700,900');
body{background:#fff; max-width:900px;
	margin:0 auto; font-family: 'Open Sans', sans-serif;
	display:table; height:100%;}
.main{text-align:center; display:table-cell;
	vertical-align:middle; text-align:center;}
.patrimonio_logo{max-width:150px;
	position: relative;
    -webkit-animation-name: pch_logo;
    -webkit-animation-duration: 1.8s;
    animation-name: pch_logo;
    animation-duration: 1.8s;}
h1{
	color:#858585; min-width:333px;
	font-family: 'Roboto', sans-serif;
	font-weight:700; text-align:center;
	font-size:1.6em; line-height:1em;
	position: relative;
    -webkit-animation-name: title;
    -webkit-animation-duration: 1.8s;
    animation-name: title;
    animation-duration: 3s;
}
a{text-decoration:none; font-size:1.2em;
	color:#fff; text-transform:uppercase;
	font-weight:700;padding:14px; display:block;
	max-width:900px; text-align:center; cursor:pointer}
a:hover{font-weight:800;}
a:visited{color:#fff; text-decoration:none;}
a.pci{background:#3d9fac;}
a.pcm_m{background:#8dc546;}
a.pcm_i{background:#f4ac27;}
a.pcd{background:#e24856}
a.pcw{background:#8b183c}
a.pci{
    position: relative;
    -webkit-animation-name: pats;
    -webkit-animation-duration: 0.2s;
	-webkit-animation-timing-function: ease;
    animation-name: pats;
    animation-duration: 0.2s;
	animation-timing-function: ease;
}
a.pcm_m{
    position: relative;
    -webkit-animation-name: pats;
    -webkit-animation-duration: 0.3s;
	-webkit-animation-timing-function: ease;
    animation-name: pats;
    animation-duration: 0.3s;
	animation-timing-function: ease;
}
a.pcm_i{
    position: relative;
    -webkit-animation-name: pats;
    -webkit-animation-duration: 0.4s;
	-webkit-animation-timing-function: ease;
    animation-name: pats;
    animation-duration: 0.4s;
	animation-timing-function: ease;
}
a.pcd{
    position: relative;
    -webkit-animation-name: pats;
    -webkit-animation-duration: 0.5s;
	-webkit-animation-timing-function: ease;
    animation-name: pats;
    animation-duration: 0.5s;
	animation-timing-function: ease;
}
a.pcw{
    position: relative;
    -webkit-animation-name: pats;
    -webkit-animation-duration: 0.6s;
	-webkit-animation-timing-function: ease;
    animation-name: pats;
    animation-duration: 0.6s;
	animation-timing-function: ease;
}

span{
	position: relative;
    -webkit-animation-name: spantxt;
    -webkit-animation-duration: 1.4s;
    animation-name: spantxt;
    animation-duration: 1.4s;
}

/* Safari 4.0 - 8.0 */
@-webkit-keyframes pats {0% {left:-25px; top:0px;} 100% {left:0px; top:0px;}}
@-webkit-keyframes spantxt {0% {opacity: 0; filter: alpha(opacity=0);} 100% {opacity: 1; filter: alpha(opacity=100);}}
@-webkit-keyframes title {0% {right:-25px; top:0px;} 100% {left:0px; top:0px;}}

/* Standard syntax */
@keyframes pats {0% {left:-25px; top:0px;} 100% {left:0px; top:0px;}}
@keyframes spantxt {0% {opacity: 0; filter: alpha(opacity=0);} 100% {opacity: 1; filter: alpha(opacity=100);}}
@keyframes title {0% {opacity: 0; filter: alpha(opacity=0);} 100% {opacity: 1; filter: alpha(opacity=100);}}

@-webkit-keyframes pch_logo {
  from { -webkit-transform: rotateY(300deg); opacity: 0; filter: alpha(opacity=0);}
  to   { -webkit-transform: rotateY(360deg); opacity: 1; filter: alpha(opacity=100);}
}

#modal {
  background: rgba(255, 255, 255, .97);
  color: #CCC; position: fixed;
  top: -100vh; left: 0;
  height: 100vh; width: 100vw;
  transition: all .5s;
  z-index:100;
}

#modal p {
  width: 60%; height: 60%;
  position: absolute; margin: auto;
  top: 0; left: 0; bottom: 0; right: 0;
  font-size: 1.2em; text-align: center;
}

#modal p a{color:#3d9fac; text-transform:none; font-size:1.2em; padding:0px; display:inline; width:auto; font-weight:normal;}


#info-modal{display: none;}
#info-modal + label {
  display: block; position:absolute; top:16px; right:16px;
  margin: auto; color: #666; line-height: 3;
  padding: 0 1em; text-transform: uppercase;
  cursor: pointer;
}

#info-modal + label:hover {
  background: #666; color:#fff;
}

#info-modal:checked ~ #modal {
  top: 0;
}

#cerrar-modal {
  display: none;
}
#cerrar-modal + label {
  position: absolute; bottom: 16px; right: 16px; z-index: 150;
  color: #fff; font-weight: bold; cursor: pointer; background: tomato;
  width: 25px; height: 25px; line-height: 25px; text-align: center;
  border-radius: 50%; transition: all .8s;
}
#cerrar-modal:checked ~ #modal {
  top: -100vh;
}
#cerrar-modal + label {
  display: none;
}
#info-modal:checked ~ #cerrar-modal + label {
  display: block;
}
#cerrar-modal:checked + label {
  display: none;
}


</style>
</head>

<body>

<div class="main">
    <img class="patrimonio_logo" src="../wp-content/themes/EspecialesT2/patrimonio/assets/patrimonio_cultural_hidalgo.svg">
    <h1>Patrimonio Cultural <br>de Hidalgo</h1>
    <a class="pci" href="http://cultura.hidalgo.gob.mx/patrimonio-cultural-de-hidalgo/"><span>Inmaterial</span></a>
    <a class="pcm_m"><span>Mueble</span></a>
    <a class="pcm_i"><span>Inmueble</span></a>
    <a class="pcd"><span>Documental</span></a>
    <a class="pcw"><span>Mundial</span></a>
</div>

<input id="info-modal" name="modal" type="radio" /> 
<label for="info-modal"> info </label>

<input id="cerrar-modal" name="modal" type="radio" /> 
<label for="cerrar-modal"> X </label> 

<div id="modal">
  <p>Esta aplicación fue desarrollada por la Secretaría de Cultura de Hidalgo.<br><br>
  <a href="http://cultura.hidalgo.gob.mx">Sitio Oficial</a>
  
  
  </p>
</div>


</body>
</html>