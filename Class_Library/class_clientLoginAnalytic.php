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

    function graphGetActiveUser($client, $fromdt, $enddte , $department,$location) {
        try {

			$query = "SELECT count(track.userUniqueId) as totalview,count(distinct(track.userUniqueId)) as uniqueview,DATE_FORMAT(track.date_of_entry,'%d/%m/%Y') as date_of_entry FROM Tbl_Analytic_TrackUser as track JOIN Tbl_EmployeeDetails_Master as edm ON track.userUniqueId = edm.employeeId where (DATE(track.date_of_entry) BETWEEN :fromdte AND :enddte) AND track.clientId = :client and track.description = 'Open Spalsh'";
		 
                    if ($department == 'All' && $location == 'All'){
                $query .= "";}
				
			if ($department != 'All' && $location != 'All'){
                $query .= " AND edm.department = :dept AND edm.location = :loca";}
				
			if ($department == 'All' && $location != 'All'){
                $query .= " AND edm.location = :loca";}
				
			if ($department != 'All' && $location == 'All'){
                $query .= " AND edm.department = :dept";}
			
		$query .= " group by DATE_FORMAT(track.date_of_entry,'%Y-%m-%d')";
                   
                 //  echo $query;
                   
                   
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':client', $client, PDO::PARAM_STR);
            $stmt->bindParam(':fromdte', $fromdt, PDO::PARAM_STR);
            $stmt->bindParam(':enddte', $enddte, PDO::PARAM_STR);
	  
            if ($department != 'All') {$stmt->bindParam(':dept', $department, PDO::PARAM_STR);}
	    if ($location != 'All') {$stmt->bindParam(':loca', $location, PDO::PARAM_STR);}
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
            $query = "select count(userUniqueId) as totalview,post_id,date_of_entry,flagType from Tbl_Analytic_PostView where clientId = :client group by post_id order by count(userUniqueId) desc limit 5";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':client', $clientid, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
//           echo "<pre>";
//            print_r($result);
//           
            $count = count($result);
//            echo "this is count-" . $count;
//             
            $welcomearray = array();
            for ($k = 0; $k < $count; $k++) 
            {
                $flag = $result[$k]['flagType'];
                $postid = $result[$k]['post_id'];
                $date = $result[$k]['date_of_entry'];
                $totalview = $result[$k]['totalview'];
              
                switch ($flag) {
                    case 16:
                        $storyquery = "select tcs.title,count(tpl.likeBy) as totallike from Tbl_C_AchiverStory as tcs join Tbl_Analytic_PostLike as tpl on tpl.postId = tcs.storyId and tpl.flagType = tcs.flagType where tpl.status = 1 and tcs.storyId = :id";
                        $nstmt = $this->db_connect->prepare($storyquery);
                        $nstmt->bindParam(':id', $postid, PDO::PARAM_STR);
                        $nstmt->execute();
                        $data = $nstmt->fetch(PDO::FETCH_ASSOC);
                        if ($data) {
                            $data['module'] = "Achiver Story";
                            $data['flag'] = $flag;
                            $data['viewdate'] = $date;
                            $data['totalview'] = $totalview;
                           // array_push($welcomearray, $data);
                        }
                        /********************** comment ***************************/
                         $storyquery1 = "select count(tpc.commentBy) as totalcomment from Tbl_C_AchiverStory as tcs join Tbl_Analytic_PostComment as tpc on tpc.postId = tcs.storyId and tpc.flagType = tcs.flagType where tpc.status = 'Show' and tcs.storyId = :id";
                        $nstmt1 = $this->db_connect->prepare($storyquery1);
                        $nstmt1->bindParam(':id', $postid, PDO::PARAM_STR);
                        $nstmt1->execute();
                        $data1 = $nstmt1->fetch(PDO::FETCH_ASSOC);
                        if ($data1) {
                            $data['totalcomment'] = $data1['totalcomment'];
                          
                            array_push($welcomearray, $data);
                        }
                        
                        break;
                        
                     case 11:
                        $storyquery = "select tca.title, count(tal.userId) as totallike from Tbl_C_AlbumDetails as tca join Tbl_Analytic_AlbumLike as tal on tal.albumId = tca.albumId where tca.albumId = :id and tal.status = 1";
                        $nstmt = $this->db_connect->prepare($storyquery);
                        $nstmt->bindParam(':id', $postid, PDO::PARAM_STR);
                        $nstmt->execute();
                        $data = $nstmt->fetch(PDO::FETCH_ASSOC);
                        if ($data) {
                            $data['module'] = "Album";
                             $data['flag'] = $flag;
                            $data['viewdate'] = $date;
                            $data['totalview'] = $totalview;
                                                  }
                        /****************************************/
                        $storyquery1 = "select count(tac.albumId) as totalcomment from Tbl_C_AlbumDetails as tca join Tbl_Analytic_AlbumComment as tac on tac.albumId = tca.albumId where tca.albumId = :id and tac.status = 1";
                        $nstmt1 = $this->db_connect->prepare($storyquery1);
                        $nstmt1->bindParam(':id', $postid, PDO::PARAM_STR);
                        $nstmt1->execute();
                        $data1 = $nstmt1->fetch(PDO::FETCH_ASSOC);
                        if ($data1) {
                           
                            $data['totalcomment'] = $data1['totalcomment'];
                            array_push($welcomearray, $data);
                        }
                        break;                  
                        
                         case 23:
                        $storyquery = "select tcf.feedbackQuestion,count(tfl.employeeId) as totallike from Tbl_C_Feedback as tcf join Tbl_C_FeedbackCommentLikes as tfl on tfl.feedbackId = tcf.feedbackId where tcf.feedbackId = :id";
                        $nstmt = $this->db_connect->prepare($storyquery);
                        $nstmt->bindParam(':id', $postid, PDO::PARAM_STR);
                        $nstmt->execute();
                        $data = $nstmt->fetch(PDO::FETCH_ASSOC);
                        if ($data) {
                            $data['module'] = "Feedback";
                             $data['flag'] = $flag;
                            $data['viewdate'] = $date;
                            $data['totalview'] = $totalview;
                          //  array_push($welcomearray, $data);
                        }
                        /****************************/
                        
                         $storyquery1 = "select count(tfc.commentBy) as totalcomment from Tbl_C_Feedback as tcf join Tbl_C_FeedbackComments as tfc on tfc.feedbackId = tcf.feedbackId where tfc.feedbackId = :id and tfc.status = 1";
                        $nstmt1 = $this->db_connect->prepare($storyquery1);
                        $nstmt1->bindParam(':id', $postid, PDO::PARAM_STR);
                        $nstmt1->execute();
                        $data1 = $nstmt1->fetch(PDO::FETCH_ASSOC);
                        if ($data1) {
                           
                            $data['totalcomment'] = $data1['totalcomment'];
                            array_push($welcomearray, $data);
                        }
                        break;
                        
                         case 24:
                        $storyquery = "select * from Tbl_HealthWellness where exercise_area_id = :id";
                        $nstmt = $this->db_connect->prepare($storyquery);
                        $nstmt->bindParam(':id', $postid, PDO::PARAM_STR);
                        $nstmt->execute();
                        $data = $nstmt->fetch(PDO::FETCH_ASSOC);
                        if ($data) {
                            $data['module'] = "Health & Wellness";
                             $data['flag'] = $flag;
                            $data['viewdate'] = $date;
                              $data['totalview'] = $totalview;
                             $data['totallike'] = '0';
                             $data['totalcomment'] = '0';
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
    
     function graphGetHappinessIndex($client, $fromdt, $enddate, $department) 
                {
         
         $query = "select * from Tbl_C_HappinessQuestion where expiryDate < :enddte order by surveyId desc limit 1";
          $stmt = $this->db_connect->prepare($query);
           
          $stmt->bindParam(':enddte', $enddate, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            //echo "<pre>";
            //print_r($result);
            $questionid = $result['surveyId'];
			$surveyid = $result['surveyId'];
			$clientId = $result['clientId'];
            try {  
			if($department == "All")
			{
            $query = "SELECT value as name,count(userUniqueId) as y FROM Tbl_Analytic_EmployeeHappiness where surveyId = :sid AND clientId = :client and questionId = :qid and status = 1 group by value";
			}
			else
			{
			 $query = "SELECT analytichapp.value as name,count(analytichapp.userUniqueId) as y FROM Tbl_Analytic_EmployeeHappiness as analytichapp JOIN Tbl_EmployeeDetails_Master as edm ON analytichapp.userUniqueId = edm.employeeId where analytichapp.surveyId = :sid AND analytichapp.clientId = :client and analytichapp.questionId = :qid and analytichapp.status = 1 AND edm.department = :department group by analytichapp.value";	
			}
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':client', $clientId, PDO::PARAM_STR);
            $stmt->bindParam(':sid', $surveyid, PDO::PARAM_STR);
            $stmt->bindParam(':qid', $questionid, PDO::PARAM_STR);
			if($department != "All"){$stmt->bindParam(':department', $department, PDO::PARAM_STR);}
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
