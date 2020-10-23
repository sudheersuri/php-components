<html>
<!-- write the php loop to display a table  -->
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<?php
$conn=mysqli_connect("localhost","root","","gtfs");
if($conn->error) die($conn->error);
$query="select bus_id from vehicles_info order by bus_id";
$result=$conn->query($query);
if(!$result) die($conn->error);
//define buses array 
$buses=array();
while($row=$result->fetch_assoc())
{
    $buses[]=$row["bus_id"];
}
$buses=json_encode($buses);
?>
</head>
<table>
<?php
$i=1;
while($i<=4)
{
?>
<!-- just give the loop id for both column and to the button onclick function -->
<tr>
<td><button onclick="changethis('<?php echo 'editable#'.$i;?>')">change</button></td>
<td id="<?php echo "editable#$i"?>">hi</td>
</tr>
<?php
$i++;
}
?>
</table>
<script>
function changethis(id)
{
// get the buses from php variable
var buses=<?php echo $buses ?>;
//write while loop and create snippet variable 
i=0;
snippet="<select onchange=updatethis(this,'"+id+"')>";
while(i<buses.length)
{
    eachbus=buses[i];
    snippet+=`<option value='${eachbus}'>${eachbus}</option>`;
    i++;
}
snippet+="</select>";
var column = document.getElementById(id);
column.innerHTML=snippet;
}
function updatethis(selectedoption,id)
{
var column = document.getElementById(id);
column.innerHTML=selectedoption.value;
$.get(`updatetrip.php?tripid=102_1&busid=${selectedoption.value}`,function(res){ if(res=="success") alert("success"); else alert("gone")});
}
</script>   
</body>
</html>