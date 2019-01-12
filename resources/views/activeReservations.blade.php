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
    img {
        width: 150px;
        height: 150px;
    }
    button[class = "mygt"]
    {
        background-color: #A1B0AB;
        color: black;
        font-weight: bold;
        font-size: 15px;
        width: 150px;
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
<form class="" action="{{URL::to('/reservations')}}" method="post">
    @csrf
    <div class="container">
        <h2 style="position: center">Aktyvios rezervacijos</h2>
        <br>
        <table class="table table-hover">
            <thead>
            <tr class="header">
                <th>Data</th>
                <th>Rūbo savininkas</th>
                <th>Skolininkas</th>
                <th>Rūbo pavadinimas</th>
                <th>Rezervacijos būsena</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $sql = "SELECT data, id_Rubas, pavadinimas, rezname, skol.vardas as vard,skol.pavarde as pav ,skol.id_Naudotojas as id, naud.id_Naudotojas, naud.vardas, naud.pavarde from rezervacija
            RIGHT JOIN rubas as rub on rezervacija.fk_Rubasid_Rubas = rub.id_Rubas
            Right JOIN rezervacijos_busena on rezervacijos_busena.id_rezervacijos_busena = rezervacija.busena
            LEFT JOIN naudotojas as skol on rezervacija.skolintojas = skol.id_Naudotojas
            RIGHT JOIN naudotojas as naud on rezervacija.fk_Naudotojasid_Naudotojas = naud.id_Naudotojas
            where rezervacija.busena=3 or rezervacija.busena=1 or rezervacija.busena=5
            order by data desc;";
            $connect = mysqli_connect("localhost", "root", "", "mainai");
            mysqli_query($connect,"SET NAMES 'utf8'");
            $search_result = mysqli_query($connect, $sql);
            while($row = mysqli_fetch_array($search_result)) :?>
            <tr>
                <td><?php echo $row['data'];$id=$row['id']; $idd = $row['id_Naudotojas'];
                    $vardas = $row['vard']; $pavarde  = $row['pav']; $rubas = $row['id_Rubas']; $pavadinimas = $row['pavadinimas'];
                    $vardas2 = $row['vardas']; $pavarde2  = $row['pavarde']?></td>
                <td><?php echo" <a href=../public/otherProfile?userid=",urlencode($id),">{$vardas} {$pavarde}</a> "?></td>
                <td><?php echo" <a href=../public/otherProfile?userid=",urlencode($idd),">{$vardas2} {$pavarde2}</a> "?></td>
                <td><?php echo" <a href=../public/viewItem?itemid=",urlencode($rubas),">{$pavadinimas}</a> "?></td>
                <td><?php echo $row['rezname'];?></td>
            </tr>
            <?php endwhile;?>
            </tbody>
        </table>
        <br>
    </div>
</form>
</body>
</html>