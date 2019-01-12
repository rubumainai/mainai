<!DOCTYPE html>
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

$dbc = mysqli_connect('localhost', 'root', '', 'mainai');
mysqli_query($dbc,"SET NAMES 'utf8'");
if (!$dbc) {
    die ("Negaliu prisijungti prie MySQL:" . mysqli_error($dbc));
}
else if(isset($_GET['submit']))
    {
        $metai = $_GET['metai'];
        $men = $_GET['men'];
        $k = 0;
        $rez = [];
        for ($i = 1;$i <= 31;$i++) {
            $rezKiekis = mysqli_query($dbc,"SELECT COUNT(id_Rezervacija) AS kiekis FROM rezervacija WHERE YEAR(data)='$metai' and MONTH(data)='$men' and DAY(data)='$i'");
            $row3 = mysqli_fetch_assoc($rezKiekis);
            $average = $row3['kiekis'];
            $rez[$i] = $average;
        }
    }
else {      //default rodo sausio menesi
    $k = 0;
    $rez = [];
    for ($i = 1;$i <= 31;$i++) {
        $rezKiekis = mysqli_query($dbc,"SELECT COUNT(id_Rezervacija) AS kiekis FROM rezervacija WHERE YEAR(data)=2018 and MONTH(data)=1 and DAY(data)='$i'");
        $row3 = mysqli_fetch_assoc($rezKiekis);
        $average = $row3['kiekis'];
        $rez[$i] = $average;
    }
}

$dataPoints = array(
    array("y" => $rez[1], "label" => "1"),
    array("y" => $rez[2], "label" => "2"),
    array("y" => $rez[3], "label" => "3"),
    array("y" => $rez[4], "label" => "4"),
    array("y" => $rez[5], "label" => "5"),
    array("y" => $rez[6], "label" => "6"),
    array("y" => $rez[7], "label" => "7"),
    array("y" => $rez[8], "label" => "8"),
    array("y" => $rez[9], "label" => "9"),
    array("y" => $rez[10], "label" => "10"),
    array("y" => $rez[11], "label" => "11"),
    array("y" => $rez[12], "label" => "12"),
    array("y" => $rez[13], "label" => "13"),
    array("y" => $rez[14], "label" => "14"),
    array("y" => $rez[15], "label" => "15"),
    array("y" => $rez[16], "label" => "16"),
    array("y" => $rez[17], "label" => "17"),
    array("y" => $rez[18], "label" => "18"),
    array("y" => $rez[19], "label" => "19"),
    array("y" => $rez[20], "label" => "20"),
    array("y" => $rez[21], "label" => "21"),
    array("y" => $rez[21], "label" => "21"),
    array("y" => $rez[22], "label" => "22"),
    array("y" => $rez[23], "label" => "23"),
    array("y" => $rez[24], "label" => "24"),
    array("y" => $rez[25], "label" => "25"),
    array("y" => $rez[26], "label" => "26"),
    array("y" => $rez[27], "label" => "27"),
    array("y" => $rez[28], "label" => "28"),
    array("y" => $rez[29], "label" => "29"),
    array("y" => $rez[30], "label" => "30"),
    array("y" => $rez[31], "label" => "31")
);
?>
<html lang="en">
<head>
    <title>Mainyk</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script>
        window.onload = function () {

            var chart = new CanvasJS.Chart("chartContainer", {

                axisY: {
                    title: "Rezervacijų kiekis"
                },
                axisX: {
                    title: "Diena"
                },
                backgroundColor: 'transparent',
                data: [{
                    type: "line",
                    dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                }]
            });
            chart.render();

        }
    </script>
</head>
<body>
<style>
    html, body {
        background: linear-gradient(to bottom right, #B89685, #F8F4E3);
        color: #636b6f;
        font-family: 'Nunito', sans-serif;
        font-weight: 200;height: 100%;
        background-attachment: fixed;
        font-size: 15px;
        margin: 0;
        background-attachment: fixed;
    }
    select
    {
        background-color: #A1B0AB;
        color: black;
        font-weight: bold;
        font-size: 15px;
        width: 150px;
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

    h2{
        text-align: center;
        font-size: 25px;
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
    <h2>Rezervacijų kiekis per pasirinktą mėnesį</h2>
    <form method = "get">
            <div class="dropdown" required>Pasirinkite metus ir mėnesį
                <select name = "metai">
                    <option value="2018">2018</option>
                    <option value="2019">2019</option>
                </select>
                <select name = "men">
                    <option value="1">Sausis</option>
                    <option value="2">Vasaris</option>
                    <option value="3">Kovas</option>
                    <option value="4">Balandis</option>
                    <option value="5">Gegužė</option>
                    <option value="6">Birželis</option>
                    <option value="7">Liepa</option>
                    <option value="8">Rugpjūtis</option>
                    <option value="9">Rugsėjis</option>
                    <option value="10">Spalis</option>
                    <option value="11">Lapkritis</option>
                    <option value="12">Gruodis</option>
                </select>
                <input name = "submit" type="submit" value="Rodyti">
            </div>
    </form>
<br>
    <div id="chartContainer" style="height: 370px; width: 100%;"></div>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</div>
</body>
</html>