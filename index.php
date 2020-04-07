<!DOCTYPE HTML>
<html>

<head>
<title>
Option Data Analysis
</title>

<style>
.unselectable {
-webkit-user-select: none;
-webkit-touch-callout: none;
-moz-user-select: none;
-ms-user-select: none;
user-select: none;
}
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.10.1/bootstrap-table.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.10.1/bootstrap-table.min.js"></script>
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script type="text/javascript">
var tag;

$(document).ready(function(){
$("#option_button").click(function(){
document.getElementById("created_link_text").innerHTML = "";
var expiry_date = document.getElementById("option_expiry_date").value;
var req_date = document.getElementById("option_req_date").value;
var d = new Date();
tag = expiry_date+d.getTime();
var req_time = document.getElementById("option_req_time").value;
$.get("get-requested-created-data.php?expiry_date="+expiry_date+"&tag="+tag+"&req_date="+req_date+"&req_time="+req_time, function(data){
// Display the returned data in browser
var list = data;
createdString = String(JSON.parse(list));
createdStringSplit = createdString.split(",");

list="<b>Available data for: </b>";
for(i=0; i<createdStringSplit.length; i=i+2){
time=createdStringSplit[i].substr(8,12);
list = list+' <button type="button" class="btn btn-primary btn-sm" onclick=\'getOptionSheetData("'+expiry_date+'", "'+createdStringSplit[i]+'")\'> '+time.slice(0, 2)+":"+time.slice(2)+' </button> ';
}

$("#created_link_text").html(list);
//document.getElementById("table").innerHTML = "";
//constructTable(JSON.parse(data));
});
});
});


function getOptionSheetData(expiry_date, created){

$.get("get-requested-option-data.php?expiry_date="+expiry_date+"&created="+created, function(data){
var list = data;
// document.write(list)
document.getElementById("table").innerHTML = "";
constructTable(JSON.parse(data));
});
}

//////////////////////////////////////////////////////////////////////////

$(document).ready(function(){
$("#strike_button").click(function(){

document.getElementById("created_link_text").innerHTML = "";

var strike_price = document.getElementById("strike_price").value;
var expiry_date = document.getElementById("expiry_date").value;
var req_date = document.getElementById("req_date").value;
var d = new Date();
tag = strike_price+expiry_date+d.getTime();

$.get("get-requested-strike-data.php?strike_price="+strike_price+"&expiry_date="+expiry_date+"&tag="+tag+"&req_date="+req_date, function(data){
// Display the returned data in browser
//$("#created_link_text").text(data);
var list = data;
//document.write(list);
document.getElementById("table").innerHTML = "";
constructTable(JSON.parse(data));
});
});
});

function constructTable(list, selector='#table') {
// Getting the all column names
var cols = Headers(list, selector);
// Traversing the JSON data
for (var i = 0; i < list.length; i++) {
var row = $('<tr/>');
for (var colIndex = 0; colIndex < cols.length; colIndex++)
{
var val = list[i][cols[colIndex]];
if (val == null) val = "";
row.append($('<td/>').html(val));
}
$(selector).append(row);
}

jQuery.each($("table tr"), function() {
$(this).children(":eq(5)").after($(this).children(":eq(13)"));
$(this).children(":eq(0)").after($(this).children(":eq(4)"));
$(this).children(":eq(1)").after($(this).children(":eq(0)"));
$(this).children(":eq(1)").after($(this).children(":eq(5)"));

$(this).children(":eq(10)").after($(this).children(":eq(7)"));
$(this).children(":eq(9)").after($(this).children(":eq(12)"));
$(this).children(":eq(9)").after($(this).children(":eq(8)"));
$(this).children(":eq(9)").after($(this).children(":eq(7)"));

$(this).children(":eq(5)").after($(this).children(":eq(14)"));
$(this).children(":eq(6)").after($(this).children(":eq(14)"));

$(this).children("td:eq(4)").css("color", "#3a3d7d");
$(this).children("td:eq(6)").css("color", "#c1722df5");
$(this).children("td:eq(7)").css("color", "#2e7b7bf5");
$(this).children("td:eq(8)").css("color", "#3a3d7d");
$(this).children("td:eq(10)").css("color", "#3a3d7d");

$(this).children("td:eq(6)").css("background-color", "#e7e3d5");
$(this).children("td:eq(7)").css("background-color", "#e7e3d5");
$(this).children("td:eq(8)").css("background-color", "#e7e3d5");

$(this).children("td:eq(6)").css("text-align", "center");
$(this).children("td:eq(7)").css("text-align", "center");
$(this).children("td:eq(8)").css("text-align", "center");


});

jQuery.each($("table "), function() {
$(this).children("tr:eq(0)").css({"background-color": "#e0e0e0", "font-size": "13px", "text-transform": "uppercase"});
$(this).children("tr:eq(0)").val($(this).val().toUpperCase());

});

$( "td").attr("width","60");
$('th').css('text-align', 'center');
$('tr').css('text-align', 'right');
//document.getElementById("downloadFileId").innerHTML = "Download CSV File";
//document.getElementById("downloadFileId").href = "/csvFiles/"+tag+".csv";
}

