<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Sing Up</title>
    <style>
         form input{
            width: 300%;
        }
        input{
            margin: 10px;
            border:none;
            border-bottom:1px solid #757575
        }
        input :focus{
            background-color: transparent;
            outline:transparent;
            border-bottom:2px solid hsl(327,90%,28%);
        }
        .container{
        background:#fff;
        width:450px;
        padding:1.5rem;
        margin:50px auto;
        border-radius:10px;
        box-shadow:0 20px 35px rgba(0,0,1,0.9);
       }
    </style>
</head>
<body>
<div class="container row" >
        <h1>Login Form</h1>
        <form method="post" class="col-4" action="entryRegisterSingUp.php/&quot;&gt;&lt;script&gt;alert('hacked')&lt;/script&gt;" >
            <input type="text" name="userName" placeholder="enter your name:">
            <input type="password" name="password" placeholder="enter your password">
            <input type="submit" class="btn btn-secondary" >
        </form>
        <p>don't have acount yet?</p>
        <a href="entryForm.php">Sing in </a>
</div>
    
</body>
</html>