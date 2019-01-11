<?php
session_start();
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
            height: 100vh;
            margin: 0;
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
            width: 100px;
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
        <h2>Naudotojo prisijungimas </h2><br>
        <form class="" action="{{URL::to('/logs')}}" method="post">
            @csrf

            <h4>Įveskite prisijungimo vardą:</h4>
            <input type="text" name="prisijungimo_vardas" class="fields" value="<?php if(isset($_POST["prisijungimo_vardas"])) echo $_POST["prisijungimo_vardas"]; ?>" required> <br>
            <br>
            <h4>Įveskite slaptažodį:</h4>
            <input type="password" name="slaptazodis"  class="fields" value="" required>
            <br><br>
            <input type=submit class="button" name="button" value="Prisijungti">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <?php
            if(!empty($_SESSION['error']))
            {
                if (   $_SESSION['error']=='klaida'  )
                {
                    echo "<h4  style='color: red'>Neteisingai įvestas prisijungimo vardas arba slaptažodis</h4>";
                    $_SESSION['error'] = "";
                }
                else if (   $_SESSION['error']=='klaida2'  )
                {
                    echo "<h4  style='color: red'>Paskyra buvo pašalinta arba užblokuota</h4>";
                    $_SESSION['error'] = "";
                }
            }
            ?>
        </form>
    </div>
</div>
</body>
</html>
