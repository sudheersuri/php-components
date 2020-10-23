<?php
// http://localhost/gtfs-realtime-php/crud/updatetrip.php?tripid=402_1&busid=10
if($_REQUEST["tripid"] && $_REQUEST["busid"]!=null)
{
    $conn=mysqli_connect("localhost","root","","gtfs");
    if($conn->error) die($conn->error);
        //get the current UTC time
    $utcday = new DateTime(date("F d Y H:i:s"));

    //convert the utc time to thunderbay time which is nothing but toronto time
    $utcday->setTimezone(new DateTimeZone('America/Toronto'));

    //convert the utc time to thunderbay time which is nothing but toronto time
    $utcday="".$utcday->format("F d Y H:i:s");

    $busid=$_REQUEST["busid"];
    $tripid=$_REQUEST["tripid"];
    $explodedarray=explode('_',$tripid);
    $triprefix=$explodedarray[0];
    
    if($busid!=0)
    {
    //check whether the bus is assigned to other routes
    $query="select trip_id,trip_desc from vehicles_to_routes where bus_id=$busid";
    $result=$conn->query($query);
    if(mysqli_num_rows($result)>0)
    {
       
        $row=$result->fetch_assoc();
        if(strpos($row["trip_id"], $triprefix) === false)
        {
            echo "Bus $busid is already assigned to ".$row['trip_desc'];
            return;
        }
    }
    }
    $query="update vehicles_to_routes set bus_id='$busid',dateadded='$utcday' where trip_id='$tripid'";
    $result=$conn->query($query);
    if(!$result) echo "query failed";
    //define buses array 
    echo "success";
    return;
}
else
{
    echo "invalid request";
    return;
}
?>