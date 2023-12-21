<?php 
// Bismillahirrahmanirrahim
require_once('check-login.php');
if (!(PHP_VERSION_ID >= 80100)) {
    exit("<div style='font-weight: bold;font-size: 16px;text-align:center;font-family: Arial, Helvetica, sans-serif;'>Google Drive Kütüphanesi En Düşük \">= 8.1.0\" PHP sürümünü gerektirir. Siz " . PHP_VERSION . " Çalıştırıyorsunuz.</div>");
}
if(!file_exists(__DIR__.'/plugins/google_drive/client_json/client_secrets.json')){
exit("<div style='font-weight: bold;font-size: 16px;text-align:center;font-family: Arial, Helvetica, sans-serif;'>Google Drive Hesap Bilgileri içeren \"client_secrets.json\" dosyası mevcut değil</div>");
}
require_once __DIR__.'/plugins/google_drive/vendor/autoload.php';


ob_start();
ini_set('memory_limit', '-1');
ignore_user_abort(true);
set_time_limit(3600); //7200 saniye 120 dakikadır, 3600 1 saat

$client = new Google\Client();
$client->setAuthConfig('plugins/google_drive/client_json/client_secrets.json');
$client->addScope(Google\Service\Drive::DRIVE);
$service = new Google\Service\Drive($client);

    //echo '<pre>' . print_r($_POST, true) . '</pre>';
    //exit;

    function fls()
    {
        ob_end_flush();
        if (ob_get_level() > 0) {ob_flush();}
        flush();
        ob_start();
    }

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    // Dizin içindeki dosyaları ve alt dizinleri listele
    function listFiles($secilen_dizin, $service, $folderId, $path = '') {
    $resultArray = [];
    $results = $service->files->listFiles([
        //'orderBy' => "name",
        'q' => "'$folderId' in parents",
    ]);

    foreach ($results->getFiles() as $file) {
        $filePath = $path . '/' . $file->getName();

        // Eğer dosya bir klasör ise, alt dizinleri listele
        if ($file->mimeType == 'application/vnd.google-apps.folder') {
            $resultArray = array_merge($resultArray, listFiles($secilen_dizin, $service, $file->getId(), $filePath));
            $resultArray[$file->getId()][$file->mimeType] = "/".$secilen_dizin.$filePath;
        }else{
            $resultArray[$file->getId()][$file->mimeType] = "/".$secilen_dizin.$filePath;
        }
    }
    return $resultArray;
    }

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    if(isset($_POST['yerel_den_secilen_dosya']) && isset($_POST['google_drive_dan_secilen_dosya_id'])){

        // Hedef dizin adının sonunda eğik çizgi varsa kaldıralım sonra ekleyelim
        $yerel_hedef = rtrim($_POST['yerel_den_secilen_dosya'], '/');
        // Kaynak googleden seçilen dizin veya dosya adının önünde veya arkasında eğik çizgi varsa kaldıralım
        $google_kaynak = ltrim(rtrim($_POST['google_drive_dan_secilen_dosya_adini_goster'],'/'),'/');
        // Kaynak googleden seçilen dizin veya dosya ID si
        $fileId = $_POST['google_drive_dan_secilen_dosya_id'];

        // Googleden seçilen kaynak dosya ise
        if(pathinfo($google_kaynak, PATHINFO_EXTENSION)){

            $content = $service->files->get($fileId, array("alt" => "media"));
        
            // Dosyaları indirelim
            $handle = fopen(rtrim($yerel_hedef,'/')."/".$google_kaynak, "w+");
            while (!$content->getBody()->eof()) {
                fwrite($handle, $content->getBody()->read(1024));
            }
            fclose($handle);

            echo "<br /><b>Yerel </b> ".$yerel_hedef." <b>dizine</b><br />";
            echo $google_kaynak." <b>[KOPYALANDI]</b>";

        }else{ // Googleden seçilen dizin ise
            // Googleden seçilen dizin adını diziye eklemek için fonksiyona gönderiyoruz
            $secilen_dizin = $google_kaynak;
            $googleden_secilen_dizin_arr[$fileId]['application/vnd.google-apps.folder'] = "/".$google_kaynak;
            $filePathsArray = listFiles($secilen_dizin, $service, $fileId);
            $secilen_googleden_secilen_array = array_merge($googleden_secilen_dizin_arr, $filePathsArray);

/*
    $dosya = fopen ("metin.txt" , "a"); //dosya oluşturma işlemi 
    $yaz = "görev dosyasından\n".print_r($secilen_googleden_secilen_array, true); // Yazmak istediginiz yazı 
    fwrite($dosya,$yaz); fclose($dosya);
*/

            echo "<br /><b>Yerel </b> ".$yerel_hedef." <b>dizine</b><br />";
            foreach($secilen_googleden_secilen_array AS $id => $dosya_tipi_dosya_adi)
            {
                foreach($dosya_tipi_dosya_adi AS $dosya_tipi => $dosya_adi)
                {
                    if( $dosya_tipi == 'application/vnd.google-apps.folder' ){
                        if (!file_exists($yerel_hedef.$dosya_adi)) {
                            mkdir($yerel_hedef.$dosya_adi, 0755, true);
                        }
                    }
                }
            }
////////////////////////////////////////////////////////////////////////////////////////////
            foreach($secilen_googleden_secilen_array AS $id => $dosya_tipi_dosya_adi)
            {
                foreach($dosya_tipi_dosya_adi AS $dosya_tipi => $dosya_adi)
                {
                    if( $dosya_tipi != 'application/vnd.google-apps.folder' ){
                        $content = $service->files->get($id, array("alt" => "media"));
                        // Dosyaları indirelim
                        $handle = fopen($yerel_hedef.$dosya_adi, "w+");
                        while (!$content->getBody()->eof()) {
                            fwrite($handle, $content->getBody()->read(1024));
                        }
                            echo $dosya_adi." <b>[KOPYALANDI]</b><br />";
                    }
                }
            }
            fclose($handle);
        }

    }else{
        echo "Kaynak ve indirilecek dizin seçilmelidir";
    }

?>