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
        margin: 0;
    height: 100%;
        background-attachment: fixed;
    }

    img {
        width: 150px;
        height: 150px;
    }
    .dropdown2{
        font-size: 17px;
        font-weight: bold;
    }

    input{
        background: transparent;
        border-radius: 12px;
        color: #636b6f;
    }
    input[type="submit"]
    {
        background-color: #A1B0AB;
        color: black;
        font-weight: bold;
        font-size: 15px;
        width: 120px;
        border-radius: 12px;
        font-family: 'Nunito', sans-serif;
    }

    select
    {
        border-radius: 18px;
        background: #b9bbbe;
        width: 200px;
        height: 25px;
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
            <form class="navbar-form navbar-left"  action="{{URL::to('/search')}}" method="post">
                @csrf
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Ieškoti..." name="ieskoti">
                </div>
                <button type="submit" class="btn btn-default btn-sm">
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

<div class="container">
    <form class=""  action="{{URL::to('/filter')}}" method="post">
        @csrf
    <div class="dropdown2" >Rūšis
        <select name="rusis" class="dropdown2" id="rusis">
            <option value="0"></option>
            <option value="1">Vaikiškas</option>
            <option value="2">Vyriškas</option>
            <option value="3">Moteriškas</option>
        </select>
    Spalva
        <select name="spalva" class="dropdown2" id="spalva">
            <option value="0"></option>
            <option value="1">Raudonas</option>
            <option value="2">Geltona</option>
            <option value="3">Mėlyna</option>
            <option value="4">Žalia</option>
            <option value="5">Violetinė</option>
            <option value="6">Oranžinė</option>
            <option value="7">Juoda</option>
            <option value="8">Balta</option>
        </select>
        Tipas
        <select name="tipas" class="dropdown2" id="tipas" value="<?php if(isset($_SESSION["tipas"])) echo $_SESSION["tipas"]; ?>">
            <option value="0"></option>
            <option value="1">Aksesuaras</option>
            <option value="2">Batai</option>
            <option value="3">Rankinė</option>
            <option value="4">Suknelė</option>
            <option value="5">Sijonas</option>
            <option value="6">Kelnės</option>
            <option value="7">Švarkas</option>
            <option value="8">Palaidinė</option>
        </select>
        <input type="submit" name="filtruot" value="Rodyti" placeholder="Rod"></div>
        <br>

    </form>
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
            <?php
            $dbc = mysqli_connect('localhost', 'root', '', 'mainai');
            mysqli_query($dbc,"SET NAMES 'utf8'");
            if (!$dbc) {
                die ("Negaliu prisijungti prie MySQL:" . mysqli_error($dbc));
            }
            else {
                if(!empty($_SESSION["rez"])){
                    $sql=$_SESSION["rez"];}
                else{
                $sql="SELECT * FROM rubas, spalvos, rubu_tipai, rubu_rusys WHERE spalva=id_spalvos and tipas=id_rubu_tipai and rusis=id_rubu_rusys and busena!=3";
               }
                $result = mysqli_query($dbc, $sql);
            }
                    $nr = 1;
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
            </tr>
            <?php $nr++;?>
            <?php endwhile;?>
            </tbody>
        </table>
</div>
</body>
</html>