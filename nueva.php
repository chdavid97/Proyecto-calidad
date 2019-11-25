<?php
session_start();
require 'funcs/conexion.php';
require 'funcs/funcs.php';

if (isset($_GET["id"])) {
	# code...
    $idUsuario = $_GET['id'];

    $cx=valida_clave($idUsuario);
    print_r ($cx);
}




?>
<html>
<head>
<style>
.objects {
    display:inline-block;
    background-color: #FFF3CC;
    border: #DFBC6A 1px solid;
    width: 50px; 
    height: 50px;
    margin: 10px;
    padding: 8px;
    font-size: 18px;
    text-align: center;
    box-shadow: 2px 2px 2px #999;
    cursor: move;
}
#drop_zone {
    background-color: #EEE; 
    border: #999 1px solid;
    width: 280px; 
    height: 200px;
    padding: 8px;
    font-size: 18px;
}
</style>
<script>
function _(id){
   return document.getElementById(id);	
}
var droppedIn = false;
function drag_start(event) {
    _('app_status').innerHTML = "Dragging the "+event.target.getAttribute('id');
    event.dataTransfer.dropEffect = "move";
    event.dataTransfer.setData("text", event.target.getAttribute('id') );
}
function drag_enter(event) {
    _('app_status').innerHTML = "You are dragging over the "+event.target.getAttribute('id');
}
function drag_leave(event) {
    _('app_status').innerHTML = "You left the "+event.target.getAttribute('id');
}
function drag_drop(event) {
    event.preventDefault(); /* Prevent undesirable default behavior while dropping */
    var elem_id = event.dataTransfer.getData("text");
    event.target.appendChild( _(elem_id) );
    _('app_status').innerHTML = "Dropped "+elem_id+" into the "+event.target.getAttribute('id');
    _(elem_id).removeAttribute("draggable");
    _(elem_id).style.cursor = "default";
    droppedIn = true;
}
function drag_end(event) {
    if(droppedIn == false){
        _('app_status').innerHTML = "You let the "+event.target.getAttribute('id')+" go.";
    }
	droppedIn = false;
}
function readDropZone(){
     var array = [];
    for(var i=0; i < _("drop_zone").children.length; i++){
        alert(_("drop_zone").children[i].id+" is in the drop zone");
        array.push( _("drop_zone").children[i].id );
        var resultado = array[_("drop_zone").children[i].id];
                   
    }
    
    array
/*   var l1=document.querySelector("div").innerHTML = JSON.stringify(array[0]);
    var l2=document.querySelector("div").innerHTML = JSON.stringify(array[1]);
    var l3=document.querySelector("div").innerHTML = JSON.stringify(array[2]);
/*
    <form id="loginform" class="form-horizontal" role="form" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" autocomplete="off">

    <input type="text" id="val1" name="val1" value='$l1'/>
	<input type="text" id="val2" name="val2" value="$l2" />
    <input type="hidden" id="val3" name="val3" value="$l3" />

    /* Run Ajax request to pass any data to your server */




}
</script>
</head>
<body>
<h2 id="app_status">App status...</h2>
<h1>Drop Zone</h1>
<form id="loginform" class="form-horizontal" role="form" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" autocomplete="off">

<div id="drop_zone" ondragenter="drag_enter(event)" ondrop="drag_drop(event)" ondragover="return false" ondragleave="drag_leave(event)" ></div>
<div id="1" class="objects" draggable="true" ondragstart="drag_start(event)" ondragend="drag_end(event)">object 1
<input type="text" name="1" id="1" size="2">
</div>
<div id="2" class="objects" draggable="true" ondragstart="drag_start(event)" ondragend="drag_end(event)">object 2</div>
<div id="3" class="objects" draggable="true" ondragstart="drag_start(event)" ondragend="drag_end(event)">object 3</div>
<div id="4" class="objects" draggable="true" ondragstart="drag_start(event)" ondragend="drag_end(event)">object 4</div>
<hr>
<button onclick="readDropZone()">Get Object Data</button>
</body>
</html>