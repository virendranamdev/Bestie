<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

@session_start();
if (!class_exists('Connection_Communication')) {
    include_once('class_connect_db_Communication.php');
}

class User {

    public $DB;

    public function __construct() {
        $db = new Connection_Communication();
        $this->DB = $db->getConnection_Communication();
    }

    /*     * ****************************** get max userid ************************** */

    public function maxuserid() {
        try {
            $max = "select max(autoId) from Tbl_EmployeeDetails_Master";
            $query = $this->DB->prepare($max);
            if ($query->execute()) {
                $tr = $query->fetch();
                $m_id = $tr[0];
                $m_id1 = $m_id + 1;
                $usid = "User-" . $m_id1;
                return $usid;
            }
        } catch (PDOException $e) {
            echo $e;
            trigger_error('Error occured fetching max autoid : ' . $e->getMessage(), E_USER_ERROR);
        }
    }

    /*     * ********************************** / get max user id ************************* */

    public $filename;
    public $filetempname;
    public $fullcsvpath;
    public $client_id;
    public $createdby;
    
    
    function testMailUserCsv($clientid1, $user, $file_name, $file_temp_name, $fullpath, $adminname, $adminemail) {
        $imgpath = SITE_URL;
        $this->fullcsvpath = $fullpath;

        date_default_timezone_set('Asia/Kolkata');
        $c_date = date('Y-m-d H:i:s');
        $status = "Active";
        $access = "User";
        $this->client_id = $clientid1;
        $user_session = $_SESSION['user_email'];
        $this->createdby = $user;
        //  echo "user unique id := ".$this->createdby;
        $this->filename = $file_name;
        $this->filetempname = $file_temp_name;
        $target_file = basename($this->filename);

        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

        if ($imageFileType != "csv") {
            echo "Sorry, only .csv files are allowed.";
            $uploadOk = 0;
        } else {
            $handle = fopen($this->filetempname, "r");
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $userdata[] = $data;
            }

            /*             * ************start insert into database ************************************************* */
            /* echo "<pre>"; print_r($userdata); */
            $countrows = count($userdata);
            if ($countrows > 200) {
                echo "<script>alert(Sorry! You can't upoad data more than 200 employee at a time) </script>";
            }
            
            $program_name = "Bestie";
            $dedicateemail = "support@mybestie.in";
            $subdomain_link = "bestie.benepik.com";

            /*             * ************************ fetching data from B_Client_Data******************************** */

		
            for ($row = 1; $row < $countrows; $row++) {

                $adminaccess = 'Admin';
                $useremail = $userdata[$row][5];
                //$companyname = $userdata[$row][14];				
                        /* * ********************* mail  send **************************** */


                        /* * ************************** */
                $to = $useremail;
                echo $to.'<br>';
                /*                 * ************************************************************************************************************************************************************* */
                $subject = 'Test Email from Bestie';

                $bound_text = "----*%$!$%*";
                $bound = "--" . $bound_text . "\r\n";
                $bound_last = "--" . $bound_text . "--\r\n";



                $headers = "From: " . $program_name . " <" . $dedicateemail . "> \r\n" . "Return-Path: " . $dedicateemail . "\r\n";
                $headers .= "MIME-Version: 1.0\r\n" .
                        "Content-Type: multipart/mixed; boundary=\"$bound_text\"" . "\r\n";

                $message =
                        'Content-Type: text/html; charset=UTF-8' . "\r\n" .
                        'Content-Transfer-Encoding: 7bit' . "\r\n\r\n" .
                        
			'<html>

			   <body>
			   <div style="width: 700;height: 500;background: white;">
			   <div style="width: 700;height: 100;background: white" >
			   </div >
			   
			   <div style="background: window;height: 420;  ">
			   <div style="width: 600; ">
			   <p>Dear '.ucfirst($userdata[$row][0]).',</p>
			   <p >This is a Test Email to check if you are receiving emails from Bestie.</p> 
			   <p>For any queries, please contact preethi.priscillakumarai@barclays.com </p>
			 
			   <br>

			   <p>Yours Bestie</p>
			 
			   
			   </div>
			   </div>
			   
			   
			   </div>
			   </body>
			</html>';
			   // ' . "\n\n" .   $bound_last;
                /*                 * ************************************************************************************************************************************************************* */
		if (!mail($to, $subject, $message, $headers, '-f ' . $dedicateemail)) {
                    echo "Mail Failed";
                }

            }
            
            $result = 1;
            if ($result == 1) {
                $number = $countrows - 1;

                $path = $this->fullcsvpath;

                $to1 = "gagandeep@benepik.com";
                /*                 * ************************************************************************************************************************************************************* */
                $subject = 'Administrator has uploaded a CSV File';

                $bound_text = "----*%$!$%*";
                $bound = "--" . $bound_text . "\r\n";
                $bound_last = "--" . $bound_text . "--\r\n";



                $headers = "From: " . $program_name . " <" . $dedicateemail . "> \r\n" . "Return-Path: " . $dedicateemail . "\r\n";
                $headers .= "MIME-Version: 1.0\r\n" .
                        "Content-Type: multipart/mixed; boundary=\"$bound_text\"" . "\r\n";

                $message = " Now You Can Login With This Emailid & Password \r\n" . $bound;

                $message .=

                        'Content-Type: text/html; charset=UTF-8' . "\r\n" .
                        'Content-Transfer-Encoding: 7bit' . "\r\n\r\n" .
                        '

			<html>

			   <body>
			   <div style="width: 700;height: 500;background: white;">
			   <div style="width: 700;height: 100;background: white" >
			   </div >
			   
			   <div style="background: window;height: 420;  ">
			   <div style="width: 600; ">
			   <p>Dear Admin,</p>
			   <p ><b>' . $program_name . ' Administrator has uploaded a CSV File</b></p> 
			   <p><b>' . $number . '</b> Users are listed in CSV</p>
			   <p>Users CSV can be downloaded from here <a href=' . SITE_URL . "/" . $path . '>User Csv</a></p>
			 
			   <p><b>Admin Name : </b>' . $adminname . '</p>
			   <p><b>Admin EmailID : </b>' . $adminemail . '</p>
			 
			   <br>

			   <p>Regards</p>
			   <p>Team Bestie</p>
			 
			   
			   </div>
			   </div>
			   
			   
			   </div>
			   </body>
			</html>
			   ' . "\n\n" .
                        $bound_last;
                /*                 * ************************************************************************************************************************************************************* */

                //$mailres = mail($to1, $subject, $message, $headers);
                //$mailres;

                if (mail($to1, $subject, $message, $headers, '-f ' . $dedicateemail)) {
                    $msg = "data successfully uploaded";
                    $resp['msg'] = $msg;
                    $resp['success'] = 1;
                }
            }
            return json_encode($resp);
        }



