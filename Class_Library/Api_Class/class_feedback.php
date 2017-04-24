<?php

if (!class_exists('Connection_Communication')) {
    require_once('class_connect_db_Communication.php');
}

class Feedback {

    public $db_connect;

    public function __construct() {
        $dbh = new Connection_Communication();
        $this->db_connect = $dbh->getConnection_Communication();
    }

    public function maxId() {
        try {
            $max = "select max(autoId) from Tbl_C_FeedbackComments";
            $stmt = $this->db_connect->prepare($max);
            if ($stmt->execute()) {
                $tr = $stmt->fetch();
                $m_id = $tr[0];
                $m_id1 = $m_id + 1;
                $commentId = "Comment-" . $m_id1;

                return $commentId;
            }
        } catch (PDOException $e) {
            echo $e;
            trigger_error('Error occured fetching max autoid : ' . $e->getMessage(), E_USER_ERROR);
        }
    }

    public function createFeedback() {
        
    }

    public function getFeedbackList($clientId, $empId, $val) {
        try {
            $status = "Live";
            $flagType = 23;
            $query = "select count(autoId) as total from Tbl_C_Feedback WHERE clientId=:clientId AND status=:status AND flagType=:flagType";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':clientId', $clientId, PDO::PARAM_STR);
            $stmt->bindParam(':flagType', $flagType, PDO::PARAM_STR);
            $stmt->bindParam(':status', $status, PDO::PARAM_STR);
            if ($stmt->execute()) {
                $total = $stmt->fetch(PDO::FETCH_ASSOC);
            }

            $query = "SELECT *, DATE_FORMAT(publishingTime, '%d %M %Y') as publishingTime, DATE_FORMAT(unpublishingTime, '%d %M %Y') as unpublishingTime, (select count(commentId) as totalComments from Tbl_C_FeedbackComments where feedbackId=Tbl_C_Feedback.feedbackId and Tbl_C_Feedback.status=:status) as total_comments FROM Tbl_C_Feedback WHERE clientId=:clientId AND status=:status AND flagType=:flagType LIMIT $val,10";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':clientId', $clientId, PDO::PARAM_STR);
            $stmt->bindParam(':flagType', $flagType, PDO::PARAM_STR);
            $stmt->bindParam(':status', $status, PDO::PARAM_STR);
            if ($stmt->execute()) {
                $feedbackResult = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $result['success'] = 1;
                $result['total'] = $total['total'];
                $result['data'] = $feedbackResult;
            }
        } catch (Exception $ex) {
            $result = $ex;
        }

        return $result;
    }

    public function getFeedbackDetail($clientId, $empId, $feedbackId, $val) {
        $query = "select if(avatar_image='', '', concat('" . site_url . "', avatar_image)) as avatar_image from Tbl_EmployeePersonalDetails where employeeId=:empId";
        $stmt = $this->db_connect->prepare($query);
        $stmt->bindParam(':empId', $empId, PDO::PARAM_STR);
        if ($stmt->execute()) {
    		$avatarResult = $stmt->fetch(PDO::FETCH_ASSOC);
	}
	
	try {
            $query = "select count(commentId) as totalComments from Tbl_C_FeedbackComments where feedbackId=:feedbackId";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':feedbackId', $feedbackId, PDO::PARAM_STR);
            if ($stmt->execute()) {
                $totalComments = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($totalComments['totalComments'] != 0) {
                	
                    try {
//                $status = "Live";
                        $flagType = 23;

                        $query = "SELECT feedComments.*, feed.feedbackQuestion, DATE_FORMAT(feed.unpublishingTime, '%d %M %Y') as unpublishingTime, (select count(autoId) from Tbl_C_FeedbackCommentLikes where commentId=feedComments.commentId and feedbackId=:feedbackId and like_unlike_status='1') as totalLikes, if((select count(autoId) from Tbl_C_FeedbackCommentLikes where commentId=feedComments.commentId and feedbackId=:feedbackId and employeeId=:empId and like_unlike_status='1')>0, (select if(employeeId=:empId, '1', '0') as likeStatus from Tbl_C_FeedbackCommentLikes where commentId=feedComments.commentId and feedbackId=:feedbackId and employeeId=:empId and like_unlike_status='1'), '0') as likeStatus, if(feedComments.anonymous='1', 'Anonymous', concat(master.firstName, ' ',master.lastName)) as user_name,if(feedComments.anonymous='1', if(personal.avatar_image='', '', concat('" . site_url . "', personal.avatar_image)) , if(personal.userImage='', '', concat('" . site_url . "', personal.userImage))) as avatar_image FROM Tbl_C_FeedbackComments as feedComments JOIN Tbl_C_Feedback as feed ON feedComments.feedbackId=feed.feedbackId JOIN Tbl_EmployeePersonalDetails as personal ON feedComments.commentBy=personal.employeeId JOIN Tbl_EmployeeDetails_Master as master ON master.employeeId=personal.employeeId WHERE feed.clientId=:clientId AND feed.flagType=:flagType AND feedComments.feedbackId=:feedbackId limit $val,10";
//            echo $query;die;
                        $stmt = $this->db_connect->prepare($query);
                        $stmt->bindParam(':clientId', $clientId, PDO::PARAM_STR);
                        $stmt->bindParam(':empId', $empId, PDO::PARAM_STR);
                        $stmt->bindParam(':flagType', $flagType, PDO::PARAM_STR);
//                $stmt->bindParam(':status', $status, PDO::PARAM_STR);
                        $stmt->bindParam(':feedbackId', $feedbackId, PDO::PARAM_STR);
                        if ($stmt->execute()) {
                            $commentResult = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            $result['success'] = 1;
                            $result['totalComments'] = $totalComments['totalComments'];
                            $result['avatar_image'] = $avatarResult['avatar_image'];
                            $result['feedback_question'] = $commentResult[0]['feedbackQuestion'];
                            $result['unpublishing_time'] = $commentResult[0]['unpublishingTime'];
                            $result['data'] = $commentResult;
//                print_r($result);die;
                        }
                    } catch (Exception $ex) {
                        $result = $ex;
                    }
                } else {
                    $result['success'] = 0;
                    $result['message'] = "No Comments available";
                }
            }
        } catch (Exception $ex) {
            $result = $ex;
        }
        return $result;
    }

    public function getAvatars($clientId) {
        try {
            $status = '1';

            $query = "SELECT if(avatar_image='', '', concat('" . site_url . "', avatar_image)) as avatar_image FROM Tbl_C_Avatars WHERE clientId=:cid AND status=:status";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':cid', $clientId, PDO::PARAM_STR);
            $stmt->bindParam(':status', $status, PDO::PARAM_STR);
            $stmt->execute();
            $avatar_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (!empty($avatar_list)) {
                $result['success'] = 1;
                $result['data'] = $avatar_list;
            } else {
                $result['success'] = 0;
                $result['message'] = "No Avatars Available";
            }
        } catch (Exception $ex) {
            $result = $ex;
        }
        return $result;
    }

    public function update_userAvatar($cId, $empId, $avatar_img) {
        try {
            $avatar_img = explode('images/avatar_images/', $avatar_img);

            $avatar_img[1] = "images/avatar_images/" . $avatar_img[1];

            $query = "UPDATE Tbl_EmployeePersonalDetails SET avatar_image=:avatar_img WHERE clientId=:cid AND employeeId=:empid";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':avatar_img', $avatar_img[1], PDO::PARAM_STR);
            $stmt->bindParam(':empid', $empId, PDO::PARAM_STR);
            $stmt->bindParam(':cid', $cId, PDO::PARAM_STR);
            if ($stmt->execute()) {
                $result['success'] = 1;
                $result['message'] = "Avatar updated successfully";
            } else {
                $result['success'] = 0;
                $result['message'] = "Something went wrong";
            }
        } catch (Exception $ex) {
            $result = $ex;
        }
        return $result;
    }

    public function addFeedComments($cid, $commentId, $feedbackId, $comment_text, $commentBy, $anonymous) {
        try {
            date_default_timezone_set('Asia/Kolkata');
            $commentDate = date('Y-m-d H:i:s');

            $query = "INSERT INTO Tbl_C_FeedbackComments (commentId, feedbackId, clientId, comment_text, commentBy, CommentDate, anonymous) VALUES (:commentId, :feedbackId, :cid, :comment_text, :commentBy, :cdate, :anonymous)";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':commentId', $commentId, PDO::PARAM_STR);
            $stmt->bindParam(':feedbackId', $feedbackId, PDO::PARAM_STR);
            $stmt->bindParam(':anonymous', $anonymous, PDO::PARAM_STR);
            $stmt->bindParam(':cid', $cid, PDO::PARAM_STR);
            $stmt->bindParam(':comment_text', $comment_text, PDO::PARAM_STR);
            $stmt->bindParam(':commentBy', $commentBy, PDO::PARAM_STR);
            $stmt->bindParam(':cdate', $commentDate, PDO::PARAM_STR);

            if ($stmt->execute()) {
                $result['success'] = 1;
                $result['message'] = "Comment added successfully";
            } else {
                $result['success'] = 0;
                $result['message'] = "Something went wrong";
            }
        } catch (Exception $ex) {
            $result = $ex;
        }
        return $result;
    }

    public function likeFeedComments($cId, $feedbackId, $empId, $commentId, $status) {
        try {

            $query = "INSERT INTO Tbl_C_FeedbackCommentLikes (commentId, feedbackId, employeeId, like_unlike_status) VALUES (:commentId, :feedbackId, :empId, :status) ON DUPLICATE KEY UPDATE like_unlike_status=:status";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':cid', $cid, PDO::PARAM_STR);
            $stmt->bindParam(':commentId', $commentId, PDO::PARAM_STR);
            $stmt->bindParam(':feedbackId', $feedbackId, PDO::PARAM_STR);
            $stmt->bindParam(':empId', $empId, PDO::PARAM_STR);
            $stmt->bindParam(':status', $status, PDO::PARAM_STR);

            if ($stmt->execute()) {
                $result['success'] = 1;
                $result['message'] = ($status=='1')?"liked successfully":"unliked successfully";
            } else {
                $result['success'] = 0;
                $result['message'] = "Something went wrong";
            }
        } catch (Exception $ex) {
            $result = $ex;
        }
        return $result;
    }

}