function Headers(list, selector) {
var columns = [];
var header = $('<tr/>');

for (var i = 0; i < list.length; i++) {
var row = list[i];

for (var k in row) {
if ($.inArray(k, columns) == -1) {
columns.push(k);
// Creating the header
header.append($('<th/>').html(k));
}
}
}
$(selector).append(header);
return columns;
}

function display() {
if(document.getElementById('select_strike_price').checked) {
document.getElementById("table").innerHTML = "";
document.getElementById("created_link_text").innerHTML = "";
document.getElementById("strike_form").className = 'unhide';
document.getElementById("sheet_form").className = 'hidden';
//document.write("test");
}
else if(document.getElementById('select_option_sheet').checked) {
document.getElementById("table").innerHTML = "";

document.getElementById("sheet_form").className = 'unhide';
document.getElementById("strike_form").className = 'hidden';
//document.write("test2");
}
}

function hideTableOnSelectOption(){
document.getElementById("table").innerHTML = "";
}

</script>
</head>
<body class="unselectable" style="font-family: Arial, Helvetica, sans-serif;">

<div class="container">
<h2>Option Chain Data</h2>
<p>Enter strike price and expiry date and get Nifty option chain data of Indian stock market.</p>

<iframe src="https://platform.twitter.com/widgets/follow_button.html?screen_name=rajatgupta207&show_screen_name=true&show_count=true&size=l" title="Follow Rajat Gupta on Twitter"
width="300" height="40" style="border: 0; overflow: hidden;" ></iframe>
<hr>

<input type="radio" id="select_option_sheet" onclick="display()" name="select_data-type" checked> <label for="select_option_sheet">Option Sheet</label> &nbsp;&nbsp;&nbsp;
<input type="radio" id="select_strike_price" onclick="display()" name="select_data-type"> <label for="select_strike_price">Strike Price</label>

<form class="hidden" id="strike_form">
<div class="form-group">
<div class="form-row">
<div class="form-group col-md-3">
<label for="Strike Price">Strike Price:</label></br>
<input  type="number" id="strike_price" class="form-control" name="strike_price" value="8000" placeholder="Strike Price" required>
</div>
<div class="form-group col-md-3">
<label for="Expiry Date">Expiry Date:</label></br>
<input type="text" id="expiry_date" class="form-control" name="expiry_date" value="9APR2020" placeholder="Expiry Date" required>
</div>
<div class="form-group col-md-3">
<label for="Date">Date:</label></br>
<input type="text" id="req_date" class="form-control" name="req_date" value="01/04/2020" placeholder="01/04/2020" required>
</div>
<div class="form-group col-md-3">
<br>
<button type="button" id="strike_button" class="btn btn-primary">Get Option Data</button>
</div>
</div>
</div>
</form>

<form class="unhide" id="sheet_form">
<div class="form-group">
<div class="form-row">
<div class="form-group col-md-3">
<label for="Expiry Date">Expiry Date:</label></br>
<select id="option_expiry_date" class="form-control" name="option_expiry_date" value="9APR2020" >
<?php
$expiry_select_options_list = array("1APR2020", "9APR2020", "16APR2020", "23APR2020", "30APR2020", "7MAY2020", "14MAY2020", "21MAY2020", "28MAY2020");
for($i=0; $i<sizeof($expiry_select_options_list); $i++)
echo "<option>".$expiry_select_options_list[$i]."</option>";
?>
</select>
</div>
<div class="form-group col-md-3">
<label for="Date">Date:</label></br>
<input type="text" id="option_req_date" class="form-control" name="option_req_date" value="01/04/2020" placeholder="01/04/2020" required>
</div>
<div class="form-group col-md-3">
<label for="Time">Time:</label></br>
<select class="form-control" id="option_req_time" onchange="hideTableOnSelectOption()">
<option>09:20 To 10:30</option>
<option>10:00 To 11:00</option>
<option>10:30 To 11:30</option>
<option>11:00 To 12:00</option>
<option>11:30 To 12:30</option>
<option>12:00 To 13:00</option>
<option>12:30 To 13:30</option>
<option>13:00 To 14:00</option>
<option>13:30 To 14:30</option>
<option>14:00 To 15:00</option>
<option>14:30 To 15:30</option>

<!--<option>9:20 To 10:00</option>
<option>10:00 To 10:30</option>
<option>10:30 To 11:00</option>
<option>11:00 To 11:30</option>
<option>11:30 To 12:00</option>
<option>12:00 To 12:30</option>
<option>12:30 To 13:00</option>
<option>13:00 To 13:30</option>
<option>13:30 To 14:00</option>
<option>14:00 To 14:30</option>
<option>14:30 To 15:00</option>
<option>15:00 To 15:30</option>-->
</select>
</div>
<div class="form-group col-md-3">
<br>
<button type="button" id="option_button" class="btn btn-primary">Get Option Data</button>
</div>
</div>
</div>
</form>

<br><br>
<div style="text-align:right;"><a href="" id="downloadFileId"></a></div>
<br>
</div>

<div class="container">
</br>
<style>
div.sticky {
  position: -webkit-sticky;
  position: sticky;
  top: 0;
}
</style>

<div class="sticky"><div id="created_link_text" style="padding: 5px; background-color: white;"></div></div>
</br>

<table style="font-size:14px; border-color: #aca99f; border-spacing: 5px;" id="table" border="1px"></table>
</div>

<br><br>

</body>
</html>
