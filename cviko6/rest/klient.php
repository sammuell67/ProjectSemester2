<!DOCTYPE html>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script>
$(document).ready(function(){
    $("#myPOST").click(function(){
      $.ajax({
         type: 'POST',
         url: 'http://147.175.98.101/prednasky/rest/index.php/osoby',
         data: '{"meno":"Miroslav","vek":"22","pohlavie":"M","opis":"student"}',
         success: function(msg){
            $("#myDiv").html(msg);    }});
    }); 
    $("#myDELETE").click(function(){
      $.ajax({
         type: 'DELETE',
         url: 'http://147.175.98.101/prednasky/rest/index.php/osoby/6',
         success: function(msg){
            $("#myDiv").html(msg);    }});
    }); 
    $("#myPUT").click(function(){
      $.ajax({
         type: 'PUT',
         url: 'http://147.175.98.101/prednasky/rest/index.php/osoby/6',
         data: '{"meno":"Mirco","vek":"22","pohlavie":"M","opis":"student"}',
         success: function(msg){
            $("#myDiv").html(msg);    }});
    }); 
});
</script>
</head>
<body>
  <button id="myPOST">Submit POST</button>
  <button id="myDELETE">Submit DELETE</button>
  <button id="myPUT">Submit PUT</button>  
  <div id="myDiv"></div>
</body>
</html>