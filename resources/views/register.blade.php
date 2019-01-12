<?php
session_start();
$_SESSION["login"] = NULL;
?>
<head>
    <title>Mainyk</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
        html, body {
            background: linear-gradient(to bottom right, #B89685, #F8F4E3);
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100%;
            margin: 0;
            background-attachment: fixed;
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
    </style>
</head>
<html>
<body>
<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">Mainyk</a>
        </div>
        <ul class="nav navbar-nav">
            <li class="{{Request::is('/login')?'active':null }}"><a href="{{url('/login')}}">Prisijungti</a></li>
            <li class="{{Request::is('/register')?'active':null }}"><a href="{{url('/register')}}">Registruotis</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li class="{{Request::is('/')?'active':null}}"><a href="{{url('')}}">Atgal į pradžią <span class="glyphicon glyphicon-log-out"></span></a></li>
        </ul>
    </div>
</nav>
<div class="container">
    <div class="col-md-6 col-md-offset-3">
        <form class="" action="{{URL::to('/store')}}" method="post">
            @csrf
            <h2>Vartotojo registracija</h2><br>
            <?php
            if(!empty($_SESSION['error']))
            {
                if (   $_SESSION['error']=='klaida'  )
                {
                    echo "<h4 style='color: red'>Toks vartotojas jau egzistuoja</h4>";
                    $_SESSION['error'] = "";
                }
                if (   $_SESSION['error']=='klaida2'  )
                {
                    echo "<h4 style='color: red'>Neteisingai pakartojote slaptažodį</h4>";
                    $_SESSION['error'] = "";
                }
            }
            ?>
            <h4>Įveskite vardą:</h4>
            <input type="text" name="vardas" class="fields" value="<?php if(!empty($_SESSION['vard'])) {echo $_SESSION['vard'];}?>" required><br>
            <br>
            <h4>Įveskite pavardę:</h4>
            <input type="text" name="pavarde" class="fields" value="<?php if(!empty($_SESSION['pav'])) {echo $_SESSION['pav'];}?>" required><br>
            <br>
            <h4>Įveskite el. pašto adresą:</h4>
            <input type="email" name="el_pastas" class="fields" value="<?php if(!empty($_SESSION['past'])) {echo $_SESSION['past'];}?>" required><br>
            <br>
            <h4>Įveskite gimimo datą:</h4>
            <input type="date" name="gimimo_data" class="fields" value="<?php if(!empty($_SESSION['data'])) {echo $_SESSION['data'];}?>" min="1900-01-01" required><br>
            <br>
            <h4>Įveskite telefono numerį:</h4>
            <input type="text" name="mob_numeris" class="fields" value="<?php if(!empty($_SESSION['tel'])) {echo $_SESSION['tel'];}?>" minlength="9" maxlength="9" required><br>
            <br>
            <h4>Įveskite gyvenamąjį miestą:</h4>
            <input type="text" name="miestas" class="fields" value="<?php if(!empty($_SESSION['miest'])) {echo $_SESSION['miest'];}?>" required><br>
            <br>
            <h4>Įveskite prisijungimo vardą:</h4>
            <input type="text" name="prisijungimo_vardas" class="fields" value="<?php if(!empty($_SESSION['log'])) {echo $_SESSION['log'];}?>" required><br>
            <br>
            <h4>Įveskite slaptažodį:</h4>
            <input type="password" name="slaptazodis" class="fields" value="" required><br>
            <br>
            <h4>Pakartokite slaptažodį:</h4>
            <input type="password" name="slaptazodis2" class="fields" value="" required><br>
            <br>
            <input type=submit name="button" class="button" value="Patvirtinti">
            <br>
        </form>
    </div>
</div>
</body>
</html>