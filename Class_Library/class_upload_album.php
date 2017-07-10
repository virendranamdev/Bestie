<?php

if (!class_exists('Connection_Communication')) {
    include_once('class_connect_db_Communication.php');
}

include_once('Api_Class/class_find_groupid.php');

class Album {

    public $DB;

    public function __construct() {
        $db = new Connection_Communication();
        $this->DB = $db->getConnection_Communication();
    }

    /*     * ******************************** compress image ************************* */

    function compress_image($source_url, $destination_url, $quality) {

        $imagevalue = filesize($source_url);
        $valueimage = $imagevalue / 1024;

        if ($valueimage > 200) {
            $info = getimagesize($source_url);

            if ($info['mime'] == 'image/jpeg')
                $image = imagecreatefromjpeg($source_url);
            elseif ($info['mime'] == 'image/gif')
                $image = imagecreatefromgif($source_url);
            elseif ($info['mime'] == 'image/png')
                $image = imagecreatefrompng($source_url);

            //save it
            imagejpeg($image, $destination_url, $quality);

            //return destination file url
            return $destination_url;
        }
        else {
            move_uploaded_file($source_url, $destination_url);
            return true;
        }
    }

    /*     * ****************************** / compress image ************************** */

    public $client;
    public $albumid;
    public $atitle;
    public $description;
    public $imgpath;
    public $pdate;
    public $author;
    public $by;
    public $flag;
    public $email;
    public $teaser;
    public $like;
    public $comment;

    /*     * ************************** album max id **************************** */

    function maxId() {
        try {
            $max = "select max(autoId) from Tbl_C_AlbumDetails";
            $stmt = $this->DB->prepare($max);
            if ($stmt->execute()) {
                $tr = $stmt->fetch();
                $m_id = $tr[0];
                $m_id1 = $m_id + 1;
                $albumid = "Album-" . $m_id1;

                return $albumid;
            }
        } catch (PDOException $e) {
            echo $e;
            trigger_error('Error occured fetching max autoid : ' . $e->getMessage(), E_USER_ERROR);
        }
    }

    /*     * ************************ / album max id ************************* */

    /*     * ************************** get categorymax id ******************* */

    function maxcategoryId() {
        try {
            $max = "select max(categoryId) from Tbl_C_AlbumCategory";
            $stmt = $this->DB->prepare($max);
            if ($stmt->execute()) {
                $tr = $stmt->fetch();
                $m_id = $tr[0];
                $m_id1 = $m_id + 1;
                $categoryid = $m_id1;

                return $categoryid;
            }
        } catch (PDOException $e) {
            echo $e;
            trigger_error('Error occured fetching max autoid : ' . $e->getMessage(), E_USER_ERROR);
        }
    }

    /*     * *************************** / get category id ******************* */
    
    
    /*     * ************************** get categorymax id ******************* */

    function maxbundleId() {
        try {
            $max = "select max(bundleId) from Tbl_C_AlbumImage";
            $stmt = $this->DB->prepare($max);
            if ($stmt->execute()) {
                $tr = $stmt->fetch();
                $m_id = $tr[0];
                //$m_id1 = $m_id + 1;
                $categoryid = $m_id;

                return $categoryid;
            }
        } catch (PDOException $e) {
            echo $e;
            trigger_error('Error occured fetching max autoid : ' . $e->getMessage(), E_USER_ERROR);
        }
    }

    /*     * *************************** / get category id ******************* */
    

    /*     * *********************** / add album ******************************* */

