<?php

if (!class_exists("Connection_Communication")) {
    include_once('../../Class_Library/Api_Class/class_connect_db_Communication.php');
}

class Family {

    public $db_connect;

    public function __construct() {
        $dbh = new Connection_Communication();
        $this->db_connect = $dbh->getConnection_Communication();
    }

    public function filterWords($text) {
        $text = strtolower($text);
//        $bad = array('dirty', 'butt', 'lips', 'fuck');
        $bad = array('Alcoholic', 'Amateur', 'Analphabet', 'Anarchist', 'Ape', 'Arse', 'Arselicker', 'Ass', 'Ass master', 'Ass-kisser', 'Ass-nugget', 'Ass-wipe', 'Asshole',
    'Baby', 'Backwoodsman', 'Balls', 'Bandit', 'Barbar', 'Bastard', 'Beavis', 'Beginner', 'Biest', 'Bitch', 'Blubber gut', 'Bogeyman', 'Booby', 'Boozer', 'Bozo', 'Brain-fart', 'Brainless', 'Brainy', 'Brontosaurus', 'Brownie', 'Bugger', 'silly', 'Bulloks', 'Bum', 'Bum-fucker', 'Butt', 'Buttfucker', 'Butthead',
    'Callboy', 'Callgirl', 'Camel', 'Cannibal', 'Cave man', 'Chaavanist', 'Chaot', 'Chauvi', 'Cheater', 'Chicken', 'Children fucker', 'Clit', 'Clown', 'Cock', 'Cock master', 'Cock up', 'Cockboy', 'Cockfucker', 'Cockroach', 'Coky', 'Con merchant', 'Con-man', 'Country bumpkin', 'Cow', 'Creep', 'Cretin', 'Criminal', 'Cunt', 'Cunt sucker',
    'Daywalker', 'Deathlord', 'Derr brain', 'Desperado', 'Devil', 'Dickhead', 'Dinosaur', 'Disgusting packet', 'Diz brain', 'Do-Do', 'Dog', 'dirty', 'Dogshit', 'Donkey', 'Dracula', 'Drakula', 'Dreamer', 'Drinker', 'Drunkard', 'Dufus', 'Dulles', 'Dumbo', 'Dummy', 'Dumpy',
    'Egoist', 'Eunuch', 'Exhibitionist',
    'Fake', 'Fanny', 'Farmer', 'Fart', 'shitty', 'Fat', 'Fatso', 'Fibber', 'Fish', 'Fixer', 'Flake', 'Flash Harry', 'Freak', 'Frog', 'Fuck', 'Fuck face', 'Fuck head', 'Fuck noggin', 'Fucker',
    'Gangster', 'Ghost', 'Goose', 'Gorilla', 'Grouch', 'Grumpy',
    'Hell dog', 'Hillbilly', 'Hippie', 'Homo', 'Homosexual', 'Hooligan', 'Horse fucker',
    'Idiot', 'Ignoramus',
    'Jack-ass', 'Jerk', 'Joker', 'Junkey',
    'Killer',
    'Lard face', 'Latchkey child', 'Learner', 'Liar', 'Looser', 'Lucky', 'Lumpy', 'Luzifer',
    'Macho', 'Macker', 'Minx', 'Missing link', 'Monkey', 'Monster', 'Motherfucker', 'Mucky pub', 'Mutant',
    'Neanderthal', 'Nerfhearder', 'Nobody', 'Nurd', 'Nuts', 'numb',
    'Oddball', 'Oger', 'Oil dick', 'Old fart', 'Orang-Uthan', 'Original', 'Outlaw',
    'Pack', 'Pain in the ass', 'Pavian', 'Pencil dick', 'Pervert', 'Pig', 'Piggy-wiggy', 'Pirate', 'Pornofreak', 'Prick', 'Prolet',
    'Queer', 'Querulant',
    'Rat', 'Rat-fink', 'Reject', 'Retard', 'Riff-Raff', 'Ripper', 'Roboter', 'Rowdy', 'Rufian',
    'Sack', 'Sadist', 'Saprophyt', 'Satan', 'Scarab', 'Schfincter', 'Shark', 'Shit eater', 'Shithead', 'Simulant', 'Skunk', 'Skuz bag', 'Slave', 'Sleeze', 'Sleeze bag', 'Slimer', 'Slimy bastard', 'Small pricked', 'Snail', 'Snake', 'Snob', 'Snot', 'Son of a bitch', 'Square', 'Stinker', 'Stripper', 'Stunk', 'Swindler', 'Swine',
    'Teletubby', 'Thief', 'Toilett cleaner', 'Tussi', 'Typ',
    'Unlike',
    'Vampir', 'Vandale', 'Varmit',
    'Wallflower', 'Wanker', 'bloody', 'Weeze Bag', 'Whore', 'Wierdo', 'Wino', 'Witch', 'Womanizer', 'Woody allen', 'Worm',
    'Xena', 'Xenophebe', 'Xenophobe', 'XXX Watcher',
    'Yak', 'Yeti',
    'Zit face');

        $rep = '***';

//                '***', '***', '***', '***', '***', '***', '***', '***', '***', '***');
        $bad = array_map('strtolower', $bad);
//        print_r(sizeof($rep));        die;
        $text = str_replace($bad, $rep, $text);
        return $text;
    }
    
