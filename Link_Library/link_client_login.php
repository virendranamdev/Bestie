<?php
require_once('../Class_Library/class_client_login.php');


if (!empty($_POST)) {
    $username = $_POST['username'];
    $pass = $_POST['password'];

    $db = new ClientLogin();

    $result = $db->clientLoginCheck($username, $pass);
    $res = json_decode($result, true);
    if ($res['success'] == '0') {
        echo "<script>alert('Sorry ! you are not authorized user please check ur email id')</script>";
        echo "<script>window.location='../index.php'</script>";
    }

    if ($res['success'] == 'True') {
        echo "<script>window.location='../wall.php'</script>";
    } else {
        $val = base64_encode($res['email']);
        echo "<script>alert('Please check your Password')</script>";
        echo "<script>window.location='../login.php?email=" . $val . "'</script>";
    }
} else {
    ?>


    <form name="form1" method="post" action="">

        <p>email id:
            <label for="textfield"></label>
            <input type="text" name="email" id="textfield">
        </p>

        <p>password:
            <label for="textfield"></label>
            <input type="password" name="password" id="textfield"> 
        </p>

        <p>
            <input type="submit" name="submit" id="button" value="Submit">
        </p>
    </form>

    <?php
}
?>