        /*         * ********************************file csv start  end ********************************** */
    }
    
    

    function uploadUserCsv($clientid1, $user, $file_name, $file_temp_name, $fullpath, $adminname, $adminemail) {
        $imgpath = SITE_URL;
        $this->fullcsvpath = $fullpath;

        date_default_timezone_set('Asia/Kolkata');
        $c_date = date('Y-m-d H:i:s');
        $status = "Active";
        $access = "User";
        $this->client_id = $clientid1;
        $user_session = $_SESSION['user_email'];
        $this->createdby = $user;
        //  echo "user unique id := ".$this->createdby;
        $this->filename = $file_name;
        $this->filetempname = $file_temp_name;
        $target_file = basename($this->filename);

        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

        if ($imageFileType != "csv") {
            echo "Sorry, only .csv files are allowed.";
            $uploadOk = 0;
        } else {
            $handle = fopen($this->filetempname, "r");
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $userdata[] = $data;
            }

            /*             * ************start insert into database ************************************************* */
            /* echo "<pre>"; print_r($userdata); */
            $countrows = count($userdata);
            if ($countrows > 200) {
                echo "<script>alert(Sorry! You can't upoad data more than 200 employee at a time) </script>";
            }
            // echo $countrows;
            /**             * **************************fetch existing admin details (emaild)************************************* */
            try {
                $max = "select * from Tbl_EmployeeDetails_Master where clientId = '" . $this->client_id . "'";
                $query = $this->DB->prepare($max);
                if ($query->execute()) {
                    $tr = $query->fetch();
                    $ADMINEMAIL = $tr['employeeId'];   //fetch admin email id
                }
            } catch (PDOException $e) {
                echo $e;
                trigger_error('Error occured fetching max autoid : ' . $e->getMessage(), E_USER_ERROR);
            }

            try {
                $query_client = "select * from Tbl_ClientDetails_Master where client_id =:cid7";
                $stmt7 = $this->DB->prepare($query_client);
                $stmt7->bindParam(':cid7', $this->client_id, PDO::PARAM_STR);
                if ($stmt7->execute()) {
                    $row = $stmt7->fetch();
                    $program_name = $row['program_name'];
                    $dedicateemail = $row['dedicated_mail'];
                    $clientid = $row['client_id'];
                    $subdomain_link = $row['subDomainLink'];
                    $package_name = $row['packageName'];
                }
            } catch (PDOException $e) {
                echo $e;
                trigger_error('Error occured fetching max autoid : ' . $e->getMessage(), E_USER_ERROR);
            }

            /*             * *************************************** */

            /*             * ************************ fetching data from B_Client_Data******************************** */


            for ($row = 1; $row < $countrows; $row++) {

                $user_name = ucfirst($userdata[$row][0]) . " " . $userdata[$row][1] . " " . ucfirst($userdata[$row][2]);

                //$randomAlpha = self::randomalpha(4);
                $randomDigit = self::randomdigit(6);

                $randompassword = $randomDigit;
                $md5password1 = md5($randompassword);
                $md5password = "";

                $randomempid = self::randomuuid(30);

                $adminaccess = 'Admin';
                $useremail = $userdata[$row][5];
                //$companyname = $userdata[$row][14];				
                //$comname = self::checkCompany($clientid1,$companyname);
                $companyname = "";
                $comname = "";

                try {
                    $max = "select max(autoId) from Tbl_EmployeeDetails_Master";
                    $query = $this->DB->prepare($max);
                    if ($query->execute()) {
                        $tr = $query->fetch();
                        $m_id = $tr[0];
                        $m_id1 = $m_id + 1;
                        $usid = "User-" . $m_id1;
                    }
                } catch (PDOException $e) {
                    echo $e;
                    trigger_error('Error occured fetching max autoid : ' . $e->getMessage(), E_USER_ERROR);
                }

                try {
                    $qu = "insert into Tbl_EmployeeDetails_Master
(userId,clientId,employeeId,firstName,middleName,lastName,emailId,password,department,location, companyName, companyUniqueId, status, accessibility, createdDate, createdBy) values(:uid,:cid,:eid,:fname,:mname,:lname,:email,:pass,:dep, :loc,:compny, :comid,:sta,:acc,:cred,:creb) ON DUPLICATE KEY UPDATE firstName =:fname,middleName=:mname, lastName=:lname, department=:dep, location=:loc, status=:sta, accessibility=:acc,createdDate=:cred,createdBy=:creb , password =:pass  ";
                    $stmt = $this->DB->prepare($qu);

		    $firstName = ucfirst($userdata[$row][0]);
		    $lastName  = ucfirst($userdata[$row][2]);
		    $emailId   = rtrim($userdata[$row][5]);
		    
                    $stmt->bindParam(':uid', $usid, PDO::PARAM_STR);
                    $stmt->bindParam(':cid', $clientid, PDO::PARAM_STR);
                    $stmt->bindParam(':eid', $randomempid, PDO::PARAM_STR);

                    $stmt->bindParam(':fname', $firstName, PDO::PARAM_STR);
                    $stmt->bindParam(':mname', $userdata[$row][1], PDO::PARAM_STR);
                    $stmt->bindParam(':lname', $lastName, PDO::PARAM_STR);

                    //$stmt->bindParam(':gen', $userdata[$row][3], PDO::PARAM_STR);
                    $stmt->bindParam(':email', $emailId, PDO::PARAM_STR);
                    //$stmt->bindParam(':mob', $userdata[$row][13], PDO::PARAM_STR);
                    $stmt->bindParam(':pass', $md5password1, PDO::PARAM_STR);
                    //$stmt->bindParam(':ecode', $userdata[$row][6], PDO::PARAM_STR);
                    $stmt->bindParam(':dep', $userdata[$row][3], PDO::PARAM_STR);
                    //$stmt->bindParam(':des', $userdata[$row][8], PDO::PARAM_STR);
                    $stmt->bindParam(':loc', $userdata[$row][4], PDO::PARAM_STR);
                    //$stmt->bindParam(':bra', $userdata[$row][11], PDO::PARAM_STR);
                    //$stmt->bindParam(':gra', $userdata[$row][9], PDO::PARAM_STR);
                    $stmt->bindParam(':compny', $companyname, PDO::PARAM_STR);
                    $stmt->bindParam(':comid', $comname, PDO::PARAM_STR);
                    $stmt->bindParam('sta', $status, PDO::PARAM_STR);
                    $stmt->bindParam(':acc', $access, PDO::PARAM_STR);
                    $stmt->bindParam(':cred', $c_date, PDO::PARAM_STR);
                    $stmt->bindParam(':creb', $this->createdby, PDO::PARAM_STR);

                    if ($stmt->execute()) {
                        $query4 = "insert into Tbl_EmployeePersonalDetails(userid, clientId, employeeId, emailId) values(:uid1, :cid1, :eid1, :emailid1) ON DUPLICATE KEY UPDATE clientId=:cid1";
                        $stmt4 = $this->DB->prepare($query4);
                        $stmt4->bindParam(':uid1', $usid, PDO::PARAM_STR);
                        //$stmt4->bindParam(':ecode1', $userdata[$row][6], PDO::PARAM_STR);
                        $stmt4->bindParam(':cid1', $clientid, PDO::PARAM_STR);
                        $stmt4->bindParam(':eid1', $randomempid, PDO::PARAM_STR);
                        $stmt4->bindParam(':emailid1', $userdata[$row][5], PDO::PARAM_STR);
                        //$stmt4->bindParam(':dob', $userdata[$row][4], PDO::PARAM_STR);
                        //$stmt4->bindParam(':doj', $userdata[$row][5], PDO::PARAM_STR);
                        //$stmt4->bindParam(':compname',$companyname, PDO::PARAM_STR);
                        //echo $userdata[$row][4].' '.$userdata[$row][5];
                        if ($stmt4->execute()) {
                            if ($useremail != $ADMINEMAIL) {
                                $SENDTO = $useremail;
                            }
                        }

                        /*                         * ********************* mail  send **************************** */


                        /*                         * ************************** */
                        $portalpath = "http://" . $subdomain_link;
                        $to = $SENDTO;
                        $subject = 'I am your Bestie!!!';
                        
                        // $subject = 'Test Email from Bestie';   // remove soon

                        $bound_text = "----*%$!$%*";
                        $bound = "--" . $bound_text . "\r\n";
                        $bound_last = "--" . $bound_text . "--\r\n";

                        $headers = "From: " . $program_name . " <" . $dedicateemail . "> \r\n" . "Return-Path: " . $dedicateemail . "\r\n";
                        //$headers = "From: ".$program_name." <".$dedicateemail."> \r\n";
                        $headers .= "MIME-Version: 1.0\r\n" .
                                "Content-Type: multipart/mixed; boundary=\"$bound_text\"" . "\r\n";

//                        $message = " Now You Can Login With This Emailid & Password \r\n" .
                        $bound;

//                        $message = 'Content-Type: text/html; charset=UTF-8' . "\r\n" .'Content-Transfer-Encoding: 7bit' . "\r\n\r\n" .

			$message = '<html>

                          <body style=&quot;font-family:"Calibri"; width:600; &quot;>
                          <div style="width: 700;height:500; background: white;">
			  <img src = "'.SITE_URL.'images/mailImg/bestie.png"/>
			
                          <div style="background: window;height: 420;  ">
                          <div style="width: 600; ">
                          <p>Dear ' . ucfirst($userdata[$row][0]) . ',</p>
						  
                          <p >We are delighted to introduce you to your Bestie at Barclays!</p>
						  
			  <p>Bestie will be your Colleague Engagement App, packaged with exciting features.  A fabulous place for you to connect with your colleagues beyond the workplace.</p>
					  
					 
                           <p>Sounds Exciting?  You can quickly get Bestie on to your Personal Phone Mobile (Anroid or iPhone) right now.</p>

                           <p>Please see the attached for instructions on how to install.</p>
						   
                          <table style="width: auto;height: auto;margin-left: 80;" class="table-responsive table-hover">
                          <tr><td style="width: 200px;">
                          Your Login Details:
                          </td>
                          </tr>
                          <tr>
                          <td style="width: 100;">User ID:</td>
                          <td> User ID: ' . $SENDTO . '</td>
                          </tr>
                          <tr>
                          <td style="width: 100;">Password:  </td>
                          <td> Password: ' . $randompassword . '</td>
                          </tr>
                          </table>
                          <p>If you are unable to login or have any queries, please contact me at <a href="mailto:' . $dedicateemail . '?Subject=Query" target="_top">' . $dedicateemail . '</a> or @<font style="color: blue;"> +91 124 421 2827</font>(Mon- Fri) between 9 am and 6 p.m. IST.</p>
					
			  <p> Can’t wait to connect with you… </p>	  
                          
                          <br>

			  <p>' . $program_name . '!</p>

                          </div>
                          </div>


                          </div>
                          </body>
                          </html>';
			
			/*
			$message = '<html>

                          <body>
                          <div style="width: 700;height: 500;background: white;">
                          <div style="width: 700;height: 100;background: white" >
                          </div >

                          <div style="background: window;height: 420;  ">
                          <div style="width: 600; ">
                          <p>Hey ' . ucfirst($userdata[$row][0]) . ',</p>
						  
                          <p >This is a Test Email to check if you are receiving emails from Bestie.</p>
						  
			  <p>For any queries, please contact preethi.priscillakumarai@barclays.com </p>
					  
                          <br>

			  <p>Yours ' . $program_name . '!</p>

                          </div>
                          </div>


                          </div>
                          </body>
                          </html>'; 
			*/
			
                        // ' . "\n\n" .$bound_last;
                        //$sm=mail($to,$subject,$message,$headers, '-f '.$dedicateemail);
                        include_once('Api_Class/class_messageSentTo.php');
                        $objMessageSent = new messageSent();
                        $senderName = "Bestie";
                        $files = array();
                        $files[0] = "../attachment/pdf-sample.pdf";
                        $files[1] = "../attachment/dummy.pdf";
                        $files = array();
                        $sm = $objMessageSent->multi_attach_mail($to, $subject, $message, $dedicateemail, $senderName, $files);

                        /*                         * ************* **************************************************************************
                          if($sm)
                          {
                          $result = 1;
                          }
                          else
                          {
                          $msg = "email not sent and there is some error in emailid ".$SENDTO;
                          $resp['msg'] = $msg;
                          $resp['success'] = 0;


                          }   ************* */
                    }
                } catch (PDOException $ex) {
                    echo $ex;
                }
            }
            $result = 1;
            if ($result == 1) {
                $number = $countrows - 1;

                $path = $this->fullcsvpath;

                $to1 = "support@mybestie.in,sau_org@yahoo.co.in,saurabh.jain@benepik.com";
                /*                 * ************************************************************************************************************************************************************* */
                $subject = 'Administrator has uploaded a CSV File';

                $bound_text = "----*%$!$%*";
                $bound = "--" . $bound_text . "\r\n";
                $bound_last = "--" . $bound_text . "--\r\n";



                $headers = "From: " . $program_name . " <" . $dedicateemail . "> \r\n" . "Return-Path: " . $dedicateemail . "\r\n";
                $headers .= "MIME-Version: 1.0\r\n" .
                        "Content-Type: multipart/mixed; boundary=\"$bound_text\"" . "\r\n";

                $message = " Now You Can Login With This Emailid & Password \r\n" . $bound;

                $message .=

                        'Content-Type: text/html; charset=UTF-8' . "\r\n" .
                        'Content-Transfer-Encoding: 7bit' . "\r\n\r\n" .
                        '

			<html>

			   <body>
			   <div style="width: 700;height: 500;background: white;">
			   <div style="width: 700;height: 100;background: white" >
			   </div >
			   
			   <div style="background: window;height: 420;  ">
			   <div style="width: 600; ">
			   <p>Dear Admin,</p>
			   <p ><b>' . $program_name . ' Administrator has uploaded a CSV File</b></p> 
			   <p><b>' . $number . '</b> Users are listed in CSV</p>
			   <p>Users CSV can be downloaded from here <a href=' . SITE_URL . "/" . $path . '>User Csv</a></p>
			 
			   <p><b>Admin Name : </b>' . $adminname . '</p>
			   <p><b>Admin EmailID : </b>' . $adminemail . '</p>
			 
			   <br>

			   <p>Regards</p>
			   <p>Team Bestie</p>
			 
			   
			   </div>
			   </div>
			   
			   
			   </div>
			   </body>
			</html>
			   ' . "\n\n" .
                        $bound_last;
                /*                 * ************************************************************************************************************************************************************* */

                //$mailres = mail($to1, $subject, $message, $headers);
                //$mailres;

                if (mail($to1, $subject, $message, $headers, '-f ' . $dedicateemail)) {
                    $msg = "data successfully uploaded";
                    $resp['msg'] = $msg;
                    $resp['success'] = 1;
                }
            }
            return json_encode($resp);
        }



        /*         * ********************************file csv start  end ********************************** */
    }

    function createAdmin($empCode, $cid, $uniqId, $access, $createBy) {
        //echo'<pre>';print_r($empCode.'---'.$cid.'---'.$uniqId.'---'.$access.'---'.$createBy);die;
        $this->empCode = $empCode;
        $this->cid = $cid;
        $this->uniId = $uniqId;
        $this->access = $access;
        $this->createBy = $createBy;
        $this->status = 'Active';

        date_default_timezone_set('Asia/Calcutta');
        $c_date = date('Y-m-d H:i:s');

        /*         * ******************************* fetch maxid********************************************* */
        try {
            $max = "select max(autoId) from Tbl_ClientAdminDetails";
            $query = $this->DB->prepare($max);
            if ($query->execute()) {
                $tr = $query->fetch();
                $m_id = $tr[0];
                $m_id1 = $m_id + 1;
                $adminid = "AD-" . $m_id1;
            }
        } catch (PDOException $e) {
            echo $e;
            trigger_error('Error occured fetching max autoid : ' . $e->getMessage(), E_USER_ERROR);
        }

        try {

            $query = "insert into Tbl_ClientAdminDetails (adminId,clientId,userUniqueId,accessibility,createdDate,createdBy,status) values(:adid,:cid,:uniId,:access,:cDate,:cBy,:status) ON DUPLICATE KEY UPDATE  clientId=:cid, userUniqueId=:uniId, accessibility=:access, createdDate=:cDate , createdBy=:cBy , status:=status";
            $stmt = $this->DB->prepare($query);

            $stmt->bindParam(':cid', $this->cid, PDO::PARAM_STR);
            $stmt->bindParam(':adid', $adminid, PDO::PARAM_STR);
            $stmt->bindParam(':uniId', $this->uniId, PDO::PARAM_STR);
            $stmt->bindParam(':access', $this->access, PDO::PARAM_STR);
            $stmt->bindParam(':cDate', $c_date, PDO::PARAM_STR);
            $stmt->bindParam(':cBy', $this->createBy, PDO::PARAM_STR);
            $stmt->bindParam(':status', $this->status, PDO::PARAM_STR);

            if ($stmt->execute()) {

                $query1 = "update Tbl_EmployeeDetails_Master set accessibility=:access where employeeId=:uniId and employeeCode=:empCode";
                $stmt1 = $this->DB->prepare($query1);
                $stmt1->bindParam(':uniId', $this->uniId, PDO::PARAM_STR);
                $stmt1->bindParam(':empCode', $this->empCode, PDO::PARAM_STR);
                $stmt1->bindParam(':access', $this->access, PDO::PARAM_STR);

                if ($stmt1->execute()) {
                    $response = array();
                    $response["success"] = 1;
                    $response["message"] = "Admin created successfully";
                }
            }
        } catch (PDOException $ex) {
            echo $ex;
        }

        return $response;
    }

    function userForm($clientid1, $user, $fname, $mname, $lname, $email_id, $department, $location, $adminname, $adminemail) {

// function userForm($clientid1, $user, $fname, $mname, $lname, $emp_code, $dob,$doj, $email_id, $designation, $department, $contact, $location, $branch, $grade, $gender,$companyname,$companycode,$adminname,$adminemail) {

        $imgpath = SITE_URL;
        //echo $imgpath.'images/smily/smily1.png';

        $this->first_name = ucfirst($fname);
        $this->middle_name = $mname;
        $this->last_name = ucfirst($lname);
        $this->mail1 = rtrim($email_id);
        $this->depart = $department;
        $this->locs = $location;

        //$this->mobile = $contact;
        //$this->brnch = $branch;
        //$this->grad = $grade;
        //$this->gend = $gender;
        //$this->empCode = $companycode.$emp_code;
        //$this->dobirth = $dob;
        //$this->desig = $designation;

        date_default_timezone_set('Asia/Kolkata');
        $c_date = date('Y-m-d H:i:s');

        //$randomAlpha = self::randomalpha(4);
        $randomDigit = self::randomdigit(6);
        //$comname = self::checkCompany($clientid1,$companyname);
        $randompassword = $randomDigit;

        $md5password1 = md5($randompassword);
        $md5password = "";

        $randomempid = self::randomuuid(30);

        $status = "Active";
        $access = "User";
        $this->createdby = $user;
        $this->client_id = $clientid1;



        try {
            $query_client = "select * from Tbl_ClientDetails_Master where client_id =:cid7";
            $stmt7 = $this->DB->prepare($query_client);
            $stmt7->bindParam(':cid7', $this->client_id, PDO::PARAM_STR);
            if ($stmt7->execute()) {
                $row = $stmt7->fetch();
                $program_name = $row['program_name'];
                $dedicateemail = $row['dedicated_mail'];
                $clientid = $row['client_id'];
                $subdomain_link = $row['subDomainLink'];
                $package_name = $row['packageName'];
            }
        } catch (PDOException $e) {
            echo $e;
            trigger_error('Error occured fetching max autoid : ' . $e->getMessage(), E_USER_ERROR);
        }

        /*         * ******************************* fetch maxid********************************************* */
        try {

            $max = "select max(autoId) from Tbl_EmployeeDetails_Master";
            $query = $this->DB->prepare($max);
            if ($query->execute()) {
                $tr = $query->fetch();
                $m_id = $tr[0];
                $m_id1 = $m_id + 1;
                $usid = "User-" . $m_id1;
            }
        } catch (PDOException $e) {
            echo $e;
            trigger_error('Error occured fetching max autoid : ' . $e->getMessage(), E_USER_ERROR);
        }

        $companyname = "";
        $comname = "";

        try {
            $qu = "insert into Tbl_EmployeeDetails_Master
	(userId, clientId, employeeId, firstName, middleName, lastName, emailId, password, department, location, companyName, companyUniqueId, status, accessibility, createdDate, createdBy) values(:uid, :cid, :eid, :fname, :mname, :lname, :email, :pass, :dep, :loc, :companyname, :companyid, :sta, :acc, :cred, :creb) ON DUPLICATE KEY UPDATE firstName =:fname,middleName=:mname, lastName=:lname,department=:dep,location=:loc,accessibility=:acc,createdDate=:cred,createdBy=:creb , password =:pass ";

            $stmt = $this->DB->prepare($qu);
            $stmt->bindParam(':uid', $usid, PDO::PARAM_STR);
            $stmt->bindParam(':cid', $clientid, PDO::PARAM_STR);
            $stmt->bindParam(':eid', $randomempid, PDO::PARAM_STR);
            $stmt->bindParam(':fname', $this->first_name, PDO::PARAM_STR);
            $stmt->bindParam(':mname', $this->middle_name, PDO::PARAM_STR);
            $stmt->bindParam(':lname', $this->last_name, PDO::PARAM_STR);
            $stmt->bindParam(':email', $this->mail1, PDO::PARAM_STR);
            $stmt->bindParam(':pass', $md5password1, PDO::PARAM_STR);
            $stmt->bindParam(':dep', $this->depart, PDO::PARAM_STR);
            $stmt->bindParam(':loc', $this->locs, PDO::PARAM_STR);
            $stmt->bindParam('sta', $status, PDO::PARAM_STR);
            $stmt->bindParam(':acc', $access, PDO::PARAM_STR);
            $stmt->bindParam(':cred', $c_date, PDO::PARAM_STR);
            $stmt->bindParam(':creb', $this->createdby, PDO::PARAM_STR);
            $stmt->bindParam(':companyname', $companyname, PDO::PARAM_STR);
            $stmt->bindParam(':companyid', $comname, PDO::PARAM_STR);
            //$stmt->bindParam(':gen', $this->gend, PDO::PARAM_STR);
            //$stmt->bindParam(':ecode', $this->empCode, PDO::PARAM_STR);
            //$stmt->bindParam(':con', $this->mobile, PDO::PARAM_STR);
            //$stmt->bindParam(':des', $this->desig, PDO::PARAM_STR);
            //$stmt->bindParam(':bra', $this->brnch, PDO::PARAM_STR);
            //$stmt->bindParam(':gra', $this->grad, PDO::PARAM_STR);


            if ($stmt->execute()) {

                $query4 = "insert into Tbl_EmployeePersonalDetails(userid,clientId,employeeId,emailId)
				values(:uid1,:cid1,:eid1,:emailid1) ON DUPLICATE KEY UPDATE clientId =:cid1";
                $stmt4 = $this->DB->prepare($query4);
                $stmt4->bindParam(':uid1', $usid, PDO::PARAM_STR);
                $stmt4->bindParam(':cid1', $clientid, PDO::PARAM_STR);
                //$stmt4->bindParam(':ecode1', $this->empCode, PDO::PARAM_STR);
                $stmt4->bindParam(':eid1', $randomempid, PDO::PARAM_STR);
                $stmt4->bindParam(':emailid1', $this->mail1, PDO::PARAM_STR);
                //$stmt4->bindParam(':dob', $this->dobirth, PDO::PARAM_STR);
                //$stmt4->bindParam(':doj', $doj, PDO::PARAM_STR);
                //$stmt4->bindParam(':compname', $companyname, PDO::PARAM_STR);
                if ($stmt4->execute()) {
                    $user_name = $this->first_name;
                    $SENDTO = $this->mail1;

                    /*                     * **********************************************  mail  send ****************************************** */
                    /*                     * ************ */

                    $portalpath = "http://" . $subdomain_link;

                    $to = $SENDTO;
                    //$to = "monikagupta05051994@gmail.com";
                    $subject = 'I am your Bestie!!!';

                    $bound_text = "----*%$!$%*";
                    $bound = "--" . $bound_text . "\r\n";
                    $bound_last = "--" . $bound_text . "--\r\n";

                    $headers = "From: " . $program_name . " <" . $dedicateemail . "> \r\n" . "Return-Path: " . $dedicateemail . "\r\n";
                    $headers .= "MIME-Version: 1.0\r\n" .
                            "Content-Type: multipart/mixed; boundary=\"$bound_text\"" . "\r\n";

                    //$message = " Now You Can Login With This Emailid & Password \r\n".
                    $bound;

                    // $message = 'Content-Type: text/html; charset=UTF-8'."\r\n".  'Content-Transfer-Encoding: 7bit'."\r\n\r\n".

	     	    /*
                    $message = '<html>

                      <body>
                      <div style="width: 700;height: 500;background: white;">
                      <div style="width: 700;height: 100;background: white" >
                      </div >

                      <div style="background: window;height: 420;  ">
                      <div style="width: 600; ">
                      <p>Hey ' . ucfirst($user_name) . ',</p>
                      <p >I am going to be your Bestie at Barclays.</p>
					  
		      <p>Please install the Bestie App (Test Version) as follows: </p>
				  
					  
                      <p>Go to <a href="https://iphone.benepik.com/bestie"> mybestie.in</a> on your phone’s browser (Android or iPhone) and click Install/ Get.</p>
					  
		      <p><b>Android Users</b>: After file download, your phone may ask for permission to install the app from unknown sources. Go to phone settings ->security -> unknown sources -> enable.</p>
                      
<p><b>iPhone Users</b>: After installation, please trust the developer as follows: Settings -> General -> Device Management -> Trust Benepik.</p>
                      
                      <table style="width: auto;height: auto;margin-left: 80;" class="table-responsive table-hover">
                      <tr><td style="width: 200px;">
                      Your Login Details:
                      </td>
                      </tr>
                      <tr>
                      <td style="width: 100;">User ID: </td>
                      <td>' . $SENDTO . '</td>
                      </tr>
                      <tr>
                      <td style="width: 100;">Password: </td>
                      <td> ' . $randompassword . '</td>
                      </tr>
                      </table>
                      <p>If you are unable to login or have any queries, please contact me at <a href="mailto:' . $dedicateemail . '?Subject=Query" target="_top">' . $dedicateemail . '</a> or @<font style="color: blue;"> +91 124 421 2827</font>(Mon- Fri).</p>
                      <br>

                      <p>Yours ' . $program_name . '!</p>

                      </div>
                      </div>


                      </div>
                      </body>
                      </html>';
                      */
			
		      $message = '<html>

                          <body style=&quot;font-family:"Calibri"; width:600; &quot;>
                          <div style="width: 700;height:500; background: white;">
			  <img src = "'.SITE_URL.'images/mailImg/bestie.png" />
			
                          <div style="background: window;height: 420;  ">
                          <div style="width: 600; ">
                          <p>Dear ' . ucfirst($user_name) . ',</p>
						  
                          <p >We are delighted to introduce you to your Bestie at Barclays!</p>
						  
			  <p>Bestie will be your Colleague Engagement App, packaged with exciting features.  A fabulous place for you to connect with your colleagues beyond the workplace.</p>
					  
					 
                           <p>Sounds Exciting?  You can quickly get Bestie on to your Personal Phone Mobile (Anroid or iPhone) right now.</p>

                           <p>Please see the attached for instructions on how to install.</p>
						   
                          <table style="width: auto;height: auto;margin-left: 80;" class="table-responsive table-hover">
                          <tr><td style="width: 200px;">
                          Your Login Details:
                          </td>
                          </tr>
                          <tr>
                          <td style="width: 100;">User ID:</td>
                          <td> User ID: ' . $SENDTO . '</td>
                          </tr>
                          <tr>
                          <td style="width: 100;">Password:  </td>
                          <td> Password: ' . $randompassword . '</td>
                          </tr>
                          </table>
                          <p>If you are unable to login or have any queries, please contact me at <a href="mailto:' . $dedicateemail . '?Subject=Query" target="_top">' . $dedicateemail . '</a> or @<font style="color: blue;"> +91 124 421 2827</font>(Mon- Fri) between 9 am and 6 p.m. IST.</p>
					
			  <p> Can’t wait to connect with you… </p>	  
                          
                          <br>

			  <p>' . $program_name . '!</p>

                          </div>
                          </div>


                          </div>
                          </body>
                          </html>';
                          


                    //'."\n\n".$bound_last;
                    //mail($to,$subject,$message,$headers, '-f '.$dedicateemail);            
                    include_once('Api_Class/class_messageSentTo.php');
                    $objMessageSent = new messageSent();
                    $senderName = "Bestie";
                    $files = array();
                    $files[0] = "../attachment/pdf-sample.pdf";
                    $files[1] = "../attachment/dummy.pdf";
                    $files = array();
                    $objMessageSent->multi_attach_mail($to, $subject, $message, $dedicateemail, $senderName, $files);
                    /*                     * ************************************ */

                    $to = "support@mybestie.in,sau_org@yahoo.co.in,saurabh.jain@benepik.com";
                    //$to = "monikagupta05051994@gmail.com";

                    /**                     * ******************************************************************************************************************************************************************* */
                    /*                     * ************************************************************************************************************************************************************* */
                    $subject = 'Administrator added new User';

                    $bound_text = "----*%$!$%*";
                    $bound = "--" . $bound_text . "\r\n";
                    $bound_last = "--" . $bound_text . "--\r\n";

                    $headers = "From: " . $program_name . " <" . $dedicateemail . "> \r\n" . "Return-Path: " . $dedicateemail . "\r\n";
                    $headers .= "MIME-Version: 1.0\r\n" .
                            "Content-Type: multipart/mixed; boundary=\"$bound_text\"" . "\r\n";

                    $message = " Now You Can Login With This Emailid & Password \r\n" .
                            $bound;

                    $message .=

                            'Content-Type: text/html; charset=UTF-8' . "\r\n" .
                            'Content-Transfer-Encoding: 7bit' . "\r\n\r\n" .
                            '
			   <html>

			   <body>
			   <div style="width: 700;height: 200;background: white;">
			   <div style="width: 700;height: 100;background: white" >
			   </div >
			   
			   <div style="background: window;height: 120;  ">
			   <div style="width: 600; ">
			   <p>Dear Admin,</p>
			   <p ><b>' . $program_name . ' Administrator added new User</b></p> 
			   <p>Details are as follows</p>
			   <p>Employee Name : ' . $this->first_name . ' ' . $this->last_name . '</p>
			    <p>Email Id : ' . $this->mail1 . '</p>
			  
			 <br>
			   <p><b>Admin Name : </b>' . $adminname . '</p>
			   <p><b>Admin EmailID : </b>' . $adminemail . '</p>
			   <br>

			   <p>Regards</p>
			    <p>Team Bestie</p>
			 
			   
			   </div>
			   </div>
			   
			   
			   </div>
			   </body>
			   </html>
			   ' . "\n\n" .
                            $bound_last;



                    /*                     * ********************************************************************************* */

                    mail($to, $subject, $message, $headers, '-f ' . $dedicateemail);

                    echo "<script>alert('User Added Successfully')</script>";
                    echo "<script>window.location='../add_user.php'</script>";
                }
            }
        } catch (PDOException $ex) {
            echo $ex;
        }
    }

    /*     * *************************************** user guest detail **************************************** */

    function guestUserForm($clientid1, $user, $fname, $mname, $lname, $emp_code, $dob, $father, $email_id, $designation, $department, $contact, $location, $branch, $grade, $gender, $companyname) {
        $this->first_name = ucfirst($fname);
        $this->middle_name = $mname;
        $this->last_name = ucfirst($lname);
        $this->empCode = $emp_code;
        $this->dobirth = $dob;
        $this->mail1 = $email_id;
        $this->desig = $designation;
        $this->depart = $department;
        $this->mobile = $contact;
        $this->locs = $location;
        $this->brnch = $branch;
        $this->grad = $grade;
        $this->gend = $gender;
        $this->companyname = $companyname;


        date_default_timezone_set('Asia/Kolkata');
        $c_date = date('Y-m-d H:i:s');

        //$randomAlpha = self::randomalpha(4);
        $randomDigit = self::randomdigit(6);
        $comname = self::checkCompany($clientid1, $companyname);
        $randompassword = $randomDigit;

        $md5password1 = md5($randompassword);
        $md5password = "";

        $randomempid = self::randomuuid(30);

        $status = "Active";
        $access = "guestuser";
        $this->createdby = $user;
        $this->client_id = $clientid1;

        try {
            $query_client = "select * from Tbl_ClientDetails_Master where client_id =:cid7";
            $stmt7 = $this->DB->prepare($query_client);
            $stmt7->bindParam(':cid7', $this->client_id, PDO::PARAM_STR);
            if ($stmt7->execute()) {
                $row = $stmt7->fetch();
                $program_name = $row['program_name'];
                $dedicateemail = $row['dedicated_mail'];
                $clientid = $row['client_id'];
                $subdomain_link = $row['subDomainLink'];
                $package_name = $row['packageName'];
            }
        } catch (PDOException $e) {
            echo $e;
            trigger_error('Error occured fetching max autoid : ' . $e->getMessage(), E_USER_ERROR);
        }

        /*         * ******************************* fetch maxid********************************************* */
        try {

            $max = "select max(autoId) from Tbl_EmployeeDetails_Master";
            $query = $this->DB->prepare($max);
            if ($query->execute()) {
                $tr = $query->fetch();
                $m_id = $tr[0];
                $m_id1 = $m_id + 1;
                $usid = "Guest-" . $m_id1;
            }
        } catch (PDOException $e) {
            echo $e;
            trigger_error('Error occured fetching max autoid : ' . $e->getMessage(), E_USER_ERROR);
        }

        try {
            $qu = "insert into Tbl_EmployeeDetails_Master
	(userId,clientId,employeeId,firstName,middleName,lastName,gender,emailId,password,employeeCode,contact,department,designation,location,branch,grade,status,accessibility,createdDate,createdBy) values(:uid,:cid,:eid,:fname,:mname,:lname,:gen,:email,:pass,:ecode,:con,:dep,:des, :loc,:bra,:gra,:sta,:acc,:cred,:creb) ON DUPLICATE KEY UPDATE firstName =:fname,middleName=:mname, lastName=:lname,gender=:gen, emailId=:email, contact=:con,department=:dep,designation=:des,location=:loc,branch=:bra,grade=:gra, accessibility=:acc,createdDate=:cred,createdBy=:creb";

            $stmt = $this->DB->prepare($qu);

            $stmt->bindParam(':uid', $usid, PDO::PARAM_STR);
            $stmt->bindParam(':cid', $clientid, PDO::PARAM_STR);
            $stmt->bindParam(':eid', $randomempid, PDO::PARAM_STR);

            $stmt->bindParam(':fname', $this->first_name, PDO::PARAM_STR);
            $stmt->bindParam(':mname', $this->middle_name, PDO::PARAM_STR);
            $stmt->bindParam(':lname', $this->last_name, PDO::PARAM_STR);

            $stmt->bindParam(':gen', $this->gend, PDO::PARAM_STR);
            $stmt->bindParam(':email', $this->mail1, PDO::PARAM_STR);
            $stmt->bindParam(':pass', $md5password, PDO::PARAM_STR);
            $stmt->bindParam(':ecode', $this->empCode, PDO::PARAM_STR);
            $stmt->bindParam(':con', $this->mobile, PDO::PARAM_STR);
            $stmt->bindParam(':dep', $this->depart, PDO::PARAM_STR);
            $stmt->bindParam(':des', $this->desig, PDO::PARAM_STR);
            $stmt->bindParam(':loc', $this->locs, PDO::PARAM_STR);
            $stmt->bindParam(':bra', $this->brnch, PDO::PARAM_STR);
            $stmt->bindParam(':gra', $this->grad, PDO::PARAM_STR);
            $stmt->bindParam('sta', $status, PDO::PARAM_STR);
            $stmt->bindParam(':acc', $access, PDO::PARAM_STR);
            $stmt->bindParam(':cred', $c_date, PDO::PARAM_STR);
            $stmt->bindParam(':creb', $this->createdby, PDO::PARAM_STR);
            if ($stmt->execute()) {

                $query4 = "insert into Tbl_EmployeePersonalDetails(userid,clientId,employeeCode,employeeId,emailId,userDOB,userFatherName,	userCompanyname)
				values(:uid1,:cid1,:ecode1,:eid1,:emailid1,:dob,:father,:compname) ON DUPLICATE KEY UPDATE userDOB=:dob,userFatherName=:father,emailId=:emailid1,userCompanyname=:compname";
                $stmt4 = $this->DB->prepare($query4);
                $stmt4->bindParam(':uid1', $usid, PDO::PARAM_STR);
                $stmt4->bindParam(':cid1', $clientid, PDO::PARAM_STR);
                $stmt4->bindParam(':ecode1', $this->empCode, PDO::PARAM_STR);
                $stmt4->bindParam(':eid1', $randomempid, PDO::PARAM_STR);
                $stmt4->bindParam(':emailid1', $this->mail1, PDO::PARAM_STR);
                $stmt4->bindParam(':dob', $this->dobirth, PDO::PARAM_STR);
                $stmt4->bindParam(':father', $father, PDO::PARAM_STR);
                $stmt4->bindParam(':compname', $comname, PDO::PARAM_STR);

                if ($stmt4->execute()) {
                    $user_name = $this->first_name . " " . $this->middle_name . " " . $this->last_name;
                    $SENDTO = $this->mail1;

                    /*                     * **********************************************  mail  send ****************************************** */
                    /*                     * **************
                      $portalpath = "http://".$subdomain_link;

                      $to = $SENDTO;
                      $subject = 'Login Credentials for '.$program_name;

                      $bound_text = "----*%$!$%*";
                      $bound = "--".$bound_text."\r\n";
                      $bound_last = "--".$bound_text."--\r\n";

                      $headers = "From: ".$program_name." <".$dedicateemail."> \r\n";
                      $headers .= "MIME-Version: 1.0\r\n" .
                      "Content-Type: multipart/mixed; boundary=\"$bound_text\""."\r\n" ;

                      $message = " Now You Can Login With This Emailid & Password \r\n".
                      $bound;

                      $message .=

                      'Content-Type: text/html; charset=UTF-8'."\r\n".
                      'Content-Transfer-Encoding: 7bit'."\r\n\r\n".
                      '


                      <html>

                      <body>
                      <div style="width: 700;height: 500;background: white;">
                      <div style="width: 700;height: 100;background: white" >
                      </div >

                      <div style="background: window;height: 420;  ">
                      <div style="width: 600; ">
                      <p>Dear '.ucfirst($user_name).',</p>
                      <p ><b>'.$program_name.' is here!</b></p>
                      <p>For login, please visit <a href="'.$portalpath.'">'.$subdomain_link.'</a>.
                      Please also download '.$program_name.'
                      Mobile App on your phone:
                      <a href="https://play.google.com/store/apps/details'.$package_name.'">Android</a>.</p>
                      </p>

                      <p>Login only takes a second and you will have instant access to great savings and deals.</p>
                      <p></p>


                      <table style="width: auto;height: auto;margin-left: 80;" class="table-responsive table-hover">
                      <tr><td style="width: 200px;">
                      Your Login Details:
                      </td>
                      </tr>
                      <tr>
                      <td style="width: 100;">User ID:</td>
                      <td>'.$SENDTO.'</td>
                      </tr>
                      <tr>
                      <td style="width: 100;">Password:  </td>
                      <td> '.$randompassword.'</td>
                      </tr>
                      </table>
                      <p>If you are unable to login or have any queries, please write to <a href="mailto:'.$dedicateemail.'?Subject=Query" target="_top">'.$dedicateemail.'</a> or <br> contact customer service @<font style="color: blue;">+91 124 -421-2827</font>(Mon- Fri).</p>
                      <br>

                      <p>Happy Savings!</p>

                      <p>Team '.$program_name.'</p>

                      </div>
                      </div>


                      </div>
                      </body>
                      </html>

                      '."\n\n".
                      $bound_last;
                      mail($to,$subject,$message,$headers);               ********************** */


                    $to = "sau_org@yahoo.co.in,saurabh.jain@benepik.com";
                    // $to = "monikagupta05051994@gmail.com";


                    /**                     * ******************************************************************************************************************************************************************* */
                    /*                     * ************************************************************************************************************************************************************* */
                    $subject = 'Administrator added new Guest User';

                    $bound_text = "----*%$!$%*";
                    $bound = "--" . $bound_text . "\r\n";
                    $bound_last = "--" . $bound_text . "--\r\n";

                    $headers = "From: " . $program_name . " <" . $dedicateemail . "> \r\n";
                    $headers .= "MIME-Version: 1.0\r\n" .
                            "Content-Type: multipart/mixed; boundary=\"$bound_text\"" . "\r\n";

                    $message = " Now You Can Login With This Emailid & Password \r\n" .
                            $bound;

                    $message .=

                            'Content-Type: text/html; charset=UTF-8' . "\r\n" .
                            'Content-Transfer-Encoding: 7bit' . "\r\n\r\n" .
                            '

   <html>

   <body>
   <div style="width: 700;height: 200;background: white;">
   <div style="width: 700;height: 100;background: white" >
   </div >
   
   <div style="background: window;height: 120;  ">
   <div style="width: 600; ">
   <p>Dear Admin,</p>
   <p ><b>' . $program_name . ' Administrator added new Guest User</b></p> 
   <p>Details are as follows</p>
   <p>Employee Code : ' . $this->empCode . '</p>
   <p>Employee Name : ' . $this->first_name . ' ' . $this->last_name . '</p>
    <p>Email Id : ' . $this->mail1 . '</p>
  
 
   <p></p>
 
   <br>

   <p>Regards</p>
    <p>Team Vikas Group Connect</p>
 
   
   </div>
   </div>
   
   
   </div>
   </body>
   </html>
   ' . "\n\n" .
                            $bound_last;



                    /*                     * ********************************************************************************* */

                    mail($to, $subject, $message, $headers);

                    echo "<script>alert('Data inserted successfully')</script>";
                    echo "<script>window.location='../add_guestuser.php'</script>";
                }
            }
        } catch (PDOException $ex) {
            echo $ex;
        }
    }

    /*     * ***************************************** end guest user detail ************************************ */

    /*     * **************************************** add guest user throught csv ********************************* */

    function uploadGuestUserCsv($clientid1, $user, $file_name, $file_temp_name, $fullpath) {

        $this->fullcsvpath = $fullpath;

        date_default_timezone_set('Asia/Calcutta');
        $c_date = date('Y-m-d H:i:s');
        $status = "Active";
        $access = "guestuser";
        $this->client_id = $clientid1;
        $user_session = $_SESSION['user_email'];
        $this->createdby = $user;
        //  echo "user unique id := ".$this->createdby;
        $this->filename = $file_name;
        $this->filetempname = $file_temp_name;
        $target_file = basename($this->filename);

        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

        if ($imageFileType != "csv") {
            echo "Sorry, only .csv files are allowed.";
            $uploadOk = 0;
        } else {
            $handle = fopen($this->filetempname, "r");
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $userdata[] = $data;
            }

            /*             * ************start insert into database ************************************************* */

            // print_r($userdata);
            $countrows = count($userdata);
            if ($countrows > 200) {
                echo "<script>alert(Sorry! You can't upoad data more than 200 employee at a time) </script>";
            }
            // echo $countrows;
            /**             * **************************fetch existing admin details (emaild)************************************* */
            try {
                $max = "select * from Tbl_EmployeeDetails_Master where clientId = '" . $this->client_id . "'";
                $query = $this->DB->prepare($max);
                if ($query->execute()) {
                    $tr = $query->fetch();
                    $ADMINEMAIL = $tr['employeeId'];   //fetch admin email id
                }
            } catch (PDOException $e) {
                echo $e;
                trigger_error('Error occured fetching max autoid : ' . $e->getMessage(), E_USER_ERROR);
            }

            try {
                $query_client = "select * from Tbl_ClientDetails_Master where client_id =:cid7";
                $stmt7 = $this->DB->prepare($query_client);
                $stmt7->bindParam(':cid7', $this->client_id, PDO::PARAM_STR);
                if ($stmt7->execute()) {
                    $row = $stmt7->fetch();
                    $program_name = $row['program_name'];
                    $dedicateemail = $row['dedicated_mail'];
                    $clientid = $row['client_id'];
                    $subdomain_link = $row['subDomainLink'];
                    $package_name = $row['packageName'];
                }
            } catch (PDOException $e) {
                echo $e;
                trigger_error('Error occured fetching max autoid : ' . $e->getMessage(), E_USER_ERROR);
            }

            /*             * *************************************** */

            /*             * ************************ fetching data from B_Client_Data******************************** */


            for ($row = 1; $row < $countrows; $row++) {

                $user_name = ucfirst($userdata[$row][0]);

                //$randomAlpha = self::randomalpha(4);
                $randomDigit = self::randomdigit(6);

                $randompassword = $randomDigit;
                //   $md5password1 = md5($randompassword);
                $md5password = md5($userdata[$row][3]);

                $randomempid = self::randomuuid(30);

                $useremail = $userdata[$row][12];
                $companyname = $userdata[$row][1];
                $comname = self::checkCompany($clientid1, $companyname);
                try {
                    $max = "select max(autoId) from Tbl_EmployeeDetails_Master";
                    $query = $this->DB->prepare($max);
                    if ($query->execute()) {
                        $tr = $query->fetch();
                        $m_id = $tr[0];
                        $m_id1 = $m_id + 1;
                        $usid = "Guest-" . $m_id1;
                    }
                } catch (PDOException $e) {
                    echo $e;
                    trigger_error('Error occured fetching max autoid : ' . $e->getMessage(), E_USER_ERROR);
                }

                try {
                    $qu = "insert into Tbl_EmployeeDetails_Master
(userId,clientId,employeeId,firstName,password,employeeCode,companyName,companyUniqueId,status,accessibility,createdDate,createdBy)values(:uid,:cid,:eid,:fname,:pass,:ecode,:company,:compid,:sta,:acc,:cred,:creb) ON DUPLICATE KEY UPDATE firstName =:fname,status=:sta, accessibility=:acc,companyUniqueId=:compid,companyName=:company,createdDate=:cred,createdBy=:creb";
                    $stmt = $this->DB->prepare($qu);

                    $stmt->bindParam(':uid', $usid, PDO::PARAM_STR);
                    $stmt->bindParam(':cid', $clientid, PDO::PARAM_STR);
                    $stmt->bindParam(':eid', $randomempid, PDO::PARAM_STR);

                    $stmt->bindParam(':fname', ucfirst($userdata[$row][0]), PDO::PARAM_STR);

                    $stmt->bindParam(':pass', $md5password, PDO::PARAM_STR);
                    $stmt->bindParam(':ecode', $userdata[$row][2], PDO::PARAM_STR);
                    $stmt->bindParam(':company', $companyname, PDO::PARAM_STR);
                    $stmt->bindParam(':compid', $comname, PDO::PARAM_STR);
                    $stmt->bindParam('sta', $status, PDO::PARAM_STR);
                    $stmt->bindParam(':acc', $access, PDO::PARAM_STR);
                    $stmt->bindParam(':cred', $c_date, PDO::PARAM_STR);
                    $stmt->bindParam(':creb', $this->createdby, PDO::PARAM_STR);

                    if ($stmt->execute()) {

                        $query4 = "insert into Tbl_EmployeePersonalDetails(userid,clientId,employeeCode,employeeId,Companyname)
	                                         values(:uid1,:cid1,:ecode1,:eid1,:compname)
	      ON DUPLICATE KEY UPDATE Companyname=:compname";
                        $stmt4 = $this->DB->prepare($query4);
                        $stmt4->bindParam(':uid1', $usid, PDO::PARAM_STR);
                        $stmt4->bindParam(':ecode1', $userdata[$row][2], PDO::PARAM_STR);
                        $stmt4->bindParam(':cid1', $clientid, PDO::PARAM_STR);
                        $stmt4->bindParam(':eid1', $randomempid, PDO::PARAM_STR);

                        $stmt4->bindParam(':compname', $companyname, PDO::PARAM_STR);
                        //echo $userdata[$row][4].' '.$userdata[$row][5];
                        if ($stmt4->execute()) {
                            if ($useremail != $ADMINEMAIL) {
                                $SENDTO = $useremail;
                            }
                        }

                        /*                         * *****************************  mail  send****************************************** */

// we comment this code because password not send during uploading csv
                        /*                         * ***************************
                          $portalpath = "http://".$subdomain_link;

                          $to = $SENDTO;
                          $subject = 'Login Credentials for '.$program_name;

                          $bound_text = "----*%$!$%*";
                          $bound = "--".$bound_text."\r\n";
                          $bound_last = "--".$bound_text."--\r\n";

                          $headers = "From: ".$program_name." <".$dedicateemail."> \r\n";
                          $headers .= "MIME-Version: 1.0\r\n" .
                          "Content-Type: multipart/mixed; boundary=\"$bound_text\""."\r\n" ;

                          $message = " Now You Can Login With This Emailid & Password \r\n".
                          $bound;

                          $message .=

                          'Content-Type: text/html; charset=UTF-8'."\r\n".
                          'Content-Transfer-Encoding: 7bit'."\r\n\r\n".
                          '


                          <html>

                          <body>
                          <div style="width: 700;height: 500;background: white;">
                          <div style="width: 700;height: 100;background: white" >
                          </div >

                          <div style="background: window;height: 420;  ">
                          <div style="width: 600; ">
                          <p>Dear '.ucfirst($user_name).',</p>
                          <p ><b>'.$program_name.' is here!</b></p>
                          <p>For login, please visit <a href="'.$portalpath.'">'.$subdomain_link.'</a>.
                          Please also download '.$program_name.'
                          Mobile App on your phone:
                          <a href="https://play.google.com/store/apps/details'.$package_name.'">Android</a>.</p>
                          </p>

                          <p>Login only takes a second and you will have instant access to great savings and deals.</p>
                          <p></p>


                          <table style="width: auto;height: auto;margin-left: 80;" class="table-responsive table-hover">
                          <tr><td style="width: 200px;">
                          Your Login Details:
                          </td>
                          </tr>
                          <tr>
                          <td style="width: 100;">User ID:</td>
                          <td>'.$SENDTO.'</td>
                          </tr>
                          <tr>
                          <td style="width: 100;">Password:  </td>
                          <td> '.$randompassword.'</td>
                          </tr>
                          </table>
                          <p>If you are unable to login or have any queries, please write to <a href="mailto:'.$dedicateemail.'?Subject=Query" target="_top">'.$dedicateemail.'</a> or <br> contact customer service @<font style="color: blue;">+91 124 -421-2827</font>(Mon- Fri).</p>
                          <br>

                          <p>Happy Savings!</p>

                          <p>Team '.$program_name.'</p>

                          </div>
                          </div>


                          </div>
                          </body>
                          </html>

                          '."\n\n".
                          $bound_last;
                          $sm=mail($to,$subject,$message,$headers);

                         * ************ */

                        /*                         * **************************************************************************
                          if($sm)
                          {
                          $result = 1;
                          }
                          else
                          {
                          $msg = "email not sent and there is some error in emailid ".$SENDTO;
                          $resp['msg'] = $msg;
                          $resp['success'] = 0;


                          }   ************* */
                    }
                } catch (PDOException $ex) {
                    echo $ex;
                }
            }
            $result = 1;
            if ($result == 1) {
                $number = $countrows - 1;

                $path = $this->fullcsvpath;

                //   $to1 = "webveeru@gmail.com";
                $to1 = "sau_org@yahoo.co.in,saurabh.jain@benepik.com";
                /*                 * ************************************************************************************************************************************************************* */
                $subject = 'Administrator has uploaded a Guest CSV File';

                $bound_text = "----*%$!$%*";
                $bound = "--" . $bound_text . "\r\n";
                $bound_last = "--" . $bound_text . "--\r\n";

                $headers = "From: " . $program_name . " <" . $dedicateemail . "> \r\n";
                $headers .= "MIME-Version: 1.0\r\n" .
                        "Content-Type: multipart/mixed; boundary=\"$bound_text\"" . "\r\n";

                $message = " Now You Can Login With This Loginid & Password \r\n" .
                        $bound;

                $message .=

                        'Content-Type: text/html; charset=UTF-8' . "\r\n" .
                        'Content-Transfer-Encoding: 7bit' . "\r\n\r\n" .
                        '

   <html>

   <body>
   <div style="width: 700;height: 500;background: white;">
   <div style="width: 700;height: 100;background: white" >
   </div >
   
   <div style="height: 420;  ">
   <div style="width: 600; ">
   <p>Dear Admin,</p>
   <p ><b>' . $program_name . ' Administrator has uploaded a CSV File</b></p> 
   <p><b>' . $number . '</b>Guest Users are listed in CSV</p>
   <p>Users CSV can be downloaded from here <a href=' . SITE_URL . "/" . $path . '>User Csv</a></p>
 
   <p></p>
 
   <br>

   <p>Regards</p>
   <p>Team Vikas Group Connect</p>
 
   
   </div>
   </div>
   
   
   </div>
   </body>
   </html>
   ' . "\n\n" .
                        $bound_last;
                /*                 * ************************************************************************************************************************************************************* */
                if (mail($to1, $subject, $message, $headers)) {
                    $msg = "data successfully uploaded";
                    $resp['msg'] = $msg;
                    $resp['success'] = 1;
                }
            }
            return json_encode($resp);
        }



        /*         * ********************************file csv start  end ********************************** */
    }

    /*     * ***************************** end add guest user throught csv **************************************** */

    function randomalpha($length) {
        $alphabet = "abcdefghjkmnpqrtuwxyz";
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < $length; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    function randomdigit($length) {
        $alphabet = "12346789";
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < $length; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    function randomuuid($length) {
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < $length; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    /*     * ********************************random Password function ********************************** */

    function getUserDetail($clientid, $uuid) {
        try {
            $query = "select tem.*, cm.* from Tbl_EmployeeDetails_Master as tem join Tbl_ClientDetails_Master as cm on cm.client_id = tem.clientId where tem.clientId=:cli and tem.employeeId=:empid";
            $stmt = $this->DB->prepare($query);
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

    /*     * ************************** get user *********************** */

    function getUser($clientid, $emailId) {
        try {
            $query = "select * from Tbl_EmployeeDetails_Master where emailId = :emid AND clientId = :cli ";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cli', $clientid, PDO::PARAM_STR);
            $stmt->bindParam(':emid', $emailId, PDO::PARAM_STR);
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

    /*     * **************************** / get user ******************* */

    /*     * ******************************* check company *********************************** */

    function checkCompany($cli, $companyname) {
        $lquery = "select * from Tbl_Client_CompanyDetails where companyName = :cname";
        $lstmt = $this->DB->prepare($lquery);
        $lstmt->bindParam(':cname', $companyname, PDO::PARAM_STR);
        $lstmt->execute();
        $res = $lstmt->fetchAll(PDO::FETCH_ASSOC);
        //print_r($res);
        if (count($res) > 0) {
            $companyuniqueId = $res[0]['companyUniqueId'];
            return $companyuniqueId;
        } else {
            try {
                $max = "select max(companyId) from Tbl_Client_CompanyDetails";
                $query = $this->DB->prepare($max);
                if ($query->execute()) {
                    $tr = $query->fetch();
                    $m_id = $tr[0];
                    $m_id1 = $m_id + 1;
                    $companyuniqueId = "Company-" . $m_id1;
                }
            } catch (PDOException $e) {
                echo $e;
                trigger_error('Error occured fetching max companyid : ' . $e->getMessage(), E_USER_ERROR);
            }

            /*             * ****************************************************************** */

            $locationquery = "insert into Tbl_Client_CompanyDetails(companyUniqueId,clientId,companyName)values(:companyid,:cid,:cname)";
            $locationstmt = $this->DB->prepare($locationquery);
            $locationstmt->bindParam(':companyid', $companyuniqueId, PDO::PARAM_STR);

            $locationstmt->bindParam(':cid', $cli, PDO::PARAM_STR);
            $locationstmt->bindParam(':cname', $companyname, PDO::PARAM_STR);
            $locationstmt->execute();
            return $companyuniqueId;
        }
    }

    /*     * ***************************** end check company ********************************** */
}

?>
