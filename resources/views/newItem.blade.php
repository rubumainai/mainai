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

    input[type="submit"]
    {
        border-radius: 18px;
        background: #b9bbbe;
        font-size: 18px;
    }

    input[type="file"]
    {
        background: transparent;
    }

    button[class="btn btn-success"]
    {
        background-color: #A1B0AB;
        color: black;
        font-weight: bold;
        font-size: 15px;
        width: 90px;
        border-radius: 12px;
        font-family: 'Nunito', sans-serif;
    }
    button[class="btn btn-primary"]
    {
        background-color: #A1B0AB;
        color: black;
        font-weight: bold;
        font-size: 15px;
        width: 90px;
        border-radius: 12px;
        font-family: 'Nunito', sans-serif;
    }

    select
    {
        border-radius: 18px;
        background: #b9bbbe;
        width: 200px;
        height: 25px;
    }

    .dropdown
    {
        font-size: 18px;
    }

    .cont{
        font-size: 15px;
    }

    a{
        font-size: 15px;
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
        <h2>Naujas įkėlimas</h2>
        <form method="post" id="formImgInp" action="{{route('image.add')}}" enctype="multipart/form-data">
            <!-- DROP DOWN-->
            <h4>Įveskite pavadinimą:</h4>
            <input type="text" name="pavadinimas" class="fields" value="" required><br>
            <br>
            <h4>Įveskite aprašymą:</h4>
            <input type="text" name="aprasymas" class="fields" value="" required><br>
            <br>
            <div class="dropdown" required>Pasirinkite spalvą
                <br>
                <select name = "spalva">
                    <option value="1">Raudona</option>
                    <option value="2">Geltona</option>
                    <option value="3">Mėlyna</option>
                    <option value="4">Žalia</option>
                    <option value="5">Violetinė</option>
                    <option value="6">Oranžinė</option>
                    <option value="7">Juoda</option>
                    <option value="8">Balta</option>
                </select>
            </div>
            <br>
            <div class="dropdown" required>Pasirinkite tipą
                <br>
                <select name = "tipas">
                    <option value="1">Aksesuaras</option>
                    <option value="2">Batai</option>
                    <option value="3">Rankinė</option>
                    <option value="4">Suknelė</option>
                    <option value="5">Sijonas</option>
                    <option value="6">Kelnės</option>
                    <option value="7">Švarkas</option>
                    <option value="8">Palaidinė</option>
                </select>
            </div>
            <br>
            <div class="dropdown" required>Pasirinkite rūšį
                <br>
            <select name = "rusis">
                <option value="1">Vaikiškas</option>
                <option value="2">Vyriškas</option>
                <option value="3">Moteriškas</option>
            </select>
            </div>
            <br>
            <input type="hidden" name="_token" value="{{csrf_token()}}"/>
            <input type="file" name="image" id="image" required/><br>
            <input type="file" name="image2" id="image2" required/><br>
            <input type="file" name="image3" id="image3" required/><br>
            <input type="file" name="image4" id="image4" required/><br>
            <input type="submit"/>
        </form>
</div>
</div>

</body>
</html>