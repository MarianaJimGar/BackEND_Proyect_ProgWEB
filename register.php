<?php
include 'config.php';
if(isset($_POST['submit'])){
    $name = mysql_real_escape_string($conn,$_POST['name']);
    $email = mysql_real_escape_string($conn,$_POST['email']);
    $pass = mysql_real_escape_string($conn, md5($_POST['password']));
    $cpass = mysql_real_escape_string($conn, md5($_POST['cpassword']));
    $user_type = $_POST['email'];

    $select_users = mysql_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');
    if(mysql_num_rows($select_users)>0){
        $message[] = 'el usuario ya existe';
    }else {
        if($pass != $cpass){
            $message[] = 'confirma tu contraseña';
        }else {
            mysql_query($conn, "INSERT INTO `users`(name, email, password, user_type) VALUES ('$name','$email','$cpass','$user_type')") or die('query failed');
            $message[] = 'registro completado';
            header('location:login.php');
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>-Register-</title>

    <!--font awesome cdn link-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!--custom css file link-->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>
    <?php
    if(isset($message)){
        foreach ($message as $message) {
            echo'
            <div class="mesage">
                <span>'.$mesage.'</span>
                <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
            </div>
            ';
        }
    }
    ?>
    
    <div class="form-container">
        <form action="" method="post">
            <h3>REGISTRATE AQUI</h3>
            <input type="text" name="name" placeholder="Ingresa tu nombre" required class="box">
            <input type="email" name="email" placeholder="Ingresa tu correo" required class="box">
            <input type="password" name="password" placeholder="Ingresa tu contraseña" required class="box">
            <input type="password" name="cpassword" placeholder="Confirma tu contraseña" required class="box">
            <select name="user_type">
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
            <input type="text" name="submit" value="Registrate ahora" class="btn">
            <p>Listo para tener tu cuenta con nosotros? unete! <a href="login.php">Registrate ahora!</a></p>
        </form>
    </div>
</body>
</html>