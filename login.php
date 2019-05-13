<?php 
require_once 'config.php';
session_start();
$message = '';
if (isset($_SESSION['user'])) {
    header("location: secured.php");
    die();
}
if ($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST['credentials'])) {
    $username = mysqli_real_escape_string($db,$_POST['credentials'][0]);
    $password = mysqli_real_escape_string($db,$_POST['credentials'][1]);
    $sql = "SELECT id FROM users WHERE username = '$username' and password = SHA2('$password', 512)";
    $result = mysqli_query($db,$sql);
    if (!$result) {
        printf("Error: %s\n", mysqli_error($db));
        die();
    }
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
    // $active = $row['active'];
    $count = mysqli_num_rows($result);
    if ($count == 1) {
        $_SESSION['user'] = $username;
        header("location: secured.php");
    }
    else {
        $message = "Invalid credentials";
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>login</title>
    </head>
    <body>
        <center>
            <form action="" method="post">
                <input type="text" name="credentials[0]" placeholder="Username"></input>
                <br /><br />
                <input type="password" name="credentials[1]" placeholder="Password"></input>
                <br /><br />
                <input type="submit"></input>
                <?php echo $message; ?>
            </form>
        </center>
    </body>
</html>