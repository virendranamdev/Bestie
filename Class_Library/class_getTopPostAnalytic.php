<?php

include_once('class_connect_db_Communication.php');

class TopPostAnalytic {

    public $db_connect;

    public function __construct() {
        $dbh = new Connection_Communication();
        $this->db_connect = $dbh->getConnection_Communication();
    }


 function getTopPostForAnalytic($client, $fromdt, $enddte,$department,$location) {
     
        try {
           
                  $query = "select count(tap.userUniqueId) as totalview,tap.post_id,tap.date_of_entry,tap.flagType from Tbl_Analytic_PostView as tap join Tbl_EmployeeDetails_Master as tem on tem.employeeId = tap.userUniqueId where (DATE(tap.date_of_entry) BETWEEN :fromdte AND :enddte) and tap.clientId = :client";
           
              if ($department == 'All' && $location == 'All'){
                $query .= "";}
				
			if ($department != 'All' && $location != 'All'){
                $query .= " AND tem.department = :dept AND tem.location = :loca";}
				
			if ($department == 'All' && $location != 'All'){
                $query .= " AND tem.location = :loca";}
				
			if ($department != 'All' && $location == 'All'){
                $query .= " AND tem.department = :dept";}
			
		$query .= " group by tap.post_id , tap.flagType order by count(tap.userUniqueId) desc";
            
            
            
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':client', $client, PDO::PARAM_STR);
            $stmt->bindParam(':fromdte', $fromdt, PDO::PARAM_STR);
            $stmt->bindParam(':enddte', $enddte, PDO::PARAM_STR);
            if ($department != 'All') {$stmt->bindParam(':dept', $department, PDO::PARAM_STR);}
	    if ($location != 'All') {$stmt->bindParam(':loca', $location, PDO::PARAM_STR);}
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
//			echo "<pre>";
//            print_r($result);
			//die;
//           
            $count = count($result);
        //   echo "this is count-" . $count;
//             
            $welcomearray = array();
            for ($k = 0; $k < $count; $k++) 
            {
             //  echo "from date-".$fromdt."<br/>";
             //  echo "end date-".$enddte;
                $flag = $result[$k]['flagType'];
                $postid = $result[$k]['post_id'];
                $date = $result[$k]['date_of_entry'];
                $totalview = $result[$k]['totalview'];
          // echo "flag->".$flag."-this is post id ->".$postid."-this is date->".$date."-totalview->".$totalview."<br/>";  
                switch ($flag) {
                    case 16:
                        $storyquery = "select tcs.title,DATE_FORMAT(tcs.createdDate,'%d %b %Y') as createdDate,count(tpl.likeBy) as totallike from Tbl_C_AchiverStory as tcs join Tbl_Analytic_PostLike as tpl on tpl.postId = tcs.storyId and tpl.flagType = tcs.flagType join Tbl_EmployeeDetails_Master as tem on tem.employeeId = tpl.likeBy where tpl.status = 1 and tcs.storyId = :id and (DATE(tpl.likeDate) BETWEEN :fromdte AND :enddte)";
                        if ($department == 'All' && $location == 'All'){
                $storyquery .= "";}
				
			if ($department != 'All' && $location != 'All'){
                $storyquery .= " AND tem.department = :dept AND tem.location = :loca";}
				
			if ($department == 'All' && $location != 'All'){
                $storyquery .= " AND tem.location = :loca";}
				
			if ($department != 'All' && $location == 'All'){
                $storyquery .= " AND tem.department = :dept";}
                
                        $nstmt = $this->db_connect->prepare($storyquery);
                        $nstmt->bindParam(':id', $postid, PDO::PARAM_STR);
                         $nstmt->bindParam(':fromdte', $fromdt, PDO::PARAM_STR);
                         $nstmt->bindParam(':enddte', $enddte, PDO::PARAM_STR);
                        if ($department != 'All') {$nstmt->bindParam(':dept', $department, PDO::PARAM_STR);}
	                if ($location != 'All') {$nstmt->bindParam(':loca', $location, PDO::PARAM_STR);}
                        $nstmt->execute();
                        $data = $nstmt->fetch(PDO::FETCH_ASSOC);
                        if (count($data)>0) {
                            $data['module'] = "Achiver Story";
                            $data['flag'] = $flag;
                            $data['viewdate'] = $date;
                            $data['totalview'] = $totalview;
                           // array_push($welcomearray, $data);
                        }
                        /********************** comment ***************************/
                         $storyquery1 = "select count(tpc.commentBy) as totalcomment from Tbl_C_AchiverStory as tcs join Tbl_Analytic_PostComment as tpc on tpc.postId = tcs.storyId and tpc.flagType = tcs.flagType join Tbl_EmployeeDetails_Master as tem on tem.employeeId = tpc.commentBy where tpc.status = 'Show' and tcs.storyId = :id and (DATE(tpc.commentDate) BETWEEN :fromdte AND :enddte)";
                         
                          if ($department == 'All' && $location == 'All'){
                $storyquery1 .= "";}
				
			if ($department != 'All' && $location != 'All'){
                $storyquery1 .= " AND tem.department = :dept AND tem.location = :loca";}
				
			if ($department == 'All' && $location != 'All'){
                $storyquery1 .= " AND tem.location = :loca";}
				
			if ($department != 'All' && $location == 'All'){
                $storyquery1 .= " AND tem.department = :dept";}
                
                        $nstmt1 = $this->db_connect->prepare($storyquery1);
                        $nstmt1->bindParam(':id', $postid, PDO::PARAM_STR);
                         $nstmt1->bindParam(':fromdte', $fromdt, PDO::PARAM_STR);
                         $nstmt1->bindParam(':enddte', $enddte, PDO::PARAM_STR);
                        if ($department != 'All') {$nstmt1->bindParam(':dept', $department, PDO::PARAM_STR);}
	                if ($location != 'All') {$nstmt1->bindParam(':loca', $location, PDO::PARAM_STR);}
                        $nstmt1->execute();
                        $data1 = $nstmt1->fetch(PDO::FETCH_ASSOC);
                        if ($data1) {
                            $data['totalcomment'] = $data1['totalcomment'];
                          
                            array_push($welcomearray, $data);
                        }
                        
                        break;
                        
                     case 11:
                        $storyquery = "select tca.title,DATE_FORMAT(tca.createdDate,'%d %b %Y') as createdDate,count(tal.userId) as totallike from Tbl_C_AlbumDetails as tca join Tbl_Analytic_AlbumLike as tal on tal.albumId = tca.albumId join Tbl_EmployeeDetails_Master as tem on tem.employeeId = tal.userId where tca.albumId = :id and tal.status = 1 and (DATE(tal.createdDate) BETWEEN :fromdte AND :enddte)";
                         
                           if ($department == 'All' && $location == 'All'){
                $storyquery .= "";}
				
			if ($department != 'All' && $location != 'All'){
                $storyquery .= " AND tem.department = :dept AND tem.location = :loca";}
				
			if ($department == 'All' && $location != 'All'){
                $storyquery .= " AND tem.location = :loca";}
				
			if ($department != 'All' && $location == 'All'){
                $storyquery .= " AND tem.department = :dept";}
                         
                        $nstmt = $this->db_connect->prepare($storyquery);
                        $nstmt->bindParam(':id', $postid, PDO::PARAM_STR);
                        $nstmt->bindParam(':fromdte', $fromdt, PDO::PARAM_STR);
                        $nstmt->bindParam(':enddte', $enddte, PDO::PARAM_STR);
                        if ($department != 'All') {$nstmt->bindParam(':dept', $department, PDO::PARAM_STR);}
	                if ($location != 'All') {$nstmt->bindParam(':loca', $location, PDO::PARAM_STR);}
                        $nstmt->execute();
                        $data = $nstmt->fetch(PDO::FETCH_ASSOC);
                        if ($data) {
                            $data['module'] = "Album";
                             $data['flag'] = $flag;
                            $data['viewdate'] = $date;
                            $data['totalview'] = $totalview;
                                                  }
                        /****************************************/
                        $storyquery1 = "select count(tac.albumId) as totalcomment from Tbl_C_AlbumDetails as tca join Tbl_Analytic_AlbumComment as tac on tac.albumId = tca.albumId join Tbl_EmployeeDetails_Master as tem on tem.employeeId = tac.userId where tca.albumId = :id and tac.status = 1 and (DATE(tac.createdDate) BETWEEN :fromdte AND :enddte)";
                        
                        if ($department == 'All' && $location == 'All'){
                $storyquery1 .= "";}
				
			if ($department != 'All' && $location != 'All'){
                $storyquery1 .= " AND tem.department = :dept AND tem.location = :loca";}
				
			if ($department == 'All' && $location != 'All'){
                $storyquery1 .= " AND tem.location = :loca";}
				
			if ($department != 'All' && $location == 'All'){
                $storyquery1 .= " AND tem.department = :dept";}
                        
                        $nstmt1 = $this->db_connect->prepare($storyquery1);
                        $nstmt1->bindParam(':id', $postid, PDO::PARAM_STR);
                        $nstmt1->bindParam(':fromdte', $fromdt, PDO::PARAM_STR);
                        $nstmt1->bindParam(':enddte', $enddte, PDO::PARAM_STR);
                        if ($department != 'All') {$nstmt1->bindParam(':dept', $department, PDO::PARAM_STR);}
	                if ($location != 'All') {$nstmt1->bindParam(':loca', $location, PDO::PARAM_STR);}
                        $nstmt1->execute();
                        $data1 = $nstmt1->fetch(PDO::FETCH_ASSOC);
                        if ($data1) {
                           
                            $data['totalcomment'] = $data1['totalcomment'];
                            array_push($welcomearray, $data);
                        }
                        break;                  
                        
                         case 23:
                        $storyquery = "select tcf.feedbackQuestion,DATE_FORMAT(tcf.createdDate,'%d %b %Y') as createdDate,count(tfl.employeeId) as totallike from Tbl_C_Feedback as tcf join Tbl_C_FeedbackCommentLikes as tfl on tfl.feedbackId = tcf.feedbackId join Tbl_EmployeeDetails_Master as tem on tem.employeeId = tfl.employeeId where tcf.feedbackId = :id and DATE(tfl.createdDate) BETWEEN :fromdte AND :enddte";
                             
                               if ($department == 'All' && $location == 'All'){
                $storyquery .= "";}
				
			if ($department != 'All' && $location != 'All'){
                $storyquery .= " AND tem.department = :dept AND tem.location = :loca";}
				
			if ($department == 'All' && $location != 'All'){
                $storyquery .= " AND tem.location = :loca";}
				
			if ($department != 'All' && $location == 'All'){
                $storyquery .= " AND tem.department = :dept";}
                             
                             
                        $nstmt = $this->db_connect->prepare($storyquery);
                        $nstmt->bindParam(':id', $postid, PDO::PARAM_STR);
                         $nstmt->bindParam(':fromdte', $fromdt, PDO::PARAM_STR);
                         $nstmt->bindParam(':enddte', $enddte, PDO::PARAM_STR);
                        if ($department != 'All') {$nstmt->bindParam(':dept', $department, PDO::PARAM_STR);}
	                if ($location != 'All') {$nstmt->bindParam(':loca', $location, PDO::PARAM_STR);}
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
                        
                         $storyquery1 = "select count(tfc.commentBy) as totalcomment from Tbl_C_Feedback as tcf join Tbl_C_FeedbackComments as tfc on tfc.feedbackId = tcf.feedbackId join Tbl_EmployeeDetails_Master as tem on tem.employeeId = tfc.commentBy where tfc.feedbackId = :id and tfc.status = 1 and (DATE(tfc.CommentDate) BETWEEN :fromdte AND :enddte)";
                         
                          if ($department == 'All' && $location == 'All'){
                $storyquery1 .= "";}
				
			if ($department != 'All' && $location != 'All'){
                $storyquery1 .= " AND tem.department = :dept AND tem.location = :loca";}
				
			if ($department == 'All' && $location != 'All'){
                $storyquery1 .= " AND tem.location = :loca";}
				
			if ($department != 'All' && $location == 'All'){
                $storyquery1 .= " AND tem.department = :dept";}
                         
                        $nstmt1 = $this->db_connect->prepare($storyquery1);
                        $nstmt1->bindParam(':id', $postid, PDO::PARAM_STR);
                         $nstmt1->bindParam(':fromdte', $fromdt, PDO::PARAM_STR);
                         $nstmt1->bindParam(':enddte', $enddte, PDO::PARAM_STR);
                        if ($department != 'All') {$nstmt1->bindParam(':dept', $department, PDO::PARAM_STR);}
	                if ($location != 'All') {$nstmt1->bindParam(':loca', $location, PDO::PARAM_STR);}
                        $nstmt1->execute();
                        $data1 = $nstmt1->fetch(PDO::FETCH_ASSOC);
                        if ($data1) {
                           
                            $data['totalcomment'] = $data1['totalcomment'];
                            array_push($welcomearray, $data);
                        }
                        break;
                        
                         case 24:
                        $storyquery = "select *,DATE_FORMAT(create_date,'%d %b %Y') as createdDate from Tbl_HealthWellness where exercise_area_id = :id";
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
      //  echo "<pre>";
      //  print_r($welcomearray);
        return json_encode($welcomearray,JSON_NUMERIC_CHECK);
      
        
}


/*************************** get top view list *******************************/

function getViewListAnalytic($client, $fromdt, $enddte,$department,$location) {
     
        try {
                $query = "select count(tap.userUniqueId) as totalview, count(DISTINCT tap.userUniqueId) as uniqueview , tap.flagType , flag.moduleName from Tbl_Analytic_TrackUser as tap JOIN FlagMaster as flag ON tap.flagType = flag.flagId join Tbl_EmployeeDetails_Master as tem on tem.employeeId = tap.userUniqueId where (DATE(tap.date_of_entry) BETWEEN :fromdte AND :enddte) and tap.clientId = :client";
           
                if ($department == 'All' && $location == 'All'){
                $query .= "";}
				
				if ($department != 'All' && $location != 'All'){
					$query .= " AND tem.department = :dept AND tem.location = :loca";}
					
				if ($department == 'All' && $location != 'All'){
					$query .= " AND tem.location = :loca";}
					
				if ($department != 'All' && $location == 'All'){
					$query .= " AND tem.department = :dept";}
			
				$query .= " group by tap.flagType order by count(tap.userUniqueId) desc";
            
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':client', $client, PDO::PARAM_STR);
            $stmt->bindParam(':fromdte', $fromdt, PDO::PARAM_STR);
            $stmt->bindParam(':enddte', $enddte, PDO::PARAM_STR);
            if ($department != 'All') {$stmt->bindParam(':dept', $department, PDO::PARAM_STR);}
			if($location != 'All') {$stmt->bindParam(':loca', $location, PDO::PARAM_STR);}
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            } catch (Exception $exc) {
            echo $exc;
        }
          return json_encode($result,JSON_NUMERIC_CHECK);
      
        
}

/*************************** / get top view list *****************************/


}
?>