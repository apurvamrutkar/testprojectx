<?php
include_once 'AutoIncrement.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$m = new MongoClient();
$db = $m->projectx;
$tts = $db->ac_2013_2014;

$a = new Mongodb_Autoincrement($tts, $db, "subjectcounter");
$sub_name=array(
	"Maths",
	"Science",
	"Geography",
	"History",
	"English",
	"Hindi",
	);



$t = array(
	"_id"=>"tts"
	);
$tts->insert($t);
$subcount=1;

for($std=1;$std<=10;$std++){
	for($i=0;$i<count($sub_name);$i++){
		$n = $a->getNext();
		$p = array(
			"subject_id"=> $n,
			"subject_name"=> $sub_name[$i],
			"teacher_id"=> mt_rand(1501,1600),
			"standard"=> $std,
			"chapter"=>""
			);
                    echo $p["subject_id"].'<br />';
                    echo $p["subject_name"].'<br />';
                    echo $p["teacher_id"].'<br />';
                    echo $p["standard"].'<br />'.'<br />';
                    
		$tts->update(
			array("_id"=>"tts"),
			array('$push'=>array("subject"=>$p))
                        );
                
    }
}
echo "Databse for TTS completed";