<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Mainyk</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<style>
    html, body {
        background: linear-gradient(to bottom right, #B89685, #F8F4E3);
        color: #636b6f;
        font-family: 'Nunito', sans-serif;
        font-weight: 200;
        height: 100vh;
        margin: 0;
        background-attachment: fixed;
    }
</style>
<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">Mainyk</a>
        </div>
        <ul class="nav navbar-nav">
            <li class="{{Request::is('/catalog')?'active':null }}"><a href="{{url('/catalog')}}">Katalogas</a></li>
            <li class="{{Request::is('/newItem')?'active':null }}"><a href="{{url('/newItem')}}">Pridėti naują</a></li>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Rodyti mano
                    <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li class="{{Request::is('/myCatalog')?'active':null }}"><a href="{{url('/myCatalog')}}">Katalogas</a></li>
                    <li class="{{Request::is('/personalHistory')?'active':null }}"><a href="{{url('/personalHistory')}}">Istorija</a></li>
                </ul>
            </li>
            <form class="navbar-form navbar-left" action="/action_page.php">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Ieškoti...">
                </div>
                <button type="button" class="btn btn-default btn-sm">
                    <span class="glyphicon glyphicon-search"></span>
                </button>
            </form>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li class="{{Request::is('/tagsList')?'active':null}}"><a href="{{url('/tagsList')}}"><span class="glyphicon glyphicon-heart"></span></a></li>
            <li class="{{Request::is('/myProfile')?'active':null}}"><a href="{{url('/myProfile')}}"><span class="glyphicon glyphicon-user"></span></a></li>
            <li class="{{Request::is('/logout')?'active':null}}"><a href="{{url('/logout')}}"><span class="glyphicon glyphicon-log-out"></span></a></li>
           </ul>
    </div>
</nav>
<div class="container">
    <div class="col-md-6 col-md-offset-3">
<form class="" action="{{URL::to('/editClient')}}" method="post">
    @csrf
   <?php
    $id = $_SESSION["id"];
    $sql = "select * from naudotojas where id_Naudotojas = '$id'";
    $dbc=mysqli_connect('localhost','root', '','mainai');
    mysqli_query($dbc,"SET NAMES 'utf8'");
    if(!$dbc){
        die ("Negaliu prisijungti prie MySQL:"	.mysqli_error($dbc));
    }
    $data = mysqli_query($dbc, $sql);
    $row = mysqli_fetch_assoc($data);

    ?>
       <h2>Asmeninių duomenų redagavimas</h2><br>
    Vardas:<br>
    <input type="text" name="name" value="<?php echo $row['vardas']; ?>">
    <br><br>
    Pavardė:<br>
    <input type="text" name="surname" value="<?php echo $row['pavarde']; ?>"><br><br>
       El. pašto adresas:<br>
       <input type="text" name="email" value="<?php echo $row['email']; ?>"><br><br>
       Telefono numeris:<br>
       <input type="text" name="numer" value="<?php echo $row['tel']; ?>" minlength="9" maxlength="9"><br>
       <br>
       Miestas:<br>
       <input type="text" name="city" value="<?php echo $row['miestas']; ?>"><br>
       <br>
    Prisijungimo vardas:<br>
    <input type="text" name="username" value="<?php echo $row['prisijungimo_vardas']; ?>" readonly="readonly"><br>


    <br>


    Naujas slaptažodis:<br>
    <input type="password" name="password" value=""><br>
    <br>
    Pakartoti slaptažodį:<br>
    <input type="password" name="password2" value=""><br>
    <br>
    <input type="submit" value="Pakeisti"><br>

    <?php
    if(!empty($_SESSION['error']))
    {


        if (   $_SESSION['error']=='klaida'  )
        {
            echo "<h4>Neteisingai įvestas slaptažodis</h4>";
            $_SESSION['error'] = "";
        }}
    ?>

</form>
    </div>
</div>
</body>
</html>