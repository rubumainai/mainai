<?php
session_start();
if($_SESSION['person']!=1)
{
    echo "<h4  style='color: red'>Jums nepakanka teisių peržiūrėti šį puslapį</h4>";
    die;
}
$_SESSION["tipas"] = NULL;
$_SESSION["spalva"] = NULL;
$_SESSION["rusis"] = Null;
$_SESSION["rez"] = NULL;
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
        font-weight: 200;height: 100%;
        background-attachment: fixed;
        margin: 0;
    }
    input[class="fields"]
    {
        border-radius: 18px;
        background: #b9bbbe;
        padding: 10px;
        width: 200px;
        height: 10px;
    }
    input[class="button"]
    {
        background-color: #A1B0AB;
        color: black;
        font-weight: bold;
        font-size: 15px;
        width: 120px;
        border-radius: 12px;
        font-family: 'Nunito', sans-serif;
    }
    button[class="button"]
    {
        background-color: #A1B0AB;
        color: black;
        font-weight: bold;
        font-size: 15px;
        width: 130px;
        border-radius: 12px;
        font-family: 'Nunito', sans-serif;
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
    <input type="text" name="vardas" class="fields" value="<?php echo $row['vardas']; ?>" required>
    <br><br>
    Pavardė:<br>
    <input type="text" name="pavarde" class="fields" value="<?php echo $row['pavarde']; ?>" required><br><br>
       Telefono numeris:<br>
       <input type="text" name="mob_numeris" class="fields" value="<?php echo $row['tel']; ?>" minlength="9" maxlength="9" required><br>
       <br>
       Miestas:<br>
       <input type="text" name="miestas" class="fields" value="<?php echo $row['miestas']; ?>" required><br>
       <br>
    Naujas slaptažodis:<br>
    <input type="password" name="slaptazodis" class="fields" value=""><br>
    <br>
    Pakartoti slaptažodį:<br>
    <input type="password" name="slaptazodis2" class="fields" value=""><br>
    <br>
    <button type=submit class="button" name="button" value="{{$_SESSION['id']}}">Pakeisti</button>
    <br><br>

    <?php
    if(!empty($_SESSION['error']))
    {
        if (   $_SESSION['error']=='klaida'  )
        {
            echo "<h4 style='color: red'>Neteisingai pakartotas slaptažodis</h4>";
            $_SESSION['error'] = "";
        }}
    ?>

</form>
        <form class="" action="{{URL::to('/deleteUser')}}" method="post">
            @csrf

            <button type=submit class="button" name="button" value="{{$_SESSION['id']}}" onclick="return confirm('Ar tikrai norite pašalinti paskyrą?')">Ištrinti paskyrą</button>
            <br><br>
        </form>
    </div>
</div>
</body>
</html>