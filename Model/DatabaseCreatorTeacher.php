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
        

$myfile = fopen("G:\Project X\DataBase Name\Teacher.txt", "r") or die("Unable to open file!");


$person = $db->person;
$total_teachers = 100;


for($i=1;$i<=$total_teachers;$i++){
	$n = $a->getNext();
	$name=fgets($myfile);
	$namedesc=explode(" ",$name);
	$p=array(
		"_id"=> (string)$n,
		"type"=> "teacher",
		"name"=>array(
			"first_name"=> $namedesc[0],
			"last_name"=> $namedesc[1]
		),
		"address"=> "Mumbai",
		"email_id"=> $namedesc[0]."@gmail.com",
		"username"=> $namedesc[0].$n,
		"password"=> $namedesc[0].$n,
		"contact_no"=> (string)mt_rand(20000000,99999999),
		"dob"=> mt_rand(1,31)."/".mt_rand(1,12)."/".mt_rand(1970,1990),
	);
	$person->insert($p);

    /*echo $p["_id"] . '<br />';
    echo $p["type"] . '<br />';
    echo $p["name"]["first_name"].'<br />';
    echo $p["name"]["last_name"].'<br />';
    echo $p["address"].'<br />';
    echo $p["email_id"].'<br />';
    echo $p["username"].'<br />';
    echo $p["password"].'<br />';
    echo $p["contact_no"].'<br />';
    echo $p["dob"].'<br />'.'<br />';
    */
        
        
}

echo "Done with Teacher Database Creation";
