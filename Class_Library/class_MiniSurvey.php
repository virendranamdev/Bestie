<?php

//error_reporting(E_ALL);
//ini_set('display_errors', 1);
include_once('class_connect_db_Communication.php');

if (!class_exists('FindGroup')) {
    require_once('Api_Class/class_find_groupid.php');
}

class MiniSurvey {

    public $DB;

    public function __construct() {
        $db = new Connection_Communication();
        $this->DB = $db->getConnection_Communication();
    }

    /*************************get survey question option for panel************************************/
    
    
    function getSurveyQuestionOption($clientId)
    {
        try {
            $query = "select * from Tbl_C_SurveyOptionType where status=1";
             $stmt = $this->DB->prepare($query);
            if ($stmt->execute()) {
                $tr = $stmt->fetchAll(PDO::FETCH_ASSOC);
              $response['success'] = 1;
              $response['data'] = $tr;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            $response['success'] = 0;
              $response['data'] = $tr;
            
        }
        return(json_encode($response));
        }
    
    
//    
//    function surveyMaxId() {
//        try {
//            $max = "select max(surveyId) from Tbl_C_SurveyDetails";
//            $stmt = $this->DB->prepare($max);
//            if ($stmt->execute()) {
//                $tr = $stmt->fetch();
//                $m_id = $tr[0];
//                $m_id1 = $m_id + 1;
//                $qid = $m_id1;
//
//                return $qid;
//            }
//        } catch (PDOException $e) {
//            echo $e;
//            trigger_error('Error occured fetching max autoid : ' . $e->getMessage(), E_USER_ERROR);
//        }
//    }
//
        
        /******************************* check survey availablity when create survey ***********/
        
  function checkSurveyAvailablity($clientid, $startdate) {
            try {
                $query1 = "select * from Tbl_C_SurveyDetails where expiryDate > '" . $startdate . "' and status = 1 and clientId=:cid";
                $stmt1 = $this->DB->prepare($query1);
                //  $stmt1->bindParam(':dte1', $this->startdate, PDO::PARAM_STR);
                $stmt1->bindParam(':cid', $clientid, PDO::PARAM_STR);
    
                $stmt1->execute();
                $value = $stmt1->fetchAll(PDO::FETCH_ASSOC);
    
                if (count($value) > 0) {
                    $result['success'] = 1;
                    $result['message'] = "survey is Available";
                } else {
                    $result['success'] = 0;
                    $result['message'] = "survey not Available";
                }
            } catch (PDOException $e) {
                $result['success'] = 0;
                $result['message'] = "there is some error please contact info@benepik.com" . $e;
            }
            return json_encode($result);
  }

  /************* create new survey question from panel ***************************/
  
    function createSurvey($clientid, $surveytitle, $noofques, $createdby, $createddate, $expiryDate, $startdate, $status) {
        // echo $status;
        try {
            $query = "insert into Tbl_C_SurveyDetails(clientId,surveyTitle,quesno,createdBy,createdDate,    expiryDate,startDate,status)values(:cid,:stitle,:quesno, :createdby,  :createddate, :expiryDate,:startdate,:status )";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cid', $clientid, PDO::PARAM_STR);
            $stmt->bindParam(':stitle', $surveytitle, PDO::PARAM_STR);
            $stmt->bindParam(':quesno', $noofques, PDO::PARAM_STR);
            $stmt->bindParam(':createdby', $createdby, PDO::PARAM_STR);
            $stmt->bindParam(':createddate', $createddate, PDO::PARAM_STR);
            $stmt->bindParam(':expiryDate', $expiryDate, PDO::PARAM_STR);
            $stmt->bindParam(':startdate', $startdate, PDO::PARAM_STR);
            $stmt->bindParam(':status', $status, PDO::PARAM_STR);

            $stmt->execute();
            $last_id = $this->DB->lastInsertId();

            $result['success'] = 1;
            $result['message'] = "survey is successfully started";
            $result['lastid'] = $last_id;
            return($result);
        } catch (PDOException $e) {
            echo $e;
        }
    }

    /************* create new survey question from panel ***************************/
    
    function createSurveyQuestion($surveyid, $questiontext, $optiontype, $optionnumber, $createdDate, $createdBy,$status) {

       
        try {

            $query = "insert into Tbl_C_SurveyQuestion(surveyId,question,optionType,optionNumber,status,createdDate,createdBy)values(:sid,:ques_text,:opttype,:optionnumber,:sts,:cd,:cb)";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':sid', $surveyid, PDO::PARAM_STR);
            $stmt->bindParam(':ques_text', $questiontext, PDO::PARAM_STR);
            $stmt->bindParam(':opttype', $optiontype, PDO::PARAM_STR);
            $stmt->bindParam(':optionnumber', $optionnumber, PDO::PARAM_STR);
            $stmt->bindParam(':sts', $status, PDO::PARAM_STR);
            $stmt->bindParam(':cd', $createdDate, PDO::PARAM_STR);
            $stmt->bindParam(':cb', $createdBy, PDO::PARAM_STR);
            $stmt->execute();
             $last_id = $this->DB->lastInsertId();

            $result['success'] = 1;
            $result['message'] = "survey question successfully created";
              $result['questionid'] = $last_id;
            return($result);
        } catch (PDOException $e) {
            echo $e;
             $result['success'] = 0;
            $result['message'] = "error";
              $result['questionid']=0;
        }
         return($result);
    }
    
    
    /******************************* survey question option from panel**************************/
    
