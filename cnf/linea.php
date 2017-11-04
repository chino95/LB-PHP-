<?php
$path="http://apps.cbp.gov/bwt/bwt.xml";
$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$path);
	curl_setopt($ch, CURLOPT_FAILONERROR,1);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);    
	curl_setopt($ch, CURLOPT_TIMEOUT, 15);
	$retValue = curl_exec($ch);			 
	curl_close($ch);
$xml=new SimpleXMLElement($retValue);
$data="Nogales";
//$data=$_GET['city'];
$json= array();
foreach($xml->port as $child)
{
if($child->port_name ==  $data)
{
    $dataToParse=array(
        "crossing_name"=>(string)$child->crossing_name,
        "hours"=>(string)$child->hours,
        "port_status"=>(string)$child->port_status,
        "commercial_vehicle_lanes"=>array(
            "max_lanes"=>(string)$child->commercial_vehicle_lanes->maximum_lanes,
            "standard_lanes"=>array(
                "update_time"=>(string)$child->commercial_vehicle_lanes->standard_lanes->update_time,
                "delay"=>(string)$child->commercial_vehicle_lanes->standard_lanes->delay_minutes,
                "lanes_open"=>(string)$child->commercial_vehicle_lanes->FAST_lanes->lanes_open),
            
			"fast_lanes"=>array(
				"update_time"=>(string)$child->commercial_vehicle_lanes->FAST_lanes->update_time,
                "delay"=>(string)$child->commercial_vehicle_lanes->FAST_lanes->delay_minutes,
                "lanes_open"=>(string)$child->commercial_vehicle_lanes->FAST_lanes->lanes_open
			)
		),
		"passenger_vehicle_lanes"=>array(
			"max_lanes"=>(string)$child->passenger_vehicle_lanes->maximum_lanes,
			"standard_lanes"=>array(  
				"update_time"=>(string)$child->passenger_vehicle_lanes->standard_lanes->update_time,
				"delay"=>(string)$child->passenger_vehicle_lanes->standard_lanes->delay_minutes,
				"lanes_open"=>(string)$child->passenger_vehicle_lanes->standard_lanes->lanes_open
			),
			"nexus_sentri_lanes"=>array(  
				"update_time"=>(string)$child->passenger_vehicle_lanes->NEXUS_SENTRI_lanes->update_time,
				"delay"=>(string)$child->passenger_vehicle_lanes->NEXUS_SENTRI_lanes->delay_minutes,
				"lanes_open"=>(string)$child->passenger_vehicle_lanes->NEXUS_SENTRI_lanes->lanes_open
			),
			"ready_lanes"=>array( 
				"update_time"=>(string)$child->passenger_vehicle_lanes->ready_lanes->update_time,
				"delay"=>(string)$child->passenger_vehicle_lanes->ready_lanes->delay_minutes,
				"lanes_open"=>(string)$child->passenger_vehicle_lanes->ready_lanes->lanes_open
			)
		),
		"pedestrian_lanes"=>array(  
			"max_lanes"=>(string)$child->pedestrian_lanes->maximum_lanes,
			"standard_lanes"=>array(  
				"update_time"=>(string)$child->pedestrian_lanes->standard_lanes->update_time,
				"delay"=>(string)$child->pedestrian_lanes->standard_lanes->delay_minutes,
				"lanes_open"=>(string)$child->pedestrian_lanes->standard_lanes->lanes_open
			),
			"ready_lanes"=>array( 
				"update_time"=>(string)$child->pedestrian_lanes->ready_lanes->update_time,
				"delay"=>(string)$child->pedestrian_lanes->ready_lanes->delay_minutes,
				"lanes_open"=>(string)$child->pedestrian_lanes->ready_lanes->lanes_open
			)
		)
    );
    array_push($json, $dataToParse);
}
}
$aux = array("ports"=>$json);
header('Content-Type:application/json');
echo json_encode($aux);
?>
