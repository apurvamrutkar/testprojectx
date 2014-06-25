<?php
include_once 'AutoIncrement.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$m = new MongoClient();
$db = $m->testdb;
$person = $db->person;
$a = new Mongodb_Autoincrement($person, $db, "counters");
        

$fatherfile = fopen("G:\Project X\DataBase Name\Parent.txt", "r") or die("Unable to open file!");
$motherfile = fopen("G:\Project X\DataBase Name\ParentMother.txt", "r") or die("Unable to open file!");

$person = $db->person;
$total_parents = 600;


for($i=1;$i<=$total_parents;$i++){
	$n = $a->getNext();
	$student_id= $person->find(array("parent_id"=>$n));
        
	if($student_id->count()==0){
            //echo "NOT FOUND.......................";
            continue;
	}
	$fathername=fgets($fatherfile);
	$mothername = fgets($motherfile);
	$fnamedesc=explode(" ",$fathername);
	$mnamedesc=explode(" ",$mothername);
	$p=array(
		"_id"=> (string)$n,
		"type"=> "parent",
		"father_name"=>array(
			"first_name"=> $fnamedesc[0],
			"last_name"=> $fnamedesc[1]
		),
		"mother_name"=>array(
			"first_name"=> $mnamedesc[0],
			"last_name"=> $mnamedesc[1]
		),
		//"students"=> 
		"address"=> "Mumbai",
		"email_id"=> $fnamedesc[0]."@gmail.com",
		"username"=> $fnamedesc[0].$n,
		"password"=> $fnamedesc[0].$n,
		"contact_no"=> (string)mt_rand(20000000,99999999),
		"dob"=> mt_rand(1,31)."/".mt_rand(1,12)."/".mt_rand(1960,1980),
	);
	$person->insert($p);

    echo $p["_id"] . '<br />';
    echo $p["type"] . '<br />';
    echo $p["father_name"]["first_name"].'<br />';
    echo $p["mother_name"]["first_name"].'<br />'.'<br />';
    /*echo $p["address"].'<br />';
    echo $p["email_id"].'<br />';
    echo $p["username"].'<br />';
    echo $p["password"].'<br />';
    echo $p["contact_no"].'<br />';
    echo $p["dob"].'<br />';
     */   
        
}
echo "Done with Parent Database Creation";