    function getUserDetail($clientid, $uuid) {
        try {
            $query = "select firstName from Tbl_EmployeeDetails_Master where clientId=:cli and employeeId=:empid";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':cli', $clientid, PDO::PARAM_STR);
            $stmt->bindParam(':empid', $uuid, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                $response["success"] = 1;
                $response["userName"] = $row;
            } else {
                $response["success"] = 0;
                $response["userName"] = "User doesn't exist";
            }
            return $response;
        }      //--------------------------------------------- end of try block
        catch (PDOException $e) {
            echo $e;
        }
    }

    function getUserDetails($clientid, $uuid) {
        try {
            $query = "select Tbl_EmployeeDetails_Master.firstName,Tbl_EmployeeDetails_Master.middleName,Tbl_EmployeeDetails_Master.lastName, if(Tbl_EmployeePersonalDetails.userImage IS NULL or Tbl_EmployeePersonalDetails.userImage='', '',concat('" . site_url . "',Tbl_EmployeePersonalDetails.userImage)) as userImage from Tbl_EmployeeDetails_Master join Tbl_EmployeePersonalDetails on Tbl_EmployeeDetails_Master.employeeId = Tbl_EmployeePersonalDetails.employeeId where Tbl_EmployeeDetails_Master.clientId=:cli and Tbl_EmployeeDetails_Master.employeeId=:empid";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':cli', $clientid, PDO::PARAM_STR);
            $stmt->bindParam(':empid', $uuid, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                $response["success"] = 1;
                $response["UserDetails"] = $row;
            } else {
                $response["userName"] = "User doesn't exist";
            }
            return $response;
        }      //--------------------------------------------- end of try block
        catch (PDOException $e) {
            echo $e;
        }
    }

    function getUsers($clientid, $uuid, $sperson) {
        $this->idclient = $clientid;
        $this->sperson = $sperson;
        $this->iduuid = "%" . $uuid . "%";
        try {
            $query = "select Tbl_EmployeeDetails_Master.employeeId, Tbl_EmployeeDetails_Master.firstName, Tbl_EmployeeDetails_Master.middleName, Tbl_EmployeeDetails_Master.lastName,Tbl_EmployeeDetails_Master.location,Tbl_EmployeeDetails_Master.designation, if(Tbl_EmployeePersonalDetails.userImage IS NULL or Tbl_EmployeePersonalDetails.userImage='', '', CONCAT('" . site_url . "', Tbl_EmployeePersonalDetails.userImage)) as userImage from Tbl_EmployeeDetails_Master join Tbl_EmployeePersonalDetails on Tbl_EmployeeDetails_Master.employeeId = Tbl_EmployeePersonalDetails.employeeId where Tbl_EmployeeDetails_Master.employeeId!=:sprson and Tbl_EmployeeDetails_Master.clientId=:cli and (Tbl_EmployeeDetails_Master.employeeCode like '" . $this->iduuid . "' or Tbl_EmployeeDetails_Master.firstName like '" . $this->iduuid . "') ";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':cli', $this->idclient, PDO::PARAM_STR);
            $stmt->bindParam(':sprson', $this->sperson, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($row) {
                $response["success"] = 1;
                $response["message"] = "Users are displayin here";
                $response["users"] = $row;
            } else {
                $response["success"] = 0;
                $response["message"] = "Users don't exist here";
                $response["users"] = $row;
            }
            return $response;
        }      //--------------------------------------------- end of try block
        catch (PDOException $e) {
            echo $e;
        }
    }

    function maxIdRecognition($clientid) {
        try {
            $max = "select max(autoId) from Tbl_RecognizedEmployeeDetails";
            $stmt = $this->db_connect->prepare($max);
            if ($stmt->execute()) {
                $tr = $stmt->fetch();
                $m_id = $tr[0];
                $m_id1 = $m_id + 1;
                $recogid = "Recognition-" . $m_id1;
            }
        } catch (PDOException $e) {
            echo $e;
            trigger_error('Error occured fetching max autoid : ' . $e->getMessage(), E_USER_ERROR);
        }
        return $recogid;
    }

    /*     * ************************************************************************************* */

    function insertUserRecognition($clientid, $recognitionto, $recognitionby, $topicId, $recognizeTitle, $mesg, $points) {
        date_default_timezone_set('Asia/Kolkata');
        $da = date('Y-m-d, H:i:s');
        $status = "Approve";

        $recogid = self::maxIdRecognition($clientid);
        $recognizeto = self::getUserDetails($clientid, $recognitionto);

        $rto = $recognizeto['UserDetails']['firstName'] . " " . $recognizeto['UserDetails']['lastName'];
        $recognizeby = self::getUserDetails($clientid, $recognitionby);

        $rby = $recognizeby['UserDetails']['firstName'] . " " . $recognizeby['UserDetails']['lastName'];
        try {
            $query = "insert into Tbl_RecognizedEmployeeDetails(recognitionId,clientId,recognitionBy,recognitionTo,topic,text,dateOfEntry,status,points) values(:reg,:cli,:rby,:rto,:top,:txt,:dat,:sta,:pts)";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':reg', $recogid, PDO::PARAM_STR);
            $stmt->bindParam(':cli', $clientid, PDO::PARAM_STR);
            $stmt->bindParam(':rby', $recognitionby, PDO::PARAM_STR);
            $stmt->bindParam(':rto', $recognitionto, PDO::PARAM_STR);
            $stmt->bindParam(':top', $topicId, PDO::PARAM_STR);
            $stmt->bindParam(':txt', $mesg, PDO::PARAM_STR);
            $stmt->bindParam(':dat', $da, PDO::PARAM_STR);
            $stmt->bindParam(':sta', $status, PDO::PARAM_STR);
            $stmt->bindParam(':pts', $points, PDO::PARAM_STR);

            if ($stmt->execute()) {
                $stmtStatus = 'Credited';
                include_once('../../Class_Library/class_recognize.php');
                $recog = new Recognize();
                $totalpointsdata = $recog->getMaxtotalPoints($clientid, $recognitionto);
                $ert = json_decode($totalpointsdata, true);

                $flag = '0';
                if ($ert['success'] == 1) {
                    $totlpoint = $ert['data'][0]['totalPoints'] + $points;
                } else {
                    $totlpoint = $points;
                }
                $query = "insert into Tbl_RecognizeApprovDetails (clientId, recognizeId, userId, recognizeBy, quality, points, totalPoints, entryDate, stmtStatus, regStatus, flag) VALUES (:cli, :reg, :rto, :rby, :top, :pts, :tpts, :dat, :stmtStatus, :status, :flag)";
                $stmt = $this->db_connect->prepare($query);
                $stmt->bindParam(':cli', $clientid, PDO::PARAM_STR);
                $stmt->bindParam(':reg', $recogid, PDO::PARAM_STR);
                $stmt->bindParam(':rto', $recognitionto, PDO::PARAM_STR);
                $stmt->bindParam(':rby', $recognitionby, PDO::PARAM_STR);
                $stmt->bindParam(':top', $topicId, PDO::PARAM_STR);
                $stmt->bindParam(':pts', $points, PDO::PARAM_STR);
                $stmt->bindParam(':tpts', $totlpoint, PDO::PARAM_STR);
                $stmt->bindParam(':dat', $da, PDO::PARAM_STR);
                $stmt->bindParam(':stmtStatus', $stmtStatus, PDO::PARAM_STR);
                $stmt->bindParam(':status', $status, PDO::PARAM_STR);
                $stmt->bindParam(':flag', $flag, PDO::PARAM_STR);
                $stmt->execute();

                /*
                  $to = 'gagandeep509.singh@gmail.com';
                  $subject = 'Request for Recognition Approval';
                  $from = 'info@benepik.com';
                  $headers = 'MIME-Version: 1.0' . "\r\n";
                  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                  $headers .= 'From: ' . $from . "\r\n" .
                  'Reply-To: ' . $from . "\r\n" .
                  'X-Mailer: PHP/' . phpversion();

                  // Compose a simple HTML email messag
                  $message = '<html><body>';
                  $message .= '<h3>Dear Sir</h3>';
                  $message .= '<p><b>' . $rby . '</b> recognize to <b> ' . $rto . '</b></p>';
                  $message .= '<p><b>Topic</b> : ' . $recognizeTitle . '</p>';
                  $message .= '<p><b>Comment </b> : ' . $mesg . '</p><br><br>';

                  $message .= '<p>Thanks</p>';
                  $message .= '<p>Benepik Team</p>';

                  $message .= '</body></html>';

                  if (mail($to, $subject, $message, $headers)) {

                  // echo 'Your mail has been sent successfully.';
                  } else {

                  // echo 'Unable to send email. Please try again.';
                  }
                 */


                $response = array();
                $response["success"] = 1;
                $response["message"] = "Recognition submitted successfully";
                $response["rcid"] = $this->db_connect->lastInsertId();
                ;
                return $response;
            }
        }      //--------------------------------------------- end of try block
        catch (PDOException $e) {
            echo $e;
            echo 'Please try again.';
        }
    }

    function entryFamily($empid, $fnam, $mnam, $snam, $cname) {

        $this->employeeid = $empid;
        $this->fname = $fnam;
        $this->mname = $mnam;
        $this->sname = $snam;
        $this->childrenName = $cname;

        date_default_timezone_set('Asia/Kolkata');
        $_date = date('Y-m-d H:i:s');

        try {
            $query = "update Tbl_EmployeePersonalDetails set userFatherName=:fnam, userMotherName=:mnam, userSpouseName=:snam,childrenName=:children,updatedDate = :udte,updatedBy=:uby where employeeId=:empid";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':empid', $this->employeeid, PDO::PARAM_STR);
            $stmt->bindParam(':fnam', $this->fname, PDO::PARAM_STR);
            $stmt->bindParam(':mnam', $this->mname, PDO::PARAM_STR);
            $stmt->bindParam(':snam', $this->sname, PDO::PARAM_STR);
            $stmt->bindParam(':children', $this->childrenName, PDO::PARAM_STR);
            $stmt->bindParam(':udte', $_date, PDO::PARAM_STR);
            $stmt->bindParam(':uby', $this->employeeid, PDO::PARAM_STR);

            if ($stmt->execute()) {

                $response = array();
                $response["success"] = 1;
                $response["message"] = "Data inserted successfully";
                return $response;
            }
        }      //--------------------------------------------- end of try block
        catch (PDOException $e) {
            echo $e;
        }
    }

    function RemoveFamilyDetails($employeeid, $dealid, $branchid) {

        try {
            $query = "delete from BranchWish where branchid=:bri and dealid=:dli and emailid=:emi";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':bri', $branchid, PDO::PARAM_STR);
            $stmt->bindParam(':dli', $dealid, PDO::PARAM_STR);
            $stmt->bindParam(':emi', $employeeid, PDO::PARAM_STR);

            if ($stmt->execute()) {
                $response = array();
                $response["success"] = 1;
                $response["message"] = "Remove Deal from Favourite successfully";
            } else {
                $response = array();
                $response["success"] = 0;
                $response["message"] = "No action perform";
            }

            return $response;
        } catch (PDOException $e) {
            echo $e;
        }
    }

    function getPersonalDetails($eId) {
        $site_url = site_url;
        $this->eId = $eId;
        try {
            $query = "select edm.department,edm.contact,edm.designation,edm.location,edm.branch,edm.grade,edm.firstName,edm.middleName,edm.lastName,edm.companyName from Tbl_EmployeeDetails_Master as edm join Tbl_EmployeePersonalDetails as epd on edm.employeeId = epd.employeeId where edm.employeeId =:eid";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':eid', $this->eId, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetch(PDO::FETCH_ASSOC);

            $filterdArray = array_filter($rows);

            if (array_filter($rows)) {
                $response = array();
                $response["success"] = 1;
                $response["message"] = "Personal Details Found Displaying";
                $response["posts"] = $rows;
                return $response;
            } else if (!array_filter($rows)) {
                $response = array();
                $response["success"] = 0;
                $response["message"] = "No Details Found For Personal Details";
                return $response;
            } else {
                $response = array();
                $response["success"] = 0;
                $response["message"] = "Email id dosn't found";
                return $response;
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

    function getFamilyDetails($mailId) {
        $site_url = site_url;
        $this->emailId = $mailId;
        try {
            $query = "select if(userImage = '' or userImage is NULL, '',CONCAT('$site_url',userImage)) as userImage,userFatherName,userMotherName,userSpouseName,childrenName,userDOB,emailId from Tbl_EmployeePersonalDetails where employeeId =:mail";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':mail', $this->emailId, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetch(PDO::FETCH_ASSOC);

            $filterdArray = array_filter($rows);

            if (array_filter($rows)) {
                $response = array();
                $response["success"] = 1;
                $response["message"] = "Family Details Found Displaying";
                $response["posts"] = $rows;
                return $response;
            } else if (!array_filter($rows)) {
                $response = array();
                $response["success"] = 0;
                $response["message"] = "No Details Found For Family Details";
                return $response;
            } else {
                $response = array();
                $response["success"] = 0;
                $response["message"] = "Email id dosn't found";
                return $response;
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

    function randomNumber($length) {
        $result = '';

        for ($i = 0; $i < $length; $i++) {
            $result .= mt_rand(0, 9);
        }

        return $result;
    }

    function getRecognisedUser($clientid, $uuid, $value, $leader = '') {
        $sts = "Approve";
        try {
            $query1 = "select recognition.*, badges.recognizeTitle, if(badges.image IS NULL or badges.image='', '',concat('" . site_url . "', badges.image)) as badgesImage from Tbl_RecognizedEmployeeDetails as recognition join Tbl_RecognizeTopicDetails as badges ON recognition.topic=badges.topicId where recognition.status =:sts and recognition.clientId=:cli";

            if (!empty($leader)) {
                $query1 .= " and recognition.recognitionTo='$leader' ";
            }

            $query1 .= " order by recognition.autoId desc";
            
            if (empty($leader)) {
	    	$query1 .= " limit " . $value . ",5";
	    }
	    
            $stmt1 = $this->db_connect->prepare($query1);
            $stmt1->bindParam(':cli', $clientid, PDO::PARAM_STR);
            $stmt1->bindParam(':sts', $sts, PDO::PARAM_STR);
            $stmt1->execute();
            $rows1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);

            $query2 = "select count(recognitionTo) as total_recognitions from Tbl_RecognizedEmployeeDetails where clientId=:cli and status=:sts";

            if (!empty($leader)) {
                $query2 .= " and recognitionTo='$leader'";
            }

            $stmt2 = $this->db_connect->prepare($query2);
            $stmt2->bindParam(':cli', $clientid, PDO::PARAM_STR);
            $stmt2->bindParam(':sts', $sts, PDO::PARAM_STR);
            $stmt2->execute();
            $rows2 = $stmt2->fetch(PDO::FETCH_ASSOC);

            if (count($rows1) > 0) {
                $response["success"] = 1;
                $response["message"] = "Recognised data available here";
                $response["total_recognitions"] = $rows2["total_recognitions"];
                $response["posts"] = array();

                foreach ($rows1 as $row) {
                    $totalLikesQuery = "select count(autoId) as totalLikes from Tbl_Analytic_RecognitionLikes where recognitionId=:pt and like_unlike_status='1'";
                    $stmt = $this->db_connect->prepare($totalLikesQuery);
                    $stmt->bindParam(':pt', $row["recognitionId"], PDO::PARAM_STR);
                    $stmt->execute();
                    $totalLikes = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($totalLikes["totalLikes"] > 0) {
                        $likeStatusQuery = "select if(employeeId=:empId, '1', '0') as likeStatus from Tbl_Analytic_RecognitionLikes where recognitionId=:pt and like_unlike_status='1'";
                        $stmt = $this->db_connect->prepare($likeStatusQuery);
                        $stmt->bindParam(':pt', $row["recognitionId"], PDO::PARAM_STR);
                        $stmt->bindParam(':empId', $uuid, PDO::PARAM_STR);
                        $stmt->execute();
                        $likeStatus = $stmt->fetch(PDO::FETCH_ASSOC);
                    } else {
                        $likeStatus = '0';
                    }

                    $post["recognitionId"] = $row["recognitionId"];
                    $post["recognitionBy"] = $row["recognitionBy"];

                    $recognitionBy = $row["recognitionBy"];
                    $user = self::getUserDetails($clientid, $recognitionBy);
                    $post["recognitionByName"] = $user[UserDetails][firstName] . " " . $user[UserDetails][lastName];
                    $post["recognitionByImage"] = $user[UserDetails][userImage];

                    $post["recognitionTo"] = $row["recognitionTo"];
                    $recognitionTo = $row["recognitionTo"];
                    $user = self::getUserDetails($clientid, $recognitionTo);
                    $post["recognitionToName"] = $user[UserDetails][firstName] . " " . $user[UserDetails][lastName];

                    $namefirst = $user[UserDetails][firstName];
                    $namesecond = $user[UserDetails][lastName];

                    $post["recognitionShortName"] = $namefirst[0] . " " . $namesecond[0];
                    $post["recognitionToImage"] = $user[UserDetails][userImage];

                    $query2 = "select count(recognitionTo) as total_approve from Tbl_RecognizedEmployeeDetails where clientId=:cli and recognitionTo=:rec and status = :sta";
                    $stmt2 = $this->db_connect->prepare($query2);
                    $stmt2->bindParam(':cli', $clientid, PDO::PARAM_STR);
                    $stmt2->bindParam(':rec', $recognitionTo, PDO::PARAM_STR);
                    $stmt2->bindParam(':sta', $sts, PDO::PARAM_STR);
                    $stmt2->execute();
                    $rows21 = $stmt2->fetch(PDO::FETCH_ASSOC);

                    $post["likeStatus"] = $likeStatus["likeStatus"];
                    $post["totalLikes"] = $totalLikes["totalLikes"];
                    $post["TotalApprove"] = $rows21["total_approve"];
                    $post["topic"] = $row["topic"];
                    $post["text"] = $row["text"];
                    $post["badge"] = $row["recognizeTitle"];
                    $post["badge_image"] = $row["badgesImage"];
                    $d1 = $row["dateOfEntry"];
                    $date = date_create($d1);
                    $post["dateOfEntry"] = date_format($date, "d M Y");

                    array_push($response["posts"], $post);
                }
                return $response;
            } else {
                $response["success"] = 0;
                $response["message"] = "No More Posts Available";
                return $response;
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

    /*     * ****************************************************************************************************************************************************************** */

    function userImageUpload($clientid, $baseimage, $uuid, $dname) {
        $this->idclient = $clientid;
        $this->imgpath = $baseimage;
        $this->employeeid = $uuid;
        $this->number = $dname;

        if ($this->imgpath != "") {
            $data = base64_decode($this->imgpath);

            $img = imagecreatefromstring($data);

            if ($img != false) {
                $imgpath = base_path . '/Client_img/user_img/' . $this->number . '.jpg';
                imagejpeg($img, $imgpath); //for converting jpeg of image

                $imgpath1 = 'Client_img/user_img/' . $this->number . '.jpg';
            }
        } else {
            $this->imgpath = "";
            $imgpath1 = "";
        }

        try {
            $query = "update Tbl_EmployeePersonalDetails set userImage =:img where employeeId=:uid and clientId=:cli";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':img', $imgpath1, PDO::PARAM_STR);
            $stmt->bindParam(':uid', $this->employeeid, PDO::PARAM_STR);
            $stmt->bindParam(':cli', $this->idclient, PDO::PARAM_STR);

            if ($stmt->execute()) {
                $response = array();

                if ($imgpath1 != "") {
                    $response["success"] = 1;
                    $response["userImage"] = site_url . $imgpath1;
                    $response["message"] = "image updated successfully";
                } else {
                    $response["success"] = 0;
                    $response["userImage"] = "";
                    $response["message"] = "image update failed";
                }
                return json_encode($response);
            }
        }      //--------------------------------------------- end of try block
        catch (PDOException $e) {
            echo $e;
        }
    }

}

?>