    function createSurveyQuestionoption($questionId,$surveyId, $optiontype, $option, $status, $createdDate, $createdBy) {
  
        try {

            $query = "insert into Tbl_C_SurveyQuestionOption(questionId,surveyId,optionType,options,status,createdDate,createdBy)values(:qid,:sid,:opttype,:option1,:sts,:cd,:cb)";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':qid', $questionId, PDO::PARAM_STR);
            $stmt->bindParam(':sid', $surveyId, PDO::PARAM_STR);
            $stmt->bindParam(':opttype', $optiontype, PDO::PARAM_STR);
            $stmt->bindParam(':option1', $option, PDO::PARAM_STR);
            $stmt->bindParam(':sts', $status, PDO::PARAM_STR);
            $stmt->bindParam(':cd', $createdDate, PDO::PARAM_STR);
            $stmt->bindParam(':cb', $createdBy, PDO::PARAM_STR);
            $stmt->execute();
             $last_id = $this->DB->lastInsertId();

            $result['success'] = 1;
            $result['message'] = "survey question's option successfully created";
              $result['optionid'] = $last_id;
            return($result);
        } catch (PDOException $e) {
            echo $e;
             $result['success'] = 0;
            $result['message'] = "error";
              $result['optionid']=0;
        }
         return($result);
    }
    
    
 /************** display survey list in panel **************************/  

    function getSurveyDetails($clientid, $user_uniqueid, $user_type) {
        $this->idclient = $clientid;
        $this->eid = $user_uniqueid;
        $this->utype = $user_type;

        if ($this->utype == "SubAdmin") {
            try {
                $query = "select *, DATE_FORMAT(startDate,'%d %b %Y') as startDate,DATE_FORMAT(expiryDate,'%d %b %Y') as expiryDate from Tbl_C_SurveyDetails where clientId=:cli and createdBy =:cb order by surveyId desc";
                $stmt = $this->DB->prepare($query);
                $stmt->bindParam(':cli', $this->idclient, PDO::PARAM_STR);
                $stmt->bindParam(':cb', $this->eid, PDO::PARAM_STR);
                $stmt->execute();
                $rows = $stmt->fetchAll();

                $response = array();

                if ($rows) {
                    $responseCount = array();
                    foreach ($rows as $val) {
                        $query = "select survey.surveyId,count(distinct(happiness.userUniqueId)) as responseCount from Tbl_Analytic_EmployeeHappiness as happiness join Tbl_C_SurveyDetails as survey on happiness.surveyId=survey.surveyId where happiness.clientId=:cli and happiness.surveyId=:surveyId";
                        $stmt = $this->DB->prepare($query);
                        $stmt->bindParam(':cli', $this->idclient, PDO::PARAM_STR);
                        $stmt->bindParam(':surveyId', $val['surveyId'], PDO::PARAM_STR);
                        $stmt->execute();
                        $data = $stmt->fetch(PDO::FETCH_ASSOC);

                        array_push($responseCount, $data);
                    }

                    $response["success"] = 1;
                    $response["message"] = "You successfully fetched";
                    $response["posts"] = $rows;
                    $response["responseCount"] = $responseCount;
                    return json_encode($response);
                } else {
                    $response["success"] = 0;
                    $response["message"] = "data doesn't fetch";
                    return json_encode($response);
                }
            } catch (PDOException $e) {
                echo $e;
            }
        } else {
            try {
                $query = "select *,DATE_FORMAT(startDate,'%d %b %Y') as startDate,DATE_FORMAT(expiryDate,'%d %b %Y') as expiryDate from Tbl_C_SurveyDetails where clientId=:cli order by surveyId desc";
                $stmt = $this->DB->prepare($query);
                $stmt->bindParam(':cli', $this->idclient, PDO::PARAM_STR);
                $stmt->execute();
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
              
                $response = array();

                if ($rows) {
                    $responseCount = array();
                    foreach ($rows as $val) {
                        $query = "select survey.surveyId,count(distinct(happiness.answeredBy)) as responseCount from Tbl_Analytic_Survey as happiness join Tbl_C_SurveyDetails as survey on happiness.surveyId=survey.surveyId where happiness.clientId=:cli and happiness.surveyId=:surveyId";
                        $stmt = $this->DB->prepare($query);
                        $stmt->bindParam(':cli', $this->idclient, PDO::PARAM_STR);
                        $stmt->bindParam(':surveyId', $val['surveyId'], PDO::PARAM_STR);
                        $stmt->execute();
                        $data = $stmt->fetch(PDO::FETCH_ASSOC);

                        array_push($responseCount, $data);
                    }

                    $response["success"] = 1;
                    $response["message"] = "You successfully fetched";
                    $response["posts"] = $rows;
                    $response["responseCount"] = $responseCount;
                    return json_encode($response);
                } else {
                    $response["success"] = 0;
                    $response["message"] = "data doesn't fetch";
                    return json_encode($response);
                }
            } catch (PDOException $e) {
                echo $e;
            }
        }
    }
    
    
    /******************** dispaly survey question detail in panel tab ***********************************/

    function surveyQuestionDetails($sid, $cid) {
        $this->idclient = $cid;
        $this->sid = $sid;
        //  $this->utype = $user_type;

        try {
            $query = "select *,DATE_FORMAT(createdDate,'%d %b %Y') as createdDate from Tbl_C_SurveyQuestion where surveyId=:sid";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':sid', $this->sid, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $response = array();

            if ($rows) {
                $response["success"] = 1;
                $response["message"] = "You successfully fetched";
                $response["posts"] = $rows;
                return json_encode($response);
            } else {
                $response["success"] = 0;
                $response["message"] = "data doesn't fetch";
                return json_encode($response);
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

    function getSurveyquestionresponse($sid, $qid) {
        try {
            $squery = "select tas.*,DATE_FORMAT(tas.answeredDate,'%d %b %Y') as answeredDate, tcs.question, tem.firstName,tem.lastName from Tbl_Analytic_Survey as tas join Tbl_EmployeeDetails_Master as tem on tem.employeeId = tas.answeredBy join Tbl_C_SurveyQuestion as tcs on tcs.questionId = tas.questionId where tas.surveyId = :sid and tas.questionId = :qid and tas.status = 1";

            $stmt2 = $this->DB->prepare($squery);
            $stmt2->bindParam(':sid', $sid, PDO::PARAM_STR);
            $stmt2->bindParam(':qid', $qid, PDO::PARAM_STR);         
            $stmt2->execute();
            $rows2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
          ///  print_r($rows2);
            
        } catch (Exception $ex) {
            echo $ex;
        }
        return json_encode($rows2);
    }

    function updateSurveyStatus($sid, $sta) {
        $this->sid = $sid;
        $this->status = $sta;

        try {
            $query1 = "update Tbl_C_SurveyDetails set status=:sta where surveyId =:sid1";
            $stmt1 = $this->DB->prepare($query1);
            $stmt1->bindParam(':sid1', $this->sid, PDO::PARAM_STR);
            $stmt1->bindParam(':sta', $this->status, PDO::PARAM_STR);
            $stmt1->execute();

            $query2 = "update Tbl_Analytic_PostSentToGroup set status=:sta2 where postId =:sid2 and flagType = 26";
            $stmt2 = $this->DB->prepare($query2);
            $stmt2->bindParam(':sid2', $this->sid, PDO::PARAM_STR);
            $stmt2->bindParam(':sta2', $this->status, PDO::PARAM_STR);
            $stmt2->execute();

            $query = "update Tbl_C_HappinessQuestion set status=:sta where surveyId =:sid";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':sid', $this->sid, PDO::PARAM_STR);
            $stmt->bindParam(':sta', $this->status, PDO::PARAM_STR);
            if ($stmt->execute()) {
                $response["success"] = 1;
                $response["message"] = "Survey status change now it is expire";
            }
        } catch (PDOException $e) {
            //  echo $e;
            $response["success"] = 0;
            $response["message"] = "there is some problem please contact info@benepik.com" . $e;
        }
        return json_encode($response);
    }

    
    
    /*****FOR GETTING survey analytic data for calling by surveyQuestionResult*************************** */
    
    
    function getGraphDataforRadio($qid, $sid) {
       
        try {
            $query = "select answer as name,count(answeredBy) as y from Tbl_Analytic_Survey where surveyId = :sid and questionId = :qid and status = 1 group by optionId";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':qid', $qid, PDO::PARAM_STR);
            $stmt->bindParam(':sid', $sid, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);


           $query1 = "select question from Tbl_C_SurveyQuestion where surveyId = :sid and questionId = :qid";

            $stmt1 = $this->DB->prepare($query1);
            $stmt1->bindParam(':qid', $qid, PDO::PARAM_STR);
//            $stmt1->bindParam(':cli', $clientid, PDO::PARAM_STR);
            $stmt1->bindParam(':sid', $sid, PDO::PARAM_STR);
            $stmt1->execute();
            $value = $stmt1->fetch(PDO::FETCH_ASSOC);

            $response["data"] = $rows;
             $response["question"] = $value;
        } catch (PDOException $e) {
            echo $e;
        }
      //  return json_encode($response);
       return json_encode( $response, JSON_NUMERIC_CHECK );
    }

    /******************************************************************/
    
    
      function getGraphDataforEmoji($qid, $sid) {
       
        //  echo "surveyid-".$sid;
        //  echo "questionid-".$qid;
        try {
            $query = "select answer as name,count(answeredBy) as y from Tbl_Analytic_Survey where surveyId = :sid and questionId = :qid and status = 1 group by answer";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':qid', $qid, PDO::PARAM_STR);
            $stmt->bindParam(':sid', $sid, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);


            $query1 = "select question from Tbl_C_SurveyQuestion where surveyId = :sid and questionId = :qid";

            $stmt1 = $this->DB->prepare($query1);
            $stmt1->bindParam(':qid', $qid, PDO::PARAM_STR);
            $stmt1->bindParam(':sid', $sid, PDO::PARAM_STR);
            $stmt1->execute();
            $value = $stmt1->fetch(PDO::FETCH_ASSOC);
          //  print_r($value);
            $response["data"] = $rows;
            $response["question"] = $value;
        } catch (PDOException $e) {
            echo $e;
        }
      //  return json_encode($response);
       return json_encode( $response, JSON_NUMERIC_CHECK );
    }
    
    
    /******************************************************************/
    
      function getGraphDataforWord($qid, $sid) {
       
        //  echo "surveyid-".$sid;
        //  echo "questionid-".$qid;
        try {
            $query = "select answer as comment from Tbl_Analytic_Survey where surveyId = :sid and questionId = :qid and status = 1 group by answeredBy";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':qid', $qid, PDO::PARAM_STR);
            $stmt->bindParam(':sid', $sid, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);


            $query1 = "select question from Tbl_C_SurveyQuestion where surveyId = :sid and questionId = :qid";

            $stmt1 = $this->DB->prepare($query1);
            $stmt1->bindParam(':qid', $qid, PDO::PARAM_STR);
            $stmt1->bindParam(':sid', $sid, PDO::PARAM_STR);
            $stmt1->execute();
            $value = $stmt1->fetch(PDO::FETCH_ASSOC);
          //  print_r($value);
            $response["data"] = $rows;
            $response["question"] = $value;
        } catch (PDOException $e) {
            echo $e;
        }
      //  return json_encode($response);
       return json_encode( $response, JSON_NUMERIC_CHECK );
    }
    
    
    /******************************************************************/
    
    
    
    
    
    
    function getSurveyquestion($qid, $clientid, $sid) {

        try {

            $query1 = "select question from Tbl_C_HappinessQuestion where clientId=:cli and surveyId = :sid and questionId = :qid";

            $stmt1 = $this->DB->prepare($query1);
            $stmt1->bindParam(':qid', $qid, PDO::PARAM_STR);
            $stmt1->bindParam(':cli', $clientid, PDO::PARAM_STR);
            $stmt1->bindParam(':sid', $sid, PDO::PARAM_STR);
            $stmt1->execute();
            $value = $stmt1->fetch(PDO::FETCH_ASSOC);


            // $response["question"] = $value;
        } catch (PDOException $e) {
            echo $e;
        }
        return json_encode($value);
    }

    function getSurveyResponse($qid, $clientid, $sid) {

        try {
            $query = "select *,DATE_FORMAT(createdDate,'%d %b %Y %h:%i %p') as createdDate from Tbl_Analytic_EmployeeHappiness where clientId=:cli and surveyId = :sid and questionId = :qid";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':qid', $qid, PDO::PARAM_STR);
            $stmt->bindParam(':cli', $clientid, PDO::PARAM_STR);
            $stmt->bindParam(':sid', $sid, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // print_r($rows);
            if (count($rows) > 0) {
                $response["success"] = 1;
                $response["data"] = $rows;
                // $response["question"] = $value;
            } else {
                $response["success"] = 0;
                $response["msg"] = "No Rresponse Found";
            }
        } catch (PDOException $e) {
            echo $e;
        }
        return json_encode($response);
    }

    /*     * ********************************************* */

    function getSurveyReminderUser($clientid, $sid) {
        // echo $clientid;
        // echo $sid;
        try {
            $query = "select * from Tbl_C_SurveyDetails where clientId=:cli and surveyId = :sid and status = 1";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cli', $clientid, PDO::PARAM_STR);
            $stmt->bindParam(':sid', $sid, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetch(PDO::FETCH_ASSOC);
//            echo "<pre>";
//               print_r($rows);

            if (count($rows) > 0) {

                $query2 = "select distinct(userUniqueId) from Tbl_Analytic_EmployeeHappiness where surveyId =:sid and clientId = :cli";
                $stmt1 = $this->DB->prepare($query2);
                $stmt1->bindParam(':cli', $clientid, PDO::PARAM_STR);
                $stmt1->bindParam(':sid', $sid, PDO::PARAM_STR);
                $stmt1->execute();
                $rows2 = $stmt1->fetchAll(PDO::FETCH_ASSOC);

                $emoveval = "";
                $val = "";

                foreach ($rows2 as $type) {
                    $val .= "'" . implode("', '", $type) . "',";
                }
                $emoveval = rtrim($val, ',');
//echo "respondent user-".$emoveval;
                if($emoveval == '')
                {
                    $query3 = "select distinct(postsent.userUniqueId) from Tbl_Analytic_PostSentTo as postsent where postsent.flagType = 26 and postsent.userUniqueId NOT IN ('". $emoveval ."')";
                }
 else {
                $query3 = "select distinct(postsent.userUniqueId) from Tbl_Analytic_PostSentTo as postsent where postsent.flagType = 26 and postsent.userUniqueId NOT IN (". $emoveval .")";
 }
             //   echo "-------------->".$query3."-------------";
                $stmt3 = $this->DB->prepare($query3);

                $stmt3->execute();
                $rows3 = $stmt3->fetchAll(PDO::FETCH_ASSOC);

                $data = array();
                foreach ($rows3 as $row4) {
                    array_push($data, $row4["userUniqueId"]);
                }

                if (count($rows) > 0) {

                    $response["success"] = 1;
                    $response["data"] = $data;
                    $response["survey"] = $rows;
                    // $response["question"] = $value;
                } else {
                    $response["success"] = 0;
                    $response["msg"] = "No Rresponse Found";
                    $response["data"] = $data;
                    $response["survey"] = $rows;
                }
            }
        } catch (PDOException $e) {
            echo $e;
        }
        return json_encode($response);
    }
    
    function SurveycommentDetails($sid, $cid) {
        $this->idclient = $cid;
        $this->sid = $sid;
        //  $this->utype = $user_type;

        try {
            $query = "select survey.surveyTitle, happiness.userUniqueId, happiness.comment, happiness.surveyId, avg(happiness.value) as avgRating from Tbl_Analytic_EmployeeHappiness as happiness join Tbl_C_SurveyDetails as survey on happiness.surveyId=survey.surveyId where happiness.clientId=:cli and happiness.surveyId=:sid group by happiness.userUniqueId";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cli', $this->idclient, PDO::PARAM_STR);
            $stmt->bindParam(':sid', $this->sid, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $response = array();

            if ($rows) {
                $response["success"] = 1;
                $response["message"] = "You successfully fetched";
                $response["posts"] = $rows;
                return json_encode($response);
            } else {
                $response["success"] = 0;
                $response["message"] = "data doesn't fetch";
                return json_encode($response);
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }
	
/************************************** update survey **************************************/
function SurveyStatusupdate($sid, $sta) {
        
        try {
            $query = "update Tbl_C_SurveyDetails set status=:sta where surveyId =:sid";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':sid', $sid, PDO::PARAM_STR);
            $stmt->bindParam(':sta', $sta, PDO::PARAM_STR);
            $stmt->execute();
			
			$query2 = "update Tbl_C_SurveyQuestion set status=:sta2 where surveyId =:sid2";
            $stmt2 = $this->DB->prepare($query2);
            $stmt2->bindParam(':sid2', $sid, PDO::PARAM_STR);
            $stmt2->bindParam(':sta2', $sta, PDO::PARAM_STR);
            $stmt2->execute();
			
			$query3 = "update Tbl_C_SurveyQuestionOption set status=:sta3 where surveyId =:sid3";
            $stmt3 = $this->DB->prepare($query3);
            $stmt3->bindParam(':sid3', $sid, PDO::PARAM_STR);
            $stmt3->bindParam(':sta3', $sta, PDO::PARAM_STR);
            $stmt3->execute();
	
            $query4 = "update Tbl_Analytic_PostSentToGroup set status=:sta4 where postId =:sid4 and flagType = 26";
            $stmt4 = $this->DB->prepare($query4);
            $stmt4->bindParam(':sid4', $sid, PDO::PARAM_STR);
            $stmt4->bindParam(':sta4', $sta, PDO::PARAM_STR);
            $res = $stmt4->execute();

            if ($res) {
                $response["success"] = 1;
                $response["message"] = "status has changed";
            }
			else
			{
				$response["success"] = 0;
                $response["message"] = "status not changed";
			}
        } catch (PDOException $e) {
            //  echo $e;
            $response["success"] = 0;
            $response["message"] = "there is some problem please contact info@benepik.com" . $e;
        }
        return json_encode($response);
    }
/************************************** / update survey ************************************/

/************************************** update previous survey **************************************/
function SurveyStatusupdateprevious($sid, $sta) {
        
        try {
            $query = "update Tbl_C_SurveyDetails set status=:sta where surveyId !=:sid";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':sid', $sid, PDO::PARAM_STR);
            $stmt->bindParam(':sta', $sta, PDO::PARAM_STR);
            $stmt->execute();
			
			$query2 = "update Tbl_C_SurveyQuestion set status=:sta2 where surveyId !=:sid2";
            $stmt2 = $this->DB->prepare($query2);
            $stmt2->bindParam(':sid2', $sid, PDO::PARAM_STR);
            $stmt2->bindParam(':sta2', $sta, PDO::PARAM_STR);
            $stmt2->execute();
			
			$query3 = "update Tbl_C_SurveyQuestionOption set status=:sta3 where surveyId !=:sid3";
            $stmt3 = $this->DB->prepare($query3);
            $stmt3->bindParam(':sid3', $sid, PDO::PARAM_STR);
            $stmt3->bindParam(':sta3', $sta, PDO::PARAM_STR);
            $stmt3->execute();
	
            $query4 = "update Tbl_Analytic_PostSentToGroup set status=:sta4 where postId !=:sid4 and flagType = 26";
            $stmt4 = $this->DB->prepare($query4);
            $stmt4->bindParam(':sid4', $sid, PDO::PARAM_STR);
            $stmt4->bindParam(':sta4', $sta, PDO::PARAM_STR);
            $res = $stmt4->execute();

            if ($res) {
                $response["success"] = 1;
                $response["message"] = "status has changed";
            }
			else
			{
				$response["success"] = 0;
                $response["message"] = "status not changed";
			}
        } catch (PDOException $e) {
            //  echo $e;
            $response["success"] = 0;
            $response["message"] = "there is some problem please contact info@benepik.com" . $e;
        }
        return json_encode($response);
    }
/************************************** / update previous survey ************************************/

}