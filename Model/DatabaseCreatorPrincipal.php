<?php
include_once 'AutoIncrement.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$m = new MongoClient();
$db = $m->projectx;
$person = $db->person;
$a = new Mongodb_Autoincrement($person, $db, "counters");
        



$person = $db->person;




$n = $a->getNext();

$p=array(
        "_id"=> $n,
        "type"=> "principal",
        "name"=>array(
                "first_name"=> "Rishabh",
                "last_name"=> "Jha"
        ),
        "address"=> "Mumbai",
        "email_id"=> "rish@gmail.com",
        "username"=> "rish",
        "password"=> "rish",
        "contact_no"=> mt_rand(20000000,99999999),
        "dob"=> mt_rand(1,31)."/".mt_rand(1,12)."/".mt_rand(1970,1990),
);
$person->insert($p);

echo $p["_id"] . '<br />';
echo $p["type"] . '<br />';
echo $p["name"]["first_name"].'<br />';
echo $p["name"]["last_name"].'<br />';
echo $p["address"].'<br />';
echo $p["email_id"].'<br />';
echo $p["username"].'<br />';
echo $p["password"].'<br />';
echo $p["contact_no"].'<br />';
echo $p["dob"].'<br />'.'<br />';

        
        


echo "Done with Principal Database Creation";
