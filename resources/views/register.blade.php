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
            height: 100%;
            margin: 0;
            background-attachment: fixed;
        }
    </style>
</head>
<html>
<body>

<div class="container">
    <div class="col-md-6 col-md-offset-3">
        <form class="" action="{{URL::to('/store')}}" method="post">
            @csrf
            <h2>Vartotojo registracija</h2><br>
            <h4>Įveskite vardą:</h4>
            <input type="text" name="vardas" placeholder="Įveskite vardą" value="" required><br>
            <br>
            <h4>Įveskite pavardę:</h4>
            <input type="text" name="pavarde" placeholder="Įveskite pavardę" value="" required><br>
            <br>
            <h4>Įveskite el. pašto adresą:</h4>
            <input type="email" name="el_pastas" placeholder="Įveskite el. paštą" value="" required><br>
            <br>
            <h4>Įveskite gimimo datą:</h4>
            <input type="date" name="gimimo_data" placeholder="Įveskite gimimo datą" value="" min="1900-01-01" required><br>
            <br>
            <h4>Įveskite telefono numerį (formatu 86*******):</h4>
            <input type="text" name="mob_numeris" placeholder="Įveskite mob. numerį" value="" minlength="9" maxlength="9" required><br>
            <br>
            <h4>Įveskite gyvenamąjį miestą:</h4>
            <input type="text" name="miestas" placeholder="Įveskite miestą" value="" required><br>
            <br>
            <h4>Įveskite prisijungimo vardą:</h4>
            <input type="text" name="prisijungimo_vardas" placeholder="Įveskite prisijungimo vardą" value="" required><br>
            <br>
            <h4>Įveskite slaptažodį:</h4>
            <input type="password" name="slaptazodis" placeholder="Įveskite slaptažodį" value="" required><br>
            <br>
            <h4>Pakartokite slaptažodį:</h4>
            <input type="password" name="slaptazodis2" placeholder="Pakartokite slaptažodį" value="" required><br>
            <br>
            <button type=submit name="button">Patvirtinti</button>
            <br>
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
        </form>
    </div>
</div>
</body>
</html>