    function createAlbum($ClientId, $albumid, $category, $title, $description, $createdby, $createddate) {
        $this->client = $ClientId;
        $this->albumid = $albumid;
        $this->atitle = $title;
        $this->description = $description;
        $this->author = $createdby;
        $this->adate = $createddate;
        $this->acategory = $category;

        try {
            $query = "insert into Tbl_C_AlbumDetails(clientId, albumId, categoryId, title, 	description , createdby, createdDate)
            values(:cid,:aid,:category,:title,:des,:cb,:cd)";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cid', $this->client, PDO::PARAM_STR);
            $stmt->bindParam(':aid', $this->albumid, PDO::PARAM_STR);
            $stmt->bindParam(':category', $this->acategory, PDO::PARAM_STR);
            $stmt->bindParam(':title', $this->atitle, PDO::PARAM_STR);
            $stmt->bindParam(':des', $this->description, PDO::PARAM_STR);
            $stmt->bindParam(':cb', $this->author, PDO::PARAM_STR);
            $stmt->bindParam(':cd', $this->adate, PDO::PARAM_STR);

            if ($stmt->execute()) {
                $ft = 'True';
                return $ft;
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

    /*     * *********************** / add album ******************************* */

    /*     * ***************************** save image ************************** */

    public $caption;
	     
    function saveImage($albumid, $image, $title, $thumbImgName, $caption, $Uuid, $Post_Date, $status='' , $bundleid ='', $approveddate ='', $skip='') {
        $this->albumid = $albumid;
        $this->title = $title;
        $this->imgpath = $image;
        $this->caption = $caption;
	$this->status  = ($status != '')?$status:1;
	$appdate = ($approveddate != '')?$approveddate:'';
	$bunid = ($bundleid != '')?$bundleid:0;
	$seen = ($skip != '')?$skip:0;
	
        try {
            $query = "insert into Tbl_C_AlbumImage(albumId, bundleId, imgName, thumbImgName, imageCaption, title, createdBy, createdDate, status, ApprovedDate, seen) values(:aid, :bid , :img,:thumbImgName,:imageCaption,:title,:createdby,:createddate, :status , :apprdate, :seen)";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':aid', $this->albumid, PDO::PARAM_STR);
            $stmt->bindParam(':bid', $bunid, PDO::PARAM_STR);
            $stmt->bindParam(':title', $this->title, PDO::PARAM_STR);
            $stmt->bindParam(':img', $this->imgpath, PDO::PARAM_STR);
            $stmt->bindParam(':status', $this->status, PDO::PARAM_INT);
            $stmt->bindParam(':thumbImgName', $thumbImgName, PDO::PARAM_STR);
            $stmt->bindParam(':imageCaption', $this->caption, PDO::PARAM_STR);
            $stmt->bindParam(':createdby', $Uuid, PDO::PARAM_STR);
            $stmt->bindParam(':createddate', $Post_Date, PDO::PARAM_STR);
	    $stmt->bindParam(':apprdate', $appdate, PDO::PARAM_STR);
	    $stmt->bindParam(':seen', $seen, PDO::PARAM_STR);
            if ($stmt->execute()) {
                $ft = 'True';
                return $this->DB->lastInsertId();
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

    /*     * ***************************** / save image ************************** */

    public function updateAlbumImageContent($id, $albumId, $maxBundleId, $uid, $album_title) {
        try{
            $query = "UPDATE Tbl_C_AlbumImage SET albumId=:aid, bundleId=:bid, title=:title, createdBy=:createdby where autoId=:id";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':aid', $albumId, PDO::PARAM_STR);
            $stmt->bindParam(':bid', $maxBundleId, PDO::PARAM_STR);
            $stmt->bindParam(':title', $album_title, PDO::PARAM_STR);
            $stmt->bindParam(':createdby', $uid, PDO::PARAM_STR);
            if ($stmt->execute()) {
                $result = true;
            }
        } catch (Exception $ex) {
            $result = $ex;
        }
        return $result;
    }

    /*     * ************************ get album Details ******************* */

    function getAlbum($cid, $uuid, $user_type, $device = '') {

        $this->client = $cid;
        $this->author = $uuid;
        $server_name = ($device == '') ? dirname(SITE_URL) . '/' : SITE;



        if ($user_type == 'SubAdmin') {
            try {
                $query = "select ad.*,DATE_FORMAT(ad.createdDate,'%d %b %Y %h:%i %p') as createdDate,if(ai.imgName IS NULL or ai.imgName = '','',concat('" . $server_name . "',ai.imgName)) as image , concat(count(ai.albumId),' Photos') as totalimage , category.categoryName , CONCAT(FirstName , ' ' , middleName , ' ', LastName) as name from Tbl_C_AlbumDetails as ad join Tbl_C_AlbumImage as ai on ad.albumId = ai.albumId JOIN Tbl_C_AlbumCategory as category ON ad.categoryId = category.categoryId JOIN Tbl_EmployeeDetails_Master as edm ON ad.createdby = edm.employeeId where ad.clientId =:cid and ad.createdby = :uid AND category.status = 1 group by ad.albumId order by autoId desc";

                $stmt = $this->DB->prepare($query);
                $stmt->bindParam(':cid', $this->client, PDO::PARAM_STR);
                $stmt->bindParam(':uid', $uuid, PDO::PARAM_STR);
                $stmt->execute();
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if (count($rows) > 0) {
                    $response["success"] = 1;
                    $response["message"] = "Displaying post details";
                    $response["posts"] = $rows;
                    return json_encode($response);
                } else {
                    $response["success"] = 0;
                    $response["message"] = "No more post available";
                    return json_encode($response);
                }
            } catch (PDOException $e) {
                $response["success"] = 0;
                $response["message"] = "No more post available" . $e;
                return json_encode($response);
            }
        } else {
            try {
                $query = "select ad.*,DATE_FORMAT(ad.createdDate,'%d %b %Y %h:%i %p') as createdDate,if(ai.imgName IS NULL or ai.imgName = '','',concat('" . $server_name . "',ai.imgName)) as image , concat(count(ai.albumId),' Photos') as totalimage , category.categoryName , CONCAT(FirstName , ' ' , middleName , ' ', LastName) as name from Tbl_C_AlbumDetails as ad join Tbl_C_AlbumImage as ai on ad.albumId = ai.albumId JOIN Tbl_C_AlbumCategory as category ON ad.categoryId = category.categoryId JOIN Tbl_EmployeeDetails_Master as edm ON ad.createdby = edm.employeeId where ad.clientId =:cid AND category.status = 1 group by ad.albumId order by autoId desc";

                $stmt = $this->DB->prepare($query);
                $stmt->bindParam(':cid', $this->client, PDO::PARAM_STR);

                $stmt->execute();
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if (count($rows) > 0) {
                    $response["success"] = 1;
                    $response["message"] = "Displaying post details";
                    $response["posts"] = $rows;
                    return json_encode($response);
                } else {
                    $response["success"] = 0;
                    $response["message"] = "No more post available";
                    return json_encode($response);
                }
            } catch (PDOException $e) {
                $response["success"] = 0;
                $response["message"] = "No more post available" . $e;
                return json_encode($response);
            }
        }
    }

    /*     * ********************************************************************************************** */

    /*     * *********************************** get album image ****************************** */

    function getAlbumImage($albumid, $device = '') {
        $this->albumid = $albumid;
        try {
            $server_name = ($device == '') ? dirname(SITE_URL) . '/' : SITE;

            /*             * ***************** album details *********************** */
            $query1 = "select * From Tbl_C_AlbumDetails as album join Tbl_C_AlbumCategory as category on category.categoryId=album.categoryId where album.albumId = :aid1";
            $stmt1 = $this->DB->prepare($query1);
            $stmt1->bindParam(':aid1', $this->albumid, PDO::PARAM_STR);
            $stmt1->execute();
            $rows1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);
            /*             * ******************************************************* */
            if ($rows1) {
                if ($device == 'panel') {
                    $query = "select albumimg.*, if(albumimg.imgName IS NULL or albumimg.imgName ='', '', concat('" . $server_name . "',albumimg.imgName)) as imgName , DATE_FORMAT(albumimg.createdDate	,'%d %b %Y %h:%i %p') as createdDate , DATE_FORMAT(albumimg.ApprovedDate ,'%d %b %Y %h:%i %p') as ApprovedDate , CONCAT(edm.firstName,' ', edm.middleName , ' ', edm.lastName) as uploadedBy from Tbl_C_AlbumImage as albumimg JOIN Tbl_EmployeeDetails_Master as edm ON albumimg.createdBy = edm.employeeId where albumimg.albumId =:aid and albumimg.status != 3 order by albumimg.autoId desc";
                } else {
                    $query = "select *, if(imgName IS NULL or imgName ='', '',concat('" . $server_name . "',imgName)) as imgName  from Tbl_C_AlbumImage where albumId =:aid AND status = 1 order by autoId desc";
                }
                $stmt = $this->DB->prepare($query);
                $stmt->bindParam(':aid', $this->albumid, PDO::PARAM_STR);

                $stmt->execute();
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);


                //   print_r($rows);
                if ($rows > 0) {
                    $response["success"] = 1;
                    $response["message"] = "Displaying post details";
                    $response["posts"] = $rows;
                    $response["album"] = $rows1;
                    return json_encode($response);
                } else {
                    $response["success"] = 0;
                    $response["message"] = "No post details Available";
                    return json_encode($response);
                }
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

    /*     * ************************** / get album image ****************************** */

    /*     * ************************* / album sent to group ************** */

    public function albumSentToGroup($clientId, $albumId, $bundleId, $GroupId) {
        $this->client = $clientId;
        $this->albumId = $albumId;
        $this->bundleId = $bundleId;
        $this->groupid = $GroupId;
        date_default_timezone_set('Asia/Kolkata');
        $today = date("Y-m-d H:i:s");
        $flag = 11;
        try {
            $query = "insert into Tbl_Analytic_AlbumSentToGroup(clientId,albumId,bundleId,groupId,sentDate,flagType)values(:cid,:aid,:bid,:gid,:today,:flag)";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cid', $this->client, PDO::PARAM_STR);
            $stmt->bindParam(':aid', $this->albumId, PDO::PARAM_STR);
            $stmt->bindParam(':bid', $this->bundleId, PDO::PARAM_STR);            
            $stmt->bindParam(':gid', $this->groupid, PDO::PARAM_STR);
            $stmt->bindParam(':today', $today, PDO::PARAM_STR);
            $stmt->bindParam(':flag', $flag, PDO::PARAM_STR);
            $response = array();

            if ($stmt->execute()) {
                $response["success"] = 1;
                $response["message"] = "successfully inserted data";
                return json_encode($response);
            } else {
                $response["success"] = 0;
                $response["message"] = "no inserted data";
                return json_encode($response);
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

    /*     * ************************* / album sent to group ************** */
    /*     * ******************* get album image details ************************************** */

    /* function getalbumimagedetails($albumid, $imageid) {

      try {
      $query = "select * from Tbl_C_AlbumImage where albumId = :albumid AND autoId = :imgid";
      $stmt = $this->DB->prepare($query);
      $stmt->bindParam(':albumid', $albumid, PDO::PARAM_STR);
      $stmt->bindParam(':imgid', $imageid, PDO::PARAM_STR);
      $stmt->execute();
      } catch (PDOException $e) {
      echo $e;
      }

      $rows = $stmt->fetchAll();
      $response["success"] = 1;
      $response["message"] = "Displaying Album Image details";
      $response["posts"] = array();

      if ($rows) {
      for ($i = 0; $i < count($rows); $i++) {
      $post["post_title"] = $rows[$i]["title"];
      $post["post_img"] = $rows[$i]["imgName"];
      array_push($response["posts"], $post);
      }
      return json_encode($response);
      }
      } */

    /* function getAllAlbumImageDetails($albumid, $clientid = '', $device = '') {
      $this->albumid = $albumid;
      $status = 1;
      try {
      $server_name = ($device == '') ? dirname(SITE_URL) . '/' : SITE;


      $query = "select *, if(imgName IS NULL or imgName='', '',concat('" . $server_name . "',imgName)) as imgName  from Tbl_C_AlbumImage where albumId =:aid AND status = 1 order by autoId desc";
      $stmt = $this->DB->prepare($query);
      $stmt->bindParam(':aid', $this->albumid, PDO::PARAM_STR);

      $stmt->execute();
      $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

      //            print_r($rows);die;

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

      $imgautoid = $rows[$i]["autoId"];
      $albid = $rows[$i]["albumId"];


      $query = "select count(imageId) as total_likes from Tbl_Analytic_AlbumLike where albumId =:albumid AND imageId = :imgid and status = :status";
      $stmt = $this->DB->prepare($query);

      $stmt->bindParam(':albumid', $albid, PDO::PARAM_STR);
      $stmt->bindParam(':imgid', $imgautoid, PDO::PARAM_INT);
      $stmt->bindParam(':status', $status, PDO::PARAM_INT);

      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);


      include_once('Api_Class/class_albumLike.php');
      include_once('Api_Class/class_comment_album.php');

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
     */

    /*     * *************************** end get album image details ***************************** */

    /*     * ****************** get album image like *************************************** */

    function getAlbumImagelike($albumid, $imageid) {

        try {
            $query1 = "SELECT *,DATE_FORMAT(createdDate	,'%d %b %Y %h:%i %p') as createdDate FROM Tbl_Analytic_AlbumLike WHERE albumId = :aid AND imageId = :imgid AND status = 1";
            $stmt1 = $this->DB->prepare($query1);
            $stmt1->bindParam(':aid', $albumid, PDO::PARAM_STR);
            $stmt1->bindParam(':imgid', $imageid, PDO::PARAM_STR);
            $stmt1->execute();
            $rows = $stmt1->fetchAll();
            $count = count($rows);
            $response["posts"] = array();
            $response["total_like"] = $count;

            if ($rows) {

                $forimage = SITE;

                $response["success"] = 1;
                $response["message"] = "likes available";

                $i = 0;
                while ($i < count($rows)) {
                    $post = array();

                    $post["albumId"] = $rows[$i]["albumId"];
                    $post["imageId"] = $rows[$i]["imageId"];
                    $post["userId"] = $rows[$i]["userId"];
                    $mailid = $rows[$i]["userId"];

                    $query2 = "SELECT Tbl_EmployeeDetails_Master.*, Tbl_EmployeePersonalDetails.* FROM Tbl_EmployeeDetails_Master join Tbl_EmployeePersonalDetails on Tbl_EmployeeDetails_Master.employeeId = Tbl_EmployeePersonalDetails.employeeId WHERE Tbl_EmployeeDetails_Master.employeeId =:maid";

                    $stmt2 = $this->DB->prepare($query2);
                    $stmt2->bindParam(':maid', $mailid, PDO::PARAM_STR);
                    $stmt2->execute();
                    $row = $stmt2->fetch(PDO::FETCH_ASSOC);

                    //echo'<pre>';print_r($row);
                    $post["firstname"] = $row["firstName"];
					$post["middlename"] = $row["middleName"];
                    $post["lastname"] = $row["lastName"];
                    $post["designation"] = $row["designation"];
                    // $post["userimage"] = ($row["userImage"]==''?'':$forimage . $row["userImage"]);

                    $post["userimage"] = ($row["linkedIn"] == '1' ? $row["userImage"] : ($row["userImage"] == '' ? '' : $forimage . $row["userImage"]));
                    $post["cdate"] = $rows[$i]["createdDate"];
                    //$posts[] = $post;
                    //echo'<pre>';print_r($posts);

                    array_push($response["posts"], $post);
                    $i++;
                }
                return json_encode($response);
            } else {
                $response["success"] = 0;
                $response["message"] = "There is no Like for this post";
                return json_encode($response);
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

    /*     * ******************* end album image like *************************************** */

    /*     * ****************************** album image comment ********************************* */

    function getAlbumImageComment($albumid, $imageid) {
        $status = 1;
        try {
            $query1 = "SELECT *,DATE_FORMAT(createdDate,'%d %b %Y %h:%i %p') as commentDate FROM Tbl_Analytic_AlbumComment WHERE albumId = :albumid and imageId = :imgid and status = :status";
            $stmt1 = $this->DB->prepare($query1);
            $stmt1->bindParam(':albumid', $albumid, PDO::PARAM_STR);
            $stmt1->bindParam(':imgid', $imageid, PDO::PARAM_STR);
            $stmt1->bindParam(':status', $status, PDO::PARAM_STR);
            $stmt1->execute();
            $rows = $stmt1->fetchAll();

            $response["posts"] = array();


            if ($rows) {
                $forimage = SITE;

                $response["success"] = 1;
                $response["message"] = "comments available";

                for ($i = 0; $i < count($rows); $i++) {
                    $post = array();

                    $post["comment_id"] = $rows[$i]["commentId"];
                    $post["albumid"] = $rows[$i]["albumId"];
                    $post["imageId"] = $rows[$i]["imageId"];
                    $post["content"] = $rows[$i]["comments"];
                    $post["commentby"] = $rows[$i]["userId"];
                    $mailid = $rows[$i]["userId"];

                    $query2 = "SELECT Tbl_EmployeeDetails_Master.*, Tbl_EmployeePersonalDetails.* FROM Tbl_EmployeeDetails_Master join Tbl_EmployeePersonalDetails on Tbl_EmployeeDetails_Master.employeeId = Tbl_EmployeePersonalDetails.employeeId WHERE Tbl_EmployeeDetails_Master.employeeId =:maid";
                    $stmt2 = $this->DB->prepare($query2);
                    $stmt2->bindParam(':maid', $mailid, PDO::PARAM_STR);
                    $stmt2->execute();
                    $row = $stmt2->fetchAll();

                    $post["firstname"] = $row[0]["firstName"];
                    $post["middlename"] = $row[0]["middleName"];
                    $post["lastname"] = $row[0]["lastName"];
                    $post["designation"] = $row[0]["designation"];
                    // $post["userimage"] = ($row[0]["userImage"]==''?'':$forimage . $row[0]["userImage"]);

                    $post["userimage"] = ($row[0]["linkedIn"] == '1' ? $row[0]["userImage"] : ($row[0]["userImage"] == '' ? '' : $forimage . $row[0]["userImage"]));

                    $post["cdate"] = $rows[$i]["commentDate"];


                    array_push($response["posts"], $post);
                }

                return json_encode($response);
            } else {
                $response["success"] = 0;
                $response["message"] = "There is no comments for this post";
                return json_encode($response);
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

    /*     * ********************** end album image comment *************************************** */

    /*     * ************************* album status change **************************** */

    public $idpost;
    public $statuspost;

    function status_Post($com, $coms) {

        $this->idpost = $com;
        $this->statuspost = $coms;
        if ($this->statuspost == 1) {
            $welstatus = "Publish";
        } else {
            $welstatus = "Unpublish";
        }
        try {
            /* $query = "update Tbl_C_AlbumImage set status = :sta where albumId = :comm AND status != 3";
              $stmt = $this->DB->prepare($query);
              $stmt->bindParam(':comm', $this->idpost, PDO::PARAM_STR);
              $stmt->bindParam(':sta', $this->statuspost, PDO::PARAM_STR);
              $stmt->execute(); */

            $pquery = "update Tbl_C_AlbumDetails set status = :sta3 where albumId = :comm3 AND flagType = 11 ";
            $stmtp = $this->DB->prepare($pquery);
            $stmtp->bindParam(':comm3', $this->idpost, PDO::PARAM_STR);
            $stmtp->bindParam(':sta3', $this->statuspost, PDO::PARAM_STR);
            $stmtp->execute();

            /* $cquery = "update Tbl_Analytic_AlbumComment set status = :sta4 where albumId = :comm4 ";
              $stmtc = $this->DB->prepare($cquery);
              $stmtc->bindParam(':comm4', $this->idpost, PDO::PARAM_STR);
              $stmtc->bindParam(':sta4', $this->statuspost, PDO::PARAM_STR);
              $stmtc->execute();

              $lquery = "update Tbl_Analytic_AlbumLike set status = :sta5 where albumId = :comm5 ";
              $stmtl = $this->DB->prepare($lquery);
              $stmtl->bindParam(':comm5', $this->idpost, PDO::PARAM_STR);
              $stmtl->bindParam(':sta5', $this->statuspost, PDO::PARAM_STR);
              $stmtl->execute(); */

            $squery = "update Tbl_Analytic_AlbumSentToGroup set status = :sta6 where albumId = :comm6 AND flagType = 11";
            $stmts = $this->DB->prepare($squery);
            $stmts->bindParam(':comm6', $this->idpost, PDO::PARAM_STR);
            $stmts->bindParam(':sta6', $this->statuspost, PDO::PARAM_STR);
            $stmts->execute();

            $wquery = "update Tbl_C_WelcomeDetails set status = :sta1 where id = :comm1 And flagType = 11";
            $stmtw = $this->DB->prepare($wquery);
            $stmtw->bindParam(':comm1', $this->idpost, PDO::PARAM_STR);
            $stmtw->bindParam(':sta1', $this->statuspost, PDO::PARAM_STR);
            //$stmtw->execute();

            $response = array();

            if ($stmtw->execute()) {
                $response["success"] = 1;
                $response["message"] = "status has changed";
                return json_encode($response);
            } else {
                $response["success"] = 0;
                $response["message"] = "status not changed";
                return json_encode($response);
            }
        } catch (PDOException $e) {
            $response["success"] = 0;
            $response["message"] = "status not changed" . $e;
            return json_encode($response);
        }
    }

    /*     * *************************** end album status change ***************************** */

    /*     * ********************************album image status *************************************** */


     function status_albumImage($albumid, $imgid, $status) {


      try {
      $aquery = "Select * from Tbl_C_AlbumImage where albumId = :albumid3 AND status = 1";
      $stmta = $this->DB->prepare($aquery);
      $stmta->bindParam(':albumid3', $albumid, PDO::PARAM_STR);
      $stmta->execute();
      $row = $stmta->fetchAll();
     
	  $rowcount = count($row);
	
			if($rowcount > 3)
			{
				  $query = "update Tbl_C_AlbumImage set status = :sta where albumId = :albumid And autoId = :imgid";
				  $stmt = $this->DB->prepare($query);
				  $stmt->bindParam(':albumid', $albumid, PDO::PARAM_STR);
				  $stmt->bindParam(':sta', $status, PDO::PARAM_STR);
				  $stmt->bindParam(':imgid', $imgid, PDO::PARAM_STR);
				  $tres = $stmt->execute();

				  $response = array();

				  if ($tres) {
				  $response["success"] = 1;
				  $response["message"] = "status has changed";
				  return json_encode($response);
				  }
				  else
				  {
				  $response["success"] = 0;
				  $response["message"] = "status not change";
				  return json_encode($response);

				  }
			}
			else
			{
				  $response["success"] = 0;
				  $response["message"] = "Sorry , Minimum 3 images are required in album";
				  return json_encode($response);		  
			}
    
      }
      catch (PDOException $e) {
		  $response["success"] = 0;
		  $response["message"] = "status not change".$e;
		  return json_encode($response);		
      }
      }
     

    /*     * **************************************** end album image status ***************************** */

    /*     * ************************ get all album Details for api ******************* */
    /*
      function getAllAlbum($cid, $uuid, $device = '') {

      $this->client = $cid;
      $this->author = $uuid;

      $server_name = ($device == '') ? dirname(SITE_URL) . '/' : SITE;

      /////////////////// check user detail ////////////////////////////////
      $query2 = "select * from Tbl_EmployeeDetails_Master where clientId=:cli and employeeId=:empid and status = 'Active'";
      $stmt2 = $this->DB->prepare($query2);
      $stmt2->bindParam(':cli', $cid, PDO::PARAM_STR);
      $stmt2->bindParam(':empid', $uuid, PDO::PARAM_STR);
      $stmt2->execute();
      $rows2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
      //print_r($rows2);

      ///////////////////////// end check user detail //////////////////////

      if (count($rows2) > 0)
      {
      ///////////////////////// find user group ///////////////////////////////
      $uuids = $rows2[0]['employeeId'];
      //echo "employee id -".$uuids;
      $group_object = new FindGroup();    // this is object to find group id of given unique id
      $getgroup = $group_object->groupBaseofUid($cid, $uuids);
      $value = json_decode($getgroup, true);
      //echo'<pre>';
      //print_r($value);
      //////////////////////////// end find user group ////////////////////////

      if (count($value['groups']) > 0)
      {
      $in = implode("', '", array_unique($value['groups']));
      //echo $in;

      try {

      ///////////////////// fetch album id //////////////////////////
      $query3 = "select distinct(albumId) from Tbl_Analytic_AlbumSentToGroup where clientId=:cli and status = 1 and flagType = 11 and groupId IN('" . $in . "') order by autoId desc";

      $stmt3 = $this->DB->prepare($query3);
      $stmt3->bindParam(':cli', $cid, PDO::PARAM_STR);
      $stmt3->execute();
      $rows3 = $stmt3->fetchAll(PDO::FETCH_ASSOC);
      //print_r($rows3);
      $post = array();

      //////////////////////////// end fetch album id //////////////////////////////
      if (count($rows3) > 0)
      {
      $response["success"] = 1;
      $response["message"] = "Displaying post details";
      $response["posts"] = array();
      foreach ($rows3 as $row)
      {
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
      }
      else
      {
      $response["success"] = 0;
      $response["message"] = "No more post available";
      return json_encode($response);
      }
      }    // try closing
      catch (PDOException $e)
      {
      echo $e;
      }
      }
      else
      {
      $response["success"] = 0;
      $response["message"] = "You are not selected in any group";
      return json_encode($response);
      }
      }
      else
      {
      $response["success"] = 0;
      $response["message"] = "Sorry! You are Not Authorized User";
      return json_encode($response);
      }
      }   //	function closing
     */
    /*     * ******************************** end get all album detail for api ***************************** */

    /*     * ******************************* get album category ************************* */

    public function getAlbumCategory($clientId, $empId) {
        try {

            $query = "SELECT * FROM Tbl_C_AlbumCategory WHERE clientId = :cid AND createdBy = :empid AND status = 1 order by categoryName";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cid', $clientId, PDO::PARAM_STR);
            $stmt->bindParam(':empid', $empId, PDO::PARAM_STR);
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

    /*     * *************************** / get album category *************************** */

    /*     * ****************************** add category ******************************* */

    function addAlbumCategory($clientId, $empId, $categoryname, $categoryimg) {
        date_default_timezone_set('Asia/Calcutta');
        $today = date("Y-m-d H:i:s");
        $status = 1;
        try {
            $query = "insert into Tbl_C_AlbumCategory (clientId, categoryName,categoryImage, status, createdBy, createdDate) values(:cid,:cname,:cimg,:status,:empid,:cdate)";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cid', $clientId, PDO::PARAM_STR);
            $stmt->bindParam(':empid', $empId, PDO::PARAM_STR);
            $stmt->bindParam(':cname', $categoryname, PDO::PARAM_STR);
            $stmt->bindParam(':cimg', $categoryimg, PDO::PARAM_STR);
            $stmt->bindParam(':cdate', $today, PDO::PARAM_STR);
            $stmt->bindParam(':status', $status, PDO::PARAM_STR);
            if ($stmt->execute()) {
                $response["success"] = 1;
                $response["message"] = "Category Added Successfully";
            } else {
                $response["success"] = 0;
                $response["message"] = "Category Not Added";
            }
        } catch (PDOException $e) {
            $response["success"] = 0;
            $response["message"] = "Category Not Added" . $e;
        }
        return json_encode($response);
    }

    /*     * ******************************* / add category **************************** */

    /*     * *************************** edit category ************************************ */

    function editAlbumCategory($clientId, $empId, $oldcategoryid, $newcategoryname) {
        date_default_timezone_set('Asia/Calcutta');
        $today = date("Y-m-d H:i:s");
        try {
            $query = "UPDATE Tbl_C_AlbumCategory SET categoryName = :newcatname , updatedBy = :empid , updatedDate = :updateddate WHERE clientId = :cid AND categoryId = :oldcatid";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cid', $clientId, PDO::PARAM_STR);
            $stmt->bindParam(':empid', $empId, PDO::PARAM_STR);
            $stmt->bindParam(':oldcatid', $oldcategoryid, PDO::PARAM_STR);
            $stmt->bindParam(':newcatname', $newcategoryname, PDO::PARAM_STR);
            $stmt->bindParam(':updateddate', $today, PDO::PARAM_STR);
            if ($stmt->execute()) {
                $response["success"] = 1;
                $response["message"] = "Category Updated Successfully";
            } else {
                $response["success"] = 0;
                $response["message"] = "Category Not updated";
            }
        } catch (PDOException $e) {
            $response["success"] = 0;
            $response["message"] = "Category Not updated" . $e;
        }
        return json_encode($response);
    }

    /*     * ***************************** / edit category ******************************** */

    /*     * *************************** delete category ************************************ */

    function deleteAlbumCategory($clientId, $empId, $categoryid) {
        date_default_timezone_set('Asia/Calcutta');
        $today = date("Y-m-d H:i:s");
        $status = 0;
        $flag = 11;
        $in = implode("', '", array_unique($categoryid));
        //echo $in;
        try {

            $query = "select albumId,categoryId FROM Tbl_C_AlbumDetails where categoryId IN('" . $in . "') and clientId =:cid ";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cid', $clientId, PDO::PARAM_STR);
            $stmt->execute();
            $albumdetails = $stmt->fetchAll(PDO::FETCH_ASSOC);
            /* echo "<pre>";
              print_r($albumdetails);
              echo count($albumdetails); */
            if (count($albumdetails) > 0) {
                for ($i = 0; $i < count($albumdetails); $i++) {
                    $albumId = $albumdetails[$i]['albumId'];
                    $categoryId1 = $albumdetails[$i]['categoryId'];

                    /*                     * ********************* update Tbl_C_AlbumDetails *************** */
                    $query1 = "Update Tbl_C_AlbumDetails SET status = :status1 WHERE clientId = :cid1 AND albumId = :aid1 AND categoryId = :catid1 AND flagType = :flag1 ";
                    $stmt1 = $this->DB->prepare($query1);
                    $stmt1->bindParam(':cid1', $clientId, PDO::PARAM_STR);
                    $stmt1->bindParam(':aid1', $albumId, PDO::PARAM_STR);
                    $stmt1->bindParam(':catid1', $categoryId1, PDO::PARAM_STR);
                    $stmt1->bindParam(':status1', $status, PDO::PARAM_STR);
                    $stmt1->bindParam(':flag1', $flag, PDO::PARAM_STR);
                    $stmt1->execute();
                    /*                     * ******************** / update Tbl_C_AlbumDetails *************** */

                    /*                     * ****************** update album image ***************************** */
                    $query2 = "Update Tbl_C_AlbumImage SET status = :status2 WHERE albumId = :aid2 ";
                    $stmt2 = $this->DB->prepare($query2);
                    $stmt2->bindParam(':aid2', $albumId, PDO::PARAM_STR);
                    $stmt2->bindParam(':status2', $status, PDO::PARAM_STR);
                    $stmt2->execute();
                    /*                     * ****************** / update album image *************************** */

                    /*                     * ************* update album sent to group ***************************** */
                    $query3 = "Update Tbl_Analytic_AlbumSentToGroup SET status = :status3 WHERE albumId = :aid3 AND flagType = :flag3 AND clientId = :cid3 ";
                    $stmt3 = $this->DB->prepare($query3);
                    $stmt3->bindParam(':aid3', $albumId, PDO::PARAM_STR);
                    $stmt3->bindParam(':status3', $status, PDO::PARAM_STR);
                    $stmt3->bindParam(':cid3', $clientId, PDO::PARAM_STR);
                    $stmt3->bindParam(':flag3', $flag, PDO::PARAM_STR);
                    $stmt3->execute();
                    /*                     * ************** / update album sent to group *************************** */

                    /*                     * ************** update welcome table ************************************** */
                    $query4 = "Update Tbl_C_WelcomeDetails SET status = :status4 WHERE 	id = :aid4 AND flagType = :flag4 AND clientId = :cid4 ";
                    $stmt4 = $this->DB->prepare($query4);
                    $stmt4->bindParam(':aid4', $albumId, PDO::PARAM_STR);
                    $stmt4->bindParam(':status4', $status, PDO::PARAM_STR);
                    $stmt4->bindParam(':cid4', $clientId, PDO::PARAM_STR);
                    $stmt4->bindParam(':flag4', $flag, PDO::PARAM_STR);
                    $stmt4->execute();
                    /*                     * ****************** / update welcome table ************************** */
                }
			}
                //echo "<pre>";
                //print_r($categoryid);
                //echo count($categoryid);
                /*                 * ************************** update category status ************** */
                for ($i = 0; $i < count($categoryid); $i++) {
                    $catid = $categoryid[$i];
                    $query5 = "Update Tbl_C_AlbumCategory SET status = :status5 WHERE categoryId = :catid5 AND clientId = :cid5 ";
                    $stmt5 = $this->DB->prepare($query5);
                    $stmt5->bindParam(':status5', $status, PDO::PARAM_STR);
                    $stmt5->bindParam(':cid5', $clientId, PDO::PARAM_STR);
                    $stmt5->bindParam(':catid5', $catid, PDO::PARAM_STR);
                    $cateres = $stmt5->execute();
                }

                /*                 * ******************* / update category status ******************* */
                if ($cateres) {
                    $response["success"] = 1;
                    $response["message"] = "Status Updated Successfully";
                } else {
                    $response["success"] = 0;
                    $response["message"] = "Status Not Updated";
                }
             
            }
         catch (PDOException $e) {
            $response["success"] = 0;
            $response["message"] = "Category Not updated" . $e;
        }
        return json_encode($response);
    }

    /*     * ***************************** / delete category ******************************** */

    /*     * ********************* image approve reject ************************************* */
    /*     * ************************* album status change **************************** */

    function albumImageApproveReject($albumid, $imageId, $status) {
	$welcomeQuery = "DELETE FROM Tbl_C_WelcomeDetails WHERE id=:albumid";
        $stmt = $this->DB->prepare($welcomeQuery);
        $stmt->bindParam(':albumid', $albumid, PDO::PARAM_STR);
        if ($stmt->execute()) {
		try {
		    $query = "update Tbl_C_AlbumImage set status = :status where albumId = :albumid AND autoId = :imageid";
		    $stmt = $this->DB->prepare($query);
		    $stmt->bindParam(':albumid', $albumid, PDO::PARAM_STR);
		    $stmt->bindParam(':imageid', $imageId, PDO::PARAM_STR);
		    $stmt->bindParam(':status', $status, PDO::PARAM_STR);
		    $row = $stmt->execute();
		    $response = array();

		    if ($row) {
		    	$albumData = json_decode(self::getAlbumImage($albumid), true);
			date_default_timezone_set('Asia/Kolkata');
			$Post_Date = date('Y-m-d H:i:s');
			$albumtitle = $albumData['album'][0]['title'];
			$Uuid = $albumData['album'][0]['createdby'];
			$Client_Id = 'CO-28';
			$Flag = 11;
			$type = "Album";
			$img = "";

			include_once('class_welcomeTable.php');
			$welcome_obj = new WelcomePage;
			$welcome_obj->createWelcomeData($Client_Id, $albumid, $type, $albumtitle, $img, $Post_Date, $Uuid, $Flag);

		    
		        $response["success"] = 1;
		        $response["message"] = "Album Image Approved Successfully";
		        return json_encode($response);
		    } else {
		        $response["success"] = 0;
		        $response["message"] = "Image Not Approve";
		        return json_encode($response);
		    }
		} catch (PDOException $e) {
		    $response["success"] = 0;
		    $response["message"] = "Image Not Approve" . $e;
		    return json_encode($response);
		}
        } else {
            $response["success"] = 0;
            $response["message"] = "Something went wrong";
            return json_encode($response);
        }
    }

    /*     * *************************** end album status change ***************************** */
    /*     * ************************** / image approve reject ****************************** */
	
	/***************************** album details ************************************ */

    function getAlbumDetails($clientId, $albumid , $imageid , $imgpath = '') {
        
		if($imgpath == '')
		{
			$path = SITE;
		}
		else
		{
			$path = $imgpath;
		}
		
        try {
            $query = "Select album.title , image.imageCaption , CONCAT('". $path ."',image.imgName) as imgName From Tbl_C_AlbumDetails as album JOIN Tbl_C_AlbumImage as image ON album.albumId = image.albumId where album.albumId = :albumid AND album.clientId = :cid AND image.autoId = :imgid";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cid', $clientId, PDO::PARAM_STR);
            $stmt->bindParam(':albumid', $albumid, PDO::PARAM_STR);
            $stmt->bindParam(':imgid', $imageid, PDO::PARAM_STR);
            if ($stmt->execute()) {
				$res = $stmt->Fetch(PDO::FETCH_ASSOC);
                $response["success"] = 1;
                $response["message"] = "Album Details Fetched Successfully";
				$response["data"] = $res;
            } else {
                $response["success"] = 0;
                $response["message"] = "Album Details Not Fetch";
            }
        } catch (PDOException $e) {
            $response["success"] = 0;
            $response["message"] = "Album Details Not Fetch" . $e;
        }
        return json_encode($response);
    }

    /******************************* / album details *********************************/
	
	/*     * ************************* album status change **************************** */

    function albumImagestatuschange($albumid, $imageId, $status) {

        try {
            $query = "update Tbl_C_AlbumImage set status = :status where albumId = :albumid AND autoId = :imageid";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':albumid', $albumid, PDO::PARAM_STR);
            $stmt->bindParam(':imageid', $imageId, PDO::PARAM_STR);
            $stmt->bindParam(':status', $status, PDO::PARAM_STR);
            $row = $stmt->execute();
            $response = array();

            if ($row) {
                $response["success"] = 1;
                $response["message"] = "Album Image Approved Successfully";
                return json_encode($response);
            } else {
                $response["success"] = 0;
                $response["message"] = "Image Not Approve";
                return json_encode($response);
            }
        } catch (PDOException $e) {
            $response["success"] = 0;
            $response["message"] = "Image Not Approve" . $e;
            return json_encode($response);
        }
    }

    /*     * *************************** end album status change ***************************** */
	
	/*********************** get album group *************************/
	
	function getAlbumGroup($clientid , $albumid)
	{
          
     try{
     $query = "select * from Tbl_Analytic_AlbumSentToGroup where clientId=:cli AND albumId = :aid order by autoid desc";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cli', $clientid, PDO::PARAM_STR);
			$stmt->bindParam(':aid', $albumid, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetchAll();
           if($rows)
           {
           $result=array();

           $result['success'] = 1;
           $result['message'] = "successfully fetch data";
           $result['posts']=$rows;

           return json_encode($result);
           }
       }
       catch(PDOException $ex)
       {
       echo $ex;
       }
}

	
	/************************ / get album group **********************/
	
	/********************************** get pending bundle ***********************/

function getPendingBundle($clientid, $albumid='') {    
     try{
	    $query = "select category.categoryName , albumdetails.title , DATE_FORMAT(albumimage.createdDate,'%d %b %Y %h:%i %p') as createdDate,  albumimage.bundleId , CONCAT(edm.firstName , ' ', edm.middleName , ' ', edm.lastName) as createdbyname , count(albumimage.bundleId) as totalimage , (select count(bundleId) From Tbl_C_AlbumImage where bundleId = albumimage.bundleId AND status = 1 ) as approveImage , (select count(bundleId) From Tbl_C_AlbumImage where bundleId = albumimage.bundleId AND status = 2 ) as pendingImage from Tbl_C_AlbumImage as albumimage JOIN Tbl_C_AlbumDetails as albumdetails ON albumimage.albumId = albumdetails.albumId JOIN Tbl_C_AlbumCategory as category ON albumdetails.categoryId = category.categoryId JOIN Tbl_EmployeeDetails_Master as edm ON albumimage.createdBy = edm.employeeId where albumdetails.clientId=:cli";
	     
	    if(empty($albumid)) {
	    	$query .= " AND albumimage.seen = 0";
	    } else {
	    	$query .= " AND albumimage.albumId='$albumid'";
	    }
	     
	    $query .= " group by albumimage.bundleId order by albumimage.bundleId, albumimage.createdDate desc";
     
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cli', $clientid, PDO::PARAM_STR);
	    $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	    $result=array();
	    
           if($rows) {
		   $result['success'] = 1;
		   $result['message'] = "successfully fetch data";
		   $result['posts']=$rows;
		   return json_encode($result);
           } else {
		   $result['success'] = 0;
	   	   $result['message'] = "Data not fetch";
		   return json_encode($result);  
	   }
       } catch(PDOException $ex) {
		$result['success'] = 0;
		$result['message'] = "Data not fetch". $ex;
		return json_encode($result);
       }
}

/********************************** / get pending bundle *********************/

/********************************** get pending bundle image ***********************/

function getPendingBundleImage($clientId , $bundleId) {  
$imgpath = SITE;
$status = 2; 
     try{
	    $query = "select * , if(imgName IS NULL OR imgName = '' , '' , CONCAT('".$imgpath."', imgName)) as imgName from Tbl_C_AlbumImage where bundleId=:bundleid And status =:sta ";
	     
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':bundleid', $bundleId, PDO::PARAM_STR);
			$stmt->bindParam(':sta', $status, PDO::PARAM_STR);
	    $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	    $result=array();
	    
           if($rows) {
		   $result['success'] = 1;
		   $result['message'] = "successfully fetch data";
		   $result['posts']=$rows;
		   return json_encode($result);
           } else {
		   $result['success'] = 0;
	   	   $result['message'] = "Data not fetch";
		   return json_encode($result);  
	   }
       } catch(PDOException $ex) {
		$result['success'] = 0;
		$result['message'] = "Data not fetch". $ex;
		return json_encode($result);
       }
}

/********************************** / get pending bundle image*********************/

/**************************** bundle image status *****************/

function BundleImagestatus($bundleid,$imageid,$status) {
		date_default_timezone_set('Asia/Kolkata');
		$Post_Date = date('Y-m-d H:i:s');
	try{
			$query = "update Tbl_C_AlbumImage set status = :status , ApprovedDate = :approvedate where bundleId = :bundleid AND autoId = :imageid";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':bundleid', $bundleid, PDO::PARAM_STR);
            $stmt->bindParam(':imageid', $imageid, PDO::PARAM_STR);
            $stmt->bindParam(':status', $status, PDO::PARAM_STR);
			$stmt->bindParam(':approvedate', $Post_Date, PDO::PARAM_STR);
            $row = $stmt->execute();
		   $result=array();
           if($row) {
		   $result['success'] = 1;
		   $result['message'] = "status updated successfully";
           } else {
		   $result['success'] = 0;
	   	   $result['message'] = "status not updated successfully"; 
			}
		
       } catch(PDOException $ex) {
		$result['success'] = 0;
		$result['message'] = "status not updated successfully". $ex;
		
       }
	   return json_encode($result);
    }

/*************************** / bundle image status ****************/

function BundleImageseen($bundleid,$seen) {
		//echo "hi";
	try{
			$query = "update Tbl_C_AlbumImage set seen = :seen where bundleId = :bundleid";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':bundleid', $bundleid, PDO::PARAM_STR);
            $stmt->bindParam(':seen', $seen, PDO::PARAM_STR);
            $row = $stmt->execute();
		   $result=array();
           if($row) {
		   $result['success'] = 1;
		   $result['message'] = "status updated successfully";
           } else {
		   $result['success'] = 0;
	   	   $result['message'] = "status not updated successfully"; 
			}
		
       } catch(PDOException $ex) {
		$result['success'] = 0;
		$result['message'] = "status not updated successfully". $ex;
		
       }
	   return json_encode($result);
    }
	
/*************************** / bundle image status ****************/

/********************* get single bundle image detail *******************/

function singleBundleImageDetail($imgid,$bundleid , $imgpath) {  

     try{
	    $query = "select albumimage.* , if(albumimage.imgName IS NULL OR albumimage.imgName = '' , '' , CONCAT('".$imgpath."', albumimage.imgName)) as imgName , CONCAT(edm.firstName , ' ', edm.middleName, ' ' , edm.lastName) as createdbyname from Tbl_C_AlbumImage as albumimage JOIN Tbl_EmployeeDetails_Master as edm ON albumimage.createdBy = edm.employeeId where albumimage.bundleId=:bundleid And albumimage.autoId = :imageid";
	     
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':bundleid', $bundleid, PDO::PARAM_STR);
			$stmt->bindParam(':imageid', $imgid, PDO::PARAM_STR);
	    $stmt->execute();
            $rows = $stmt->fetch(PDO::FETCH_ASSOC);
	    $result=array();
	    
           if($rows) {
		   $result['success'] = 1;
		   $result['message'] = "successfully fetch data";
		   $result['posts']=$rows;
		   return json_encode($result);
           } else {
		   $result['success'] = 0;
	   	   $result['message'] = "Data not fetch";
		   return json_encode($result);  
	   }
       } catch(PDOException $ex) {
		$result['success'] = 0;
		$result['message'] = "Data not fetch". $ex;
		return json_encode($result);
       }
}

/********************* get single bundle image detail *******************/

/********************************** get All budle image ***********************/

function getBundleImageAll($clientId , $bundleId) {  
$imgpath = SITE;
$status = 2; 
     try{
	    $query = "select * , if(imgName IS NULL OR imgName = '' , '' , CONCAT('".$imgpath."', imgName)) as imgName from Tbl_C_AlbumImage where bundleId=:bundleid";
	     
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':bundleid', $bundleId, PDO::PARAM_STR);
			
			$stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);			
			
	      $result=array();
	    
           if($rows) {
			
			/************************ get count *****************************/			
			$query1 = "select (select count(autoId) from Tbl_C_AlbumImage where bundleId=:bundleid AND status = 1) as approvetotalcount , (select count(autoId) from Tbl_C_AlbumImage where bundleId=:bundleid AND status = 2) as pendingtotalcount , (select count(autoId) from Tbl_C_AlbumImage where bundleId=:bundleid AND status = 0) as unpublishtotalcount , (select count(autoId) from Tbl_C_AlbumImage where bundleId=:bundleid AND status = 3) as rejecttotaltotalcount from Tbl_C_AlbumImage where bundleId=:bundleid";
	     
            $stmt1 = $this->DB->prepare($query1);
            $stmt1->bindParam(':bundleid', $bundleId, PDO::PARAM_STR);
			
			$stmt1->execute();
            $rows1 = $stmt1->fetch(PDO::FETCH_ASSOC);
			
			
			/************************ / get count ****************/
			
		   $result['success'] = 1;
		   $result['message'] = "successfully fetch data";
		   $result['posts']=$rows;
		   $result['imagestatuscount']=$rows1;
		  // $result['count']=$rows1;
		   return json_encode($result);
           } else {
		   $result['success'] = 0;
	   	   $result['message'] = "Data not fetch";
		   return json_encode($result);  
	   }
       } catch(PDOException $ex) {
		$result['success'] = 0;
		$result['message'] = "Data not fetch". $ex;
		return json_encode($result);
       }
}

/********************************** / get pending bundle image*********************/

/********************************* check bandle image status ************************/

function checkBundleImageStatus($bundleId , $setstatus) {  
$status = 1;
$flag = 11;
     try{
	    $query = "select count(autoId) as approveimagecount from Tbl_C_AlbumImage where bundleId=:bundleid And status = :sta";
	     
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':bundleid', $bundleId, PDO::PARAM_STR);
			$stmt->bindParam(':sta', $status, PDO::PARAM_STR);
			$stmt->execute();
            $rows = $stmt->fetch(PDO::FETCH_ASSOC);
			//print_r($rows);
			if($rows['approveimagecount'] == 0)
			{
			
			$query1 = "update Tbl_Analytic_AlbumSentToGroup set status = :sta where bundleId = :bunid";
            $stmt1 = $this->DB->prepare($query1);
            $stmt1->bindParam(':bunid', $bundleId, PDO::PARAM_STR);
            $stmt1->bindParam(':sta', $setstatus, PDO::PARAM_STR);
            $row1 = $stmt1->execute();
			
			$query2 = "update Tbl_C_WelcomeDetails set status = :sta2 where id = :bunid2 AND flagType = :flag";
            $stmt2 = $this->DB->prepare($query2);
            $stmt2->bindParam(':bunid2', $bundleId, PDO::PARAM_STR);
            $stmt2->bindParam(':sta2', $setstatus, PDO::PARAM_STR);
			$stmt2->bindParam(':flag', $flag, PDO::PARAM_STR);
            $row2 = $stmt2->execute();
			$result=array();
	    
			   if($row2) 
			   {
				   $result['success'] = 1;
				   $result['message'] = "status updated successfully";
				   return json_encode($result);
			   }
			   else 
			   {
				   $result['success'] = 0;
				   $result['message'] = "status not updated";
				   return json_encode($result);  
			   }
			}
			else
			{
				$result['success'] = 0;
				$result['message'] = "status not updated";
				return json_encode($result); 
			}
			
			
        } 
		catch(PDOException $ex) 
		{
		$result['success'] = 0;
		$result['message'] = "status not updated". $ex;
		return json_encode($result);
       }
}

/*********************************** / check bundle image status ********************/
	
}
?>
