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
    button[class = "mygt"]
    {
        background-color: #A1B0AB;
        color: black;
        font-weight: bold;
        font-size: 15px;
        width: 100px;
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
            <li class="{{Request::is('/blockedUsersList')?'active':null }}"><a href="{{url('/blockedUsersList')}}">Užblokuoti naudotojai</a></li>
            <li class="{{Request::is('/problemsList')?'active':null }}"><a href="{{url('/problemsList')}}">Nusiskundimai</a></li>
            <li class="{{Request::is('/registrationList')?'active':null }}"><a href="{{url('/registrationList')}}">Rezervacijos</a></li>
            <li class="{{Request::is('/registrationStatistic')?'active':null }}"><a href="{{url('/registrationStatistic')}}">Statistika</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li class="{{Request::is('/logout')?'active':null}}"><a href="{{url('/logout')}}"><span class="glyphicon glyphicon-log-out"></span></a></li>
        </ul>
    </div>
</nav>
<form class="" action="{{URL::to('/unblock')}}" method="post">
    @csrf
    <div class="container">
        <h2 style="position: center">Užblokuotų naudotojų sąrašas</h2>
        <br>
        <table class="table table-hover">
            <thead>
            <tr class="header">
                <th>Vardas</th>
                <th>Pavardė</th>
                <th>El. paštas</th>
                <th>Registracijos data</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $query = "SELECT * FROM naudotojas where tipas = 2 order by registracijos_data desc";
            $connect = mysqli_connect("localhost", "root", "", "mainai");
            mysqli_query($connect,"SET NAMES 'utf8'");
            $search_result = mysqli_query($connect, $query);
            while($row = mysqli_fetch_array($search_result)) :?>
            <tr>
                <td><?php echo $row['vardas'];   $idd =$row['id_Naudotojas'];?></td>
                <td><?php echo $row['pavarde'];?></td>
                <td><?php echo $row['email'];?></td>
                <td><?php echo $row['registracijos_data'];?></td>
                <td><button type=submit class="mygt" name="button" value="{{$idd}}" onclick="return confirm('Ar tikrai norite atblokuoti naudotoją?')">Atblokuoti</button></td>
            </tr>

            <?php endwhile;?>
            </tbody>
        </table>
    </div>
</form>
</body>
</html>