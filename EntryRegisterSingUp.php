<?php
use Endroid\QrCode\QrCode;

$db = mysqli_connect ('localhost','root','','entry');
if(!$db){
    die("conection failed :" . mysqli_connect_error());
}

if(isset($_POST["userName"])){
    $userName=$_POST["userName"];
    $password = md5($_POST['password']);
}
$query = "SELECT id, password FROM users WHERE username = ? AND password = ?";
  $stmt = $db->prepare($query);
  $stmt->bind_param("ss", $userName, $password);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      echo " <br>". "welcom"." ". $userName;
      $_SESSION["user_id"] = $db->insert_id;
      exit;
  } else {
      echo "Invalid username or password";
  }


  if (! empty($_SESSION["user_id"])) {
    require ('vendor/autoload.php');
    $barcode = new \Com\Tecnick\Barcode\Barcode();
    $targetPath = "qr-code/";
    
    if (! is_dir($targetPath)) {
        mkdir($targetPath, 0777, true);
    }
    $bobj = $barcode->getBarcodeObj('QRCODE,H', $_SESSION["user_id"], - 16, - 16, 'black', array(
        - 2,
        - 2,
        - 2,
        - 2
    ))->setBackgroundColor('#f0f0f0');
    
    $imageData = $bobj->getPngData();
    $timestamp = time();
    
    file_put_contents($targetPath . $timestamp . '.png', $imageData);
    ?>
      <div class="result-heading">Output:</div>
      <img src="<?php echo $targetPath . $timestamp ; ?>.png" width="150px" height="150px">
<?php
}

?>
?>