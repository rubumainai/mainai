<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
session_start();

class ItemController extends Controller
{
    public function addTag(request $request){

        $itemID=($request->input('fk'));
        $user=$_SESSION["id"];
        $dbc = mysqli_connect('localhost', 'root', '', 'mainai');
        mysqli_query($dbc, "SET NAMES 'utf8'");
        if (!$dbc) {
            die ("Negaliu prisijungti prie MySQL:" . mysqli_error($dbc));
        }
        else {
            $sql3 = "INSERT INTO zyma(data, id_Zyma, fk_Rubasid_Rubas, fk_Naudotojasid_Naudotojas)
VALUES (CURRENT_DATE , DEFAULT , '$itemID','$user')";

            if (mysqli_query($dbc, $sql3))
            {
                /* echo '
             <script>
             window.onload = function() {
              alert("Žyma sėkmingai pridėta");
             location.href=("/mainai/public/catalog");  */
                return redirect('/catalog');
            }
            // </script>';
            //   }
            else die ("Klaida įrašant:" . mysqli_error($dbc));
        }
    }

    public function removeTag(request $request){

        $itemID=($request->input('fk'));
        $user=$_SESSION["id"];
        $dbc = mysqli_connect('localhost', 'root', '', 'mainai');
        mysqli_query($dbc, "SET NAMES 'utf8'");
        if (!$dbc) {
            die ("Negaliu prisijungti prie MySQL:" . mysqli_error($dbc));
        }
        else {
            $sql3 = "DELETE FROM zyma WHERE fk_Rubasid_Rubas='$itemID'";

            if (mysqli_query($dbc, $sql3))
            {
                /* echo '
             <script>
             window.onload = function() {
              alert("Žyma sėkmingai ištrinta");
             location.href=("/mainai/public/tagsList");  */
                return redirect('/tagsList');
            }
            // </script>';
            //   }
            else die ("Klaida ištrinant:" . mysqli_error($dbc));
        }
    }

    public function removeItem(request $request){

        $itemID=($request->input('fk'));
        $user=$_SESSION["id"];
        $dbc = mysqli_connect('localhost', 'root', '', 'mainai');
        mysqli_query($dbc, "SET NAMES 'utf8'");
        if (!$dbc) {
            die ("Negaliu prisijungti prie MySQL:" . mysqli_error($dbc));
        }
        else {
            $sql3 = "DELETE FROM rubas WHERE id_Rubas='$itemID'";

            if (mysqli_query($dbc, $sql3))
            {
                /* echo '
             <script>
             window.onload = function() {
              alert("Drabužis sėkmingai ištrintas");
             location.href=("/mainai/public/myCatalog");  */
                return redirect('/myCatalog');
            }
            // </script>';
            //   }
            else die ("Klaida ištrinant:" . mysqli_error($dbc));

        }
    }

    public function addToBasket(request $request){

        $itemID=($request->input('fk'));
        $user=$_SESSION["id"];
        $dbc = mysqli_connect('localhost', 'root', '', 'mainai');
        $sql1 = "Select * from rubas where id_Rubas = '$itemID'";
        $data = mysqli_query($dbc, $sql1);
        $row2 = mysqli_fetch_assoc($data);
        $skolintojas = $row2['fk_Naudotojasid_Naudotojas'];
        mysqli_query($dbc, "SET NAMES 'utf8'");
        if (!$dbc) {
            die ("Negaliu prisijungti prie MySQL:" . mysqli_error($dbc));
        }
        else {
            $sql3 = "INSERT INTO rezervacija(data, busena, id_Rezervacija, fk_Naudotojasid_Naudotojas, fk_Rubasid_Rubas, skolintojas)
VALUES (CURRENT_DATE, 3, DEFAULT ,'$user', '$itemID', '$skolintojas')";
           // DB::update('update rubas set busena = ? where id_Rubas = ?', [2 , $itemID]);

            $sql = "UPDATE rubas SET busena='2' WHERE id_Rubas='$itemID'";

            if (mysqli_query($dbc, $sql3) && mysqli_query($dbc, $sql))
            {echo "Įrašyta";
                return redirect('/catalog');
                exit;}
            else die ("Klaida įrašant:" .mysqli_error($dbc));

        }
    }

    public function search(request $request)
    {
        $ieskoti = ($request->input('ieskoti'));
        if (!is_null($ieskoti)) {
            $sql="SELECT * FROM rubas, spalvos, rubu_tipai, rubu_rusys WHERE spalva=id_spalvos and tipas=id_rubu_tipai and rusis=id_rubu_rusys and busena!=3
         and CONCAT(`pavadinimas`, `aprasymas`) LIKE '%" . $ieskoti . "%'";
        }
        else {
            $sql="SELECT * FROM rubas, spalvos, rubu_tipai, rubu_rusys WHERE spalva=id_spalvos and tipas=id_rubu_tipai and rusis=id_rubu_rusys and busena!=3";
        }
        $_SESSION["rez"] = $sql;
        return redirect('/catalog');
    }

