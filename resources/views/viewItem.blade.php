<?php
session_start();
$id = $_GET['itemid'];
$dbc = mysqli_connect('localhost', 'root', '', 'mainai');
if (!$dbc) {
    die ("Negaliu prisijungti prie MySQL:" . mysqli_error($dbc));
}
    $sql="SELECT * FROM rubas, spalvos, rubu_tipai, rubu_rusys WHERE spalva=id_spalvos and tipas=id_rubu_tipai and rusis=id_rubu_rusys and id_Rubas=$id";
    $result = mysqli_query($dbc, $sql);

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
        height: 100%;
        background-attachment: fixed;
        margin: 0;
    }

    img{
        height: 300px;
        width: 300px;
    }

    button
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
<div class="container">
    <?php
    $row = mysqli_fetch_array($result); ?>
    <h3><?php echo $row['pavadinimas']; ?></h3><br>
    <h4><img src="../public/images/<?php echo $row['foto1']?>"></h4>
    <h4><?php echo $row['aprasymas']; ?></h4><br>
    <h4>Spalva <?php echo $row['name']; ?></h4><br>
    <h4>Rūšis <?php echo $row['rname']; ?></h4><br>
    <h4>Tipas <?php echo $row['tname']; ?></h4><br>
        <form class="" action="{{URL::to('/addToBasket')}}" method="post">
            @csrf
            <input type="hidden" name="fk" value="{{$id}}">
            <button type=submit name="button" <?php if ($row['busena'] != '1'){ ?> disabled <?php   } ?>>Rezervuoti</button> 
        </form>
        <form class="" action="{{URL::to('/addTag')}}" method="post">
            @csrf
            <input type="hidden" name="fk" value="{{$id}}">
            <button type=submit name="button">Pažymėti</button>
        </form>
</div>
</body>
</html>