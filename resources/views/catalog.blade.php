<?php
session_start();
$dbc = mysqli_connect('localhost', 'root', '', 'mainai');
mysqli_query($dbc,"SET NAMES 'utf8'");
if (!$dbc) {
    die ("Negaliu prisijungti prie MySQL:" . mysqli_error($dbc));
}
else {
    $sql="SELECT * FROM rubas, spalvos, rubu_tipai, rubu_rusys WHERE spalva=id_spalvos and tipas=id_rubu_tipai and rusis=id_rubu_rusys";
    $result = mysqli_query($dbc, $sql);
}

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
        margin: 0;
    height: 100%;
        background-attachment: fixed;
    }

    img {
        width: 150px;
        height: 150px;
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

        <table class="table table-hover">
            <thead>
            <tr>
                <th>Nr.</th>
                <th>Nuotrauka</th>
                <th>Pavadinimas</th>
                <th>Aprašymas</th>
                <th>Spalva</th>
                <th>Tipas</th>
                <th>Rūšis</th>
            </tr>
            </thead>
            <tr>
            <td>1</td>
            <td><img src="https://tiuliofeja.lt/792-home_default_crop/suknele-61.jpg" alt="ruta" border="0"></td>
            <td>Nuostabios kokybės proginė suknelė</td>
            <td>Dydis s. Tik vieną kartą dėvėta, kokybė gera.</td>
            <td>Balta</td>
            <td>Moteriškas</td>
            <td>Suknelė</td></tr>
            <tr><td>2</td>
            <td><img src="http://tarpmergaiciu.lt/images/2/40288028673278ca01674a948c92091a.jpg" alt="ruta" border="0"></td>
            <td>Pasakiškos medžiagos sijonas</td>
            <td>Dydis XS. Labai gražus, mažai dėvėtas, puošnus, tinka įvairioms progoms.</td>
            <td>Juoda</td>
            <td>Moteriškas</td>
            <td>Sijonas</td></tr>
            <tr><td>3</td>
                <td><img src="https://images.vinted.net/thumbs/f800/0067a_faQdKxMKVYcu4Hoi7J3LZKhV.jpeg?1502361796$fbdc386bdf8dcc54df6e96f31602ab936bb4b7b2" alt="ruta" border="0"></td>
                <td>Klasikinės puikiai tinkančios kasdieniniam nešiojimui.</td>
                <td>Dydis M. Puikiai tinka tiek oficialiam darbui, tiek vakarėliui.</td>
                <td>Juoda</td>
                <td>Moteriškas</td>
                <td>Kelnės</td></tr>
            <tr><td>4</td>
                <td><img src="http://bluecat.lt/image/cache/catalog/SID.%20PAKABUKAS/RINK-0007-3-500x500.jpg" alt="ruta" border="0"></td>
                <td>Labai puošnus ir tinkantis bet kokiai progai.</td>
                <td>Dėvėtas tik kartą, kokybė gera, užsegimas nugaroje.</td>
                <td>Juoda</td>
                <td>Moteriškas</td>
                <td>Aksesuaras</td></tr>
            </tbody>
        </table>
</div>
</body>
</html>