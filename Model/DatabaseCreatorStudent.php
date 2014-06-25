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
        

$myfile = fopen("G:\Project X\DataBase Name\Names.txt", "r") or die("Unable to open file!");
$std = 1;
$division = array("A","B","C");
$divcounter = 0;

$person = $db->person;
$total_students = 900;
$students_each_class = 30;

for($i=1;$i<=$total_students;$i++){
	$n = $a->getNext();
	$name=fgets($myfile);
	$namedesc=explode(" ",$name);
	$p=array(
		"_id"=> (string)$n,
		"type"=> "student",
		"name"=>array(
			"first_name"=> $namedesc[0],
			"last_name"=> $namedesc[1]
		),
		"address"=> "Mumbai",
		"email_id"=> $namedesc[0]."@gmail.com",
		"username"=> $namedesc[0].$n,
		"password"=> $namedesc[0].$n,
		"contact_no"=> (string)mt_rand(20000000,99999999),
		"dob"=> mt_rand(1,31)."/".mt_rand(1,12)."/".mt_rand(1999,2010),
		"standard"=> (string)$std,
		"division"=> (string)$division[$divcounter],
                "roll_no"=> ((string)$i%30)."",
		"parent_id"=> (string)mt_rand(900, 1500)
	);
	$person->insert($p);

	if($i%$students_each_class==0){
		if($divcounter==(count($division)-1)){
			$divcounter = 0;
			$std++;
		}
		else{
			$divcounter++;
		}
	}
	/*echo $p["_id"] . '<br />';
        echo $p["type"] . '<br />';
        echo $p["name"]["first_name"].'<br />';
        echo $p["name"]["last_name"].'<br />';
        echo $p["address"].'<br />';
        echo $p["email_id"].'<br />';
        echo $p["username"].'<br />';
        echo $p["password"].'<br />';
        echo $p["contact_no"].'<br />';
        echo $p["dob"].'<br />';
        echo $p["standard"].'<br />';
        echo $p["division"].'<br />';
        echo $p["roll_no"].'<br />';
        echo $p["parent_id"].'<br />';
        */
        
}
echo "Done with Student Database Creation";

