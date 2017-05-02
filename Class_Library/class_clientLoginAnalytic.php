<?php

//error_reporting(E_ALL);
//ini_set('display_errors', 1);
include_once('class_connect_db_Communication.php');

class LoginAnalytic {

    public $db_connect;

    public function __construct() {
        $dbh = new Connection_Communication();
        $this->db_connect = $dbh->getConnection_Communication();
    }

    /*     * ********************* analytic get active user Details ******************************* */

    function graphGetActiveUser($client, $fromdt, $enddte) {
        try {

            $query = "SELECT count(userUniqueId) as totalview,count(distinct(userUniqueId)) as uniqueview,DATE_FORMAT(date_of_entry,'%d/%m/%Y') as date_of_entry FROM Tbl_Analytic_TrackUser where (DATE(date_of_entry) BETWEEN :fromdte AND :enddte) AND clientId = :client and description = 'Open Spalsh' group by DATE_FORMAT(date_of_entry,'%Y-%m-%d')";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':client', $client, PDO::PARAM_STR);
            $stmt->bindParam(':fromdte', $fromdt, PDO::PARAM_STR);
            $stmt->bindParam(':enddte', $enddte, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
         //     print_r($result);
            $response["categories"] = [];
            $response["data"] = [];
            foreach ($result as $res) {
                //  $response["categories"] = $res['date_of_entry'];
                //   $response["data"] = $res['totalview'];
                array_push($response["categories"], $res['date_of_entry']);
                array_push($response["data"], $res['uniqueview']);
            }
            //   print_r($response);
            return json_encode($response, JSON_NUMERIC_CHECK);
        } catch (PDOException $ex) {
            echo $ex;
        }
    }

    /*     * ********************** end analytic graph Job Details ************************** */

    function gettoppostforwelcome($clientid, $uid) {
     
        try {
            $query = "select count(userUniqueId),post_id,date_of_entry,flagType from Tbl_Analytic_PostView where clientId = :client group by flagType";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':client', $clientid, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
//            echo "<pre>";
//              print_r($result);
            $count = count($result);
         //   echo "this is count-" . $count;
            
            $welcomearray = array();
            for ($k = 0; $k < $count; $k++) 
            {
                $flag = $result[$k]['flagType'];
                $postid = $result[$k]['post_id'];
                $date = $result[$k]['date_of_entry'];
               
               
                switch ($flag) {
                    case 16:
                        $storyquery = "select * from Tbl_C_AchiverStory where storyId = :id";
                        $nstmt = $this->db_connect->prepare($storyquery);
                        $nstmt->bindParam(':id', $postid, PDO::PARAM_STR);
                        $nstmt->execute();
                        $data = $nstmt->fetch(PDO::FETCH_ASSOC);
                        if ($data) {
                            $data['module'] = "Colleague Story";
                            $data['flag'] = $flag;
                            $data['viewdate'] = $date;
                            array_push($welcomearray, $data);
                        }
                        break;
                        
                     case 11:
                        $storyquery = "select * from Tbl_C_AlbumDetails where albumId = :id";
                        $nstmt = $this->db_connect->prepare($storyquery);
                        $nstmt->bindParam(':id', $postid, PDO::PARAM_STR);
                        $nstmt->execute();
                        $data = $nstmt->fetch(PDO::FETCH_ASSOC);
                        if ($data) {
                            $data['module'] = "Album";
                             $data['flag'] = $flag;
                            $data['viewdate'] = $date;
                            array_push($welcomearray, $data);
                        }
                        break;   
                        
                       case 20:
                        $storyquery = "select * from Tbl_C_HappinessQuestion where questionId = :id";
                        $nstmt = $this->db_connect->prepare($storyquery);
                        $nstmt->bindParam(':id', $postid, PDO::PARAM_STR);
                        $nstmt->execute();
                        $data = $nstmt->fetch(PDO::FETCH_ASSOC);
                        if ($data) {
                            $data['module'] = "Happiness";
                             $data['flag'] = $flag;
                            $data['viewdate'] = $date;
                            array_push($welcomearray, $data);
                        }
                        break;     
                        
                         case 23:
                        $storyquery = "select * from Tbl_C_Feedback where feedbackId = :id";
                        $nstmt = $this->db_connect->prepare($storyquery);
                        $nstmt->bindParam(':id', $postid, PDO::PARAM_STR);
                        $nstmt->execute();
                        $data = $nstmt->fetch(PDO::FETCH_ASSOC);
                        if ($data) {
                            $data['module'] = "Feedback";
                             $data['flag'] = $flag;
                            $data['viewdate'] = $date;
                            array_push($welcomearray, $data);
                        }
                        break;
                        
                         case 26:
                        $storyquery = "select * from Tbl_C_SurveyDetails where surveyId = :id";
                        $nstmt = $this->db_connect->prepare($storyquery);
                        $nstmt->bindParam(':id', $postid, PDO::PARAM_STR);
                        $nstmt->execute();
                        $data = $nstmt->fetch(PDO::FETCH_ASSOC);
                        if ($data) {
                            $data['module'] = "Survey";
                             $data['flag'] = $flag;
                            $data['viewdate'] = $date;
                            array_push($welcomearray, $data);
                        }
                        break;
                        
                    default:  "Invalid data";
                       
                }
            }
           
         
            } catch (Exception $exc) {
            echo $exc;
        }
        return $welcomearray;
    }
    
    /*************************************************************/
    
     function graphGetHappinessIndex($client, $fromdt,$enddate) 
                {
         
         $query = "select * from Tbl_C_HappinessQuestion where expiryDate < :enddte order by questionId desc limit 1";
          $stmt = $this->db_connect->prepare($query);
           
          $stmt->bindParam(':enddte', $enddate, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
//            echo "<pre>";
//            print_r($result);
         $questionid = $result['questionId'];
         $surveyid = $result['surveyId'];
         $clientId = $result['clientId'];
          try {
             
            $query = "SELECT value as name,count(userUniqueId) as y FROM Tbl_Analytic_EmployeeHappiness where surveyId = :sid AND clientId = :client and questionId = :qid and status = 1 group by value";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':client', $clientId, PDO::PARAM_STR);
            $stmt->bindParam(':sid', $surveyid, PDO::PARAM_STR);
            $stmt->bindParam(':qid', $questionid, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
          //  print_r($result);
          
            $response["data"] = $result;
          
        } catch (PDOException $ex) {
            echo $ex;
        }
          return json_encode($response, JSON_NUMERIC_CHECK);
    }

}

?>