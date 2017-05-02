<?php

if (!class_exists('Connection_Communication')) {
    include_once('class_connect_db_Communication.php');
}
include_once('class_find_groupid.php');

class AlbumAPI {

    public $DB;
    public $db_connect;

    public function __construct() {
        $db = new Connection_Communication();
        $this->DB = $db->getConnection_Communication();
    }

    /*     * ****************** add album ********************************************* */
    /* function create_Like($clientid, $userid, $albumid, $imageid, $device) {

      date_default_timezone_set('Asia/Calcutta');
      $cd = date("Y-m-d H:i:s");
      $status = 1;

      try {
      $query = "insert into Tbl_Analytic_AlbumLike(clientId,userId,albumId,imageId,createdDate,status,deviceName)
      values(:cli,:userid,:albumid,:imgid,:cd,:sta,:dev)";
      $stmt = $this->DB->prepare($query);
      $stmt->bindParam(':cli', $clientid, PDO::PARAM_STR);
      $stmt->bindParam(':userid', $userid, PDO::PARAM_STR);
      $stmt->bindParam(':albumid', $albumid, PDO::PARAM_INT);
      $stmt->bindParam(':imgid', $imageid, PDO::PARAM_INT);
      $stmt->bindParam(':cd', $cd, PDO::PARAM_INT);
      $stmt->bindParam(':sta', $status, PDO::PARAM_INT);
      $stmt->bindParam(':dev', $device, PDO::PARAM_STR);
      if ($stmt->execute()) {

      $query2 = "select count(imageId) as total_likes from Tbl_Analytic_AlbumLike where albumId =:albumid AND imageId = :imgid AND status = :sta AND clientId=:cli";
      $stmt2 = $this->DB->prepare($query2);
      $stmt2->bindParam(':cli', $clientid, PDO::PARAM_STR);
      $stmt2->bindParam(':albumid', $albumid, PDO::PARAM_INT);
      $stmt2->bindParam(':imgid', $imageid, PDO::PARAM_INT);
      $stmt2->bindParam(':sta', $status, PDO::PARAM_INT);
      $stmt2->execute();
      $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);

      $response["success"] = 1;
      $response["message"] = "You have liked this Image successfully";
      $response['total_likes'] = $row2['total_likes'];
      $response["post"] = self::totallikes($clientid, $albumid, $imageid);
      return $response;
      }
      } catch (PDOException $e) {
      $response["success"] = 0;
      $response["message"] = "You already liked this Image";
      return $response;
      }
      } */
    /*     * ***************************** / add album *************************************** */

    /*     * ************************* / get album category ******************************** */

    public function getAllAlbumCategory($clientId, $empId) {
        try {
            $imgpath = site_url;

            $query = "SELECT *, DATE_FORMAT(createdDate,'%d %b %Y %h:%i %p') as createdDate , if(categoryImage IS NULL OR categoryImage = '' , '',CONCAT('" . $imgpath . "',categoryImage)) as 	categoryImage FROM Tbl_C_AlbumCategory WHERE clientId = :cid  AND status = 1 order by createdDate desc";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cid', $clientId, PDO::PARAM_STR);
            $row = $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($result) {
                $response["success"] = 1;
                $response["message"] = "Album Category Fetched Successfully";
                $response["data"] = $result;
            } else {
                $response["success"] = 0;
                $response["message"] = "Category Not Fetch";
            }
        } catch (Exception $ex) {
            $response["success"] = 0;
            $response["message"] = "Category Not Fetch" . $ex;
        }
        return json_encode($response);
    }

    /*     * ************************* / get album category ******************************** */

    /*     * ***************************** view album ************************************** */

