<?php
session_start();
if($_SESSION['person']!=4)
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
    button[class = "mygt"]
    {
        background-color: #A1B0AB;
        color: black;
        font-weight: bold;
        font-size: 15px;
        width: 200px;
        border-radius: 12px;
        font-family: 'Nunito', sans-serif;
    }
</style>
<?php if($_SESSION['person']==4) {?>
<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">Mainyk</a>
        </div>
        <ul class="nav navbar-nav">
            <li class="{{Request::is('/catalog')?'active':null }}"><a href="{{url('/catalog')}}">Katalogas</a></li>
            <li class="{{Request::is('/blockedUsersList')?'active':null }}"><a href="{{url('/blockedUsersList')}}">Užblokuoti naudotojai</a></li>
            <li class="{{Request::is('/problemsList')?'active':null }}"><a href="{{url('/problemsList')}}">Nusiskundimai</a></li>
            <li class="{{Request::is('/activeReservations')?'active':null }}"><a href="{{url('/activeReservations')}}">Rezervacijos</a></li>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Statistika
                    <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li class="{{Request::is('/registrationStatistic')?'active':null }}"><a href="{{url('/registrationStatistic')}}">Naudotojai</a></li>
                    <li class="{{Request::is('/registrationList')?'active':null }}"><a href="{{url('/registrationList')}}">Rezervacijos</a></li>
                </ul>
            </li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li class="{{Request::is('/logout')?'active':null}}"><a href="{{url('/logout')}}"><span class="glyphicon glyphicon-log-out"></span></a></li>
        </ul>
    </div>
</nav>
<?php }?>

<form class="" action="{{URL::to('/block')}}" method="post">
    @csrf
    <div class="container">
        <h2 style="position: center">Nusiskundimų sąrašas</h2>
        <br>
        <table class="table table-hover">
            <thead>
            <tr class="header">
                <th>Nusiskundimo autorius</th>
                <th>Aprašas</th>
                <th>Taisyklių pažeidėjas</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $query = "SELECT aprasas, naud.vardas, naud.pavarde, naud.id_Naudotojas,naud.tipas as tip, paz.tipas, paz.vardas as vardas1, paz.pavarde as pavarde1, paz.id_Naudotojas as id1 FROM nusiskundimas, naudotojas as naud, naudotojas as paz where fk_Naudotojasid_Naudotojas = naud.id_Naudotojas and naud.tipas!=3
and fk_Naudotojasid_Naudotojas1 = paz.id_Naudotojas and paz.tipas!=3";
            $connect = mysqli_connect("localhost", "root", "", "mainai");
            mysqli_query($connect,"SET NAMES 'utf8'");
            $search_result = mysqli_query($connect, $query);
            while($row = mysqli_fetch_array($search_result)) :?>
            <tr> <?php $id = $row["id_Naudotojas"]; $vardas = $row["vardas"]; $pavarde = $row["pavarde"];
            $id1 = $row["id1"]; $vardas1 = $row["vardas1"]; $pavarde1 = $row["pavarde1"]?>
                <?php if($row["tip"]==1) {?>
                <td><?php echo" <a href=../public/otherProfile?userid=",urlencode($id),">{$vardas} {$pavarde}</a> "?></td>
                <?php } else {?>
                <td><?php echo $vardas; echo " "; echo $pavarde; }?></td>
                <td><?php echo $row['aprasas'];?></td>
                <?php if($row["tipas"]==1) {?>
                <td><?php echo" <a href=../public/otherProfile?userid=",urlencode($id1),">{$vardas1} {$pavarde1}</a> "?></td>
                <?php } else {?>
                <td><?php echo $vardas1; echo " "; echo $pavarde1; }?></td>
                    <?php if($row['tipas']==1) {?>
                <td><button type=submit class="mygt" name="button" value="{{$id1}}" onclick="return confirm('Ar tikrai norite užblokuoti naudotoją?')">Užblokuoti pažeidėją</button></td>
           <?php ;}?>
            </tr>

            <?php endwhile;?>
            </tbody>
        </table>
    </div>
</form>
</body>
</html>