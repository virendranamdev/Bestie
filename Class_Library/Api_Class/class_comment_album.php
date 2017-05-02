<?php

if (!class_exists('Connection_Communication')) {
    include_once('class_connect_db_Communication.php');
}

class Comment {

    public $DB;

    public function __construct() {
        $db = new Connection_Communication();
        $this->DB = $db->getConnection_Communication();
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

    function create_Comment($clientid, $albumid, $imageid, $employeeid, $comment, $flag, $device) {

        date_default_timezone_set('Asia/Calcutta');

        $cd = date('Y-m-d H:i:s');
        $status = 1;

        try {
            $query = "insert into Tbl_Analytic_AlbumComment(clientId,userId,albumId,imageId,comments,createdDate,flag,status,deviceName)
            values(:cli,:userid,:albumid,:imgid,:comment,:cd,:flag,:status,:dev)";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cli', $clientid, PDO::PARAM_STR);
            $stmt->bindParam(':albumid', $albumid, PDO::PARAM_INT);
            $stmt->bindParam(':imgid', $imageid, PDO::PARAM_INT);
            $stmt->bindParam(':userid', $employeeid, PDO::PARAM_STR);
            $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
            $stmt->bindParam(':flag', $flag, PDO::PARAM_STR);
            $stmt->bindParam(':dev', $device, PDO::PARAM_STR);
            $stmt->bindParam(':cd', $cd, PDO::PARAM_STR);
            $stmt->bindParam(':status', $status, PDO::PARAM_INT);


            if ($stmt->execute()) {
                try {
                    $query1 = "SELECT * FROM Tbl_Analytic_AlbumComment WHERE albumId = :albumid AND imageId = :imgid AND status = :status AND clientId = :cli order by commentId desc";
                    $stmt1 = $this->DB->prepare($query1);
                    $stmt1->bindParam(':cli', $clientid, PDO::PARAM_STR);
                    $stmt1->bindParam(':albumid', $albumid, PDO::PARAM_INT);
                    $stmt1->bindParam(':imgid', $imageid, PDO::PARAM_INT);
                    $stmt1->bindParam(':status', $status, PDO::PARAM_INT);
                    $stmt1->execute();
                    $rows = $stmt1->fetchAll();

                    $response["posts"] = array();


                    if ($rows) {
                        $forimage = dirname(SITE_URL).'/';

                        $query1 = "select count(commentId) as total_comments from Tbl_Analytic_AlbumComment where albumId = :albumid AND imageId = :imgid and clientId=:cli and status = :status";
                        $stmt1 = $this->DB->prepare($query1);
                        $stmt1->bindParam(':cli', $clientid, PDO::PARAM_STR);
                        $stmt1->bindParam(':albumid', $albumid, PDO::PARAM_INT);
                        $stmt1->bindParam(':imgid', $imageid, PDO::PARAM_INT);
                        $stmt1->bindParam(':status', $status, PDO::PARAM_INT);

                        $stmt1->execute();
                        $row = $stmt1->fetch(PDO::FETCH_ASSOC);

                        $query2 = "select count(imageId) as total_likes from Tbl_Analytic_AlbumLike where albumId =:albumid AND imageId = :imgid and clientId=:cli AND status = :status";
                        $stmt2 = $this->DB->prepare($query2);
                        $stmt2->bindParam(':cli', $clientid, PDO::PARAM_STR);
                        $stmt2->bindParam(':albumid', $albumid, PDO::PARAM_INT);
                        $stmt2->bindParam(':imgid', $imageid, PDO::PARAM_INT);
                        $stmt2->bindParam(':status', $status, PDO::PARAM_INT);

                        $stmt2->execute();
                        $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);


                        $response["success"] = 1;
                        $response["message"] = "Comment posted successfully";
                        $response["total_comments"] = $row["total_comments"];
                        $response["total_likes"] = $row2["total_likes"];

                        for ($i = 0; $i < count($rows); $i++) {
                            $post = array();

                            $post["comment_id"] = $rows[$i]["commentId"];
                            $post["album_id"] = $rows[$i]["albumId"];
                            $post["image_id"] = $rows[$i]["imageId"];
                            $post["content"] = $rows[$i]["comments"];
                            $post["commentby"] = $rows[$i]["userId"];
                            $post["flag"] = $rows[$i]["flag"];
                            $mailid = $rows[$i]["userId"];

                            $query2 = "SELECT Tbl_EmployeeDetails_Master.*, Tbl_EmployeePersonalDetails.* FROM Tbl_EmployeeDetails_Master join Tbl_EmployeePersonalDetails on Tbl_EmployeeDetails_Master.employeeId = Tbl_EmployeePersonalDetails.employeeId WHERE Tbl_EmployeeDetails_Master.employeeId =:maid";
                            $stmt2 = $this->DB->prepare($query2);
                            $stmt2->bindParam(':maid', $mailid, PDO::PARAM_STR);
                            $stmt2->execute();
                            $row = $stmt2->fetch();

                            $post["firstname"]   = $row["firstName"];
							$post["middlename"]   = $row["middleName"];
                            $post["lastname"]    = $row["lastName"];
                            $post["designation"] = $row["designation"];
                            $post["userImage"]   = !empty($row["userImage"]) ? $forimage . $row["userImage"] : "";
                            $post["cdate"]       = $rows[$i]["createdDate"];

                            array_push($response["posts"], $post);
                        }

                        return $response;
                    } else {
                        $response["success"] = 0;
                        $response["message"] = "There is no comments for this post";
                        $response["total_likes"] = $row2["total_likes"];
                        return $response;
                    }
                } catch (PDOException $e) {
                    echo $e;
                }
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

    function Comment_display($clientid, $albumid, $imageid,$imgpath='') {
        $status = 1;
		
		//$path = ($imgpath  == '')?dirname(SITE_URL)."/":site_url;
		$path = site_url;
        try {
            $query = "select *,DATE_FORMAT(createdDate,'%d %b %Y %h:%i %p') as commentDate from Tbl_Analytic_AlbumComment where albumId =:albumid AND imageId = :imgid and clientId=:cli and 	status=:status order by commentId desc";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cli', $clientid, PDO::PARAM_STR);
            $stmt->bindParam(':albumid', $albumid, PDO::PARAM_INT);
            $stmt->bindParam(':imgid', $imageid, PDO::PARAM_INT);
            $stmt->bindParam(':status', $status, PDO::PARAM_INT);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $response = array();

            $query1 = "select count(commentId) as total_comments from Tbl_Analytic_AlbumComment where albumId =:albumid AND imageId = :imgid and clientId=:cli and status=:status";
            $stmt1 = $this->DB->prepare($query1);
            $stmt1->bindParam(':cli', $clientid, PDO::PARAM_STR);
            $stmt1->bindParam(':albumid', $albumid, PDO::PARAM_INT);
            $stmt1->bindParam(':imgid', $imageid, PDO::PARAM_INT);
            $stmt1->bindParam(':status', $status, PDO::PARAM_INT);
            $stmt1->execute();
            $row = $stmt1->fetch(PDO::FETCH_ASSOC);

            $query2 = "select count(imageId) as total_likes from Tbl_Analytic_AlbumLike where albumId =:albumid and imageId = :imgid AND clientId=:cli AND status = :status";
            $stmt2 = $this->DB->prepare($query2);
            $stmt2->bindParam(':cli', $clientid, PDO::PARAM_STR);
            $stmt2->bindParam(':albumid', $albumid, PDO::PARAM_INT);
            $stmt2->bindParam(':imgid', $imageid, PDO::PARAM_INT);
            $stmt2->bindParam(':status', $status, PDO::PARAM_INT);
            $stmt2->execute();
            $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);

            if ($row['total_comments'] > 0 or $row2['total_likes'] > 0) {
                $response["Success"] = 1;
                $response["Message"] = "Comments are display here";
                $response["total_comments"] = $row["total_comments"];
                $response["total_likes"] = $row2["total_likes"];
                $response["Posts"] = array();

                foreach ($rows as $row) {
                    $post["commentId"] = $row["commentId"];
                    $post["commentBy"] = $row["userId"];
                    $employeeid = $row["userId"];


                    $query = "select Tbl_EmployeeDetails_Master.*,Tbl_EmployeePersonalDetails.*,IF(Tbl_EmployeePersonalDetails.userImage IS NULL OR Tbl_EmployeePersonalDetails.userImage='', '', if(Tbl_EmployeePersonalDetails.linkedIn = '1',Tbl_EmployeePersonalDetails.userImage, CONCAT('$path',Tbl_EmployeePersonalDetails.userImage))) as userImage from Tbl_EmployeeDetails_Master join Tbl_EmployeePersonalDetails on Tbl_EmployeeDetails_Master.employeeId=Tbl_EmployeePersonalDetails.employeeId where Tbl_EmployeeDetails_Master.employeeId=:empid";
                    $stmt = $this->DB->prepare($query);
                    $stmt->bindParam(':empid', $employeeid, PDO::PARAM_STR);
                    $stmt->execute();
                    $rows = $stmt->fetch(PDO::FETCH_ASSOC);

                    $post["name"] = $rows["firstName"] . " " .$rows["middleName"]." ". $rows["lastName"];
                    $post["userImage"] = $rows["userImage"];
                    $post["designation"] = $rows["designation"];
                    $post["comment"] = $row["comments"];
                    $post["commentDate"] = $row["commentDate"];
                    array_push($response["Posts"], $post);
                }
            } else {
                $response["Success"] = 0;
                $response["Message"] = "There is no comment for this post";
                //$response["total_likes"] = $row2["total_likes"];
            }
            return $response;
        } catch (PDOException $e) {
            echo $e;
        }
    }

    public function getAlbumGroups($clientId, $postId, $imageId) {
        try {
            $query = "SELECT * FROM Tbl_Analytic_AlbumComment WHERE clientId=:cli and albumId=:aId and imageId=:imageId";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cli', $clientId, PDO::PARAM_STR);
            $stmt->bindParam(':aId', $postId, PDO::PARAM_STR);
            $stmt->bindParam(':aId', $postId, PDO::PARAM_STR);
            $stmt->bindParam(':imageId', $imageId, PDO::PARAM_STR);
            $stmt->execute();
            $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $ex) {
            echo $ex;
        }

        return $response;
    }
/************************* get comment max id ***************************/
	function maxcommentId() {
        try {
            $max = "select max(commentId) from Tbl_Analytic_AlbumComment";
            $stmt = $this->DB->prepare($max);
            if ($stmt->execute()) {
                $tr = $stmt->fetch();
                $m_id = $tr[0];
                $m_id1 = $m_id + 1;
                $postid = $m_id1;

                return $postid;
            }
        } catch (PDOException $e) {
            echo $e;
            trigger_error('Error occured fetching max autoid : ' . $e->getMessage(), E_USER_ERROR);
        }
    }
/************************ / get comment max id **************************/	
}

?>
