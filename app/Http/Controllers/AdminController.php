<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function unblock(request $request)
    {
        $id=$request->input('button');
        $dbc = mysqli_connect('localhost', 'root', '', 'mainai');
        mysqli_query($dbc,"SET NAMES 'utf8'");
        if (!$dbc) {
            die ("Negaliu prisijungti prie MySQL:" . mysqli_error($dbc));
        }
        $sql="update naudotojas set tipas=1 where id_Naudotojas='$id'";
        if(mysqli_query($dbc, $sql))
        {
            echo'
            <script>
            window.onload = function() {
             alert("Naudotojo būsena sėkmingai pakeista");
            location.href=("/mainai/public/blockedUsersList");  
        }
         </script>';
        }
        else die ("Klaida įrašant:" .mysqli_error($dbc));
    }

    public function block(request $request)
    {
        $id=$request->input('button');
        $dbc = mysqli_connect('localhost', 'root', '', 'mainai');
        mysqli_query($dbc,"SET NAMES 'utf8'");
        if (!$dbc) {
            die ("Negaliu prisijungti prie MySQL:" . mysqli_error($dbc));
        }

        $sql1="select * from rubas where fk_Naudotojasid_Naudotojas = '$id' and busena=2";
        $data = mysqli_query($dbc, $sql1);
        $row = mysqli_fetch_assoc($data);
        $sql2="select * from rezervacija where fk_Naudotojasid_Naudotojas = '$id'  and busena!=2 and busena!=4 or skolintojas = '$id' and busena!=2 and busena!=4";
        $data2 = mysqli_query($dbc, $sql2);
        $row2 = mysqli_fetch_assoc($data2);
        if (!is_null($row['pavadinimas']) || !is_null($row2['data']))
        {
            echo '
            <script>
            window.onload = function() {
             alert("Naudotojas turi aktyvių rezervacijų, blokuoti negalima");
            location.href=("/mainai/public/problemsList");  
        }
         </script>';
            die;
        }
        $sql3 = "update rubas set busena = 3 where fk_Naudotojasid_Naudotojas='$id'";
        if(mysqli_query($dbc, $sql3))
        {
            $sql="update naudotojas set tipas=2 where id_Naudotojas='$id'";
            if(mysqli_query($dbc, $sql))
            {
                echo '
            <script>
            window.onload = function() {
             alert("Naudotojo būsena sėkmingai pakeista");
            location.href=("/mainai/public/problemsList");  
        }
         </script>';
            }
            else die ("Klaida įrašant:" .mysqli_error($dbc));
        }
        else die ("Klaida įrašant:" .mysqli_error($dbc));
    }
}