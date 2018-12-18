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
        </style>
</head>
<html>
<body>

<div class="container">
    <div class="col-md-6 col-md-offset-3">
        <h2>Vartotojo prisijungimas </h2><br>
        <form class="" action="{{URL::to('/logs')}}" method="post">
            @csrf
            <h4>Įveskite prisijungimo vardą:</h4>
            <input type="text" placeholder="Įveskite prisijungimo vardą" name="prisijungimo_vardas" value="" required> <br>
            <br>
            <h4>Įveskite slaptažodį:</h4>
            <input type="password" name="slaptazodis" placeholder="Įveskite slaptažodį" value="" required>
            <br><br>
            <button type=submit name="button">Prisijungti</button>
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
