<?php session_start(); ?>
<?php
require_once '../private/secrets.php';
$message = '';
if ($_SERVER['REQUEST_METHOD']=="POST" and isset($_POST['contact'])) {
  require_once 'vendor/autoload.php';
  $data = $_POST['contact'];
  $email = new \SendGrid\Mail\Mail();
  $email->setFrom('sumanthratna@gmail.com');
  $email->setSubject('12 reasons why php is cool');
  $email->addTo("sratna@sumanthratna.gq", "Sumanth Ratna");
  $email->addContent("text/html", nl2br($data[0]).'<br><br><br><br>-------------------<br>'.'- anonymous');
  $sendgrid = new \SendGrid($sendgrid_key);
  try {
      $response = $sendgrid->send($email);
      $message = 'Thanks for your message!';
  } catch (Exception $e) {
      $message = 'error sending message:\n\n'.$e->getMessage().'\n\nHere\'s what you wrote:\n'.nl2br($data[0]);
  }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Secured Stuff</title>
    </head>
    <body>
        Hello, <?php echo $_SESSION['user']; ?>.
        <br />
        <a href="logout.php">Logout.</a>
        <br />
        <?php echo $message; ?>
        <form action="" method="post">
            <textarea name="contact[0]"></textarea>
            <br>
            <input type="submit" />
        </form>
    </body>
</html>