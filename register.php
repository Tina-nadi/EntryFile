<?php 
session_start();


$db = mysqli_connect ('localhost','root','','users');
if(!$db){
    die("conection failed :" . mysqli_connect_error());
}

if (isset($_POST['signUp'])) {
    $firstName = $_POST['fName'];
    $lastName = $_POST['lName'];
    $email = $_POST['email'];
    $password = md5($_POST['password']); // Note: MD5 is not secure for password hashing. Consider using password_hash() and password_verify() instead.

    $checkEmail = "SELECT * FROM userinfo WHERE email = ?";
    $stmt = $db->prepare($checkEmail);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Email Address Already Exists !";
    } else {
        $insertQuery = "INSERT INTO userinfo (username, lastName, email, password) VALUES (?, ?, ?, ?)";
        $stmt = $db->prepare($insertQuery);
        $stmt->bind_param("ssss", $firstName, $lastName, $email, $password);
        if ($stmt->execute()) {
            $_SESSION["user_id"] = $db->insert_id;
            header("Location: index.php");
            echo "sucsuus";
        } else {
            echo "Error: " . $db->error;
        }
    }
}


if (isset($_POST['signIn'])) {
  $email = $_POST['email'];
  $password = md5($_POST['password']); // Note: MD5 is not secure for password hashing. Consider using password_hash() and password_verify() instead.

  $query = "SELECT id, email FROM userinfo WHERE email = ? AND password = ?";
  $stmt = $db->prepare($query);
  $stmt->bind_param("ss", $email, $password);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $_SESSION["user_id"] = $row["id"];
      $_SESSION["email"] = $row["email"];
      header("Location: index.php");
      echo "sucsuus";

      exit;
  } else {
      echo "Invalid username or password";
  }
}
   
?>