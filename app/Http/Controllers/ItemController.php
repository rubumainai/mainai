<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Null_;

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

            $sql1="select * from zyma where fk_Naudotojasid_Naudotojas = '$user' and fk_Rubasid_Rubas='$itemID'";
            $data = mysqli_query($dbc, $sql1);
            $row = mysqli_fetch_assoc($data);
            if (!is_null($row['data']))
            {
                echo '
            <script>
            window.onload = function() {
             alert("Tokia žyma jau egzistuoja");
            location.href=("/mainai/public/catalog");  
        }
         </script>';
                die;
            }
            $sql3 = "INSERT INTO zyma(data, id_Zyma, fk_Rubasid_Rubas, fk_Naudotojasid_Naudotojas)
VALUES (CURRENT_DATE , DEFAULT , '$itemID','$user')";

            if (mysqli_query($dbc, $sql3)) {
                echo '
            <script>
            window.onload = function() {
             alert("Žyma sėkmingai pridėta");
            location.href=("/mainai/public/catalog");  
        }
         </script>';
            }
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
            //$sql3 = "DELETE FROM rubas WHERE id_Rubas='$itemID'";
            $sql3 = "UPDATE rubas SET busena='3' WHERE id_Rubas='$itemID'";

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
        if($row2['busena']==2 || $row2['busena']==3 || $row2['fk_Naudotojasid_Naudotojas']==$user)
        {
            echo'
            <script>
            window.onload = function() {
             alert("Rūbo rezervacija negalima");
            location.href=("/mainai/public/catalog");  
        }
         </script>';
            die;
        }
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
            {
                echo'
            <script>
            window.onload = function() {
             alert("Rūbo rezervacija sėkminga");
            location.href=("/mainai/public/catalog");  
        }
         </script>';
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
        $valyti = ($request->input('valyti'));
        $_SESSION["tipas"] = $tipas;
        $_SESSION["spalva"] = $spalva;
        $_SESSION["rusis"] = $rusis;
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
        if($rusis==0 && $spalva==0 && $tipas==0 || $valyti!=null){
            $_SESSION["tipas"] = NULL;
            $_SESSION["spalva"] = NULL;
            $_SESSION["rusis"] = Null;
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
        $rubas = ($request->input('rubas'));
        if($patvirtinti!=0)
        {
            $sql = "update rezervacija set busena=1 where id_Rezervacija='$patvirtinti'";
        }
        else if($atmesti!=0)
        {
            $sql = "update rezervacija set busena=2 where id_Rezervacija='$atmesti'";
            $sql1 = "update rubas set busena=1 where id_Rubas = '$rubas'";
            $dbc2 = mysqli_connect('localhost', 'root', '', 'mainai');
            if(!mysqli_query($dbc2, $sql1))
            {
                die;
            }
        }
        else if($grazinti!=0)
        {
            $sql = "update rezervacija set busena=5 where id_Rezervacija='$grazinti'";
        }
        else if($patvirtinti2!=0)
        {
            $sql = "update rezervacija set busena=4 where id_Rezervacija='$patvirtinti2'";
            $sql1 = "update rubas set busena=1 where id_Rubas = '$rubas'";
            $dbc2 = mysqli_connect('localhost', 'root', '', 'mainai');
            if(!mysqli_query($dbc2, $sql1))
            {
             die;
            }
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
