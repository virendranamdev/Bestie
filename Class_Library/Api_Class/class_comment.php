<?php

//error_reporting(E_ALL); ini_set('display_errors', 1);
if (!class_exists('Connection_Communication')) {
    require_once('class_connect_db_Communication.php');
}

class Comment {

    public $DB;

    public function __construct() {
        $db = new Connection_Communication();
        $this->DB = $db->getConnection_Communication();
    }

    public $postid;
    public $commentedby;
    public $commentcontent;

    public function filterWords($text) {
        $text = strtolower($text);
//        $bad = array('dirty', 'butt', 'lips', 'fuck');
        $bad = array('Alcoholic', 'Amateur', 'Analphabet', 'Anarchist', 'Ape', 'Arse', 'Arselicker', 'Ass', 'Ass master', 'Ass-kisser', 'Ass-nugget', 'Ass-wipe', 'Asshole','Baby', 'Backwoodsman', 'Balls', 'Bandit', 'Barbar', 'Bastard', 'Beavis', 'Beginner', 'Biest', 'Bitch', 'Blubber gut', 'Bogeyman', 'Booby', 'Boozer', 'Bozo', 'Brain-fart', 'Brainless', 'Brainy', 'Brontosaurus', 'Brownie', 'Bugger', 'silly', 'Bulloks', 'Bum', 'Bum-fucker', 'Butt', 'Buttfucker', 'Butthead','Callboy', 'Callgirl', 'Camel', 'Cannibal', 'Cave man', 'Chaavanist', 'Chaot', 'Chauvi', 'Cheater', 'Chicken', 'Children fucker', 'Clit', 'Clown', 'Cock', 'Cock master', 'Cock up', 'Cockboy', 'Cockfucker', 'Cockroach', 'Coky', 'Con merchant', 'Con-man', 'Country bumpkin', 'Cow', 'Creep', 'Cretin', 'Criminal', 'Cunt', 'Cunt sucker','Daywalker', 'Deathlord', 'Derr brain', 'Desperado', 'Devil', 'Dickhead', 'Dinosaur', 'Disgusting packet', 'Diz brain', 'Do-Do', 'Dog', 'dirty', 'Dogshit', 'Donkey', 'Dracula', 'Drakula', 'Dreamer', 'Drinker', 'Drunkard', 'Dufus', 'Dulles', 'Dumbo', 'Dummy', 'Dumpy',
    'Egoist', 'Eunuch', 'Exhibitionist', 'Fake', 'Fanny', 'Farmer', 'Fart', 'shitty', 'Fat', 'Fatso', 'Fibber', 'Fish', 'Fixer', 'Flake', 'Flash Harry', 'Freak', 'Frog', 'Fuck', 'Fuck face', 'Fuck head', 'Fuck noggin', 'Fucker', 'Gangster', 'Ghost', 'Goose', 'Gorilla', 'Grouch', 'Grumpy','Hell dog', 'Hillbilly', 'Hippie', 'Homo', 'Homosexual', 'Hooligan', 'Horse fucker','Idiot', 'Ignoramus','Jack-ass', 'Jerk', 'Joker', 'Junkey',
    'Killer','Lard face', 'Latchkey child', 'Learner', 'Liar', 'Looser', 'Lucky', 'Lumpy', 'Luzifer','Macho', 'Macker', 'Minx', 'Missing link', 'Monkey', 'Monster', 'Motherfucker', 'Mucky pub', 'Mutant','Neanderthal', 'Nerfhearder', 'Nobody', 'Nurd', 'Nuts', 'numb','Oddball', 'Oger', 'Oil dick', 'Old fart', 'Orang-Uthan', 'Original', 'Outlaw','Pack', 'Pain in the ass', 'Pavian', 'Pencil dick', 'Pervert', 'Pig', 'Piggy-wiggy', 'Pirate', 'Pornofreak', 'Prick', 'Prolet','Queer', 'Querulant','Rat', 'Rat-fink', 'Reject', 'Retard', 'Riff-Raff', 'Ripper', 'Roboter', 'Rowdy', 'Rufian','Sack', 'Sadist', 'Saprophyt', 'Satan', 'Scarab', 'Schfincter', 'Shark', 'Shit eater', 'Shithead', 'Simulant', 'Skunk', 'Skuz bag', 'Slave', 'Sleeze', 'Sleeze bag', 'Slimer', 'Slimy bastard', 'Small pricked', 'Snail', 'Snake', 'Snob', 'Snot', 'Son of a bitch', 'Square', 'Stinker', 'Stripper', 'Stunk', 'Swindler', 'Swine','Teletubby', 'Thief', 'Toilett cleaner', 'Tussi', 'Typ',
    'Unlike','Vampir', 'Vandale', 'Varmit','Wallflower', 'Wanker', 'bloody', 'Weeze Bag', 'Whore', 'Wierdo', 'Wino', 'Witch', 'Womanizer', 'Woody allen', 'Worm','Xena', 'Xenophebe', 'Xenophobe', 'XXX Watcher','Yak', 'Yeti','Zit face',
            
            '2g1c','acrotomophilia','alabama hot pocket','alaskan pipeline','anal','anilingus','anus','apeshit','arsehole','ass','asshole','assmunch','auto erotic','autoerotic','babeland','baby batter','baby juice','ball gag','ball gravy','ball kicking','ball licking','ball sack','ball sucking','bangbros','bareback','barely legal','barenaked','bastard','bastardo','bastinado','bbw','bdsm','beaner','beaners','beaver cleaver','beaver lips','bestiality','big black','big breasts','big knockers','big tits','bimbos','birdlock','bitch','bitches','black cock','blonde action','blonde on blonde action','blowjob','blow job','blow your load','blue waffle','blumpkin','bollocks','bondage','boner','boob','boobs','booty call','brown showers','brunette action','bukkake','bulldyke','bullet vibe','bullshit','bung hole','bunghole','busty','butt','buttcheeks','butthole','camel toe','camgirl','camslut','camwhore','carpet muncher','carpetmuncher','chocolate rosebuds','circlejerk','cleveland steamer','clit','clitoris','clover clamps','clusterfuck','cock','cocks','coprolagnia','coprophilia','cornhole','coon','coons','creampie','cum','cumming','cunnilingus','cunt','darkie','date rape','daterape','deep throat','deepthroat','dendrophilia','dick','dildo','dingleberry','dingleberries','dirty pillows','dirty sanchez','doggie style','doggiestyle','doggy style','doggystyle','dog style','dolcett','domination','dominatrix','dommes','donkey punch','double dong','double penetration','dp action','dry hump','dvda','eat my ass','ecchi','ejaculation','erotic','erotism','escort','eunuch','faggot','fecal','felch','fellatio','feltch','female squirting','femdom','figging','fingerbang','fingering','fisting','foot fetish','footjob','frotting','fuck','fuck buttons','fuckin','fucking','fucktards','fudge packer','fudgepacker','futanari','gang bang','gay sex','genitals','giant cock','girl on','girl on top','girls gone wild','goatcx','goatse','god damn','gokkun','golden shower','goodpoop','goo girl','goregasm','grope','group sex','g-spot','guro','hand job','handjob','hard core','hardcore','hentai','homoerotic','honkey','hooker','hot carl','hot chick','how to kill','how to murder','huge fat','humping','incest','intercourse','jack off','jail bait','jailbait','jelly donut','jerk off','jigaboo','jiggaboo','jiggerboo','jizz','juggs','kike','kinbaku','kinkster','kinky','knobbing','leather restraint','leather straight jacket','lemon party','lolita','lovemaking','make me come','male squirting','masturbate','menage a trois','milf','missionary position','motherfucker','mound of venus','mr hands','muff diver','muffdiving','nambla','nawashi','negro','neonazi','nigga','nigger','nig nog','nimphomania','nipple','nipples','nsfw images','nude','nudity','nympho','nymphomania','octopussy','omorashi','one cup two girls','one guy one jar','orgasm','orgy','paedophile','paki','panties','panty','pedobear','pedophile','pegging','penis','phone sex','piece of shit','pissing','piss pig','pisspig','playboy','pleasure chest','pole smoker','ponyplay','poof','poon','poontang','punany','poop chute','poopchute','porn','porno','pornography','prince albert piercing','pthc','pubes','pussy','queaf','queef','quim','raghead','raging','boner','rape','raping','rapist','rectum','reverse cowgirl','rimjob','rimming','rosy palm','rosy palm and her 5 sisters','rusty trombone','sadism','santorum','scat','schlong','scissoring','semen','sex','sexo','sexy','shaved beaver','shaved pussy','shemale','shibari','shit','shitblimp','shitty','shota','shrimping','skeet','slanteye','slut','s&m','smut','snatch','snowballing','sodomize','sodomy','spic','splooge','splooge moose','spooge','spread legs','spunk','strap on','strapon','strappado','strip club','style doggy','suck','sucks','suicide girls','sultry women','swastika','swinger','tainted love','taste my','tea bagging','threesome','throating','tied up','tight white','tit','tits','titties','titty','tongue in a','topless','tosser','towelhead','tranny','tribadism','tub girl','tubgirl','tushy','twat','twink','twinkie','two girls one cup','undressing','upskirt','urethra play','urophilia','vagina','venus mound','vibrator','violet wand','vorarephilia','voyeur','vulva','wank','wetback','wet dream','white power','wrapping men','wrinkled starfish','xx','xxx','xxxd','yaoi','yellow showers','yiffy','zoophiliaa');

        $rep = '***';

//                '***', '***', '***', '***', '***', '***', '***', '***', '***', '***');
        $bad = array_map('strtolower', $bad);
//      print_r(sizeof($rep));        die;
        //$text = str_replace($bad, $rep, $text);
        //return $text;
		$matches = array();
        $matchFound = preg_match_all("/\b(" . implode($bad,"|") . ")\b/i", $text,$matches);
                    //  print_r($matchFound);        
        if ($matchFound) {
           $finalresult = str_replace($bad, $rep, $text); 
        }
        else
        {
            $finalresult = $text;
        }
     
       return $finalresult;
    }

