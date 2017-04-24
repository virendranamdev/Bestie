<?php

include_once('class_connect_db_Communication.php');

class Survey {

    public $DB;

    public function __construct() {
        $db = new Connection_Communication();
        $this->DB = $db->getConnection_Communication();
    }

    function getSurveyQuestion($clientid, $uuid, $date) {
        try {
            $query = "select * from Tbl_EmployeeDetails_Master where clientId=:cli and employeeId=:empid";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cli', $clientid, PDO::PARAM_STR);
            $stmt->bindParam(':empid', $uuid, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (count($rows) > 0) {
                $query = "select *,DATE_FORMAT(startDate,'%d %b %Y') as startDate,DATE_FORMAT(expiryDate,'%d %b %Y') as expiryDate,DATE_FORMAT(createdDate,'%d %b %Y') as createdDate from Tbl_C_SurveyDetails where startdate <= :dte and expiryDate > :dte and clientId= :cid and status =1";
                $nstmt = $this->DB->prepare($query);
                $nstmt->bindParam(':cid', $clientid, PDO::PARAM_STR);
                $nstmt->bindParam(':dte', $date, PDO::PARAM_STR);
                $nstmt->execute();
                $welrows = $nstmt->fetchAll(PDO::FETCH_ASSOC);
                if (count($welrows) > 0) {

                    for ($k = 0; $k < count($welrows); $k++) {
                        $surveyid = $welrows[$k]['surveyId'];
                        $query2 = "select * from Tbl_C_SurveyQuestion where surveyId=:sid and status = 1";
                        $nstmt1 = $this->DB->prepare($query2);
                        $nstmt1->bindParam(':sid', $surveyid, PDO::PARAM_STR);
                        $nstmt1->execute();
                        $welrows1 = $nstmt1->fetchAll(PDO::FETCH_ASSOC);
                     
                        if (count($welrows1) > 0) {

                            for ($d = 0; $d < count($welrows1); $d++) {
                                $welrows1[$d]['index'] = $d;
                                if ($welrows1[$d]['optionType'] == 1 && $welrows1[$d]['optionNumber'] > 0) {
                                   
                                    $questionid = $welrows1[$d]['questionId'];
                               
                                    $query3 = "select * from Tbl_C_SurveyQuestionOption where questionId=:qid and status=1";
                                    $nstmt3 = $this->DB->prepare($query3);
                                    $nstmt3->bindParam(':qid', $questionid, PDO::PARAM_STR);
                                    $nstmt3->execute();
                                    $welrows3 = $nstmt3->fetchAll(PDO::FETCH_ASSOC);
                                 
                                   $welrows1[$d]['options'] = $welrows3;
                                } else {
                                    $welrows1[$d]['options'] = [];
                                }
                            }
                        }
                        
                          $welrows[$k]['question'] = $welrows1;
                    }
                }
                /*                 * ********************************************************************************** */
                if (count($welrows) > 0) {
                    $query1 = "select * from Tbl_Analytic_Survey where clientId=:cid1 and surveyId=:sid1 and 	answeredBy=:uid1";
                    $nstmt1 = $this->DB->prepare($query1);
                    $nstmt1->bindParam(':cid1', $clientid, PDO::PARAM_STR);
                    $nstmt1->bindParam(':sid1', $welrows[0]['surveyId'], PDO::PARAM_STR);
                    $nstmt1->bindParam(':uid1', $uuid, PDO::PARAM_STR);
                    $nstmt1->execute();
                    $welrows1 = $nstmt1->fetchAll(PDO::FETCH_ASSOC);
                    //echo count($welrows1);
                    if (count($welrows1) > 0) {
                        $response['surveysubmit'] = 1;
                        $response['msg'] = "No more survey available";
                    } else {
                        $response['surveysubmit'] = 0;
                        $response['msg'] = "Successfully Display data";
                    }

                    $response['success'] = 1;
                    $response['survey'] = $welrows;
                } else {
                    $response['success'] = 0;
                    $response['msg'] = "No more survey available";
                }
            } else {
                //echo "sorry ur not authorized user";
                $response['success'] = 0;
                $response['msg'] = "Sorry u r not authorized user";
            }
        } catch (PDOException $es) {
            $response['success'] = 0;
            $response['msg'] = "there is some error please contact info@benepik.com" . $es;
        }

        return $response;
    }
/*$clientid, $employeeid, $surveyId,$totalques,$device,$deviceId,$response*/
    
    /************************************************************/
    
    
    function addSurveyAnswer($clientid, $employeeid, $surveyId, $noofquestion, $device,$deviceid, $ans) {
        date_default_timezone_set('Asia/Calcutta');
        $cd = date('Y-m-d H:i:s A');
        $flag = 20;
        $status = 1;
        // $ans1 =  json_decode($ans,true);
        // print_r($ans);

        $query1 = "select * from Tbl_Analytic_Survey where surveyId = :sid and answeredBy = :uid";
        $nstmt1 = $this->DB->prepare($query1);
        $nstmt1->bindParam(':uid', $employeeid, PDO::PARAM_STR);
        $nstmt1->bindParam(':sid', $surveyId, PDO::PARAM_STR);
        // $nstmt->bindParam(':status', $status, PDO::PARAM_STR);
        $nstmt1->execute();
        $resp = $nstmt1->fetchAll(PDO::FETCH_ASSOC);
        //print_r($resp);
        if (count($resp) > 0) {
            $response['success'] = 0;
            $response['msg'] = "You already submitted this survey";
        } else {
            $quesno = count($ans);
         
            for ($i = 0; $i < $quesno; $i++) {
                
                $questionid = $ans[$i]['questionId'];
                $optiontype = $ans[$i]['optionType'];
                 $optionid = $ans[$i]['optionid'];
                  $value = $ans[$i]['answer'];
                if($optiontype == 2)
                {
                if ($value == 's1') {
                    $value = -5;
                } elseif ($value == 'a1') {
                    $value = 0;
                } elseif ($value == 'es1') {
                    $value = 10;
                } else {
                    $value = 5;
                }
                }
                //   echo "this is quesid-".$key;
                //  echo "this is value - ".$value."\n";
                $query = "insert into Tbl_Analytic_Survey(clientId,surveyId,questionId,optionType,optionId,answer,answeredBy,answeredDate,status,device,deviceId)value(:cid,:sid,:qid,:ot,:oid,:ans,:cb,:cd,:sts,:device,:deviceid)";
                $nstmt = $this->DB->prepare($query);
                $nstmt->bindParam(':cid', $clientid, PDO::PARAM_STR);
                $nstmt->bindParam(':sid', $surveyId, PDO::PARAM_STR);
                $nstmt->bindParam(':qid', $questionid, PDO::PARAM_STR);
                $nstmt->bindParam(':ans', $value, PDO::PARAM_STR);
                $nstmt->bindParam(':ot', $optiontype, PDO::PARAM_STR);
                $nstmt->bindParam(':oid', $optionid, PDO::PARAM_STR);
                $nstmt->bindParam(':ans', $value, PDO::PARAM_STR);
                $nstmt->bindParam(':cb', $employeeid, PDO::PARAM_STR);
                 $nstmt->bindParam(':cd', $cd, PDO::PARAM_STR);
                  $nstmt->bindParam(':sts', $status, PDO::PARAM_STR);
                $nstmt->bindParam(':device', $device, PDO::PARAM_STR);
                $nstmt->bindParam(':deviceid', $deviceid, PDO::PARAM_STR);
                if ($nstmt->execute()) {
                    $res = 'True';
                }
            }
            $response['success'] = 1;
            $response['msg'] = "Survey Successfully Submitted";
        }
        return $response;
    }

}