    function getAllAlbum($cid, $uuid, $categoryid) {

        $this->client = $cid;
        $this->author = $uuid;
        $server_name = site_url;
        /*         * ***************************check user detail ************************** */
        $query2 = "select * from Tbl_EmployeeDetails_Master where clientId=:cli and employeeId=:empid and status = 'Active'";
        $stmt2 = $this->DB->prepare($query2);
        $stmt2->bindParam(':cli', $cid, PDO::PARAM_STR);
        $stmt2->bindParam(':empid', $uuid, PDO::PARAM_STR);
        $stmt2->execute();
        $rows2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
        //print_r($rows2);
        /*         * ************************ end check user detail ************************ */

        if (count($rows2) > 0) {
            /*             * *************************** find user group *************************** */
            $uuids = $rows2[0]['employeeId'];
            //echo "employee id -".$uuids;
            $group_object = new FindGroup();    // this is object to find group id of given unique id 
            $getgroup = $group_object->groupBaseofUid($cid, $uuids);
            $value = json_decode($getgroup, true);
            //echo'<pre>';
            //print_r($value);die;
            /*             * **************************** end find user group ********************** */

            if (count($value['groups']) > 0) {
                $in = implode("', '", array_unique($value['groups']));
                //echo $in;

                try {
                    /*                     * ************************* fetch album id *************************** */
                    //$query3 = "select distinct(albumId) from Tbl_Analytic_AlbumSentToGroup where clientId=:cli and status = 1 and flagType = 11 and groupId IN('" . $in . "') order by autoId desc";

                    $query3 = "select distinct(albumgroup.albumId) from Tbl_Analytic_AlbumSentToGroup as albumgroup JOIN Tbl_C_AlbumDetails as albumdetails ON albumgroup.albumId = albumdetails.albumId where albumgroup.clientId=:cli and albumgroup.status = 1 and albumgroup.flagType = 11 and albumdetails.categoryId = :categoryid AND albumgroup.groupId IN('" . $in . "') order by albumgroup.autoId desc";

                    $stmt3 = $this->DB->prepare($query3);
                    $stmt3->bindParam(':cli', $cid, PDO::PARAM_STR);
                    $stmt3->bindParam(':categoryid', $categoryid, PDO::PARAM_STR);
                    $stmt3->execute();
                    $rows3 = $stmt3->fetchAll(PDO::FETCH_ASSOC);
                    //print_r($rows3);
                    $post = array();

                    //////////////////////////// end fetch album id //////////////////////////////		
                    if (count($rows3) > 0) {
                        $response["success"] = 1;
                        $response["message"] = "Displaying post details";
                        $response["posts"] = array();
                        foreach ($rows3 as $row) {
                            $postid = $row["albumId"];

                            $query = "select ad.*,DATE_FORMAT(ad.createdDate,'%d %b %Y %h:%i %p') as createdDate,if(ai.imgName IS NULL or ai.imgName = '','',concat('" . $server_name . "',ai.imgName)) as image , concat(count(ai.albumId),' Photos') as totalimage from Tbl_C_AlbumDetails as ad join Tbl_C_AlbumImage as ai on ad.albumId = ai.albumId where ad.clientId =:cid AND ad.status = 1 And ai.status = 1 and ad.albumId = :aid group by ad.albumId order by autoId desc";

                            $stmt = $this->DB->prepare($query);
                            $stmt->bindParam(':cid', $this->client, PDO::PARAM_STR);
                            $stmt->bindParam(':aid', $postid, PDO::PARAM_STR);

                            $stmt->execute();
                            $rows = $stmt->fetch(PDO::FETCH_ASSOC);

                            array_push($response["posts"], $rows);
                        }
                        return json_encode($response);
                    } else {
                        $response["success"] = 0;
                        $response["message"] = "No more post available";
                        return json_encode($response);
                    }
                }    // try closing 
                catch (PDOException $e) {
                    echo $e;
                }
            } else {
                $response["success"] = 0;
                $response["message"] = "You are not selected in any group";
                return json_encode($response);
            }
        } else {
            $response["success"] = 0;
            $response["message"] = "Sorry! You are Not Authorized User";
            return json_encode($response);
        }
    }

//	function closing
    /*     * ******************************* / view album ********************************** */

    /*     * ******************************** get album image ****************************** */

