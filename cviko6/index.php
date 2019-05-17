<?php
$xml=simplexml_load_file("file.xml");
/*echo $xml->zaznam[0]->den;
echo $xml->zaznam[0]->SKsviatky;*/

//print_r($xml);

// get the HTTP method, path and body of the request
$method = $_SERVER['REQUEST_METHOD'];
//var_dump($method); echo("<br>");
$request = explode('/', trim($_SERVER['PATH_INFO'],'/'));
/*echo $request[0];
echo $request[1];
echo $request[2];
echo $request[3];*/

// create SQL based on HTTP method
switch ($method) {
    case 'GET':

    if($request[0]=="stat" && $request[2]=="datum"){
            if($request[1]=="SK") {
                $tmp = $request[1]."d";
            }
            else{
                $tmp = $request[1];
            }
            for($i=0;$i<=count($xml);$i++){
                //echo $xml->zaznam[$i]->$tmp;
                if ($request[3]==$xml->zaznam[$i]->den ){
                    if (strlen($xml->zaznam[$i]->$tmp)>1)
                        echo "Meniny v ".$request[1]." má ".$xml->zaznam[$i]->$tmp;
                    else echo "V tento den, v " .$request[1]. " nikto neoslavuje meniny";
                    //http://147.175.98.208/zadanie5/index.php/stat/SK/datum/0102
                    //echo $xml->zaznam[$i]->SK;
                }
            }
        }

        if($request[0]=="stat" && $request[2]=="meno") {
            for ($i = 0; $i <= count($xml); $i++) {

                if ($request[1] == "SK" && $xml->zaznam[$i]->{(SKd)}) {
                    //echo"preslo";
                    $tmp2 = $xml->zaznam[$i]->{(SKd)};
                    $menaSk = explode(",", $tmp2);
                    //echo $tmp2;
                    for ($k = 0; $k < count($menaSk);$k++) {
                        if (trim($menaSk[$k]) == $request[3]) {

                            $den=(str_split($xml->zaznam[$i]->den));
                            echo $den[2].$den[3].".".$den[0].$den[1].".";

                            //$find=true;
                            break;
                        }
                        else continue;
                    }
                } elseif ($xml->zaznam[$i]->{($request[1])}) {
                    $tmp = $xml->zaznam[$i]->{($request[1])};
                    echo $tmp;
                    $mena = explode(",", $tmp);
                    for ($j = 0; $j < count($mena); $j++) {
                        if (trim($mena[$j]) == $request[3]) {

                            $den=(str_split($xml->zaznam[$i]->den));
                            echo $den[2].$den[3].".".$den[0].$den[1].".";
                            // $find=true;
                            break;
                        }
                    }
                }
            }
        }
        if($request[0]=="sviatky"){
            $tmp=$request[1].$request[0];
            for($i=0;$i<=count($xml);$i++){
                if($xml->zaznam[$i]->{($tmp)}) {
                    $den=(str_split($xml->zaznam[$i]->den));
                    // echo $den[2].$den[3].".".$den[0].$den[1].".";
                    echo  $den[2].$den[3].".".$den[0].$den[1].". ".$xml->zaznam[$i]->$tmp."<br>";
                    //http://147.175.98.208/zadanie5/index.php/sviatky/SK
                }
                else continue;
            }
        }

        if($request[0]=="pamdni" && $request[1]=="SK" ){
            $tmp=$request[1]."dni";
            for($i=0;$i<=count($xml);$i++){
                if($xml->zaznam[$i]->{($tmp)}) {
                    $den=(str_split($xml->zaznam[$i]->den));

                    echo $den[2].$den[3].".".$den[0].$den[1].". ". $xml->zaznam[$i]->$tmp ."<br>";
                    http://147.175.98.208/zadanie5/index.php/pamdni/SK
                }
                else continue;
            }
        }
        break;

    case 'POST':

        for($i=0;$i<=count($xml);$i++){
            if($request[3]==$xml->zaznam[$i]->den){
                $meno=$request[5];
                if(strlen($xml->zaznam[$i]->SKd)>0){
                    $tmp=$xml->zaznam[$i]->SKd.", ".$meno;
                    $xml->zaznam[$i]->SKd=$tmp;

                }

                $xml->asXML("file.xml");
                echo "ulozilo";
            }
        }
          if($xml->zaznam[$i]->den) {
                echo "preslo";
                $string=$xml->zaznam[$i]->Skd;
                //echo $string;
                $den=$xml->zaznam[$i]->{($request[3])};
                echo $den;
                 echo $den[2].$den[3].".".$den[0].$den[1].".";
                echo  $den[2].$den[3].".".$den[0].$den[1].". ".$xml->zaznam[$i]->$tmp."<br>";
                //http://147.175.98.208/zadanie5/index.php/sviatky/SK
            }
            else continue;


                echo $request[0];
                echo $request[1];
                echo $request[2];

        echo $request[4];
        echo $request[5];

        break;

}

?>