    function create_Comment($client, $pid, $comby, $comcon, $flag, $device,$deviceid) {
        $this->clientid = $client;
        $this->postid = $pid;
        $this->commentedby = $comby;
        $this->commentcontent = $comcon;

        date_default_timezone_set('Asia/Calcutta');

        $cd = date('Y-m-d H:i:s');
        $st = "Show";

        try {
            $max = "select max(autoid) from Tbl_Analytic_PostComment";
            $stmt = $this->DB->prepare($max);
            if ($stmt->execute()) {
                $tr = $stmt->fetch();
                $m_id = $tr[0];
                $m_id1 = $m_id + 1;
                $commentid = "Comment-" . $m_id1;
            }
        } catch (PDOException $e) {
            echo $e;
            trigger_error('Error occured fetching max autoid : ' . $e->getMessage(), E_USER_ERROR);
        }

		
        try {
            $query = "insert into Tbl_Analytic_PostComment(commentId,clientId,postId,comment,commentBy,commentDate,status,flagType,device,deviceId)
            values(:pid,:cli,:pt,:cc,:pi,:cd,:st,:flag,:device,:deviceid)";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':pid', $commentid, PDO::PARAM_STR);
            $stmt->bindParam(':cli', $this->clientid, PDO::PARAM_STR);
            $stmt->bindParam(':pt', $this->postid, PDO::PARAM_STR);
            $stmt->bindParam(':cc', $this->commentcontent, PDO::PARAM_STR);
            $stmt->bindParam(':pi', $this->commentedby, PDO::PARAM_STR);
            $stmt->bindParam(':cd', $cd, PDO::PARAM_STR);
            $stmt->bindParam(':st', $st, PDO::PARAM_STR);
            $stmt->bindParam(':flag', $flag, PDO::PARAM_STR);
            $stmt->bindParam(':device', $device, PDO::PARAM_STR);
             $stmt->bindParam(':deviceid', $deviceid, PDO::PARAM_STR);

            if ($stmt->execute()) {
                try {
                    $query1 = "SELECT * , DATE_FORMAT(commentDate,'%d %b %Y %h:%i %p') as commentDate FROM Tbl_Analytic_PostComment WHERE postId = :pstid AND status = 'Show' order by autoId desc";
                    $stmt1 = $this->DB->prepare($query1);
                    $stmt1->bindParam(':pstid', $this->postid, PDO::PARAM_STR);
                    $stmt1->execute();
                    $rows = $stmt1->fetchAll();

                    $response["posts"] = array();


                    if ($rows) {
                        $forimage = dirname(SITE_URL) . "/";

                        $query1 = "select count(commentId) as total_comments from Tbl_Analytic_PostComment where postId =:pi and clientId=:cli and status='Show'";
                        $stmt1 = $this->DB->prepare($query1);
                        $stmt1->bindParam(':cli', $client, PDO::PARAM_STR);
                        $stmt1->bindParam(':pi', $pid, PDO::PARAM_STR);
                        $stmt1->execute();
                        $row = $stmt1->fetch(PDO::FETCH_ASSOC);

                        $query2 = "select count(postId) as total_likes from Tbl_Analytic_PostLike where postId =:pi and clientId=:cli AND status = 1";
                        $stmt2 = $this->DB->prepare($query2);
                        $stmt2->bindParam(':cli', $this->clientid, PDO::PARAM_STR);
                        $stmt2->bindParam(':pi', $this->postid, PDO::PARAM_STR);
                        $stmt2->execute();
                        $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);


                        $response["success"] = 1;
                        $response["message"] = "Comment posted successfully";
                        $response["total_comments"] = $row["total_comments"];
                        $response["total_likes"] = $row2["total_likes"];

                        for ($i = 0; $i < count($rows); $i++) {
                            $post = array();

                            $post["comment_id"] = $rows[$i]["commentId"];
                            $post["post_id"] = $rows[$i]["postId"];
                            $post["content"] = $rows[$i]["comment"];
							 $post["comment"] = $rows[$i]["comment"];
                            $post["commentby"] = $rows[$i]["commentBy"];
                            $mailid = $rows[$i]["commentBy"];

                            $query2 = "SELECT Tbl_EmployeeDetails_Master.*, Tbl_EmployeePersonalDetails.* FROM Tbl_EmployeeDetails_Master join Tbl_EmployeePersonalDetails on Tbl_EmployeeDetails_Master.employeeId = Tbl_EmployeePersonalDetails.employeeId WHERE Tbl_EmployeeDetails_Master.employeeId =:maid";
                            $stmt2 = $this->DB->prepare($query2);
                            $stmt2->bindParam(':maid', $mailid, PDO::PARAM_STR);
                            $stmt2->execute();
                            $row = $stmt2->fetch();

                            $post["firstname"] = $row["firstName"];
							$post["middlename"] = $row["middleName"];
                            $post["lastname"] = $row["lastName"];
							$post["name"] = $row["firstName"]." ".$row["middleName"]." ".$row["lastName"];
                            $post["designation"] = $row["designation"];
                            $post["userImage"] = ($row["userImage"]=="")?"":$forimage . $row["userImage"];
                            $post["cdate"] = $rows[$i]["commentDate"];
							$post["commentDate"] = $rows[$i]["commentDate"];

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

    function Comment_display($clientid, $postid, $flag,$site_url='') {
         $path = (!empty($site_url))?$site_url:site_url;
        try {
            $query = "select *,DATE_FORMAT(commentDate,'%d %b %Y %h:%i %p') as commentDate from Tbl_Analytic_PostComment where postId =:pi and clientId=:cli and flagType = :flag and status='Show' order by autoId desc";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cli', $clientid, PDO::PARAM_STR);
            $stmt->bindParam(':pi', $postid, PDO::PARAM_STR);
            $stmt->bindParam(':flag', $flag, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $response = array();

            $query1 = "select count(commentId) as total_comments from Tbl_Analytic_PostComment where postId =:pi and clientId=:cli and flagType =:flag1 and status='Show'";
            $stmt1 = $this->DB->prepare($query1);
            $stmt1->bindParam(':cli', $clientid, PDO::PARAM_STR);
            $stmt1->bindParam(':pi', $postid, PDO::PARAM_STR);
            $stmt1->bindParam(':flag1', $flag, PDO::PARAM_STR);
            $stmt1->execute();
            $row = $stmt1->fetch(PDO::FETCH_ASSOC);

            $query2 = "select count(postId) as total_likes from Tbl_Analytic_PostLike where postId =:pi and clientId=:cli and flagType = :flag2 And status = 1";
            $stmt2 = $this->DB->prepare($query2);
            $stmt2->bindParam(':cli', $clientid, PDO::PARAM_STR);
            $stmt2->bindParam(':pi', $postid, PDO::PARAM_STR);
            $stmt2->bindParam(':flag2', $flag, PDO::PARAM_STR);
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
                    $post["commentBy"] = $row["commentBy"];
                    $employeeid = $row["commentBy"];


                    $query = "select Tbl_EmployeeDetails_Master.*,Tbl_EmployeePersonalDetails.* from Tbl_EmployeeDetails_Master join Tbl_EmployeePersonalDetails on Tbl_EmployeeDetails_Master.employeeId=Tbl_EmployeePersonalDetails.employeeId where Tbl_EmployeeDetails_Master.employeeId=:empid";
                    $stmt = $this->DB->prepare($query);
                    $stmt->bindParam(':empid', $employeeid, PDO::PARAM_STR);
                    $stmt->execute();
                    $rows = $stmt->fetch(PDO::FETCH_ASSOC);

                    $post["name"] = $rows["firstName"] . " " . $rows["middleName"]. " " . $rows["lastName"];
                    $post["userImage"] = !empty($rows["userImage"]) ? $path . $rows["userImage"] : "";
                    $post["designation"] = $rows["designation"];
                    $post["comment"] = $row["comment"];
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

    public function getGroups($clientId, $postId, $flagcheck) {

        switch ($flagcheck) {
            /*             * ************************************** news ************************** */
            case 1:
                try {
                    $query = "SELECT groupId FROM Tbl_Analytic_PostSentToGroup WHERE clientId=:cli and postId=:pId and flagType = 1";
                    $stmt = $this->DB->prepare($query);
                    $stmt->bindParam(':cli', $clientId, PDO::PARAM_STR);
                    $stmt->bindParam(':pId', $postId, PDO::PARAM_STR);
                    $stmt->execute();
                    $response = $stmt->fetchAll(PDO::FETCH_COLUMN);
                } catch (Exception $ex) {
                    echo $ex;
                }
                return $response;
                break;
            /*             * ******************* album *********************** */
            case 11:
                try {
                    $query = "SELECT groupId FROM Tbl_Analytic_AlbumSentToGroup WHERE clientId=:cli and albumId=:pId";
                    $stmt = $this->DB->prepare($query);
                    $stmt->bindParam(':cli', $clientId, PDO::PARAM_STR);
                    $stmt->bindParam(':pId', $postId, PDO::PARAM_STR);
                    $stmt->execute();
                    $response = $stmt->fetchAll(PDO::FETCH_COLUMN);
                } catch (Exception $ex) {
                    echo $ex;
                }
                return $response;
                break;
            /*             * ************************************ achiver story ********************* */
            case 16:
                try {
                    $query = "SELECT groupId FROM Tbl_Analytic_StorySentToGroup WHERE clientId=:cli and storyId=:pId";
                    $stmt = $this->DB->prepare($query);
                    $stmt->bindParam(':cli', $clientId, PDO::PARAM_STR);
                    $stmt->bindParam(':pId', $postId, PDO::PARAM_STR);
                    $stmt->execute();
                    $response = $stmt->fetchAll(PDO::FETCH_COLUMN);
                } catch (Exception $ex) {
                    echo $ex;
                }
                return $response;
                break;
            /*             * ********************************* event **************************** */
            case 6:
                try {
                    $query = "SELECT groupId FROM Tbl_Analytic_EventSentToGroup WHERE clientId=:cli and eventId=:pId";
                    $stmt = $this->DB->prepare($query);
                    $stmt->bindParam(':cli', $clientId, PDO::PARAM_STR);
                    $stmt->bindParam(':pId', $postId, PDO::PARAM_STR);
                    $stmt->execute();
                    $response = $stmt->fetchAll(PDO::FETCH_COLUMN);
                } catch (Exception $ex) {
                    echo $ex;
                }
                return $response;
                break;
            /*             * ************************** poll ************************ */
            case 4:
                try {
                    $query = "SELECT groupId FROM Tbl_Analytic_PollSentToGroup WHERE clientId=:cli and pollId=:pId";
                    $stmt = $this->DB->prepare($query);
                    $stmt->bindParam(':cli', $clientId, PDO::PARAM_STR);
                    $stmt->bindParam(':pId', $postId, PDO::PARAM_STR);
                    $stmt->execute();
                    $response = $stmt->fetchAll(PDO::FETCH_COLUMN);
                } catch (Exception $ex) {
                    echo $ex;
                }
                return $response;
                break;
            /*             * ************************** Contributor ************************ */
            case 17:
                try {
                    $query = "SELECT * FROM Tbl_Analytic_PollSentToGroup WHERE clientId=:cli and pollId=:pId and flagType = 17";
                    $stmt = $this->DB->prepare($query);
                    $stmt->bindParam(':cli', $clientId, PDO::PARAM_STR);
                    $stmt->bindParam(':pId', $postId, PDO::PARAM_STR);
                    $stmt->execute();
                    $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
                } catch (Exception $ex) {
                    echo $ex;
                }
                return $response;
        }
    }

}

?>
