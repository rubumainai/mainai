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
    input
    {
        background-color: #A1B0AB;
        color: black;
        font-weight: bold;
        font-size: 15px;
        width: 80px;
        border-radius: 12px;
        font-family: 'Nunito', sans-serif;
    }
    select{
        color: black;
        background-color: #A1B0AB;
        font-weight: bold;
        font-size: 15px;
        width: 90px;
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
    <div class="row justify-content-center">
        <div class="col-md-8">
            <br>
            <br>
            <!-- DROP DOWN-->
            <form method = "get">
                <div class="dropdown4">Pasirinkite mėnesį
                    <select name="month">
                        <option value="1">Sausis</option>
                        <option value="2">February</option>
                        <option value="3">March</option>
                        <option value="4">April</option>
                        <option value="5">May</option>
                        <option value="6">June</option>
                        <option value="7">July</option>
                        <option value="8">August</option>
                        <option value="9">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select><input type="submit" value="Rodyti">
                </div>

            </form>
            <br>
            <head>
                <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                <script type="text/javascript">
                    google.charts.load('current', {'packages':['line']});
                    google.charts.setOnLoadCallback(drawChart);

                    function drawChart() {

                        var data = new google.visualization.DataTable();
                        data.addColumn('number', 'Diena');
                        data.addColumn('number', 'Vartotojai');

                        data.addRows([
                            [1,  37.8],
                            [2,  30.9],
                            [3,  25.4],
                            [4,  11.7],
                            [5,  11.9],
                            [6,   8.8],
                            [7,   7.6],
                            [8,  12.3],
                            [9,  16.9],
                            [10, 12.8],
                            [11,  5.3],
                            [12,  6.6],
                            [13,  4.8],
                            [14,  4.2],
                            [15,  16.9],
                            [16, 12.8],
                            [17,  5.3],
                            [18,  6.6],
                            [19,  4.8],
                            [20,  4.2],
                            [21, 12.8],
                            [22,  5.3],
                            [23,  6.6],
                            [24,  4.8],
                            [25,  4.2],
                            [26,  5.3],
                            [27,  6.6],
                            [28,  4.8],
                            [29,  4.2],
                            [30,  4.8],
                            [31,  4.2],
                        ]);

                        var options = {
                            chart: {
                                title: 'Naujų vartotojų registracijos grafikas'
                            },
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
</div>
</body>
</html>