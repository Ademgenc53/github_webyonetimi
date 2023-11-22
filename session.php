<?php
session_start();
    //unset($_SESSION['access_token']);
echo '<body style="padding:50; margin:0; font-family: Arial, Helvetica, sans-serif;">';
    $bloklarin_pano_katlari = [
            "1" => "18,13,7,3",
            "2" => "18,13,7,3",
            "3" => "18,13,7,3",
            "4" => "18,13,7,3",
            "5" => "18,13,7,3",
            "6" => "18,13,7,3",
            "7" => "18,13,7,3",
            "8" => "18,13,7,3",
            "9" => "18,13,7,3",
            "10" => "18,13,7,3"
        ];
foreach ($bloklarin_pano_katlari AS $key => $value){

    $hsecs = explode(",", $value);

    //echo $value."<br>";
/*
    foreach ($value AS $value2){
echo $key2."---".$value2."<br>";
    }
*/
}


//ini_set("display_errors", 0);
echo "\n<strong>SESSION LİSTESİ</strong><br /><br />\n";
echo '<pre>' . print_r($_SESSION, true) . '</pre>';
/*
foreach ( $_SESSION AS $key => $value ){
    echo "<strong>".$key."</strong>: ".$value."<br>\n";
}
*/
echo "\n<br /><br /><strong>COOKIE LİSTESİ</strong><br /><br />\n";
echo '<pre>' . print_r($_COOKIE, true) . '</pre>';
/*
foreach ( $_COOKIE AS $key => $value ){
    echo "<strong>".$key."</strong>: ".$value."<br>\n";
    //setcookie($key, "", time()-2592000); Tüm çerezleri siler
}
*/
//unset($_COOKIE);
//phpinfo();

?>
<h4>Tüm localStrodeki verileri</h4>
<div id="tumlocalstroverileri"></div>
</body>
<script>
    //localStorage.removeItem("autoSavedSql_undefined"); // biriniz sil
    //localStorage.clear(); // Tümünü sil
//console.log("local storage");
fruits = [];
Object.entries(localStorage).forEach(([ key, value ]) => {
    //console.log(`${key} => ${value}`);
    fruits.push(`[${key}] => ${value}<br />`);
});
document.getElementById('tumlocalstroverileri').innerHTML = fruits.join(" ");
</script>
</body>