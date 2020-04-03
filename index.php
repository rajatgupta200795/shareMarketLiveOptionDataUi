<!DOCTYPE HTML>
<html>

<head>
<title>
Option Data Analysis
</title>

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
    $("button").click(function(){
var strike_price = document.getElementById("strike_price").value;
var expiry_date = document.getElementById("expiry_date").value;
var req_date = document.getElementById("req_date").value;
var d = new Date();
tag = strike_price+expiry_date+d.getTime();

        $.get("get-requested-data.php?strike_price="+strike_price+"&expiry_date="+expiry_date+"&tag="+tag+"&req_date="+req_date, function(data){
            // Display the returned data in browser
            //$("#txt").text(data);
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
$( "td").attr("width","70");
$('th').css('text-align', 'center');
$('tr').css('text-align', 'center');

document.getElementById("downloadFileId").innerHTML = "Download CSV File";
document.getElementById("downloadFileId").href = "/csvFiles/"+tag+".csv";

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


</script>



</head>

<body>

<div class="container">

<h2>Option Chain Data</h2>
<p>Enter strike price and expiry date and get Nifty option chain data of Indian stock market.</p>

<br><br>

<form>
<div class="form-group">
<div class="form-row">
<div class="form-group col-md-3">
<label for="Strike Price">Strike Price:</label></br>
<input  type="number" id="strike_price" class="form-control" name="strike_price" value="9000" placeholder="Strike Price" required>
</div>
<div class="form-group col-md-3">
<label for="Expiry Date">Expiry Date:</label></br>
<input type="text" id="expiry_date" class="form-control" name="expiry_date" value="1APR2020" placeholder="Expiry Date" required>
</div>
<div class="form-group col-md-3">
<label for="Date">Date:</label></br>
<input type="text" id="req_date" class="form-control" name="req_date" value="01/04/2020" placeholder="01/04/2020" required>
</div>
<div class="form-group col-md-3">
<br>
<button type="button" class="btn btn-primary">Get Option Data</button>
</div>
</div>
</div>
</form>

<br><br>
<div id="txt"></div>

<center>
Follow on Twitter for all updates: <iframe src="https://platform.twitter.com/widgets/follow_button.html?screen_name=rajatgupta207&show_screen_name=false&show_count=false&size=l"
title="Follow on Twitter" width="80" height="30" style="border: 0; overflow: hidden;"></iframe>
<center>

<div  style="text-align:right;"><a href="" id="downloadFileId"></a></div>
<br>
</div>

<table id="table" align = "center" border="1px"></table>

<br><br>
<hr>


</body>
</html>
