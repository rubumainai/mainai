<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
session_start();
use Illuminate\Validation;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function store(request $request)     //registracijos duomenis iraso i db
    {
        $vardas=$request->input('vardas');
        $pavarde=$request->input('pavarde');
        $prisijungimo_vardas=$request->input('prisijungimo_vardas');
        $el_pastas=$request->input('el_pastas');
        $slaptazodis=$request->input('slaptazodis');
        $slaptazodis2 = $request->input('slaptazodis2');
        $gimimo_data =$request->input('gimimo_data');
        $miestas =$request->input('miestas');
        $tel =$request->input('mob_numeris');
        $slapt = password_hash($slaptazodis, PASSWORD_DEFAULT);
        if($slaptazodis!=$slaptazodis2)
        {
            $_SESSION["error"]="klaida2";
            return redirect('/register');
        }
        else{
            $dbc = mysqli_connect('localhost', 'root', '', 'mainai');
            mysqli_query($dbc,"SET NAMES 'utf8'");
            if (!$dbc) {
                die ("Negaliu prisijungti prie MySQL:" . mysqli_error($dbc));
            }
            $sql="select * from naudotojas where prisijungimo_vardas='$prisijungimo_vardas' or email = '$el_pastas'";
            $data = mysqli_query($dbc, $sql);
            $row = mysqli_fetch_assoc($data);
            if ( is_null($row['vardas'])) {

                $sql3 = "INSERT INTO naudotojas (vardas,pavarde, email, prisijungimo_vardas, slaptazodis,gimimo_data, miestas, tel, registracijos_data, tipas, id_Naudotojas)
VALUES ('$vardas', '$pavarde', '$el_pastas', '$prisijungimo_vardas', '$slapt','$gimimo_data','$miestas','$tel',CURRENT_DATE , 1, DEFAULT )";

                if (mysqli_query($dbc, $sql3))
                {echo "Įrašyta";
                    return redirect('/login');
                    exit;}
                else die ("Klaida įrašant:" .mysqli_error($dbc));
            }
            else{
                $_SESSION["error"]="klaida";
                return redirect('/register');
            }

        }
    }

    public function logs(request $request)      //paima prisijungimo duomenis is db
    {
        $prisijungimo_vardas=$request->input('prisijungimo_vardas');
        $slaptazodis=$request->input('slaptazodis');
        $dbc=mysqli_connect('localhost','root', '','mainai');
        mysqli_query($dbc,"SET NAMES 'utf8'");
        if(!$dbc){
            die ("Negaliu prisijungti prie MySQL:"	.mysqli_error($dbc));
        }
        $sql="select * from naudotojas where prisijungimo_vardas='$prisijungimo_vardas'";
        $data = mysqli_query($dbc, $sql);
        $row = mysqli_fetch_assoc($data);
        if(is_null($row['vardas']))
        {
            $_SESSION["error"]="klaida";
            return redirect('/login');
        }
        else
        {
            if(password_verify($slaptazodis, $row['slaptazodis']))
            {
                if($row['tipas']==2 || $row['tipas']==3)
                {
                    $_SESSION["error"] = "klaida2";
                    return redirect('/login');
                }
                else
                {
                    $_SESSION["username"] = $prisijungimo_vardas;
                    $_SESSION["password"] = $slaptazodis;
                    $_SESSION["person"] = $row['tipas'];
                    $_SESSION["name"] = $row['vardas'];
                    $_SESSION["surname"] = $row['pavarde'];
                    $_SESSION["el"] = $row['email'];
                    $_SESSION["id"]= $row['id_Naudotojas'];
                    return redirect('/catalog');
                }
            }
            else
            {
                $_SESSION["error"] = "klaida";
                return redirect('/login');
            }
        }
    }

    public function logout()
    {
        $_SESSION["name"] = NULL;
        $_SESSION["surname"] = NULL;
        $_SESSION["el"] = NULL;
        $_SESSION["password"]=NULL;
        $_SESSION["username"]=NULL;
        $_SESSION["id"]= NULL;
        $_SESSION["person"] = NULL;
        return redirect('/login');
    }

    public function continue(request $request)
    {
        if(empty($_SESSION["username"]))
        {
            return redirect('/');
        }
        else{
            return redirect('/courseInfo');
        }

    }

    public function editClient(request $request)
    {
        $id=$request->input('button');
        $vardas=$request->input('vardas');
        $pavarde=$request->input('pavarde');
        $slaptazodis=$request->input('slaptazodis');
        $slaptazodis2 = $request->input('slaptazodis2');
        $miestas =$request->input('miestas');
        $tel =$request->input('mob_numeris');
        $slapt = password_hash($slaptazodis, PASSWORD_DEFAULT);
        if($slaptazodis!=$slaptazodis2)
        {
            $_SESSION["error"]="klaida";
            return redirect('/myProfile');
        }
        else {
            $dbc = mysqli_connect('localhost', 'root', '', 'mainai');
            mysqli_query($dbc, "SET NAMES 'utf8'");
            if (!$dbc) {
                die ("Negaliu prisijungti prie MySQL:" . mysqli_error($dbc));
            }
            if ($slaptazodis != null) {
                $sql = " UPDATE naudotojas
SET vardas = '$vardas', pavarde = '$pavarde', tel = '$tel', miestas = '$miestas', slaptazodis='$slapt' WHERE id_Naudotojas = '$id'";
            } else {
                $sql = " UPDATE naudotojas
SET vardas = '$vardas', pavarde = '$pavarde', tel = '$tel', miestas = '$miestas' WHERE id_Naudotojas = '$id'";
            }
            if (mysqli_query($dbc, $sql)) {
                echo '
            <script>
            window.onload = function() {
             alert("Asmeninių duomenų redagavimas sėkmingas");
            location.href=("/mainai/public/catalog");  
        }
         </script>';
            } else die ("Klaida įrašant:" . mysqli_error($dbc));
        }
    }

    public function deleteUser(request $request)
    {

        $id=$request->input('button');
        $dbc = mysqli_connect('localhost', 'root', '', 'mainai');
        mysqli_query($dbc,"SET NAMES 'utf8'");
        if (!$dbc) {
            die ("Negaliu prisijungti prie MySQL:" . mysqli_error($dbc));
        }
        $sql="update naudotojas set tipas=3 where id_Naudotojas='$id'";
        if(mysqli_query($dbc, $sql))
        {
            $_SESSION["name"] = NULL;
            $_SESSION["surname"] = NULL;
            $_SESSION["el"] = NULL;
            $_SESSION["password"]=NULL;
            $_SESSION["username"]=NULL;
            $_SESSION["id"]= NULL;
            $_SESSION["person"] = NULL;
            return redirect('/');
        }
        else die ("Klaida įrašant:" .mysqli_error($dbc));
    }

    public function addRecomendation(request $request)
    {
        $balas = $request->input('balas');
        $aprasas = $request->input('aprasas');
        $user=$_SESSION['id'];                      //vertintojas
        $userID=($request->input('fk'));      //kuri vertina
        $dbc = mysqli_connect('localhost', 'root', '', 'mainai');
        mysqli_query($dbc, "SET NAMES 'utf8'");
        if (!$dbc) {
            die ("Negaliu prisijungti prie MySQL:" . mysqli_error($dbc));
        }
        else {
            $sql3 = "INSERT INTO rekomendacija(vertinimas, aprasas, id_Rekomendacija, fk_Naudotojasid_Naudotojas, fk_Naudotojasid_Naudotojas1)
VALUES ('$balas' , '$aprasas', DEFAULT , '$userID','$user')";

            if (mysqli_query($dbc, $sql3))
            {
               /* echo '
            <script>
            window.onload = function() {
             alert("Vertinimas sėkmingai pridėtas");
            location.href=("/mainai/public/catalog");  */
                return redirect('/catalog');
        }
        // </script>';
         //   }
            else die ("Klaida įrašant:" . mysqli_error($dbc));
        }
    }

    public function removeRecomendation(request $request)
    {
        $recID=($request->input('fk'));
        $dbc = mysqli_connect('localhost', 'root', '', 'mainai');
        mysqli_query($dbc, "SET NAMES 'utf8'");
        if (!$dbc) {
            die ("Negaliu prisijungti prie MySQL:" . mysqli_error($dbc));
        }
        else {
            $sql3 = "DELETE FROM rekomendacija WHERE id_Rekomendacija='$recID'";

            if (mysqli_query($dbc, $sql3))
            {
                /* echo '
             <script>
             window.onload = function() {
              alert("Vertinimas sėkmingai ištrintas");
             location.href=("/mainai/public/catalog");  */
                return redirect('/catalog');
            }
                // </script>';
                //   }
            else die ("Klaida ištrinant:" . mysqli_error($dbc));
        }
    }

    public function addProblem(request $request)
    {
        $aprasas = $request->input('skundas');
        $user=$_SESSION['id'];                      //vertintojas
        $userID=($request->input('fk'));      //kuri vertina
        $dbc = mysqli_connect('localhost', 'root', '', 'mainai');
        mysqli_query($dbc, "SET NAMES 'utf8'");
        if (!$dbc) {
            die ("Negaliu prisijungti prie MySQL:" . mysqli_error($dbc));
        }
        else {
            $sql3 = "INSERT INTO nusiskundimas(aprasas, id_Nusiskundimas, fk_Naudotojasid_Naudotojas, fk_Naudotojasid_Naudotojas1)
VALUES ('$aprasas', DEFAULT , '$userID','$user')";

            if (mysqli_query($dbc, $sql3))
            {
                /* echo '
             <script>
             window.onload = function() {
              alert("Nusiskundimas sėkmingai pridėtas");
             location.href=("/mainai/public/catalog");  */
                return redirect('/catalog');
            }
            // </script>';
            //   }
            else die ("Klaida įrašant:" . mysqli_error($dbc));
        }
    }
}