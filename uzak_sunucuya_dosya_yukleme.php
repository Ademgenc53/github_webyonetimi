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
    // Upload the file to the specified directory
    // Sadece tek dosya yükleme fonksiyonu
    function insertFile($service, $parentId, $filename) {
        $file = new Google_Service_Drive_DriveFile();
        $file->setName(basename($filename));
        $file->setMimeType(mime_content_type($filename));
        $parentId = !empty($parentId) ? $parentId : null;
        $file->setParents(array($parentId));
        try {
            $data = file_get_contents($filename);
            $createdFile = $service->files->create($file, array(
            'data' => $data,
            'mimeType' => mime_content_type($filename),
            ));
            // Uncomment the following line to print the File ID
            // print 'File ID: %s' % $createdFile->getId();
            return $createdFile->getName();
        } catch (Exception $e) {
            print "Tek dosya yükleme fonsiyonun da bir hata oluştu: " . $e->getMessage();
        }
    }
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Klasör veya Dosya var mı yokmu kontrolu yapan fonksiyon
    function dir_exists($fileid, $service) {
        $folderId = $fileid;
        $results = $service->files->listFiles(array(
            'q' => "'$folderId' in parents"
        ));
        $klasorler_dizi = [];
        foreach ($results->getFiles() as $file) {
            $klasorler_dizi[$file->getId()] = $file->getName();
        }
        return $klasorler_dizi;
    }
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Yerelden gelen kaynak klasör ise bu fonksiyondan dizin yolu parçalayıp
    // dizin oluşturmak için bir alttaki fonksiyona gönderiyoruz dosya ise
    // yüklemek için iki üsteki fonksiyona gönderiyoruz
    function createDirectoryPath($service, $source_selected, $parentId = 'root') {
        // Dizinler varsa parçala
        $source = str_replace(array('../', './', BACKUPDIR.'/'), '', $source_selected); //Eğer dizin yolunda BACKUPDIR varsa bu dizini oluşturma
        $directories = explode('/', $source);

            foreach ($directories as $directory) {
                // Sıradaki döngü "$directory" ile parçalanan dizinin son öğesi ile aynı mı? ve
                // Tam "$source_selected" kaynağın son öğesi dizin mi 
                // Sıradaki döngü öğe ile dizinin son öğesi aynı ve kaynağın son öğesi dosya ise yükle
                if($directory == end($directories) && !is_dir($source_selected))
                {
                    // Dosya yüklemek için tam dosya yolu lazım olduğu "$source_selected" kullanıyoruz
                    $dizinveyadosyavarmi = dir_exists($parentId, $service);
                    if(!in_array($directory, $dizinveyadosyavarmi))
                    {
                    insertFile($service, $parentId, $source_selected);
                    }
                }
                else
                {
                    // Dizin ve alt dizinleri oluşturuyoruz
                    $dizinveyadosyavarmi = dir_exists($parentId, $service);

                    //echo '<pre>' . print_r($dizinveyadosyavarmi, true) . '</pre>';
                    if(in_array($directory, $dizinveyadosyavarmi))
                    {
                        $dizinveyadosyavarmi = array_flip($dizinveyadosyavarmi);
                        $parentId = $dizinveyadosyavarmi[$directory];
                    }
                    else
                    {
                        $parentId = createSubdirectory($service, $parentId, $directory);
                    }
                }
            }
            return $parentId; // Oluşturulan son klasörün ID si
    }
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Bir üsteki fonksiyondan gelecek dizin adı ile dizin oluşturma fonksiyonu
    function createSubdirectory($service, $parentId, $subdirectoryName) {
        $fileMetadata = new Google_Service_Drive_DriveFile(array(
            'name' => $subdirectoryName,
            'mimeType' => 'application/vnd.google-apps.folder',
            'parents' => $parentId ? array($parentId) : null
        ));

        try {
            $folder = $service->files->create($fileMetadata, array('fields' => 'id'));
            //printf("Klasör ID: %s\n", $folder->id);
            //echo "<br />";
            return $folder->id; // Oluşturulan klasörün ID sini döndür
        } catch (Exception $e) {
            //echo "Bir hata oluştu: " . $e->getMessage();
        }
        return null; // Bir şeyler ters giderse null değerini döndür
    }
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Yerelden gelen kaynağın önce önündeki ve sonundaki eğik çizgilerini kaldırıyoruz
    // Sonra yerelden gelen kaynağın dizin mi yoksa dosya mı kontrolu yapıyoruz
    // Eğer dizin ise döngü ile dizin yolları ile beraber dosyaların listesini oluşturup
    // Her satırı createDirectoryPath() fonksiyona gönderiyoruz
    // Eğer kaynak dosya ise döngüye sokmadan direk createDirectoryPath() fonksiyona gönderiyoruz
    $path = ltrim(rtrim($_POST['yerel_den_secilen_dosya'],'/'),'/');
    $rootId = $_POST['google_drive_dan_secilen_dosya_id'];
    if(is_dir($path)){
        $objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path), RecursiveIteratorIterator::SELF_FIRST);
        //echo "<table border='1'>";
        foreach($objects as $file => $object){
            if (substr($file, -1) != '.' && substr($file, -2) != '..')
            {
                $file = str_replace(array('\\','\\\\','//'), '/', $file);
                //echo $file."<br />";
                createDirectoryPath($service, $file, $rootId);
                //echo "<tr><td>".$file . "</td><td> <b>klasör ve dosyaları başarıyla yüklendi</b></td></tr>"; // Her öğe yükleme donrası mesaj
                //fls();
            }
        }
        //echo "</table>";
        echo "<strong>".str_replace(BACKUPDIR.'/', '', $path) . "</strong> Dizin Başarıyla Google Drive'a Yüklendi"; // Çoklu dosya yükleme tamamlandığında ki mesaj
    }else{
        if(createDirectoryPath($service, $path, $rootId))
        {
            echo "<strong>".basename($path) . "</strong> Dosya Başarıyla Google Drive'a Yüklendi"; // Tek dosya yüklendiğindeki mesaj
        }
    }

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