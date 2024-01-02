<?php 
// Bismillahirrahmanirrahim
session_start();
require_once('includes/connect.php');
require_once('check-login.php');
require_once("includes/turkcegunler.php");

if (!(PHP_VERSION_ID >= 80100)) {
    exit("<div style='font-weight: bold;font-size: 16px;text-align:center;font-family: Arial, Helvetica, sans-serif;'>Google Drive Kütüphanesi En Düşük \">= 8.1.0\" PHP sürümünü gerektirir. Siz " . PHP_VERSION . " Çalıştırıyorsunuz.</div>");
}

if(!file_exists(__DIR__.'/plugins/google_drive/client_json/client_secrets.json')){
exit("<div style='font-weight: bold;font-size: 16px;text-align:center;font-family: Arial, Helvetica, sans-serif;'>Google Drive Hesap Bilgileri içeren \"client_secrets.json\" dosyası mevcut değil</div>");
}
require_once __DIR__.'/plugins/google_drive/vendor/autoload.php';

ob_start();
ini_set('memory_limit', '256M');
ignore_user_abort(true);
set_time_limit(3600); //7200 saniye 120 dakikadır, 3600 1 saat

$client = new Google\Client();
$client->setAuthConfig('plugins/google_drive/client_json/client_secrets.json');
$client->addScope(Google\Service\Drive::DRIVE);
$service = new Google\Service\Drive($client);

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    //echo '<pre>' . print_r($_POST, true) . '</pre>';
    //exit;
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Her yerel alandan googla yükleme kodu
if(isset($_POST['googla_yukle']) && $_POST['googla_yukle'] == '1' && isset($_POST['yerel_den_secilen_dosya']) && !empty($_POST['yerel_den_secilen_dosya']) && isset($_POST['google_drive_dan_secilen_dosya_id']) && !empty($_POST['google_drive_dan_secilen_dosya_id']))
{

##################################################################################################################################
##################################################################################################################################
// Belirli bir klasörde dosya arama
function searchFile($service, $parentId, $fileName) {
    $results = $service->files->listFiles([
        'q' => "name='".$fileName."' and '".$parentId."' in parents",
    ]);

    if (count($results->getFiles()) > 0) {
        return $results->getFiles()[0];
    } else {
        return null;
    }
}
##################################################################################################################################
##################################################################################################################################
##################################################################################################################################
// Klasör ve alt içerikleri yükleme fonksiyonu
function uploadFolder($service, $parentId, $folderPath) {
    GLOBAL $google_hedef_adi;
    $google_hedefadi = $google_hedef_adi == 'root' ? '' : $google_hedef_adi;
    $folderName = basename($folderPath);

    // Klasörün mevcut olup olmadığını kontrol et
    $existingFolder = searchFile($service, $parentId, $folderName);

    if ($existingFolder) {
        $createdFolder = $existingFolder;
    } else {
        // Klasörü oluştur
        $folder = new Google_Service_Drive_DriveFile();
        $folder->setName($folderName);
        $folder->setMimeType('application/vnd.google-apps.folder');
        $folder->setParents([$parentId]);

        $createdFolder = $service->files->create($folder);
    }

    // Klasör içindeki dosyaları yükle
    $files = scandir($folderPath);
    foreach ($files as $file) {
        if ($file != '.' && $file != '..') {
            $filePath = $folderPath . '/' . $file;

            if (is_dir($filePath)) {
                // Eğer dosya bir klasör ise, alt klasörü yükle
                uploadFolder($service, $createdFolder->id, $filePath);
            } else {
                // Eğer dosya bir dosya ise, dosyayı yükle
                $existingFile = searchFile($service, $createdFolder->id, $file);

                if ($existingFile) {
                    // Dosya zaten varsa, üzerine yaz
                    $existing_File = new Google_Service_Drive_DriveFile();
                    $service->files->update($existingFile->getId(), $existing_File, array(
                        'data' => file_get_contents($filePath),
                        'mimeType' => mime_content_type($filePath),
                        'uploadType' => 'media'
                    ));
                    $cikti_yolu_adi = str_replace(array(BACKUPDIR, ZIPDIR, DIZINDIR), '', $filePath);
                    echo "<span style='color: red'>Dosyanın üzerine yazma başarılı:</span> ".$google_hedefadi.$cikti_yolu_adi."<br />";
                } else {
                    // Dosya yoksa, yeni dosya oluştur
                    $fileMetadata = new Google_Service_Drive_DriveFile();
                    $fileMetadata->setName($file);
                    $fileMetadata->setParents([$createdFolder->id]);
                    $createdFile = $service->files->create($fileMetadata, [
                        'data' => file_get_contents($filePath),
                        'mimeType' => mime_content_type($filePath),
                        'uploadType' => 'media',
                    ]);
                    $cikti_yolu_adi = str_replace(array(BACKUPDIR, ZIPDIR, DIZINDIR), '', $filePath);
                    echo "<span style='color: blue;'>Başarılı:</span> ".$google_hedefadi.$cikti_yolu_adi."<br />";
                }
            }
        }
    }
}
##################################################################################################################################
##################################################################################################################################
##################################################################################################################################
$yerelden_secilen   = rtrim($_POST['yerel_den_secilen_dosya'], '/');
$google_hedef_id    = $_POST['google_drive_dan_secilen_dosya_id'];
$google_hedef_adi   = $_POST['google_drive_dan_secilen_dosya_adini_goster'];

try {
    searchFile($service, $google_hedef_id, $google_hedef_adi);
} catch (Exception $e) {
    echo 'Yakalanan olağandışı durum mesajı: ';
    echo '<pre>' . print_r(json_decode($e->getMessage(), true), true) . '</pre>';
    echo 'Hata mesajını çözmek için bu linki tıklayın<br /><a target="_blank" href="https://developers.google.com/drive/api/guides/handle-errors?hl=tr">https://developers.google.com/drive/api/guides/handle-errors?hl=tr</a>';
    exit;
}

if(pathinfo($yerelden_secilen, PATHINFO_EXTENSION)){

    $google_hedefadi = $google_hedef_adi == 'root' ? '' : $google_hedef_adi;

    // Kaynak dosya olduğundan dosyayı hedefe yükle
    $dosya_adi = basename($yerelden_secilen);
    $existingFile = searchFile($service, $google_hedef_id, $dosya_adi);

    if($existingFile){
        // Dosya zaten varsa, üzerine yaz
        $existing_File = new Google_Service_Drive_DriveFile();
        $service->files->update($existingFile->getId(), $existing_File, array(
            'data' => file_get_contents($yerelden_secilen),
            'mimeType' => mime_content_type($yerelden_secilen),
            'uploadType' => 'media'
        ));
        echo "<span style='color: red'>Dosyanın üzerine yazma başarılı:</span> ".$google_hedefadi."/".$dosya_adi."<br />";
    }else{
        // Dosya yoksa, yeni dosya oluştur
        $fileMetadata = new Google_Service_Drive_DriveFile();
        $fileMetadata->setName($dosya_adi);
        $fileMetadata->setParents([$google_hedef_id]);
        $createdFile = $service->files->create($fileMetadata, [
            'data' => file_get_contents($yerelden_secilen),
            'mimeType' => mime_content_type($yerelden_secilen),
            'uploadType' => 'media',
        ]);
        echo "<span style='color: blue;'>Başarılı:</span> ".$google_hedefadi."/".$dosya_adi."<br />";
    }
}else{
    // Kaynak klasör olduğundan fonksiyonu çağırarak dosyaları yükle
    uploadFolder($service, $google_hedef_id, $yerelden_secilen);
}
##################################################################################################################################
##################################################################################################################################
##################################################################################################################################
##################################################################################################################################
##################################################################################################################################
##################################################################################################################################
##################################################################################################################################
##################################################################################################################################
}else if(isset($_POST['ftpye_yukle']) && $_POST['ftpye_yukle'] == '1' && isset($_POST['yerel_den_secilen_dosya']) && !empty($_POST['yerel_den_secilen_dosya']) && isset($_POST['ftp_den_secilen_dosya']) && !empty($_POST['ftp_den_secilen_dosya']))
{

$ftp_server = $genel_ayarlar['sunucu'];
$ftp_user   = $genel_ayarlar['username'];
$ftp_pass   = $genel_ayarlar['password'];

// Bağlantı oluştur
$conn_id = ftp_ssl_connect($ftp_server);

// Giriş yap
$login_result = ftp_login($conn_id, $ftp_user, $ftp_pass);
ftp_pasv($conn_id, true);

function ftp_mksubdirs($ftp,$ftpbasedir,$ftpath){
   @ftp_chdir($ftp, $ftpbasedir); // /var/www/uploads sunucudaki dizin yani başlama dizin ancak biz null girdik
   $parts = array_filter(explode('/',$ftpath)); // 2013/06/11/username buda yeni dizi veya dizinler
   foreach($parts as $part){
      if(!@ftp_chdir($ftp, $part) && ftp_nlist($ftp, $part) === false){
         ftp_mkdir($ftp, $part);
         ftp_chmod($ftp, 0755, $part);
         ftp_chdir($ftp, $part);
      }
   }
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function yukleDosyalar($conn_id, $yerel_dizin, $ftp_dizin, $secilen_yol) {

    $dosyalar = scandir($yerel_dizin);

    foreach ($dosyalar as $dosya) {
        if ($dosya != '.' && $dosya != '..') {
            $yerel_dosya_yolu = $yerel_dizin ."/". $dosya;
            $uzak_dosya_yolu = $dosya;

            if (is_dir($yerel_dosya_yolu)) {
                // Eğer bir dizinse, önce o dizine geç ve ardından dosyaları yükle
                if (!@ftp_chdir($conn_id, $uzak_dosya_yolu)) {
                    ftp_mkdir($conn_id, $uzak_dosya_yolu);
                    ftp_chdir($conn_id, $uzak_dosya_yolu);
                }
                yukleDosyalar($conn_id, $yerel_dosya_yolu, $ftp_dizin, $secilen_yol);
                ftp_chdir($conn_id, '..');

            } else {
                // Eğer bir dosyaysa, dosyayı yükle
                if (ftp_put($conn_id, $uzak_dosya_yolu, $yerel_dosya_yolu, FTP_BINARY)) {
                    $yerel_dosyayolu = str_replace(array(BACKUPDIR, ZIPDIR, DIZINDIR), array($ftp_dizin), $yerel_dosya_yolu);
                    echo "<span style='color: blue;'>Başarılı:</span> ".$ftp_dizin."/".substr($yerel_dosya_yolu, strpos($yerel_dosya_yolu, basename($secilen_yol)), null)."<br />";
                } else {
                    echo "<span style='color: red;'>Başarısız:</span> ".$ftp_dizin."/".substr($yerel_dosya_yolu, strpos($yerel_dosya_yolu, basename($secilen_yol)), null)."<br />";
                }
            }
        }
    }
}

if ($login_result) {
    //echo "FTP sunucusuna başarıyla bağlandı ve giriş yapıldı.<br><br>";
    $yerel_dizin = rtrim($_POST['yerel_den_secilen_dosya'], '/');

    // Kaynak dosya ise
    if(pathinfo($yerel_dizin, PATHINFO_EXTENSION)){
    // FTP dizinin başında ve sonunda eğik çizgi olmalıdır
    $ftp_dizin = "/".ltrim(rtrim($_POST['ftp_den_secilen_dosya'], '/'), '/')."/";
        // FTP den dizin seçildi ise ve oluşturmayan dizin varsa önce oluştur
        if($ftp_dizin != '/'){
            ftp_mksubdirs($conn_id,null,$ftp_dizin);
        }
        // Eğer bir dosyaysa, dosyayı yükle
        $ciktiyolu = ltrim($ftp_dizin.basename($yerel_dizin),'/');
        if (ftp_put($conn_id, $ftp_dizin.basename($yerel_dizin), $yerel_dizin, FTP_BINARY)) {
            echo "<span style='color: blue;'>Başarılı:</span> ".$ciktiyolu."<br />";
        } else {
            echo "<span style='color: red;'>Başarısız:</span> ".$ciktiyolu."<br />";
        }
    }else{ // Kaynak klasör ise
    $ftp_dizin = ltrim(rtrim($_POST['ftp_den_secilen_dosya'], '/'), '/'); // Seçilen dizin olduğu için ve seçilen dizinide göndermek için basename() ile ftp dizine ekliyoruz
        // FTP sunucuda dizin kontrolü yap
        if (!@ftp_chdir($conn_id, $ftp_dizin."/".basename($yerel_dizin))) {
            // Dizin yoksa oluştur
            $dizinler = array_filter(explode('/', $ftp_dizin."/".basename($yerel_dizin)));
            foreach ($dizinler as $dizin) {
                if (!@ftp_chdir($conn_id, $dizin)) {
                    ftp_mkdir($conn_id, $dizin);
                    ftp_chmod($conn_id, 0755, $dizin);
                    ftp_chdir($conn_id, $dizin);
                }
            }
        }
        // Yerel dizinindeki dosyaları FTP sunucuya yükle
        yukleDosyalar($conn_id, $yerel_dizin, $ftp_dizin, $secilen_yol=$yerel_dizin);
        echo "<b>Tüm dosyalar FTP sunucusuna başarıyla yüklendi</b>";
    }
    // Bağlantıyı kapat
    ftp_close($conn_id);
} else {
    echo "FTP sunucusuna bağlanırken bir hata oluştu.<br>";
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

}
?>