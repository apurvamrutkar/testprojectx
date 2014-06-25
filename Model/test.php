<?php
include './encryption.php';
ini_set('max_execution_time', 300);
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$m = new MongoClient();

$db = $m->projectx;
/*$exam = $db->ac_2013_2014;
$r = $exam->aggregate(
            array('$match'=>array('_id'=>"tts")),
            array('$unwind'=>'$subject'),
            array('$match'=>array('subject.standard'=>1)),
            array('$project'=>array('_id'=>0,'subject.subject_id'=>1,'subject.subject_name'=>1))
            
            );
var_dump($r);

//Find and Modify example
$change_roll_no_0to30 = $db->person->update(
        array("type"=>"student","roll_no"=>0),
        array('$set'=>array("roll_no"=>30)),
        array('multiple'=>true)
        );
 * 
 */

/*
//modify password with secured hash
$find_pass = $db->person->find(array(),array("_id"=>0, "password"=>1));
$pass = array();
$encryptedpass = array();
$i=0;
foreach ($find_pass as $doc){
    $pass[$i]=$doc["password"];
    $encryptedpass[$i++]=  password_encrypt($doc["password"]);
}
var_dump(($encryptedpass));

echo '<br />'.'<br />'.'<br />'.'<br />';

foreach ($encryptedpass as $index=>$password){
    $change_password= $db->person->update(
        array("password"=>$pass[$index]),
        array('$set'=>array("password"=>  $password))
        );
}
 * 
 */

$delete_parent_dob = $db->person->update(
        array("type"=>"parent"),
        array('$unset'=>array("dob"=>"")),
        array("multiple"=>true));