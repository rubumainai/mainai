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
<form class="" action="{{URL::to('/reservations')}}" method="post">
    @csrf
    <div class="container">
        <h2 style="position: center">Mano rezervacijos</h2>
        <br>
        <table class="table table-hover">
            <thead>
            <tr class="header">
                <th>Data</th>
                <th>Naudotojas</th>
                <th>Rūbo spalva</th>
                <th>Rūbo tipas</th>
                <th>Rūbo rūšis</th>
                <th>Rezervacijos būsena</th>
                <th>Veiksmai</th>
            </tr>
            </thead>
            <tbody>
            <?php
              $id = $_SESSION["id"];
            $sql="SELECT data, id_Rezervacija, id_rezervacijos_busena, vardas, pavarde,  name,tname, rname, rezname, foto1  from rezervacija as rez, rezervacijos_busena, rubas as rub, naudotojas, spalvos, rubu_tipai, rubu_rusys where rez.fk_Naudotojasid_Naudotojas='$id' and id_rezervacijos_busena=rez.busena and rez.fk_Rubasid_Rubas = rub.id_Rubas and
rub.fk_Naudotojasid_Naudotojas = rez.skolintojas and id_Naudotojas = rez.skolintojas and rub.tipas = id_rubu_tipai and rub.rusis = id_rubu_rusys and rub.spalva = id_spalvos and rub.busena!=3";
            $connect = mysqli_connect("localhost", "root", "", "mainai");
            mysqli_query($connect,"SET NAMES 'utf8'");
            $search_result = mysqli_query($connect, $sql);
            while($row = mysqli_fetch_array($search_result)) :?>
            <tr>
                <td><?php echo $row['data'];$idd=$row['id_Rezervacija'];?></td>
                    <td><?php echo $row['vardas'];?> <?php echo $row['pavarde'];?></td>
                    <td><?php echo $row['name'];?></td>
                    <td><?php echo $row['tname'];?></td>
                    <td><?php echo $row['rname'];?></td>
                    <td><?php echo $row['rezname'];?></td>
                <?php if($row['id_rezervacijos_busena']==1) {?>
                <td><button type=submit class="mygt" name="grazinti" value="{{$idd}}" onclick="return confirm('Ar tikrai norite grąžinti rūbą?')">Grąžinti rūbą</button></td>
                <?php ;}?>
            </tr>
            <?php endwhile;?>
            </tbody>
        </table>
        <br>
        <br>
        <h2 style="position: center">Rezervacijų užklausos</h2>
        <br>
        <table class="table table-hover">
            <thead>
            <tr class="header">
                <th>Data</th>
                <th>Naudotojas</th>
                <th>Rūbo spalva</th>
                <th>Rūbo tipas</th>
                <th>Rūbo rūšis</th>
                <th>Rezervacijos būsena</th>
                <th>Veiksmai</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $id = $_SESSION["id"];
            $sql="SELECT data, id_Rezervacija, id_rezervacijos_busena, vardas, pavarde,  name,tname, rname, rezname, foto1  from rezervacija as rez, rezervacijos_busena, rubas as rub, naudotojas, spalvos, rubu_tipai, rubu_rusys where rez.fk_Naudotojasid_Naudotojas='$id' and id_rezervacijos_busena=rez.busena and rez.fk_Rubasid_Rubas = rub.id_Rubas and
rub.fk_Naudotojasid_Naudotojas = rez.skolintojas and id_Naudotojas = rez.skolintojas and rub.tipas = id_rubu_tipai and rub.rusis = id_rubu_rusys and rub.spalva = id_spalvos and rub.busena!=3";
            $connect = mysqli_connect("localhost", "root", "", "mainai");
            mysqli_query($connect,"SET NAMES 'utf8'");
            $search_result = mysqli_query($connect, $sql);
            while($row = mysqli_fetch_array($search_result)) :?>
            <tr>
                <td><?php echo $row['data'];$idd=$row['id_Rezervacija'];?></td>
                <td><?php echo $row['vardas'];?> <?php echo $row['pavarde'];?></td>
                <td><?php echo $row['name'];?></td>
                <td><?php echo $row['tname'];?></td>
                <td><?php echo $row['rname'];?></td>
                <td><?php echo $row['rezname'];?></td>
                <?php if($row['id_rezervacijos_busena']==3) {?>
                <td><button type=submit class="mygt" name="patvirtinti" value="{{$idd}}" style="width: 100px" onclick="return confirm('Ar tikrai norite patvirtinti rezervaciją?')">Patvirtinti</button>
                <button type=submit class="mygt" name="atmesti" value="{{$idd}}" style="width: 100px" onclick="return confirm('Ar tikrai norite atmesti rezervaciją?')">Atmesti</button></td>
                <?php ;}?>
                <?php if($row['id_rezervacijos_busena']==5) {?>
                <td><button type=submit class="mygt" name="patvirtinti_graz" value="{{$idd}}" style="width: 170px" onclick="return confirm('Ar tikrai norite patvirtinti grąžinimą?')">Patvirtinti grąžinimą</button></td>
                <?php ;}?>
            </tr>
            <?php endwhile;?>
            </tbody>
        </table>
    </div>
</form>
</body>
</html>