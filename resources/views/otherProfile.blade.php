<?php
session_start();
if($_SESSION['person']!=1 && $_SESSION['person']!=4)
{
    echo "<h4  style='color: red'>Turite prisijungti, kad galėtumėte peržiūrėti šį puslapį</h4>";
    die;
}
$_SESSION["tipas"] = NULL;
$_SESSION["spalva"] = NULL;
$_SESSION["rusis"] = Null;
$_SESSION["rez"] = NULL;
$id = $_GET['userid'];
$dbc = mysqli_connect('localhost', 'root', '', 'mainai');
mysqli_query($dbc, "SET NAMES 'utf8'");
if (!$dbc) {
    die ("Negaliu prisijungti prie MySQL:" . mysqli_error($dbc));
}
$sql="SELECT * FROM naudotojas WHERE id_Naudotojas=$id";
$result = mysqli_query($dbc, $sql);

$sql2="SELECT * FROM rekomendacija WHERE fk_Naudotojasid_Naudotojas=$id";
$result2 = mysqli_query($dbc, $sql2);

$result3= mysqli_query($dbc,"SELECT AVG(vertinimas) AS vert FROM rekomendacija where fk_Naudotojasid_Naudotojas=$id");
$row3 = mysqli_fetch_assoc($result3);
$average = $row3['vert'];
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

    select
    {
        border-radius: 18px;
        background: #b9bbbe;
        width: 50px;
        height: 25px;
    }

    .a{
        size: 20px;
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
        width: 80px;
        border-radius: 12px;
        font-family: 'Nunito', sans-serif;
    }

    button[type="button"]{
        background: transparent;
        background-color: transparent;
    }

    button[type="button"]:active {
        background-color: yellow;
    }

    .table{
        font-size: 19px;
    }
    button{
        background: transparent;
        border-radius: 12px;
        width: 100px;
        color: #636b6f;
        font-size: 15px;
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
<?php if($_SESSION['person']==1) {?>
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
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li class="{{Request::is('/tagsList')?'active':null}}"><a href="{{url('/tagsList')}}"><span class="glyphicon glyphicon-heart"></span></a></li>
            <li class="{{Request::is('/myProfile')?'active':null}}"><a href="{{url('/myProfile')}}"><span class="glyphicon glyphicon-user"></span></a></li>
            <li class="{{Request::is('/logout')?'active':null}}"><a href="{{url('/logout')}}"><span class="glyphicon glyphicon-log-out"></span></a></li>
        </ul>
    </div>
</nav>
<?php } ?>
<div class="container">
    <div class="col-md-6">
<h2>Naudotojo informacija</h2><br>
    <?php
    $row = mysqli_fetch_array($result); ?>
    <h4>Vardas: <?php echo $row['vardas']; ?></h4><br>
    <h4>Pavardė: <?php echo $row['pavarde']; ?></h4><br>
    <h4>El. pašto adresas: <?php echo $row['email']; ?></h4><br>
    <h4>Telefono numeris: <?php echo $row['tel']; ?></h4><br>
    <h4>Miestas: <?php echo $row['miestas']; ?></h4><br>

    <form class="" action="{{URL::to('/addRecomendation')}}" method="post">
        <div class="dropdown" required style=" font-family: 'Nunito', sans-serif;
        font-size: 19px">Pasirinkite balą
            <br>
            <select name = "balas">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
        </div>
    <h4>Aprašymas:</h4>
    <input type="text" name="aprasas" class="fields" value="" required>
        @csrf
        <input type="hidden" name="fk" value="{{$id}}">
    <input type="submit" class="button" name="vert" onclick="return confirm('Ar tikrai norite pateikti atsiliepimą?')" value="Vertinti"><br><br>
    <br>
    </form>
    <form class="" action="{{URL::to('/addProblem')}}" method="post">
    <h4>Galit palikti nusiskundimą:</h4>
    <input type="text" name="skundas" class="fields" value="" required>
        @csrf
        <input type="hidden" name="fk" value="{{$id}}">
    <input type="submit" class="button" name="skustis" onclick="return confirm('Ar tikrai norite pateikti skundą?')" value="Išsaugoti"><br><br>
    <br>
    </form>
    </div>
    <div class="col-md-6">
        <h4><?php echo ("Įvertinimas: $average"); ?></h4>
        <table class="table table-hover">
            <thead>
            <tr>
                <th>Atsiliepimai</th>
            </tr>
            </thead>
            <tbody>
            <?php
            while($row2 = mysqli_fetch_array($result2)) :?>
            <?php $array =array() ?>
            <td><?php echo $row2['aprasas']; $idd=$row2['id_Rekomendacija'];?></td>
            <form class="" action="{{URL::to('/removeRecomendation')}}" method="post">
                @csrf
                <input type="hidden" name="fk" value="{{$idd}}">
            <?php if($_SESSION["username"]== "admin")
            {
            ?>
            <td>
                <button type=submit name="button" onclick="return confirm('Ar tikrai norite ištrinti atsiliepimą?')"><span class="glyphicon glyphicon-trash"></span> Šalinti</button>
            </td>
            <?php
            }?>
            </form>
            </tr>
            <?php endwhile;?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>