    function getAlbumImage($albumid) {
        $this->albumid = $albumid;
        try {
            $server_name = site_url;

            $query = "select *, if(imgName IS NULL or imgName ='', '',concat('" . $server_name . "',imgName)) as imgName  from Tbl_C_AlbumImage where albumId =:aid AND status = 1 order by autoId desc";

            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':aid', $this->albumid, PDO::PARAM_STR);

            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            //print_r($rows);
            if ($rows) {
                $response["success"] = 1;
                $response["message"] = "Displaying post details";
                $response["posts"] = $rows;
                return json_encode($response);
            } else {
                $response["success"] = 0;
                $response["message"] = "No post details Available";
                return json_encode($response);
            }
        } catch (PDOException $e) {
            $response["success"] = 0;
            $response["message"] = "No post details Available" . $e;
            return json_encode($response);
        }
    }

    /*     * ******************************** / get album image **************************** */

    /*     * ********************** get image details ************************************** */

    function getAllAlbumImageDetails($albumid, $clientid = '', $device = '') {
        $this->albumid = $albumid;
        $status = 1;
        try {
            $server_name = site_url;

            $query = "select albumImage.*, if(albumImage.imgName IS NULL or albumImage.imgName='', '',concat('" . $server_name . "',albumImage.imgName)) as imgName, if(master.lastName IS NULL or master.lastName='', master.firstName, CONCAT(master.firstName, ' ', master.lastName)) as createdBy, if(personal.userImage IS NULL or personal.userImage='', '',concat('" . $server_name . "',personal.userImage)) as userImage from Tbl_C_AlbumImage as albumImage join Tbl_EmployeeDetails_Master as master on albumImage.createdBy=master.employeeId join Tbl_EmployeePersonalDetails as personal on albumImage.createdBy=personal.employeeId where albumImage.albumId =:aid AND albumImage.status = 1 order by autoId desc";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':aid', $this->albumid, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

//          print_r($rows);die;

            if ($rows > 0) {
                $response["success"] = 1;
                $response["message"] = "Displaying post details";
                $response["posts"] = array();

                for ($i = 0; $i < count($rows); $i++) {
                    $post = array();

                    $post["autoId"] = $rows[$i]["autoId"];
                    $post["albumId"] = $rows[$i]["albumId"];
                    $post["imgName"] = $rows[$i]["imgName"];
                    $post["title"] = $rows[$i]["title"];
                    $post["imageCaption"] = $rows[$i]["imageCaption"];
                    $post["createdBy"] = $rows[$i]["createdBy"];
                    $post["userImage"] = $rows[$i]["userImage"];

                    $imgautoid = $rows[$i]["autoId"];
                    $albid = $rows[$i]["albumId"];


                    $query = "select count(imageId) as total_likes from Tbl_Analytic_AlbumLike where albumId =:albumid AND imageId = :imgid and status = :status";
                    $stmt = $this->DB->prepare($query);

                    $stmt->bindParam(':albumid', $albid, PDO::PARAM_STR);
                    $stmt->bindParam(':imgid', $imgautoid, PDO::PARAM_INT);
                    $stmt->bindParam(':status', $status, PDO::PARAM_INT);

                    $stmt->execute();
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);


                    include_once('class_albumLike.php');
                    include_once('class_comment_album.php');

                    $objLike = new Like;

                    $likes_content = $objLike->getTotalLikeANDcomment($clientid, $post['albumId'], $imgautoid);

                    $objComment = new Comment;
                    $comment_content = $objComment->Comment_display($clientid, $post['albumId'], $imgautoid);

//                    $post["likeDate"] = $userdetailsrows["likeDate"];
                    $post["total_likes"] = $row["total_likes"];
                    $post["total_comments"] = (!empty($comment_content["total_comments"])) ? $comment_content["total_comments"] : "0";

                    $post["likes"] = ($likes_content['Success'] == 1) ? $likes_content['Posts'] : "";
                    $post["comments"] = ($comment_content['Success'] == 1) ? $comment_content['Posts'] : "";
//                    print_r($post);die;
//                    $post["likes"] = ($row["total_likes"] == 0) ? "" : $likes_content['Posts'];
//                    $post["comments"] = ($post["total_comments"] == 0) ? "" : $comment_content['Posts'];


                    array_push($response["posts"], $post);
//                    print_r($response);die;
                }
                return json_encode($response);
            } else {
                $response["success"] = 0;
                $response["message"] = "No post details Available";
                return json_encode($response);
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

    /*     * ********************** / get image details ************************************ */
}

?>
