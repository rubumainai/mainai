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
$user=$_SESSION['id'];
$dbc = mysqli_connect('localhost', 'root', '', 'mainai');
mysqli_query($dbc,"SET NAMES 'utf8'");
if (!$dbc) {
    die ("Negaliu prisijungti prie MySQL:" . mysqli_error($dbc));
}
else {
   // $sql="SELECT * FROM rubas, spalvos, rubu_tipai, rubu_rusys, rubo_busena WHERE spalva=id_spalvos and tipas=id_rubu_tipai and rusis=id_rubu_rusys and busena = id_rubo_busena and fk_Naudotojasid_Naudotojas=$user and busena != 3";
   // $result = mysqli_query($dbc, $sql);

  //  $sql2="SELECT DISTINCT * FROM spalvos, rubu_tipai, rubu_rusys, rubas LEFT JOIN zyma on rubas.id_Rubas=zyma.fk_Rubasid_Rubas
//WHERE spalva=id_spalvos and tipas=id_rubu_tipai and rusis=id_rubu_rusys and rubas.fk_Naudotojasid_Naudotojas=$user and busena != 3";
    $sql2 = "SELECT * FROM spalvos, rubu_tipai, rubu_rusys, rubas
WHERE spalva=id_spalvos and tipas=id_rubu_tipai and rusis=id_rubu_rusys and rubas.fk_Naudotojasid_Naudotojas=$user and busena != 3";
    $result = mysqli_query($dbc, $sql2);
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
        font-weight: 200;height: 100%;
        background-attachment: fixed;
        margin: 0;
    }

    img {
        width: 120px;
        height: 150px;
    }

    input{
        background-color: #A1B0AB;
        border-radius: 12px;
        width: 100px;
        color: black;
        font-weight: bold;
    }

    button{
        background-color: #A1B0AB;
        border-radius: 12px;
        width: 100px;
        color: black;
        font-weight: bold;
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
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li class="{{Request::is('/tagsList')?'active':null}}"><a href="{{url('/tagsList')}}"><span class="glyphicon glyphicon-heart"></span></a></li>
            <li class="{{Request::is('/myProfile')?'active':null}}"><a href="{{url('/myProfile')}}"><span class="glyphicon glyphicon-user"></span></a></li>
            <li class="{{Request::is('/logout')?'active':null}}"><a href="{{url('/logout')}}"><span class="glyphicon glyphicon-log-out"></span></a></li>
        </ul>
    </div>
</nav>
<div class="container">
<h2>Mano drabužiai</h2>
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
        <tbody>
        <?php   $nr = 1;
        while($row = mysqli_fetch_array($result)) :?>
        <?php $array =array() ?>
        <td><?php echo $nr;$idd =$row['id_Rubas'];?></td>
        <td><img src="../public/images/<?php echo $row['foto1']?>"></td>
        <td><?php echo $row['pavadinimas'];?></td>
        <td><?php echo $row['aprasymas'];?></td>
        <td><?php echo $row['name'];?></td>
        <td><?php echo $row['tname'];?></td>
        <td><?php echo $row['rname'];?></td>
        <td><?php echo" <a href=../public/viewItem?itemid=",urlencode($idd),"><input type=button id='$idd' value='Peržiūrėti' ></a> "?></td>
        <td>
            <form class="" action="{{URL::to('/removeItem')}}" method="post">
                @csrf
                <input type="hidden" name="fk" value="{{$idd}}">
                <button type=submit name="button"<?php if ($row['busena'] != '1'){ ?> disabled <?php   } ?> onclick="return confirm('Ar tikrai norite ištrinti drabužį?')"><span class="glyphicon glyphicon-trash"></span> Šalinti</button>
            </form></td>
        </tr>
        <?php $nr++;?>
        <?php endwhile;?>
        </tbody>
    </table>
</div>
</body>
</html>