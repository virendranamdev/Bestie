<?php
@session_start();
$clientid = $_SESSION['client_id'];
$user = $_SESSION['user_unique_id'];
$adminname = $_SESSION['user_name'];
$adminemail = $_SESSION['user_email'];
//echo "user id-: ".$user;

if (!empty($_POST)) {
/******************************* add user through csv *************************/
    if (isset($_POST['user_csv'])) {
		require_once('../Class_Library/class_user.php');
		$obj = new User();     //class object
		
        $filename = trim(str_replace(" ", "_", $_FILES['user_csv_file']['name']));
        //echo  "user csv file name:-".$filename;
		$upload_file_name = $clientid . "-" . $filename;
        $filtempname = $_FILES['user_csv_file']['tmp_name'];
        $target = "../usersCSVfiles/";
        $target1 = "/usersCSVfiles/";
        $fullcsvpath = $target1 . $upload_file_name;
		//echo $fullcsvpath;
        $result1 = $obj->uploadUserCsv($clientid, $user, $filename, $filtempname, $fullcsvpath,$adminname,$adminemail);
        $result = json_decode($result1, true);
		//print_r($result);
        
		$message = $result['msg'];
        $suc = $result['success'];
		//echo $suc;
        if ($suc == 1) {
            move_uploaded_file($filtempname, $target . $upload_file_name);
            echo "<script>alert('CSV uploaded Successfully')</script>";
            echo "<script>window.location='../add_user.php'</script>";
            //print_r($result);
            //die;
        } else {
            echo "<script>alert('CSV not uploaded')</script>";
            echo "<script>window.location='../add_user.php'</script>";
        }
    }
/******************************* / add user through csv *************************/

/******************************* add user through form *************************/
    if (isset($_POST['user_form'])) {
		require_once('../Class_Library/class_user.php');
		$obj = new User();     //class object
//        echo '<pre>';print_r($_POST);die;
        extract($_POST);
		//print_r($_POST);
		
        //$result = $obj->userForm($clientid, $user, $first_name, $middle_name, $last_name, $emp_code, $dob, $doj, $email_id, $designation, $department, $contact, $location, $branch, $grade, $gender,$companyname,$companycode,$adminname,$adminemail);
		
		$result = $obj->userForm($clientid, $user, $first_name, $middle_name, $last_name, $email_id, $department,$location,$adminname,$adminemail);
		
		    echo "<script>alert('User Added Successfully')</script>";
            echo "<script>window.location='../add_user.php'</script>";
        //print_r($result);
    }
/******************************* / add user through form *************************/

/******************************* update user through form *************************/
	if (isset($_POST['user_form_update'])) 
	{
		
		require_once('../Class_Library/class_user_update.php');

		$objupdateuser = new User();     //class object
		extract($_POST);
		
		$resultupdate = $objupdateuser->userFormUpdate($employeeid,$first_name,$middle_name,$last_name,$department,$location,$clientid,$user,$email_id);
		//print_r($resultupdate);
		$updatearray = json_decode($resultupdate , true);
		if($updatearray['success']== 1)
		{
			echo "<script>alert('User Details updated Successfully')</script>";
            echo "<script>window.location='../update-user.php'</script>";	
		}
		else
		{
			echo "<script>alert('User Details not updated')</script>";
			echo "<script>window.location='../update-user.php'</script>";	
		}
	}
/******************************* / update user through form *************************/
if (isset($_POST['updateusercsv'])) 
{
	require_once('../Class_Library/class_user_update.php');
	$objupdateuser = new User(); 
		$filename = trim(str_replace(" ", "_", $_FILES['user_csv_file_update']['name']));
        $upload_file_name = $clientid . "-update-" . $filename;
        $filtempname = $_FILES['user_csv_file_update']['tmp_name'];
        $target = "../usersCSVfiles/";
        $target1 = "/usersCSVfiles/";
        $fullcsvpath = $target1 . $upload_file_name;
		$updatecsvres = $objupdateuser->updateUserCsv($clientid, $user, $filename, $filtempname, $fullcsvpath);
		$resultcsvupdate = json_decode($updatecsvres, true);
		$suc = $resultcsvupdate['success'];
        if ($suc == 1) 
		{
            move_uploaded_file($filtempname, $target . $upload_file_name);
            echo "<script>alert('CSV Uploaded Successfully')</script>";
            echo "<script>window.location='../update-user.php'</script>";
        } 
		else 
		{
            echo "<script>alert('CSV not Uploaded')</script>";
            echo "<script>window.location='../update-user.php'</script>";
        }	
}
/******************************* / update user through CSV *************************/
/******************************* / update user through CSV *************************/

} else {
    ?>
    <form method="post" action="" enctype="multipart/form-data">
        <p>Channel Id:
            <label for="textfield">upload csv</label>
            <input type="file" name="user_csv_file" id="textfield">
        </p>
        <p>
            <input type="submit" name="user_csv" id="button" value="upload">
        </p>
    </form>
    <br/><br/><br/><br/><br/>
    <hr/>
    single user
    <hr/>
    <!----------------------------------------------------single user--------------------------------------------->

    <form name="form1" method="post" action="">

        <p>First Name:
            <label for="textfield"></label>
            <input type="text" name="first_name" id="textfield">
        </p>

        <p>Middle Name:
            <label for="textfield"></label>
            <input type="text" name="middle_name" id="textfield">
        </p>

        <p>Last Name:
            <label for="textfield"></label>
            <input type="text" name="last_name" id="textfield">

        </p>
        <!--<p>Employee code:
            <label for="textfield"></label>
            <input type="text" name="emp_code" id="textfield">
        </p>
    </p>
    <p>Date of Birth:
        <label for="textfield"></label>
        <input type="date" name="dob" id="textfield">
    </p>

    </p>
    <p>Date of Joining:
        <label for="textfield"></label>
        <input type="date" name="doj" id="textfield">
    </p>-->

    <p>Email id:
        <label for="textfield"></label>
        <input type="text" name="email_id" id="textfield">
    </p>

    <!--<p>designation:
        <label for="textfield"></label>
        <input type="text" name="designation" id="textfield">
    </p>-->

    <p>department:
        <label for="textfield"></label>
        <input type="text" name="department" id="textfield">
    </p>
    <!--<p>Mobile number:
        <label for="textfield"></label>
        <input type="text" name="contact" id="textfield">
    </p>
-->
    <p>location:
        <label for="textfield"></label>
        <input type="text" name="location" id="textfield">
    </p>
<!--
    <p>branch:
        <label for="textfield"></label>
        <input type="text" name="branch" id="textfield">
    </p>
    <p>Grade:
        <label for="textfield"></label>
        <input type="text" name="grade" id="textfield">
    </p>
    <p>Gender:
        <label for="textfield"></label>
        <input type="text" name="gender" id="textfield">
    </p>
-->
    <p>
        <input type="submit" name="user_form" id="button" value="submit">
    </p>
    </form>
    <?php
}
?>