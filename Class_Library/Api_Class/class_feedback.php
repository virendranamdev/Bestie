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

    public function filterWords($text) {
        $text = strtolower($text);
//        $bad = array('dirty', 'butt', 'lips', 'fuck');
        $bad = array('Alcoholic', 'Amateur', 'Analphabet', 'Anarchist', 'Ape', 'Arse', 'Arselicker', 'Ass', 'Ass master', 'Ass-kisser', 'Ass-nugget', 'Ass-wipe', 'Asshole','Baby', 'Backwoodsman', 'Balls', 'Bandit', 'Barbar', 'Bastard', 'Beavis', 'Beginner', 'Biest', 'Bitch', 'Blubber gut', 'Bogeyman', 'Booby', 'Boozer', 'Bozo', 'Brain-fart', 'Brainless', 'Brainy', 'Brontosaurus', 'Brownie', 'Bugger', 'silly', 'Bulloks', 'Bum', 'Bum-fucker', 'Butt', 'Buttfucker', 'Butthead','Callboy', 'Callgirl', 'Camel', 'Cannibal', 'Cave man', 'Chaavanist', 'Chaot', 'Chauvi', 'Cheater', 'Chicken', 'Children fucker', 'Clit', 'Clown', 'Cock', 'Cock master', 'Cock up', 'Cockboy', 'Cockfucker', 'Cockroach', 'Coky', 'Con merchant', 'Con-man', 'Country bumpkin', 'Cow', 'Creep', 'Cretin', 'Criminal', 'Cunt', 'Cunt sucker','Daywalker', 'Deathlord', 'Derr brain', 'Desperado', 'Devil', 'Dickhead', 'Dinosaur', 'Disgusting packet', 'Diz brain', 'Do-Do', 'Dog', 'dirty', 'Dogshit', 'Donkey', 'Dracula', 'Drakula', 'Dreamer', 'Drinker', 'Drunkard', 'Dufus', 'Dulles', 'Dumbo', 'Dummy', 'Dumpy',
    'Egoist', 'Eunuch', 'Exhibitionist', 'Fake', 'Fanny', 'Farmer', 'Fart', 'shitty', 'Fat', 'Fatso', 'Fibber', 'Fish', 'Fixer', 'Flake', 'Flash Harry', 'Freak', 'Frog', 'Fuck', 'Fuck face', 'Fuck head', 'Fuck noggin', 'Fucker', 'Gangster', 'Ghost', 'Goose', 'Gorilla', 'Grouch', 'Grumpy','Hell dog', 'Hillbilly', 'Hippie', 'Homo', 'Homosexual', 'Hooligan', 'Horse fucker','Idiot', 'Ignoramus','Jack-ass', 'Jerk', 'Joker', 'Junkey',
    'Killer','Lard face', 'Latchkey child', 'Learner', 'Liar', 'Looser', 'Lucky', 'Lumpy', 'Luzifer','Macho', 'Macker', 'Minx', 'Missing link', 'Monkey', 'Monster', 'Motherfucker', 'Mucky pub', 'Mutant','Neanderthal', 'Nerfhearder', 'Nobody', 'Nurd', 'Nuts', 'numb','Oddball', 'Oger', 'Oil dick', 'Old fart', 'Orang-Uthan', 'Original', 'Outlaw','Pack', 'Pain in the ass', 'Pavian', 'Pencil dick', 'Pervert', 'Pig', 'Piggy-wiggy', 'Pirate', 'Pornofreak', 'Prick', 'Prolet','Queer', 'Querulant','Rat', 'Rat-fink', 'Reject', 'Retard', 'Riff-Raff', 'Ripper', 'Roboter', 'Rowdy', 'Rufian','Sack', 'Sadist', 'Saprophyt', 'Satan', 'Scarab', 'Schfincter', 'Shark', 'Shit eater', 'Shithead', 'Simulant', 'Skunk', 'Skuz bag', 'Slave', 'Sleeze', 'Sleeze bag', 'Slimer', 'Slimy bastard', 'Small pricked', 'Snail', 'Snake', 'Snob', 'Snot', 'Son of a bitch', 'Square', 'Stinker', 'Stripper', 'Stunk', 'Swindler', 'Swine','Teletubby', 'Thief', 'Toilett cleaner', 'Tussi', 'Typ',
    'Unlike','Vampir', 'Vandale', 'Varmit','Wallflower', 'Wanker', 'bloody', 'Weeze Bag', 'Whore', 'Wierdo', 'Wino', 'Witch', 'Womanizer', 'Woody allen', 'Worm','Xena', 'Xenophebe', 'Xenophobe', 'XXX Watcher','Yak', 'Yeti','Zit face',
            
            '2g1c','acrotomophilia','alabama hot pocket','alaskan pipeline','anal','anilingus','anus','apeshit','arsehole','ass','asshole','assmunch','auto erotic','autoerotic','babeland','baby batter','baby juice','ball gag','ball gravy','ball kicking','ball licking','ball sack','ball sucking','bangbros','bareback','barely legal','barenaked','bastard','bastardo','bastinado','bbw','bdsm','beaner','beaners','beaver cleaver','beaver lips','bestiality','big black','big breasts','big knockers','big tits','bimbos','birdlock','bitch','bitches','black cock','blonde action','blonde on blonde action','blowjob','blow job','blow your load','blue waffle','blumpkin','bollocks','bondage','boner','boob','boobs','booty call','brown showers','brunette action','bukkake','bulldyke','bullet vibe','bullshit','bung hole','bunghole','busty','butt','buttcheeks','butthole','camel toe','camgirl','camslut','camwhore','carpet muncher','carpetmuncher','chocolate rosebuds','circlejerk','cleveland steamer','clit','clitoris','clover clamps','clusterfuck','cock','cocks','coprolagnia','coprophilia','cornhole','coon','coons','creampie','cum','cumming','cunnilingus','cunt','darkie','date rape','daterape','deep throat','deepthroat','dendrophilia','dick','dildo','dingleberry','dingleberries','dirty pillows','dirty sanchez','doggie style','doggiestyle','doggy style','doggystyle','dog style','dolcett','domination','dominatrix','dommes','donkey punch','double dong','double penetration','dp action','dry hump','dvda','eat my ass','ecchi','ejaculation','erotic','erotism','escort','eunuch','faggot','fecal','felch','fellatio','feltch','female squirting','femdom','figging','fingerbang','fingering','fisting','foot fetish','footjob','frotting','fuck','fuck buttons','fuckin','fucking','fucktards','fudge packer','fudgepacker','futanari','gang bang','gay sex','genitals','giant cock','girl on','girl on top','girls gone wild','goatcx','goatse','god damn','gokkun','golden shower','goodpoop','goo girl','goregasm','grope','group sex','g-spot','guro','hand job','handjob','hard core','hardcore','hentai','homoerotic','honkey','hooker','hot carl','hot chick','how to kill','how to murder','huge fat','humping','incest','intercourse','jack off','jail bait','jailbait','jelly donut','jerk off','jigaboo','jiggaboo','jiggerboo','jizz','juggs','kike','kinbaku','kinkster','kinky','knobbing','leather restraint','leather straight jacket','lemon party','lolita','lovemaking','make me come','male squirting','masturbate','menage a trois','milf','missionary position','motherfucker','mound of venus','mr hands','muff diver','muffdiving','nambla','nawashi','negro','neonazi','nigga','nigger','nig nog','nimphomania','nipple','nipples','nsfw images','nude','nudity','nympho','nymphomania','octopussy','omorashi','one cup two girls','one guy one jar','orgasm','orgy','paedophile','paki','panties','panty','pedobear','pedophile','pegging','penis','phone sex','piece of shit','pissing','piss pig','pisspig','playboy','pleasure chest','pole smoker','ponyplay','poof','poon','poontang','punany','poop chute','poopchute','porn','porno','pornography','prince albert piercing','pthc','pubes','pussy','queaf','queef','quim','raghead','raging','boner','rape','raping','rapist','rectum','reverse cowgirl','rimjob','rimming','rosy palm','rosy palm and her 5 sisters','rusty trombone','sadism','santorum','scat','schlong','scissoring','semen','sex','sexo','sexy','shaved beaver','shaved pussy','shemale','shibari','shit','shitblimp','shitty','shota','shrimping','skeet','slanteye','slut','s&m','smut','snatch','snowballing','sodomize','sodomy','spic','splooge','splooge moose','spooge','spread legs','spunk','strap on','strapon','strappado','strip club','style doggy','suck','sucks','suicide girls','sultry women','swastika','swinger','tainted love','taste my','tea bagging','threesome','throating','tied up','tight white','tit','tits','titties','titty','tongue in a','topless','tosser','towelhead','tranny','tribadism','tub girl','tubgirl','tushy','twat','twink','twinkie','two girls one cup','undressing','upskirt','urethra play','urophilia','vagina','venus mound','vibrator','violet wand','vorarephilia','voyeur','vulva','wank','wetback','wet dream','white power','wrapping men','wrinkled starfish','xx','xxx','xxxd','yaoi','yellow showers','yiffy','zoophiliaa');

        $rep = '***';

        $bad = array_map('strtolower', $bad);
//        print_r(sizeof($rep));        die;
       // $text = str_replace($bad, $rep, $text);
        //return $text;
		
	$matches = array();
        $matchFound = preg_match_all("/\b(" . implode($bad,"|") . ")\b/i", $text, $matches);
        //print_r($matchFound);
                      
                      
        if ($matchFound) {
           $finalresult = str_replace($bad, $rep, $text); 
        }
        else
        {
            $finalresult = $text;
        }
     
       return $finalresult;
		
    }

    public function getLatestFeedback(){
    	try{
    		$query = "SELECT feedbackId from Tbl_C_Feedback ORDER BY autoId DESC limit 0,1";
    		$stmt = $this->db_connect->prepare($query);
		if ($stmt->execute()) {
                	$response = $stmt->fetch(PDO::FETCH_ASSOC);
                }
    		
    	} catch(Exception $ex){
    		$response = $ex;
    	}
    	return $response;
    }

    public function getFeedbackList($clientId, $empId, $val) {
        try {
            $flagType = 23;
            $query = "select feedbackId from Tbl_C_Feedback WHERE unpublishingTime <= CURDATE() AND unpublishingTime != '0000-00-00 00:00:00' AND status='Live' AND clientId=:clientId AND flagType=:flagType";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':clientId', $clientId, PDO::PARAM_STR);
            $stmt->bindParam(':flagType', $flagType, PDO::PARAM_STR);
            if ($stmt->execute()) {
            	$feedbackList = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            
            foreach($feedbackList as $feeds) {
            	$fstatus = "Expired";
            	self::status_FeedbackWall($feeds['feedbackId'], $fstatus);
            }
            
        
            $query = "select count(autoId) as total from Tbl_C_Feedback WHERE clientId=:clientId AND flagType=:flagType";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':clientId', $clientId, PDO::PARAM_STR);
            $stmt->bindParam(':flagType', $flagType, PDO::PARAM_STR);
            //$stmt->bindParam(':status', $status, PDO::PARAM_STR);
            if ($stmt->execute()) {
                $total = $stmt->fetch(PDO::FETCH_ASSOC);
            }

            $query = "SELECT *, DATE_FORMAT(publishingTime, '%d %M %Y') as publishingTime, if(unpublishingTime = '0000-00-00 00:00:00' , '', DATE_FORMAT(unpublishingTime, '%d %M %Y')) as unpublishingTime, (select count(commentId) as totalComments from Tbl_C_FeedbackComments where feedbackId=Tbl_C_Feedback.feedbackId) as total_comments FROM Tbl_C_Feedback WHERE clientId=:clientId AND flagType=:flagType ORDER BY Tbl_C_Feedback.status DESC,Tbl_C_Feedback.createdDate DESC LIMIT $val,10";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':clientId', $clientId, PDO::PARAM_STR);
            $stmt->bindParam(':flagType', $flagType, PDO::PARAM_STR);
            //$stmt->bindParam(':status', $status, PDO::PARAM_STR);
            if ($stmt->execute()) {
                $feedbackResult = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $result['success'] = 1;
                $result['total'] = $total['total'];
                $result['data'] = $feedbackResult;
            }
            
            $datacount = count($result['data']);
                    //echo $datacount;
            if ($datacount < 1) {
            	$result = array();
                $result['success'] = 0;
                $result['message'] = "No more posts available";
                return $result;
            } else {
                return $result;
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

                        $query = "SELECT feedComments.*, DATE_FORMAT(feedComments.CommentDate, '%d %M %Y') as CommentDate, feed.feedbackQuestion, feed.feedbackTopic, if(feed.unpublishingTime = '0000-00-00 00:00:00' , '', DATE_FORMAT(feed.unpublishingTime, '%d %M %Y')) as unpublishingTime, (select count(autoId) from Tbl_C_FeedbackCommentLikes where commentId=feedComments.commentId and feedbackId=:feedbackId and like_unlike_status='1') as totalLikes, if((select count(autoId) from Tbl_C_FeedbackCommentLikes where commentId=feedComments.commentId and feedbackId=:feedbackId and employeeId=:empId and like_unlike_status='1')>0, (select if(employeeId=:empId, '1', '0') as likeStatus from Tbl_C_FeedbackCommentLikes where commentId=feedComments.commentId and feedbackId=:feedbackId and employeeId=:empId and like_unlike_status='1'), '0') as likeStatus, if(feedComments.anonymous='1', 'Anonymous', concat(master.firstName, ' ',master.lastName)) as user_name,if(feedComments.anonymous='1', if(feedComments.avatar_image='', '', concat('" . site_url . "', feedComments.avatar_image)) , if(personal.userImage='', '', concat('" . site_url . "', personal.userImage))) as avatar_image FROM Tbl_C_FeedbackComments as feedComments JOIN Tbl_C_Feedback as feed ON feedComments.feedbackId=feed.feedbackId JOIN Tbl_EmployeePersonalDetails as personal ON feedComments.commentBy=personal.employeeId JOIN Tbl_EmployeeDetails_Master as master ON master.employeeId=personal.employeeId WHERE feed.clientId=:clientId AND feed.flagType=:flagType AND feedComments.feedbackId=:feedbackId ORDER BY feedComments.autoId desc limit $val,10";

                        $stmt = $this->db_connect->prepare($query);
                        $stmt->bindParam(':clientId', $clientId, PDO::PARAM_STR);
                        $stmt->bindParam(':empId', $empId, PDO::PARAM_STR);
                        $stmt->bindParam(':flagType', $flagType, PDO::PARAM_STR);
//                	$stmt->bindParam(':status', $status, PDO::PARAM_STR);
                        $stmt->bindParam(':feedbackId', $feedbackId, PDO::PARAM_STR);
                        if ($stmt->execute()) {
                            $commentResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
							
			    if(!empty($commentResult)){
		                    $result['success'] = 1;
		                    $result['message'] = "Feedback comments available";
		                    $result['totalComments'] = $totalComments['totalComments'];
		                    //$result['avatar_image'] = $avatarResult['avatar_image'];
		                    $result['feedbackId'] 	 = $feedbackId;
		                    $result['feedback_topic']    = $commentResult[0]['feedbackTopic'];
		                    $result['feedback_question'] = $commentResult[0]['feedbackQuestion'];
		                    $result['unpublishing_time'] = $commentResult[0]['unpublishingTime'];
		                    $result['data'] = $commentResult;
		                    //$result['data'][0]['comment_text'] = base64_decode($commentResult[5]['comment_text']);
                            } else {				
				/*************************************************/

				$queryfeed = "SELECT *, if(unpublishingTime = '0000-00-00 00:00:00' , '', DATE_FORMAT(unpublishingTime, '%d %M %Y')) as unpublishingTime FROM Tbl_C_Feedback WHERE feedbackId=:fbId";
				$stmtfeed = $this->db_connect->prepare($queryfeed);
				$stmtfeed->bindParam(':fbId', $feedbackId, PDO::PARAM_STR);
				$stmtfeed->execute();
				$commentResultfeed = $stmtfeed->fetchAll(PDO::FETCH_ASSOC);
							
				/*************************************************/
				$result['success'] = 0;
				$result['message'] = "No more comments available";
				//$result['avatar_image'] = $avatarResult['avatar_image'];
				$result['feedbackId'] 	 = $feedbackId;
				$result['feedback_topic'] = $commentResultfeed[0]['feedbackTopic'];
				$result['feedback_question'] = $commentResultfeed[0]['feedbackQuestion'];
				$result['unpublishing_time'] = $commentResultfeed[0]['unpublishingTime'];
                            }
//                print_r($result);die;
                        }
                    } catch (Exception $ex) {
                        $result = $ex;
                    }
                } else {
	            $query = "SELECT *,  if(unpublishingTime = '0000-00-00 00:00:00' , '', DATE_FORMAT(unpublishingTime, '%d %M %Y')) as unpublishingTime FROM Tbl_C_Feedback WHERE feedbackId=:feedbackId";
		    $stmt = $this->db_connect->prepare($query);
		    $stmt->bindParam(':feedbackId', $feedbackId, PDO::PARAM_STR);
		    $stmt->execute();
		    $commentResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                    $result['success'] = 0;
                    $result['message'] = "No Comments available";
                    $result['feedbackId'] 	 = $feedbackId;
                    $result['feedback_topic']    = $commentResult[0]['feedbackTopic'];
                    $result['feedback_question'] = $commentResult[0]['feedbackQuestion'];
                    $result['unpublishing_time'] = $commentResult[0]['unpublishingTime'];
                    $result['totalComments'] = $totalComments['totalComments'];
                    //$result['avatar_image'] = $avatarResult['avatar_image'];
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

    public function addFeedComments($cid, $commentId, $feedbackId, $comment_text, $commentBy, $anonymous, $avatar_img) {
        try {
            date_default_timezone_set('Asia/Kolkata');
            $commentDate = date('Y-m-d H:i:s');
	
	    if(!empty($avatar_img)){
		$avatar_img = explode('images/avatar_images/', $avatar_img);
		$avatar_img = "images/avatar_images/" . $avatar_img[1];
	    }else{
	    	$avatar_img = '';
	    }
	    
            $query = "INSERT INTO Tbl_C_FeedbackComments (commentId, feedbackId, clientId, comment_text, commentBy, CommentDate, anonymous, avatar_image) VALUES (:commentId, :feedbackId, :cid, :comment_text, :commentBy, :cdate, :anonymous, :avatar_img)";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':commentId', $commentId, PDO::PARAM_STR);
            $stmt->bindParam(':feedbackId', $feedbackId, PDO::PARAM_STR);
            $stmt->bindParam(':anonymous', $anonymous, PDO::PARAM_STR);
            $stmt->bindParam(':avatar_img', $avatar_img, PDO::PARAM_STR);
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
            date_default_timezone_set('Asia/Kolkata');
            $likeDate = date('Y-m-d H:i:s');
            $query = "INSERT INTO Tbl_C_FeedbackCommentLikes (commentId, feedbackId, employeeId, like_unlike_status,createdDate,updatedDate) VALUES (:commentId, :feedbackId, :empId, :status,:cd,:ud) ON DUPLICATE KEY UPDATE like_unlike_status=:status,updatedDate=:ud";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':cid', $cid, PDO::PARAM_STR);
            $stmt->bindParam(':commentId', $commentId, PDO::PARAM_STR);
            $stmt->bindParam(':feedbackId', $feedbackId, PDO::PARAM_STR);
            $stmt->bindParam(':empId', $empId, PDO::PARAM_STR);
            $stmt->bindParam(':status', $status, PDO::PARAM_STR);
            $stmt->bindParam(':cd', $likeDate, PDO::PARAM_STR);
            $stmt->bindParam(':ud', $likeDate, PDO::PARAM_STR);

            if ($stmt->execute()) {
                $totalLikesQuery = "select count(autoId) as totalLikes from Tbl_C_FeedbackCommentLikes where commentId=:commentId and feedbackId=:feedbackId and like_unlike_status='1'"; 
		$stmt = $this->db_connect->prepare($totalLikesQuery);
		$stmt->bindParam(':commentId', $commentId, PDO::PARAM_STR);
		$stmt->bindParam(':feedbackId', $feedbackId, PDO::PARAM_STR);
		$stmt->execute();
		$totalLikes = $stmt->fetch(PDO::FETCH_ASSOC);
            
                $result['success'] = 1;
                $result['status'] = $status;
                $result['totalLikes'] = $totalLikes['totalLikes'];
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
    
    /********************************* status feedback wall ***************************/

    function status_FeedbackWall($fid, $fstatus) {
 	$flag = 23;
        if ($fstatus == 'Live') {
            $status = 1;
        } else {
            $status = 0;
        }
        
        try {
            $query = "update Tbl_C_Feedback set status = :sta where feedbackId = :fid And flagType = :flag";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':fid', $fid, PDO::PARAM_STR);
            $stmt->bindParam(':sta', $fstatus, PDO::PARAM_STR);
			$stmt->bindParam(':flag', $flag, PDO::PARAM_STR);
            $stmt->execute();

            $gquery = "update Tbl_Analytic_PostSentToGroup set status = :sta2 where postId = :fid2 And flagType = :flag2 ";
            $stmtg = $this->db_connect->prepare($gquery);
            $stmtg->bindParam(':fid2', $fid, PDO::PARAM_STR);
            $stmtg->bindParam(':sta2', $status, PDO::PARAM_STR);
	    $stmtg->bindParam(':flag2', $flag, PDO::PARAM_STR);
	    $stmtg->execute();
			
	    $wquery = "update Tbl_C_WelcomeDetails set status = :sta3 where id = :fid3 And flagType = :flag3 ";
            $stmtw = $this->db_connect->prepare($wquery);
            $stmtw->bindParam(':fid3', $fid, PDO::PARAM_STR);
            $stmtw->bindParam(':sta3', $status, PDO::PARAM_STR);
	    $stmtw->bindParam(':flag3', $flag, PDO::PARAM_STR);
            
            if ($stmtw->execute()) {
                $response["success"] = 1;
                $response["message"] = "Feedback Wall status has changed";
            } else {
                $response["success"] = 0;
                $response["message"] = "Feedback Wall Not change";
            }
        } catch (PDOException $e) {
            $response["success"] = 0;
                $response["message"] = "Feedback Wall status Not change".$e;
        }
	
    }

}
