<?php 
use Endroid\QrCode\QrCode;

$db = mysqli_connect ('localhost','root','','entry');
if(!$db){
    die("conection failed :" . mysqli_connect_error());
}
if(isset($_POST["userName"])){
    $userName=$_POST["userName"];
    $phoneNumber=$_POST["phoneNumber"];

    if(preg_match('/^[0-9]+$/',$phoneNumber)){
        $stmt = $db->prepare("SELECT * FROM users WHERE phoneNumber = ?");
        $stmt->bind_param("s", $phoneNumber);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            echo "Error: A user with this phone number already exists.";
        } else {
            $password = md5($_POST['password']);
            $education=$_POST["education"];
            $birthDay=$_POST["birthDay"];

            $json_file = 'users.json';
            $json_data = json_decode(file_get_contents($json_file), true);
            $json_data[] = array(
                'userName' => $userName,
                'phoneNumber' => $phoneNumber,
                'password' => $password,
                'education' => $education
            );
            $json_data = json_encode($json_data, JSON_PRETTY_PRINT);
            file_put_contents($json_file, $json_data);

            $stmt=$db->prepare("INSERT INTO users (username,phoneNumber,password,education,Date) VALUE (?,?,?,?,?)");
            $stmt->bind_param("sssss",$userName,$phoneNumber,$password,$education,$birthDay);
            $stmt->execute();
            $_SESSION["user_id"] = $db->insert_id;


            if($stmt->affected_rows>0){
                echo " <br>". "welcom"." ". $userName;
            } else{
                echo "somthing went wrong";
            }

        }
    } else{
        echo "your phone number is not valid";
    }
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