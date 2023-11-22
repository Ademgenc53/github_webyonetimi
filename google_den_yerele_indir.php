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
    // Kaynaktan seçilen klasör olmadığını kontrol ediyoruz
    function isDir($dirid, $service) {
        $file = $service->files->get($dirid);
        return array($file->getName(),$file->getMimeType());
    }
    

    if(isset($_POST['yerel_den_secilen_dosya']) && isset($_POST['google_drive_dan_secilen_dosya_id'])){
        // Kaynaktan 
        $kaynak_nedir = isDir($_POST['google_drive_dan_secilen_dosya_id'], $service);

        $fileId = $_POST['google_drive_dan_secilen_dosya_id'];
        // Kaynaktan root veya dizin ID geldi ise ana veya seçilen dizindeki tüm dosya ve klasörleri listele
        $drive_dosyalar_arr = [];
        if(isset($_POST['google_drive_dan_secilen_dosya_id']) && ($_POST['google_drive_dan_secilen_dosya_id'] == 'root' || $kaynak_nedir[1] == 'application/vnd.google-apps.folder')){
            $folderId = $_POST['google_drive_dan_secilen_dosya_id'];
            $results = $service->files->listFiles(array(
                'q' => "'$folderId' in parents"
            ));

            // root daki tüm dosya ve dizinleri diziye alıyoruz
            foreach ($results->getFiles() as $file) {
                $drive_dosyalar_arr[$file->getId()] = $file->getName();
            }


        // Kaynakta root değil de dosya ID si geldi ise diziye alıyoruz
        }elseif(isset($_POST['google_drive_dan_secilen_dosya_id']) && $_POST['google_drive_dan_secilen_dosya_id'] != 'root' && $kaynak_nedir[1] != 'application/vnd.google-apps.folder'){
            // Tek dosya seçildi ise dosya ID ile diziye alıyoruz
            $file = $service->files->get($fileId);
            $drive_dosyalar_arr[$file->getId()] = $file->getName();
        }
//echo '<pre>' . print_r($drive_dosyalar_arr, true) . '</pre>';

        // Oluşturduğumuz dizi ile dosyaları indiriyoruz
        foreach($drive_dosyalar_arr AS $fileId => $fileName)
        {
//echo $fileName."<br>";

            // Dosyayı indir.
            $content = $service->files->get($fileId, array("alt" => "media"));
            // Kaynakta seçilen dizin ise dizinide indir
            $kaynak_dizin = $kaynak_nedir[1] == 'application/vnd.google-apps.folder' && $kaynak_nedir[0] != 'My Drive' ? $kaynak_nedir[0]."/" : "";
            // Hedef dizin adının sonunda eğik çizgi yoksa ekleyelim
            $dirname = substr($_POST['yerel_den_secilen_dosya'], -1) == '/' ? $_POST['yerel_den_secilen_dosya'] : $_POST['yerel_den_secilen_dosya']."/";
            // Yerelde dizin yoksa önce dizin oluşturalım
            if (!is_dir($dirname.$kaynak_dizin))
            {
                mkdir($dirname.$kaynak_dizin, 0755, true);
            }
            // Dosyaları indirelim
            $handle = fopen($dirname.$kaynak_dizin.$fileName, "w+");
            while (!$content->getBody()->eof()) {
                fwrite($handle, $content->getBody()->read(1024));
            }
        // Sonucu ekrana yazalım
        echo "<br /><b>Yerel </b> ".$dirname.$kaynak_dizin." <b>dizine</b><br />";
        echo $fileName." [KOPYALANDI]";
        fls();
        }
        
        fclose($handle);

    }else{
        echo "Kaynak ve indirilecek dizin seçilmelidir";
    }


?>