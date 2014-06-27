<?php
include './AutoIncrement.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$connection = new MongoClient();
session_start();
$databasename="projectx";//$_SESSION["database_name"];
$username = "suraj69";//$_SESSION["user_name"];
$usertype = "admin";//$_SESSION["user_type"];

$db = $connection->$databasename;
echo $db;
$std = $db->person->distinct("standard");
print_r(json_encode($std));



$standard = 1;//$_POST["standard"];
$no_of_students = $db->person->aggregate(
        array('$match'=>array("standard"=>$standard)),
        array('$group'=>array("_id"=>"students", "total"=>array('$sum'=>1)))
        );
print_r(json_encode($no_of_students));



$no_of_teachers = $db->ac_2013_2014->aggregate(
        array('$match'=>array("_id"=>"tts")),
        array('$unwind'=>'$subject'),
        array('$match'=>array("subject.standard"=>$standard)),
        array('$project'=>array("_id"=>0,"subject.teacher_id"=>1))
        );
        //distinct("subject.teacher_id",array("_id"=>"tts","subject.standard"=>$standard)));
print_r(json_encode($no_of_teachers));

print_r(sizeof($no_of_teachers["result"]));
echo '<br />'.'<br />'.'<br />'.'<br />';



//Student Management
// adding a student
$a = new Mongodb_Autoincrement($db->person, $db, "counters");
$n = $a->getNext();
$fname = $_POST["first_name"];
$lname = $_POST["last_name"];
$address = $_POST["address"];
$email_id = $_POST["email_id"];
$contact = $_POST["contact_no"];
$date_of_birth = $_POST["dob"];
$std = 1;//$_POST["standard"];
$div = "A";//$_POST["division"];
$rno = $db->person->aggregate(
        array('$match'=>array("standard"=>$std,"division"=>$div)),
        //array('$sort'=>array("roll_no"=>1)),
        array('$group'=>array("_id"=>1,"roll_no"=>array('$last'=>'$roll_no'))) //Dont use "(double quotes) for property name to be accesses by $
        );





$p=array(
		"_id"=> $n,
		"type"=> "student",
		"name"=>array(
			"first_name"=> $fname,
			"last_name"=> $lname
		),
		"address"=> "Mumbai",
		"email_id"=> $email_id,
		"username"=> $fname.$n,
		"password"=> $fname.$n,
		"contact_no"=> mt_rand(20000000,99999999),
		"dob"=> mt_rand(1,31)."/".mt_rand(1,12)."/".mt_rand(1999,2010),
		"standard"=> $std,
		"division"=> $division[$divcounter],
                "roll_no"=> $rno["roll_no"]+1,
		"parent_id"=> mt_rand(900, 1500)
	);
	//$person->insert($p);


//Modify Student
//getting data on name
$standard = 1;//$_POST["standard"];
$div = "A";//$_POST["division"];
$name = $db->person->find(
        /*array('$match'=>*/array("standard"=>$standard,"division"=>$div),//),
        /*array('$project'=>*/array("_id"=>0,"name"=>1)//)
        );

$names = array();
$i=0;
foreach ($name as $doc){
    $names[$i++]=$doc["name"]["first_name"]." ".$doc["name"]["last_name"];
}
echo json_encode($names);
echo '<br />'.'<br />'.'<br />'.'<br />';
//getting roll_no
$standard = 1;//$_POST["standard"];
$div = "A";//$_POST["division"];
$name = $db->person->find(
        /*array('$match'=>*/array("standard"=>$standard,"division"=>$div),//),
        /*array('$project'=>*/array("_id"=>0,"roll_no"=>1)//)
        );

$roll = array();
$i=0;
foreach ($name as $doc){
    $roll[$i++]=$doc["roll_no"];
}
echo json_encode($roll);
echo '<br />'.'<br />'.'<br />'.'<br />';
//getting details of student to modify
//with name
$fname = "Bakshi";
$stu = $db->person->findOne(
        array("standard"=>$standard,"division"=>$div,"name.first_name"=>$fname),
        array("_id"=>0,"name"=>1,"roll_no"=>1,"address"=>1,"dob"=>1,"roll_no"=>1,"contact_no"=>1) 
        );
echo json_encode($stu);
echo '<br />'.'<br />'.'<br />'.'<br />';
//with roll_no
$rollno = 2;
$stu = $db->person->findOne(
        array("standard"=>$standard,"division"=>$div,"roll_no"=>$rollno),
        array("_id"=>0,"name"=>1,"roll_no"=>1,"address"=>1,"dob"=>1,"roll_no"=>1,"contact_no"=>1) 
        );
echo json_encode($stu);
echo '<br />'.'<br />'.'<br />'.'<br />';


//Delete a Student
$rollno = 32;
$find_stu_to_delete = $db->person->findAndModify(
        array( "standard"=>$standard,"division"=>$div,"roll_no"=>$rollno),
        array("remove"=>true)
        );

$parent_id = $find_stu_to_delete["parent_id"];
$delete_stu_doc = $db->person->remove(array("_id"=>$find_stu_to_delete["_id"]));
echo json_encode($find_stu_to_delete);
echo '<br />';
$check_parent = $db->person->find(
        array("parent_id"=>$parent_id));
echo $check_parent->count();
echo '<br />';
if($check_parent->count()==0){
    $delete_parent = $db->person->remove(array("_id"=>$parent_id));
    echo "parent removed";
}





//Extracting from Excel files
