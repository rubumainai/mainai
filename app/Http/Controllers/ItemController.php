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
            {echo "Įrašyta";
                return redirect('/catalog');
                exit;}
            else die ("Klaida įrašant:" .mysqli_error($dbc));

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
            {echo "Ištrinta";
                return redirect('/tagsList');
                exit;}
            else die ("Klaida trinant:" .mysqli_error($dbc));

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
            {echo "Ištrinta";
                return redirect('/myCatalog');
                exit;}
            else die ("Klaida trinant:" .mysqli_error($dbc));

        }
    }

    public function addToBasket(request $request){

        $itemID=($request->input('fk'));
        $user=$_SESSION["id"];
        $dbc = mysqli_connect('localhost', 'root', '', 'mainai');
        mysqli_query($dbc, "SET NAMES 'utf8'");
        if (!$dbc) {
            die ("Negaliu prisijungti prie MySQL:" . mysqli_error($dbc));
        }
        else {
            $sql3 = "INSERT INTO rezervacija(data, busena, id_Rezervacija, fk_Naudotojasid_Naudotojas, fk_Rubasid_Rubas)
VALUES (CURRENT_DATE, 3, DEFAULT ,'$user', '$itemID')";
           // DB::update('update rubas set busena = ? where id_Rubas = ?', [2 , $itemID]);
            $sql = "UPDATE rubas SET busena='2' WHERE id_Rubas='$itemID'";

            if (mysqli_query($dbc, $sql3) && mysqli_query($dbc, $sql))
            {echo "Įrašyta";
                return redirect('/catalog');
                exit;}
            else die ("Klaida įrašant:" .mysqli_error($dbc));

        }
    }
}
