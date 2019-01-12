<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
session_start();

class ImageController extends Controller
{
    public function addNew(request $request)
    {
        $user=$_SESSION['id'];
        $image=$request->file('image');
        $input=$image->getClientOriginalName();
        $destinationPath=public_path('/images');
        $image->move($destinationPath, $input);

        $image2=$request->file('image2');
        if($image2!=null){
        $input2=$image2->getClientOriginalName();
        $destinationPath=public_path('/images');
        $image2->move($destinationPath, $input2);}
        else $input2=null;

        $image3=$request->file('image3');
        if($image3!=null){
        $input3=$image3->getClientOriginalName();
        $destinationPath=public_path('/images');
        $image3->move($destinationPath, $input3);}
        else $input3=null;

        $image4=$request->file('image4');
        if($image4!=null){
        $input4=$image4->getClientOriginalName();
        $destinationPath=public_path('/images');
        $image4->move($destinationPath, $input4);}
        else $input4=null;

        $pavadinimas=$request->input('pavadinimas');
        $aprasymas=$request->input('aprasymas');
        $spalva=$request->input('spalva');
        $tipas=$request->input('tipas');
        $rusis=$request->input('rusis');

        $dbc = mysqli_connect('localhost', 'root', '', 'mainai');
        mysqli_query($dbc, "SET NAMES 'utf8'");
        if (!$dbc) {
            die ("Negaliu prisijungti prie MySQL:" . mysqli_error($dbc));
        }
        else
        {
            $sql3 = "INSERT INTO rubas (foto1, foto2, foto3, foto4, pavadinimas, aprasymas, spalva, tipas, busena, rusis, id_Rubas, fk_Naudotojasid_Naudotojas)
VALUES ('$input', '$input2', '$input3','$input4','$pavadinimas', '$aprasymas', '$spalva', '$tipas', 1,'$rusis', DEFAULT, '$user')";

            if (mysqli_query($dbc, $sql3))
            {
                 echo '
             <script>
             window.onload = function() {
              alert("Drabužis sėkmingai pridėtas");
             location.href=("/mainai/public/catalog");  
            }
             </script>';
              }
            else die ("Klaida įrašant:" . mysqli_error($dbc));
        }
    }

}
