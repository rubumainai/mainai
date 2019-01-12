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
        background-attachment: fixed;
    }
    select[name="tipas"]
    {
        background-color: #A1B0AB;
        color: black;
        font-weight: bold;
        font-size: 15px;
        width: 300px;
        border-radius: 12px;
        height: 25px;
        font-family: 'Nunito', sans-serif;
    }

    input[value="Rodyti"]
    {
        background-color: #A1B0AB;
        color: black;
        font-weight: bold;
        font-size: 15px;
        width: 100px;
        border-radius: 12px;
        font-family: 'Nunito', sans-serif;
    }
    input:hover {
        background-color: #907D8D;
        color: black;
        font-family: 'Nunito', sans-serif;
    }
    input[type="date"]
    {
        background-color: #A1B0AB;
        color: black;
        font-weight: bold;
        font-size: 15px;
        width: 180px;
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
<div class="container">
    <h2>Statistika</h2>
    <form method = "get">
        <div class="dropdown2">Pasirinkite ataskaitos tipą
            <br>
            <br>
            <select name="tipas">
                <option value="1">Įvykdytos rezervacijos</option>
                <option value="2">Arenų populiarumas</option>
            </select>
            <input type="date" name="from"/><input type="date" name="to"/><input name = "submit" type="submit" value="Rodyti"><br>
            <br>
        </div>
    </form>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['line']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            var data = new google.visualization.DataTable();
            data.addColumn('number', 'Diena');
            data.addColumn('number', 'Rezervacijos');

            data.addRows([
                [1,  20],
                [2,  15],
                [3,  2],
                [4,  11],
                [5,  11],
                [6,   8],
                [7,   7],
                [8,  6],
                [9,  5],
                [10, 6],
                [11,  7],
                [12,  6],
                [13,  9],
                [14,  11],
                [15,  11],
                [16, 12],
                [17,  13],
                [18,  10],
                [19,  11],
                [20,  11],
                [21, 12],
                [22,  15],
                [23,  16],
                [24,  20],
                [25,  15],
                [26,  14],
                [27,  13],
                [28,  12],
                [29,  14],
                [30,  23],
                [31,  25],
            ]);

            var options = {
                width: 900,
                height: 500,
                axes: {
                    x: {
                        0: {side: 'top'}
                    }
                },
                backgroundColor: 'transparent'
            };

            var chart = new google.charts.Line(document.getElementById('line_top_x'));

            chart.draw(data, google.charts.Line.convertOptions(options));
        }
    </script>
    </head>
    <body>
    <div id="line_top_x"></div>
    </body>
</div>
</div>
</body>
</html>