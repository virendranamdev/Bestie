<?php

if (!class_exists('Connection_Communication')) {
    include_once('class_connect_db_Communication.php');
}
include_once('class_find_groupid.php');  // this class for get group id on the base of unique id

class PostDisplayWelcome {

    public $DB;

    public function __construct() {
        $db = new Connection_Communication();
        $this->DB = $db->getConnection_Communication();
    }

    function PostDisplay($clientid, $uid, $start) {

        $this->idclient = $clientid;
//        $this->value = $val;

        $querycheck = "select * from Tbl_EmployeeDetails_Master where clientId=:cli and employeeId=:empid and status = 'Active'";
        $stmt = $this->DB->prepare($querycheck);
        $stmt->bindParam(':cli', $this->idclient, PDO::PARAM_STR);
        $stmt->bindParam(':empid', $uid, PDO::PARAM_STR);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
//        echo "<pre>";
//        print_r($rows);
        if (count($rows) > 0) {

            $group_object = new findGroup();    // this is object to find group id of given unique id 
            $getgroup = $group_object->groupBaseofUid($clientid, $uid);
            $value = json_decode($getgroup, true);

            //   $in = implode("', '", array_unique($value['groups']));

            /*             * *********************************************************************************************** */

            $count_group = count($value['groups']);

            if ($count_group <= 0) {

                $result["success"] = 0;
                $result["message"] = "No More Post Available";
                return $result;
            } else {
                $in = implode("', '", array_unique($value['groups']));
                //echo "group array : ".$in."<br/>";
                $useraccess = $rows[0]['accessibility'];

                /*                 * ************************ start data for guest user  ***************************************** */

                if ($useraccess == 'guestuser') {
                    try {
                        $welcomequery = "select *, DATE_FORMAT(createdDate,'%d %b %Y %h:%i %p') as createdDate from Tbl_C_WelcomeDetails where clientId =:cid and status = 1 order by autoId desc";

                        $welstmt = $this->DB->prepare($welcomequery);
                        $welstmt->bindParam(':cid', $this->idclient, PDO::PARAM_STR);
                        $welstmt->execute();
                        $welrows = $welstmt->fetchAll(PDO::FETCH_ASSOC);
                        // print_r($welrows);
                        $welcomearray = array();
                        $welcount = count($welrows);
//echo "total post ".$welcount."<br/>";

			/*
                        for ($w = 0; $w < $welcount; $w++) {
                            //$welcomearray1["PostType"] = array();
                            $welcomearray1["PostData"] = array();
                            $weltype = $welrows[$w]['type'];
                            $welid = $welrows[$w]['id'];
                            $site_url = site_url;
                            switch ($weltype) {

//                        Display News Code                                                                                            
                                case ($weltype == "News" || $weltype == "Picture" || $weltype == "Message"):

                                    $eventquery = "select * from Tbl_Analytic_PostSentToGroup where groupId IN('" . $in . "') and postId =:id and clientId =:cid and status = 1";
                                    $nstmt = $this->DB->prepare($eventquery);
                                    $nstmt->bindParam(':cid', $this->idclient, PDO::PARAM_STR);
                                    $nstmt->bindParam(':id', $welid, PDO::PARAM_STR);
                                    $nstmt->execute();
                                    $postrows = $nstmt->fetchAll(PDO::FETCH_ASSOC);
//                                Concat('$site_url', post_img) as post_img
                                    if (count($postrows) > 0) {
                                        // $newsquery = "select *, Concat(:type,'') as type ,  if(thumb_post_img IS NULL or thumb_post_img='' , Concat('$site_url',post_img),Concat('$site_url',thumb_post_img) ) as post_img, DATE_FORMAT(created_date,'%d %b %Y') as created_date from Tbl_C_PostDetails  where post_id =:id and clientId =:cid";

                                        $newsquery = "select *, Concat(:type,'') as type , if(post_img IS NULL or post_img = '','',Concat('$site_url',post_img)) as post_img, DATE_FORMAT(created_date,'%d %b %Y') as created_date from Tbl_C_PostDetails  where post_id =:id and clientId =:cid";
                                        $nstmt = $this->DB->prepare($newsquery);
                                        $nstmt->bindParam(':cid', $this->idclient, PDO::PARAM_STR);
                                        $nstmt->bindParam(':id', $welid, PDO::PARAM_STR);
                                        $nstmt->bindParam(':type', $weltype, PDO::PARAM_STR);

                                        $nstmt->execute();
                                        $val = $nstmt->fetch(PDO::FETCH_ASSOC);
                                        $userid = $val['userUniqueId'];

                                        $imgquery = "select ud.firstName, if(up.userImage IS NULL or up.userImage = '','',concat('$site_url',up.userImage)) as UserImage from Tbl_EmployeeDetails_Master as ud join Tbl_EmployeePersonalDetails as up on up.employeeId = ud.employeeId where ud.clientId=:cli and ud.employeeId=:empid";
                                        $stmt = $this->DB->prepare($imgquery);
                                        $stmt->bindParam(':cli', $this->idclient, PDO::PARAM_STR);
                                        $stmt->bindParam(':empid', $userid, PDO::PARAM_STR);
                                        $stmt->execute();
                                        $rows = $stmt->fetch(PDO::FETCH_ASSOC);
//$val["UserName"]=$rows["firstName"];
                                        $val["UserImage"] = $rows["UserImage"];
                                        $val["module"] = "Message";

                                        array_push($welcomearray, $val);

                                        //   print_r($val);
                                    }
                                    break;

//                        Display CEO Message                             
                                case "CEOMessage":
                                    $eventquery = "select * from Tbl_Analytic_PostSentToGroup where groupId IN('" . $in . "') and postId =:id and clientId =:cid and status = 1";
                                    $nstmt = $this->DB->prepare($eventquery);
                                    $nstmt->bindParam(':cid', $this->idclient, PDO::PARAM_STR);
                                    $nstmt->bindParam(':id', $welid, PDO::PARAM_STR);
                                    $nstmt->execute();
                                    $postrows = $nstmt->fetchAll(PDO::FETCH_ASSOC);
//                                Concat('$site_url', post_img) as post_img
                                    if (count($postrows) > 0) {

                                        $eventquery1 = "select *,Concat('CEOMessage','') as type, DATE_FORMAT(created_date,'%d %b %Y') as created_date, if(post_img IS NULL or post_img='','', Concat('$site_url',post_img)) as post_img from Tbl_C_PostDetails where Post_id =:id and clientId =:cid and flagCheck = 9";
                                        $nstmt = $this->DB->prepare($eventquery1);
                                        $nstmt->bindParam(':cid', $this->idclient, PDO::PARAM_STR);
                                        $nstmt->bindParam(':id', $welid, PDO::PARAM_STR);
                                        $nstmt->execute();
                                        $val1 = $nstmt->fetch(PDO::FETCH_ASSOC);
                                        $userid = $val1['userUniqueId'];

                                        $imgquery = "select ud.firstName, if(up.userImage IS NULL or up.userImage = '','',concat('$site_url',up.userImage)) as UserImage from Tbl_EmployeeDetails_Master as ud join Tbl_EmployeePersonalDetails as up on up.employeeId = ud.employeeId where ud.clientId=:cli and ud.employeeId=:empid";
                                        $stmt = $this->DB->prepare($imgquery);
                                        $stmt->bindParam(':cli', $this->idclient, PDO::PARAM_STR);
                                        $stmt->bindParam(':empid', $userid, PDO::PARAM_STR);
                                        $stmt->execute();
                                        $rows = $stmt->fetch(PDO::FETCH_ASSOC);
//$val["UserName"]=$rows["firstName"];
                                        $val1["UserImage"] = $rows["UserImage"];
                                        $val1["module"] = "Leadership Connect";

                                        array_push($welcomearray, $val1);
                                        break;
                                    }

                                default: "Invalid data";
                            }
                        }
                        */
                    } catch (PDOException $e) {
                        echo $e;
                        $result['success'] = 0;
                        $result['message'] = "data not fount found";
                        return $result;
                    }
                } else {
                    /*                     * ************************************************************************************************* */
                    try {
                        $welcomequery = "select *, DATE_FORMAT(createdDate,'%d %b %Y %h:%i %p') as createdDate from Tbl_C_WelcomeDetails where clientId =:cid and status = 1 order by autoId desc";

                        $welstmt = $this->DB->prepare($welcomequery);
                        $welstmt->bindParam(':cid', $this->idclient, PDO::PARAM_STR);
                        $welstmt->execute();
                        $welrows = $welstmt->fetchAll(PDO::FETCH_ASSOC);
                        // print_r($welrows);  
                        $welcomearray = array();
                        $welcount = count($welrows);
//echo "total post ".$welcount."<br/>";
                        for ($w = 0; $w < $welcount; $w++) {
                            //$welcomearray1["PostType"] = array();
                            $welcomearray1["PostData"] = array();
                            $weltype = $welrows[$w]['type'];
                            $welid = $welrows[$w]['id'];
                            $site_url = site_url;

                            switch ($weltype) {
                                /*
                                  //                          Notice
                                  case "Notice":
                                  $noticequery = "select * from Tbl_Analytic_NoticeSentToGroup where groupId IN('" . $in . "') and noticeId =:id and clientId =:cid and status = 1";
                                  $nstmt = $this->DB->prepare($noticequery);
                                  $nstmt->bindParam(':cid', $this->idclient, PDO::PARAM_STR);
                                  $nstmt->bindParam(':id', $welid, PDO::PARAM_STR);
                                  $nstmt->execute();
                                  $noticerows = $nstmt->fetchAll(PDO::FETCH_ASSOC);

                                  if (count($noticerows) > 0) {
                                  $noticequery1 = "select *, Concat('Notice','') as type, Concat('7','') as flagCheck, Concat('$site_url','notice/notice_img/notice-min.jpg') as noticeImage,
                                  Concat('$site_url',fileName) as fileName, DATE_FORMAT(createdDate,'%d %b %Y') as createdDate, DATE_FORMAT(publishingTime,'%d %b %Y') as publishingTime, DATE_FORMAT(unpublishingTime,'%d %b %Y') as unpublishingTime from Tbl_C_NoticeDetails where noticeId =:id and clientId =:cid and status = 'Live'";
                                  $nstmt = $this->DB->prepare($noticequery1);
                                  $nstmt->bindParam(':cid', $this->idclient, PDO::PARAM_STR);
                                  $nstmt->bindParam(':id', $welid, PDO::PARAM_STR);
                                  $nstmt->execute();
                                  $noticedata = $nstmt->fetch(PDO::FETCH_ASSOC);
                                  $userid = $noticedata['createdBy'];

                                  $query = "select emp_master.firstName,emp_master.lastName,if(emp_personal.userImage IS NULL or emp_personal.userImage='', '', if(emp_personal.linkedIn = '1', emp_personal.userImage, Concat('" . $site_url . "',emp_personal.userImage))) as userImage from Tbl_EmployeeDetails_Master as emp_master left join Tbl_EmployeePersonalDetails as emp_personal on emp_personal.employeeId=emp_master.employeeId where emp_master.employeeId =:eid";
                                  $stmt12 = $this->DB->prepare($query);
                                  $stmt12->bindparam('eid', $userid, PDO::PARAM_STR);
                                  $stmt12->execute();
                                  $noticedata1 = $stmt12->fetch(PDO::FETCH_ASSOC);
                                  $username = $noticedata1['firstName'] . " " . $noticedata1['lastName'];

                                  $noticedata['postedBy'] = $noticedata1['userImage'];
                                  $noticedata['posted'] = $username;
                                  $noticedata['module'] = "Announcements";

                                  array_push($welcomearray, $noticedata);
                                  }
                                  break;

                                  //                          Display Event Code
                                  case "Event":
                                  $eventquery = "select * from Tbl_Analytic_EventSentToGroup where groupId IN('" . $in . "') and eventId =:id and clientId =:cid and status = 1";
                                  $nstmt = $this->DB->prepare($eventquery);
                                  $nstmt->bindParam(':cid', $this->idclient, PDO::PARAM_STR);
                                  $nstmt->bindParam(':id', $welid, PDO::PARAM_STR);
                                  $nstmt->execute();
                                  $eventrows = $nstmt->fetchAll(PDO::FETCH_ASSOC);
                                  if (count($eventrows) > 0) {
                                  // array_push($welcomearray1["PostType"],$weltype);
                                  $eventquery1 = "select *,Concat('Event','') as type, Concat('6','') as flagCheck, DATE_FORMAT(createdDate,'%d %b %Y') as createdDate, DATE_FORMAT(eventTime,'%d %b %Y %h:%i %p') as eventTime, if(imageName IS NULL or imageName = '','',Concat('$site_url',imageName)) as imageName ,REPLACE(description,'\r\n','') as description from Tbl_C_EventDetails where eventId =:id and clientId =:cid and status = 'Active'";
                                  $nstmt = $this->DB->prepare($eventquery1);
                                  $nstmt->bindParam(':cid', $this->idclient, PDO::PARAM_STR);
                                  $nstmt->bindParam(':id', $welid, PDO::PARAM_STR);
                                  $nstmt->execute();
                                  $eventdata = $nstmt->fetch(PDO::FETCH_ASSOC);
                                  $userid = $eventdata['createdBy'];

                                  $query = "select emp_master.firstName,emp_master.lastName,if(emp_personal.userImage IS NULL or emp_personal.userImage='', '', if(emp_personal.linkedIn = '1', emp_personal.userImage, Concat('" . $site_url . "',emp_personal.userImage))) as userImage from Tbl_EmployeeDetails_Master as emp_master left join Tbl_EmployeePersonalDetails as emp_personal on emp_personal.employeeId=emp_master.employeeId where emp_master.employeeId =:eid";
                                  $stmt12 = $this->DB->prepare($query);
                                  $stmt12->bindparam('eid', $userid, PDO::PARAM_STR);
                                  $stmt12->execute();
                                  $eventdata1 = $stmt12->fetch(PDO::FETCH_ASSOC);
                                  $username = $eventdata1['firstName'] . " " . $eventdata1['lastName'];

                                  $eventdata['postedBy'] = $eventdata1['userImage'];
                                  $eventdata['posted'] = $username;
                                  $eventdata['module'] = "Save The Date";

                                  array_push($welcomearray, $eventdata);
                                  }
                                  break;

                                  //                          Display News Code
                                  case ($weltype == "News" || $weltype == "Picture" || $weltype == "Message"):


                                  //$status = "Publish";
                                  $eventquery = "select * from Tbl_Analytic_PostSentToGroup where groupId IN('" . $in . "') and postId =:id and clientId =:cid and status = 1";
                                  $nstmt = $this->DB->prepare($eventquery);
                                  $nstmt->bindParam(':cid', $this->idclient, PDO::PARAM_STR);
                                  $nstmt->bindParam(':id', $welid, PDO::PARAM_STR);
                                  $nstmt->execute();
                                  $postrows = $nstmt->fetchAll(PDO::FETCH_ASSOC);
                                  //                                Concat('$site_url', post_img) as post_img
                                  if (count($postrows) > 0) {
                                  // $newsquery = "select *, Concat(:type,'') as type ,  if(thumb_post_img IS NULL or thumb_post_img='' , Concat('$site_url',post_img),Concat('$site_url',thumb_post_img) ) as post_img, DATE_FORMAT(created_date,'%d %b %Y') as created_date from Tbl_C_PostDetails  where post_id =:id and clientId =:cid";

                                  $newsquery = "select *, Concat(:type,'') as type , if(post_img IS NULL or post_img = '','', Concat('$site_url',post_img)) as post_img, DATE_FORMAT(created_date,'%d %b %Y') as created_date from Tbl_C_PostDetails  where post_id =:id and clientId =:cid";
                                  $nstmt = $this->DB->prepare($newsquery);
                                  $nstmt->bindParam(':cid', $this->idclient, PDO::PARAM_STR);
                                  $nstmt->bindParam(':id', $welid, PDO::PARAM_STR);
                                  $nstmt->bindParam(':type', $weltype, PDO::PARAM_STR);

                                  $nstmt->execute();
                                  $val = $nstmt->fetch(PDO::FETCH_ASSOC);
                                  $userid = $val['userUniqueId'];

                                  $imgquery = "select ud.firstName, if(up.userImage IS NULL or up.userImage = '','',concat('$site_url',up.userImage)) as UserImage from Tbl_EmployeeDetails_Master as ud join Tbl_EmployeePersonalDetails as up on up.employeeId = ud.employeeId where ud.clientId=:cli and ud.employeeId=:empid";
                                  $stmt = $this->DB->prepare($imgquery);
                                  $stmt->bindParam(':cli', $this->idclient, PDO::PARAM_STR);
                                  $stmt->bindParam(':empid', $userid, PDO::PARAM_STR);
                                  $stmt->execute();
                                  $rows = $stmt->fetch(PDO::FETCH_ASSOC);
                                  //$val["UserName"]=$rows["firstName"];
                                  $val["UserImage"] = $rows["UserImage"];
                                  $val["module"] = "What's up";

                                  array_push($welcomearray, $val);

                                  //   print_r($val);
                                  }
                                  break;

                                  //                          Display CEO Message
                                  case "CEOMessage":

                                  $eventquery = "select * from Tbl_Analytic_PostSentToGroup where groupId IN('" . $in . "') and postId =:id and clientId =:cid and status = 1";
                                  $nstmt = $this->DB->prepare($eventquery);
                                  $nstmt->bindParam(':cid', $this->idclient, PDO::PARAM_STR);
                                  $nstmt->bindParam(':id', $welid, PDO::PARAM_STR);
                                  $nstmt->execute();
                                  $postrows = $nstmt->fetchAll(PDO::FETCH_ASSOC);
                                  //                                Concat('$site_url', post_img) as post_img
                                  if (count($postrows) > 0) {

                                  $eventquery1 = "select *,Concat('CEOMessage','') as type, DATE_FORMAT(created_date,'%d %b %Y') as created_date, if(post_img IS NULL or post_img='','', Concat('$site_url',post_img)) as post_img from Tbl_C_PostDetails where Post_id =:id and clientId =:cid and flagCheck = 9";
                                  $nstmt = $this->DB->prepare($eventquery1);
                                  $nstmt->bindParam(':cid', $this->idclient, PDO::PARAM_STR);
                                  $nstmt->bindParam(':id', $welid, PDO::PARAM_STR);
                                  $nstmt->execute();
                                  $val1 = $nstmt->fetch(PDO::FETCH_ASSOC);
                                  $userid = $val1['userUniqueId'];

                                  $imgquery = "select ud.firstName, if(up.userImage IS NULL or up.userImage = '','',concat('$site_url',up.userImage)) as UserImage from Tbl_EmployeeDetails_Master as ud join Tbl_EmployeePersonalDetails as up on up.employeeId = ud.employeeId where ud.clientId=:cli and ud.employeeId=:empid";
                                  $stmt = $this->DB->prepare($imgquery);
                                  $stmt->bindParam(':cli', $this->idclient, PDO::PARAM_STR);
                                  $stmt->bindParam(':empid', $userid, PDO::PARAM_STR);
                                  $stmt->execute();
                                  $rows = $stmt->fetch(PDO::FETCH_ASSOC);
                                  //$val["UserName"]=$rows["firstName"];
                                  $val1["UserImage"] = $rows["UserImage"];
                                  $val1["module"] = "Leadership Connect";

                                  array_push($welcomearray, $val1);
                                  }
                                  break;

                                  //                          Display Aboard
                                  case "Onboard":
                                  $noticequery = "select * from Tbl_Analytic_PostSentToGroup where groupId IN('" . $in . "') and
                                  postId =:id and clientId =:cid";
                                  $nstmt = $this->DB->prepare($noticequery);
                                  $nstmt->bindParam(':cid', $this->idclient, PDO::PARAM_STR);
                                  $nstmt->bindParam(':id', $welid, PDO::PARAM_STR);
                                  $nstmt->execute();
                                  $onboardrows = $nstmt->fetchAll(PDO::FETCH_ASSOC);

                                  if (count($onboardrows) > 0) {
                                  $noticequery1 = "select *, Concat('Post','') as type, Concat('12','') as flagCheck, Concat('$site_url','notice/notice_img/notice-min.jpg') as userImage,
                                  if(post_img IS NULL or post_img='','', Concat('$site_url',post_img)) as post_img, DATE_FORMAT(created_date,'%d %b %Y') as created_date from Tbl_C_PostDetails where post_id=:id and clientId =:cid";
                                  $nstmt = $this->DB->prepare($noticequery1);
                                  $nstmt->bindParam(':cid', $this->idclient, PDO::PARAM_STR);
                                  $nstmt->bindParam(':id', $welid, PDO::PARAM_STR);
                                  $nstmt->execute();
                                  $onboardData = $nstmt->fetchAll(PDO::FETCH_ASSOC);
                                  //echo'<pre>';print_r($onboardData);die;
                                  foreach ($onboardData as $values) {
                                  //echo '<pre>';print_r($values);die;
                                  $post_content_keys = explode("#Benepik#", $values['post_content']);

                                  //echo '<pre>';print_r($post_content_keys);die;

                                  unset($post_content_keys[0]);
                                  $post_content_keys = array_values($post_content_keys);
                                  //echo'<pre>';print_r($post_content_keys);die;
                                  $final_data_keys = array();
                                  $final_data_value = array();
                                  foreach ($post_content_keys as $keys => $val) {

                                  $key_data = explode("###", $val);
                                  array_push($final_data_keys, trim($key_data[0], " "));
                                  array_push($final_data_value, strip_tags(trim($key_data[1], " \n\t\t "), ""));
                                  }
                                  $final_data_value[2] = date('d M Y', strtotime($final_data_value[2]));
                                  array_push($final_data_keys, 'user_image', 'user_name');
                                  array_push($final_data_value, $values['post_img'], $values['post_title']);

                                  $response_data = array_combine($final_data_keys, $final_data_value);
                                  $response_data['auto_id'] = $values['auto_id'];
                                  $response_data['post_id'] = $welid;
                                  $response_data['clientId'] = $this->idclient;
                                  $response_data['type'] = "Onboard";
                                  $response_data['flagCheck'] = $values['flagCheck'];

                                  $response_data['username'] = $response_data['user_name'];
                                  $response_data['user_name'] = 'Welcome Aboard : ' . $response_data['user_name'];
                                  $response_data['module'] = "Onboard";
                                  }
                                  //echo'<pre>';print_r($response_data);die;

                                  array_push($welcomearray, $response_data);
                                  }
                                  break;

                                 */

//                          Display Happiness                            
                                case "Happiness" :
                                    $eventquery1 = "select happiness.*,Concat('Happiness','') as type,Concat('20','') as flagCheck, DATE_FORMAT(happiness.createdDate,'%d %b %Y') as createdDate, DATE_FORMAT(happiness.startDate,'%d %b %Y') as publishingTime, if(master.lastName IS NULL or master.lastName='', master.firstName, CONCAT(master.firstName, ' ', master.lastName)) as createdBy, if(personal.userImage IS NULL or personal.userImage='', '', CONCAT('$site_url', personal.userImage)) as userImage from Tbl_C_HappinessQuestion as happiness join Tbl_EmployeeDetails_Master as master on happiness.createdBy=master.employeeId join Tbl_EmployeePersonalDetails as personal on happiness.createdBy=personal.employeeId where happiness.surveyId =:id and happiness.clientId =:cid and DATE(happiness.createdDate) = CURDATE()";
                                    $nstmt = $this->DB->prepare($eventquery1);
                                    $nstmt->bindParam(':cid', $this->idclient, PDO::PARAM_STR);
                                    $nstmt->bindParam(':id', $welid, PDO::PARAM_STR);
                                    $nstmt->execute();
                                    $data = $nstmt->fetch(PDO::FETCH_ASSOC);
                             	    if ($data) {
		                            $data['module'] = "Happiness";                                    
		                            array_push($welcomearray, $data);
                                    }
                                    break;

//                          Display Album                            
                                case "Album":
                                $eventquery = "select * from Tbl_Analytic_AlbumSentToGroup where groupId IN('" . $in . "') and albumId =:id and clientId =:cid";
                                $nstmt = $this->DB->prepare($eventquery);
                                $nstmt->bindParam(':cid', $this->idclient, PDO::PARAM_STR);
                                $nstmt->bindParam(':id', $welid, PDO::PARAM_STR);
                                $nstmt->execute();
                                $eventrows = $nstmt->fetchAll(PDO::FETCH_ASSOC);
                                if (count($eventrows) > 0) {
                                    $eventquery1 = "select album.*,Concat('Album','') as type, Concat('11','') as flagCheck, DATE_FORMAT(album.createdDate,'%d %b %Y') as createdDate, Concat('$site_url',album_image.imgName) as imageName from Tbl_C_AlbumDetails as album join Tbl_C_AlbumImage as album_image on album_image.albumId=album.albumId where album.albumId =:id and album.clientId =:cid And album.status=1 And album_image.status = 1 ";                                   
                                    $nstmt = $this->DB->prepare($eventquery1);
                                    $nstmt->bindParam(':cid', $this->idclient, PDO::PARAM_STR);
                                    $nstmt->bindParam(':id', $welid, PDO::PARAM_STR);
                                    $nstmt->execute();
                                    $eventdata = $nstmt->fetch(PDO::FETCH_ASSOC);

				   
				   
				    $albumImages = array();
				    $albumImagesQuery = "select IF(imgName IS NULL or imgName='', '', CONCAT('$site_url',imgName)) AS imgName from Tbl_C_AlbumImage where albumId=:albumId and status=1 limit 0,3";
				    $nstmt = $this->DB->prepare($albumImagesQuery);
				    $nstmt->bindParam(':albumId', $eventdata['albumId'], PDO::PARAM_STR);
				    $nstmt->execute();
				    $albumImages = $nstmt->fetchAll(PDO::FETCH_ASSOC);
                                    	
                            	    //$eventdata['imageName'] = $albumImages;
                            	    unset($eventdata['imageName']);
                            	    $eventdata['imageName1'] = (!empty($albumImages[0]['imgName']))?$albumImages[0]['imgName']:"";
                            	    $eventdata['imageName2'] = (!empty($albumImages[1]['imgName']))?$albumImages[1]['imgName']:"";
                            	    $eventdata['imageName3'] = (!empty($albumImages[2]['imgName']))?$albumImages[2]['imgName']:"";
                                   
                                    
                                    $userid = $eventdata['createdby'];

                                    $query = "select emp_master.firstName,emp_master.lastName,if(emp_personal.userImage IS NULL or emp_personal.userImage='', '', if(emp_personal.linkedIn = '1', emp_personal.userImage, Concat('$site_url',emp_personal.userImage))) as userImage from Tbl_EmployeeDetails_Master as emp_master left join Tbl_EmployeePersonalDetails as emp_personal on emp_personal.employeeId=emp_master.employeeId where emp_master.employeeId =:eid";
                                    $stmt12 = $this->DB->prepare($query);
                                    $stmt12->bindparam(':eid', $userid, PDO::PARAM_STR);
                                    $stmt12->execute();
                                    $eventdata1 = $stmt12->fetch(PDO::FETCH_ASSOC);

                                    $username = $eventdata1['firstName'] . " " . $eventdata1['lastName'];
                                    $eventdata['posted'] = $username;
                                    $eventdata['postedBy'] = $eventdata1['userImage'];
                                    $eventdata['module'] = 'Gallery';

                                    array_push($welcomearray, $eventdata);
                                }
                                break;

//                          Display Recognition
                                case "Recognition" :
                                    $sts = "Approve";
				    $recognitionQuery = "select recognition.*, Concat('Recognition','') as type,Concat('10','') as flagCheck, DATE_FORMAT(recognition.dateOfEntry,'%d %b %Y') as createdDate, badges.recognizeTitle, if(badges.image IS NULL or badges.image='', '',concat('$site_url', badges.image)) as badgesImage, if(Bymaster.lastName IS NULL or Bymaster.lastName='', Bymaster.firstName,CONCAT(Bymaster.firstName, ' ', Bymaster.lastName)) as ByUsername, if(Bypersonal.userImage IS NULL or Bypersonal.userImage='', '', CONCAT('$site_url',Bypersonal.userImage)) as ByuserImage, if(Tomaster.lastName IS NULL or Tomaster.lastName='', Tomaster.firstName,CONCAT(Tomaster.firstName, ' ', Tomaster.lastName)) as ToUsername, if(Topersonal.userImage IS NULL or Topersonal.userImage='', '', CONCAT('$site_url',Topersonal.userImage)) as TouserImage, (select count(autoId) as totalLikes from Tbl_Analytic_RecognitionLikes where recognitionId=:id and like_unlike_status='1') as totalLikes, if((select if(employeeId=:uid, '1', '0') as likeStatus from Tbl_Analytic_RecognitionLikes where recognitionId=:id and like_unlike_status='1' and employeeId=:uid), 1, 0) as likeStatus from Tbl_RecognizedEmployeeDetails as recognition join Tbl_RecognizeTopicDetails as badges ON recognition.topic=badges.topicId join Tbl_EmployeeDetails_Master as Bymaster on Bymaster.employeeId=recognition.recognitionBy join Tbl_EmployeeDetails_Master as Tomaster on Tomaster.employeeId=recognition.recognitionTo join Tbl_EmployeePersonalDetails as Bypersonal ON Bypersonal.employeeId=recognition.recognitionBy join Tbl_EmployeePersonalDetails as Topersonal ON Topersonal.employeeId=recognition.recognitionTo where recognition.status =:sts and recognition.clientId=:cli and recognition.recognitionId=:id"; 
				    
//				    , if((select if(employeeId='$uid', '1', '0') as likeStatus from Tbl_Analytic_RecognitionLikes where recognitionId=:id and like_unlike_status='1'),1,0) as likeStatus
				    
				    $nstmt = $this->DB->prepare($recognitionQuery);
				    $nstmt->bindParam(':cli', $this->idclient, PDO::PARAM_STR);
				    $nstmt->bindParam(':id', $welid, PDO::PARAM_STR);
				    $nstmt->bindParam(':uid', $uid, PDO::PARAM_STR);
				    $nstmt->bindParam(':sts', $sts, PDO::PARAM_STR);
				    $nstmt->execute();
				    $data = $nstmt->fetch(PDO::FETCH_ASSOC);
				    
				    
				    $data['module'] = "Recognition";                                    
                                    array_push($welcomearray, $data);
                                    break;

//                          Display Thought
                                case "Thought":
                                    $eventquery1 = "select thought.*,Concat('Thought','') as type,Concat('5','') as flagCheck, DATE_FORMAT(thought.createdDate,'%d %b %Y') as createdDate, DATE_FORMAT(thought.publishingTime,'%d %b %Y') as publishingTime, if(thought.thoughtImage IS NULL OR thought.thoughtImage ='','',Concat('$site_url',thought.thoughtImage)) as thoughtImage, if(master.lastName IS NULL or master.lastName='', master.firstName, CONCAT(master.firstName, ' ', master.lastName)) as createdBy, if(personal.userImage IS NULL or personal.userImage='', '', CONCAT('$site_url', personal.userImage)) as userImage from Tbl_C_Thought as thought join Tbl_EmployeeDetails_Master as master on thought.createdBy=master.employeeId join Tbl_EmployeePersonalDetails as personal on thought.createdBy=personal.employeeId where thought.thoughtId =:id and thought.clientId =:cid";
                                    $nstmt = $this->DB->prepare($eventquery1);
                                    $nstmt->bindParam(':cid', $this->idclient, PDO::PARAM_STR);
                                    $nstmt->bindParam(':id', $welid, PDO::PARAM_STR);
                                    $nstmt->execute();
                                    $data = $nstmt->fetch(PDO::FETCH_ASSOC);
                                    $data['module'] = "Thought";                                    
                                    array_push($welcomearray, $data);

                                    break;

//                          Display Colleague Story or Achiever Story
                                case "AStory":
                                $eventquery1 = "select achiever.*,Concat('AStory','') as type, DATE_FORMAT(achiever.createdDate,'%d %b %Y') as createdDate, if(achieverImage.imagePath IS NULL or achieverImage.imagePath='', '', Concat('$site_url',achieverImage.imagePath)) as post_img, achiever.flagType as flagCheck, REPLACE(achiever.story,'\r\n','') as story from Tbl_C_AchiverStory as achiever join Tbl_C_AchieverImage as achieverImage on achieverImage.storyId=achiever.storyId where achiever.storyId =:id and achiever.clientId =:cid and achiever.flagType = 16 and achiever.status=1";
                                $nstmt = $this->DB->prepare($eventquery1);
                                $nstmt->bindParam(':cid', $this->idclient, PDO::PARAM_STR);
                                $nstmt->bindParam(':id', $welid, PDO::PARAM_STR);
                                $nstmt->execute();
                                $val = $nstmt->fetch(PDO::FETCH_ASSOC);
                                $userid = $val['createdBy'];

                                $query = "select emp_master.firstName,emp_master.lastName,if(emp_personal.userImage IS NULL or emp_personal.userImage='', '', if(emp_personal.linkedIn = '1', emp_personal.userImage, Concat('$site_url',emp_personal.userImage))) as userImage from Tbl_EmployeeDetails_Master as emp_master left join Tbl_EmployeePersonalDetails as emp_personal on emp_personal.employeeId=emp_master.employeeId where emp_master.employeeId =:eid";
                                $stmt12 = $this->DB->prepare($query);
                                $stmt12->bindparam(':eid', $userid, PDO::PARAM_STR);
                                $stmt12->execute();
                                $eventdata1 = $stmt12->fetch(PDO::FETCH_ASSOC);

                                $username = $eventdata1['firstName'] . " " . $eventdata1['lastName'];
                                $val['posted'] = $username;
                                $val['postedBy'] = $eventdata1['userImage'];
                                $val['module'] = 'Colleague Story';

                                array_push($welcomearray, $val);
                                break;
                                
//				Display News, Picture and Message (Only Message used here)                                
                                case ($weltype == "News" || $weltype == "Picture" || $weltype == "Message"):


                                    $eventquery = "select * from Tbl_Analytic_PostSentToGroup where groupId IN('" . $in . "') and postId =:id and clientId =:cid and status = 1";
                                    $nstmt = $this->DB->prepare($eventquery);
                                    $nstmt->bindParam(':cid', $this->idclient, PDO::PARAM_STR);
                                    $nstmt->bindParam(':id', $welid, PDO::PARAM_STR);
                                    $nstmt->execute();
                                    $postrows = $nstmt->fetchAll(PDO::FETCH_ASSOC);
//                                Concat('$site_url', post_img) as post_img
                                    if (count($postrows) > 0) 
                                        {
                                        // $newsquery = "select *, Concat(:type,'') as type ,  if(thumb_post_img IS NULL or thumb_post_img='' , Concat('$site_url',post_img),Concat('$site_url',thumb_post_img) ) as post_img, DATE_FORMAT(created_date,'%d %b %Y') as created_date from Tbl_C_PostDetails  where post_id =:id and clientId =:cid";

                                        $newsquery = "select *, Concat(:type,'') as type , if(post_img IS NULL or post_img = '','',Concat('$site_url',post_img)) as post_img, DATE_FORMAT(created_date,'%d %b %Y') as created_date from Tbl_C_PostDetails  where post_id =:id and clientId =:cid";
                                        $nstmt = $this->DB->prepare($newsquery);
                                        $nstmt->bindParam(':cid', $this->idclient, PDO::PARAM_STR);
                                        $nstmt->bindParam(':id', $welid, PDO::PARAM_STR);
                                        $nstmt->bindParam(':type', $weltype, PDO::PARAM_STR);

                                        $nstmt->execute();
                                        $val = $nstmt->fetch(PDO::FETCH_ASSOC);
                                        $userid = $val['userUniqueId'];

                                        $imgquery = "select ud.firstName, if(up.userImage IS NULL or up.userImage = '','',concat('$site_url',up.userImage)) as UserImage from Tbl_EmployeeDetails_Master as ud join Tbl_EmployeePersonalDetails as up on up.employeeId = ud.employeeId where ud.clientId=:cli and ud.employeeId=:empid";
                                        $stmt = $this->DB->prepare($imgquery);
                                        $stmt->bindParam(':cli', $this->idclient, PDO::PARAM_STR);
                                        $stmt->bindParam(':empid', $userid, PDO::PARAM_STR);
                                        $stmt->execute();
                                        $rows = $stmt->fetch(PDO::FETCH_ASSOC);
//$val["UserName"]=$rows["firstName"];
                                        $val["UserImage"] = $rows["UserImage"];
                                        $val["module"] = "Message";

                                        array_push($welcomearray, $val);

                                        //   print_r($val);
                                    }
					break;
					
//                          Display Notification Reminder
                                case "Reminder" :
                                
				$reminderQuery = "select reminder.*,Concat('Reminder','') as type,Concat('25','') as flagCheck, DATE_FORMAT(reminder.createdDate,'%d %b %Y') as createdDate, DATE_FORMAT(reminder.createdDate,'%d %b %Y') as publishingTime, if(reminder.image IS NULL OR reminder.image ='','',Concat('$site_url', reminder.image)) as image, if(personal.userImage IS NULL or personal.userImage='', '', CONCAT('$site_url', personal.userImage)) as userImage from Tbl_C_ReminderDetails as reminder join Tbl_EmployeePersonalDetails as personal on reminder.createdBy=personal.employeeId where reminder.reminderId =:id and reminder.clientId =:cid and reminder.status=1";
                                    $nstmt = $this->DB->prepare($reminderQuery);
                                    $nstmt->bindParam(':cid', $this->idclient, PDO::PARAM_STR);
                                    $nstmt->bindParam(':id', $welid, PDO::PARAM_STR);
                                    $nstmt->execute();
                                    $data = $nstmt->fetch(PDO::FETCH_ASSOC);
//print_r($data);
                                    $data['module'] = "Reminder";
                                    array_push($welcomearray, $data);
                                    break;

                                default: "Invalid data";
                            }
                        }
                    } catch (PDOException $e) {
                        echo $e;
                        $result['success'] = 0;
                        $result['message'] = "data not fount found";
                        return $result;
                    }
                }
                /*                 * ********************************************************************************************* */
//$uniquedata = array_values(array_unique($welcomearray));
                $datacount = count($welcomearray);
//echo "array of user ".$datacount."<br>";
                $result['totalpost'] = $datacount;

                $welcomedata = array();
                if ($datacount < 1) {
                    $result['success'] = 0;
                    $result['message'] = "No More Post Available";
                    return $result;
                } else {
//$start = $this.value * 5;
//echo "start value ".$start;
//echo "<br>";

                    for ($ui = $start, $kh = 1; $ui < $datacount; $ui++, $kh++) {
//print_r($welcomearray[$ui]);
//echo "welcome array ".$kh."<br>";
                        array_push($welcomedata, $welcomearray[$ui]);
                        if ($kh <= 10) {
//echo "if part".$kh;
                            continue;
                        } else {
//echo "else part ".$kh;
                            break;
                        }
                    }
//print_r($welcomedata);
                    $result['success'] = 1;
                    $result['message'] = "data found";
                    $result['welcomedata'] = $welcomedata;
//echo "welcome array"."<br/>";
                    /* echo "<pre>";
                      print_r($result);
                      echo "</pre>"; */
                }
            }
        } else {
            $result['success'] = 2;
            $result['message'] = "Sorry !! You are not an authorized user";
        }
        return $result;
    }

}

?>
