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
ini_set('memory_limit', '-1');
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
                        'data' => $filePath,
                        'mimeType' => mime_content_type($filePath),
                        'uploadType' => 'multipart'
                    ));
                    $cikti_yolu_adi = str_replace(array(BACKUPDIR, ZIPDIR, DIZINDIR), '', $filePath);
                    echo "<span style='color: red'>Dosyanın üzerine yazıldı:</span> ".$google_hedefadi."/".$cikti_yolu_adi."<br />";
                } else {
                    // Dosya yoksa, yeni dosya oluştur
                    $fileMetadata = new Google_Service_Drive_DriveFile();
                    $fileMetadata->setName($file);
                    $fileMetadata->setParents([$createdFolder->id]);
                    $createdFile = $service->files->create($fileMetadata, [
                        'data' => $filePath,
                        'mimeType' => mime_content_type($filePath),
                        'uploadType' => 'multipart',
                    ]);
                    $cikti_yolu_adi = str_replace(array(BACKUPDIR, ZIPDIR, DIZINDIR), '', $filePath);
                    echo "<span style='color: blue;'>Dosya yüklendi:</span> ".$google_hedefadi."/".$cikti_yolu_adi."<br />";
                }
            }
        }
    }
}
##################################################################################################################################
##################################################################################################################################
##################################################################################################################################
$yerelden_secilen = rtrim($_POST['yerel_den_secilen_dosya'], '/');
$google_hedef_id = $_POST['google_drive_dan_secilen_dosya_id'];
$google_hedef_adi = $_POST['google_drive_dan_secilen_dosya_adini_goster'];

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
            'data' => $dosya_adi,
            'mimeType' => mime_content_type($yerelden_secilen),
            'uploadType' => 'multipart'
        ));
        echo "<span style='color: red'>Dosyanın üzerine yazıldı:</span> ".$google_hedefadi."/".$dosya_adi."<br />";
    }else{
        // Dosya yoksa, yeni dosya oluştur
        $fileMetadata = new Google_Service_Drive_DriveFile();
        $fileMetadata->setName($dosya_adi);
        $fileMetadata->setParents([$google_hedef_id]);
        $createdFile = $service->files->create($fileMetadata, [
            'data' => $dosya_adi,
            'mimeType' => mime_content_type($yerelden_secilen),
            'uploadType' => 'multipart',
        ]);
        echo "<span style='color: blue;'>Dosya yüklendi:</span> ".$google_hedefadi."/".$dosya_adi."<br />";
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
}else
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST['ftpye_yukle']) && $_POST['ftpye_yukle'] == '1' && isset($_POST['yerel_den_secilen_dosya']) && !empty($_POST['yerel_den_secilen_dosya']) && isset($_POST['ftp_den_secilen_dosya']) && !empty($_POST['ftp_den_secilen_dosya']))
{

//r10.net fatal
    $ftp_directory = "";

    $ftpsunucu      =  $genel_ayarlar['sunucu'];
    $ftpusername    =  $genel_ayarlar['username'];
    $ftppass        =  $genel_ayarlar['password'];

    // Yerelden kaynak dosya değişkene alıyoruz
    $yuklenecek_dizin_veya_dosya = $_POST['yerel_den_secilen_dosya'];
    // Yerelden kaynak dosya mı klasör mu kontrol ediyoruz
    if(is_dir($yuklenecek_dizin_veya_dosya)){
        $ftp_directory = "/".str_replace(BACKUPDIR.'/', '', $yuklenecek_dizin_veya_dosya); // Dizi yolundaki BACKUPDIR dizin yüklenmesi diye çıkarıyoruz
    }else{
        $ftp_directory = "/".str_replace(BACKUPDIR.'/', '', $yuklenecek_dizin_veya_dosya); // Dizi yolundaki BACKUPDIR dizin yüklenmesi diye çıkarıyoruz
    }

    $ftp = @ftp_ssl_connect($ftpsunucu)
            or die($ftpsunucu . " sunucuya bağlanamadı");
    $login_result = ftp_login($ftp, $ftpusername, $ftppass);
    ftp_pasv($ftp, true);

    if((!$ftp) || (!$login_result))
    {
        echo "FTP'ye bağlanamıyorum!";
        die();
    }

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

function kaynakKlasoruOku($directory_name) {

  global $current_directory,$full_directory,$ftp_directory,$ftp,$basarili,$arrow,$basarisiz;

    if(!empty($ftp_directory)){
        ftp_mksubdirs($ftp,null,$ftp_directory);
    }
 
  chdir($directory_name."/"); // PHP'nin geçerli dizinden belirtilen dizin'e geçmesini sağlar. 
  $directory  =  opendir(".");

  while($row = readdir($directory)) {
    if ($row != '.' and $row != '..' and $row != "Thumbs.db") {
        $tamyol = "$directory_name/$row";

        $lokalkla = str_replace("".$current_directory."/","",$directory_name)."";
        $lokaldosya = "$lokalkla/$row";
        $ftp_upload = str_replace(array("\\\\","/"),array("/","/"),"$ftp_directory".str_replace("".$full_directory."","",$directory_name)."/$row");

        if(!is_dir($row)) {
            $yükleme = @ftp_put($ftp, $ftp_upload, $tamyol, FTP_BINARY); // FTP ile dosyaları uzak sunucuya yükler

          if ($yükleme) {

          }else{

          }
        }else{
            // Gönderilen dizin ise önce dizin oluşturuyoruz
            // Eğer aynı dizin varsa }else{ ile dizin oluşturmayı atlıyoruz ve dosyaları yüklüyoruz
            if(@ftp_mkdir($ftp, $ftp_upload)){
                ftp_chmod($ftp, 0755, $ftp_upload);    
                ftp_chdir($ftp, $ftp_upload);
                kaynakKlasoruOku("$directory_name/$row");
                chdir($directory_name."/");
                //fls();
            }else{
                kaynakKlasoruOku("$directory_name/$row");
                chdir($directory_name."/");             
            }
        }
    }
  }
  closedir ($directory);
} // function kaynakKlasoruOku($directory_name) {

    $current_directory = getcwd();
    $full_directory = $current_directory."/$yuklenecek_dizin_veya_dosya";

    // Gönderilecek dosya tek dosyasımı kontrol ediyoruz
    if(!is_dir($yuklenecek_dizin_veya_dosya)){
/*
    $uzaksunucudosyayolu = "";
    if(!empty($ftp_directory)){
        ftp_mksubdirs($ftp,null,$ftp_directory);
        $uzaksunucudosyayolu = $ftp_directory."/";
    }
*/
        // Tek seçilen dosyayı yüklemek için
        $upload = @ftp_put($ftp, basename($yuklenecek_dizin_veya_dosya), $yuklenecek_dizin_veya_dosya, FTP_BINARY); // FTP ile dosyaları uzak sunucuya yükler

        if ($upload) {
            echo "<div style='font-size: 14px;text-align:center;'><strong>".basename($ftp_directory)."</strong> Dosya Başarıyla FTP'ye Yüklendi</div>";
        } else {
            echo "<div style='font-size: 14px;text-align:center;'><strong>".basename($ftp_directory)."</strong> Dosya Bir Hatadan Dolayı FTP'ye Yüklenemedi</div>";
        }
        
    }else if(is_dir($yuklenecek_dizin_veya_dosya)){

        kaynakKlasoruOku($full_directory);
        echo "<div style='font-size: 14px;text-align:center;'><strong>".basename($ftp_directory)."</strong> Dizin Başarıyla FTP'ye Yüklendi</div>";
    }
    ftp_close($ftp);

}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

?>