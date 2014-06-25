<?php
include_once 'AutoIncrement.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$m = new MongoClient();
$db = $m->testdb;
$exam = $db->ac_2013_2014;

$a = new Mongodb_Autoincrement($exam, $db, "examcounter");

$n = $a->getNext();
$t = array(
	"_id"=>(string)$n
	);
$exam->insert($t);

$students=$db->person->find(array("type"=>"student"));


foreach($students as $stu){
	$std = $stu["standard"];
        //echo $std.'<br  />';
	$stuid = $stu["_id"];
        echo $stuid;
	$p=array("student_id"=>$stuid);
	$exam->update(
			array("_id"=>(string)$n),
			array('$push'=>array("student"=>$p))
			);
        
        
        //$js= "function(){ return this.standard==$std;}";
        $sublength = $db->ac_2013_2014->find(array("_id"=>"tts","subject.standard"=>$std),array("subject"=>true));
        //echo $sublength->count();
        /*$sublength = $db->ac_2013_2014->aggregate(
            array('$match'=> array("_id"=>"tts")),
            array('$unwind'=> 'subject'),
            array('$match'=> array("standard"=> 1)),
            array('$group'=> array("_id"=>"tts","subject"=> array('$push'=>"subject")))
            );
         */
        $doc = $sublength->getNext()["subject"];
        
        $no_of_subjects= sizeof($doc,1);
        //var_dump($doc);
        
        $min=6*(intval($std)-1);
        $max=6*intval($std);
        //echo $no_of_subjects;
        for($i=$min;$i<$max;$i++){
	
                
		$subjectid = $doc[$i]["subject_id"];
                
		$subname = $doc[$i]["subject_name"];
		$s = array(
		"subject_id"=>$subjectid,
		"subject_name"=> $subname,
		"marks_obtained"=> (string)mt_rand(0,100),
		"max_marks"=> (string)100
		);
                
                echo $s["subject_id"].'<br />';
                echo $s["subject_name"].'<br />';
                echo $s["marks_obtained"].'<br />';
                echo $s["max_marks"].'<br />'.'<br />';
                $student_id = intval($stuid)-1;
		$exam->update(
			array("_id"=>(string)$n),
			array('$push'=>array("student.$student_id.subject"=>$s))
			);
                
        }
}
echo "Done with Exam database entry";
         