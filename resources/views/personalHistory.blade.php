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
<form class="" action="{{URL::to('/block')}}" method="post">
    @csrf
    <div class="container">
        <h2 style="position: center">Rezervacijų istorija</h2>
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
            </tr>
            </thead>
            <tbody>
            <?php
              $id = $_SESSION["id"];
            $query = "SELECT * FROM rezervacija, rezervacijos_busena where fk_Naudotojasid_Naudotojas = $id and busena = id_rezervacijos_busena
order by data desc";
            $connect = mysqli_connect("localhost", "root", "", "mainai");
            mysqli_query($connect,"SET NAMES 'utf8'");
            $search_result = mysqli_query($connect, $query);
            while($row = mysqli_fetch_array($search_result)) :?>
            <tr>
                <?php
                $id2 = $row['fk_Rubasid_Rubas'];
                $query2 = "select * from rubas where id_Rubas= '$id2'";
                $data = mysqli_query($connect, $query2);
                $row2 = mysqli_fetch_assoc($data);
                $tip = $row2['tipas'];
                $query3 = "select * from rubu_tipai where id_rubu_tipai = '$tip'";
                $data2 = mysqli_query($connect, $query3);
                $row3 = mysqli_fetch_assoc($data2);
                $sp = $row2['spalva'];
                $query4 = "select * from spalvos where id_spalvos = '$sp'";
                $data3 = mysqli_query($connect, $query4);
                $row4 = mysqli_fetch_assoc($data3);
                $rus = $row2['rusis'];
                $query5 = "select * from rubu_rusys where id_rubu_rusys = '$rus'";
                $data4 = mysqli_query($connect, $query5);
                $row5 = mysqli_fetch_assoc($data4);
                $naud = $row2['fk_Naudotojasid_Naudotojas'];
                $query6 = "select * from naudotojas where id_Naudotojas = '$naud'";
                $data5 = mysqli_query($connect, $query6);
                $row6 = mysqli_fetch_assoc($data5);
                ?>
                <td><?php echo $row['data'];;?></td>
                    <td><?php echo $row6['vardas'];?> <?php echo $row6['pavarde'];?></td>
                    <td><?php echo $row4['name'];?></td>

                    <td><?php echo $row3['name'];?></td>
                    <td><?php echo $row5['name'];?></td>
                    <td><?php echo $row['name'];?></td>
            </tr>

            <?php endwhile;?>
            </tbody>
        </table>
    </div>
</form>
</body>
</html>