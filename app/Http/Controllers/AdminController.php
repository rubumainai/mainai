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
        $sql="update naudotojas set tipas=2 where id_Naudotojas='$id'";
        if(mysqli_query($dbc, $sql))
        {
            echo'
            <script>
            window.onload = function() {
             alert("Naudotojo būsena sėkmingai pakeista");
            location.href=("/mainai/public/problemsList");  
        }
         </script>';
        }
        else die ("Klaida įrašant:" .mysqli_error($dbc));
    }
}