    public function filter(request $request)
    {
        $rusis = ($request->input('rusis'));
        $spalva = ($request->input('spalva'));
        $tipas = ($request->input('tipas'));
        if($rusis ==0 && $spalva==0 && $tipas!=0)
        {
            $sql="SELECT * FROM rubas, spalvos, rubu_tipai, rubu_rusys WHERE spalva=id_spalvos and tipas=id_rubu_tipai and rusis=id_rubu_rusys and busena!=3
and tipas = '$tipas'";
        }
        if($rusis ==0 && $spalva!=0 && $tipas==0)
        {
            $sql="SELECT * FROM rubas, spalvos, rubu_tipai, rubu_rusys WHERE spalva=id_spalvos and tipas=id_rubu_tipai and rusis=id_rubu_rusys and busena!=3
and spalva = '$spalva'";
        }
        if($rusis ==0 && $spalva!=0 && $tipas!=0)
        {
            $sql="SELECT * FROM rubas, spalvos, rubu_tipai, rubu_rusys WHERE spalva=id_spalvos and tipas=id_rubu_tipai and rusis=id_rubu_rusys and busena!=3
and tipas = '$tipas' and spalva = '$spalva'";
        }
        if($rusis !=0 && $spalva==0 && $tipas==0)
        {
            $sql="SELECT * FROM rubas, spalvos, rubu_tipai, rubu_rusys WHERE spalva=id_spalvos and tipas=id_rubu_tipai and rusis=id_rubu_rusys and busena!=3
and rusis = '$rusis'";
        }
        if($rusis !=0 && $spalva==0 && $tipas!=0)
        {
            $sql="SELECT * FROM rubas, spalvos, rubu_tipai, rubu_rusys WHERE spalva=id_spalvos and tipas=id_rubu_tipai and rusis=id_rubu_rusys and busena!=3
and tipas = '$tipas' and rusis = '$rusis'";
        }
        if($rusis !=0 && $spalva!=0 && $tipas==0)
        {
            $sql="SELECT * FROM rubas, spalvos, rubu_tipai, rubu_rusys WHERE spalva=id_spalvos and tipas=id_rubu_tipai and rusis=id_rubu_rusys and busena!=3
and rusis = '$rusis' and spalva='$spalva'";
        }
        if($rusis !=0 && $spalva!=0 && $tipas!=0)
        {
            $sql="SELECT * FROM rubas, spalvos, rubu_tipai, rubu_rusys WHERE spalva=id_spalvos and tipas=id_rubu_tipai and rusis=id_rubu_rusys and busena!=3
and tipas = '$tipas' and spalva='$spalva' and rusis='$rusis'";
        }
        if($rusis==0 && $spalva==0 && $tipas==0){
            $sql="SELECT * FROM rubas, spalvos, rubu_tipai, rubu_rusys WHERE spalva=id_spalvos and tipas=id_rubu_tipai and rusis=id_rubu_rusys and busena!=3";
        }
        $_SESSION["rez"] = $sql;
        return redirect('/catalog');
    }

    public function reservations(request $request)
    {
        $patvirtinti = ($request->input('patvirtinti'));
        $atmesti = ($request->input('atmesti'));
        $grazinti = ($request->input('grazinti'));
        $patvirtinti2 = ($request->input('patvirtinti_graz'));
        echo "Patvirtinti:";
        echo $patvirtinti;
        echo "Atmesti:";
        echo $atmesti;
        echo "Grazinti:";
        echo $grazinti;
        echo "Patvirtinti2:";
        echo $patvirtinti2;
        if($patvirtinti!=0)
        {
            $sql = "update rezervacija set busena=1 where id_Rezervacija='$patvirtinti'";
        }
        else if($atmesti!=0)
        {
            $sql = "update rezervacija set busena=2 where id_Rezervacija='$atmesti'";
        }
        else if($grazinti!=0)
        {
            $sql = "update rezervacija set busena=5 where id_Rezervacija='$grazinti'";
        }
        else if($patvirtinti2!=0)
        {
            $sql = "update rezervacija set busena=4 where id_Rezervacija='$patvirtinti2'";
        }
        $dbc = mysqli_connect('localhost', 'root', '', 'mainai');
        if (!$dbc) {
            die ("Negaliu prisijungti prie MySQL:" . mysqli_error($dbc));
        }
        else if(mysqli_query($dbc, $sql))
        {
            return redirect('/personalHistory');
        }
        else die ("Klaida įrašant:" .mysqli_error($dbc));
    }
}
