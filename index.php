<?php 
// Bismillahirrahmanirrahim
session_start();
require_once('includes/connect.php');
require_once('check-login.php');
require_once("includes/turkcegunler.php");
##########################################################################################################

    if(!empty($_SESSION["dizitablolar"])){
        unset($_SESSION["dizitablolar"]);
    }

    // Yedeklenecek dizin yoksa oluştur
    if(!file_exists(BACKUPDIR)){
        if (!mkdir(BACKUPDIR, 0777, true)) {
            die('Failed to create folder' .BACKUPDIR);
        }
    }

##########################################################################################################
include('includes/header.php');
include('includes/navigation.php');
include('includes/sub_navbar.php');
?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Web Siteler Yönetimi</h1>
                        </div><!-- / <div class="col-sm-6"> -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="index.php">Anasayfa</a></li>
                                <li class="breadcrumb-item active">Anasayfa</li>
                            </ol>
                        </div><!-- / <div class="col-sm-6"> -->
                    </div><!-- / <div class="row mb-2"> -->
                </div><!-- / <div class="container-fluid"> -->
            </div><!-- / <div class="content-header"> -->

    <!-- Bilgilendirme Satırı Başlangıcı -->
    <section class="content">
    <div class="container-fluid">
        <div class="row mb-2">
        <div class="col-sm-12">
                    <!-- Bilgilendirme bölümü -->
                    <div id="accordion">
                        <div class="card">
                            <div class="card-header" id="headingOne">
                            <h5 class="m-0">
                                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                Web Siste Yönetimi Hakkında Bilmeniz Gerekenler !
                                </button>
                            </h5>
                            </div>

                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                            <div class="card-body">
                                <p>Zaman zaman veritabanı yedeği alınması gerekir, bunun bir çok sebebi olabilir istemeden yapacağınız bir yanlış geri dönülmesi sağlayacağı gibi sitenize başkaları tarafından saldırıda veritabanındaki verilerin silinmesi gibi durumlarda sitenizin geri getirilmesini sağlar. Ancak bu veritabanı yedeklerin arada bir bilgisayarınıza indirmenizde fayda olacaktır.</p>
                                <p>Yedeklenmiş veritabanlarınıza URL ile doğrudan ulaşılması mümkün değil, sadece FTP ile ulaşmak mümkündür. Ancak web sitenize hack gibi durumlar için garanti edilemez.</p>
                                <p><b>ÖNEMLİ NOT:</b> sitenizde riskli değişiklikler ve ayarlamalar yapmadan önce veritabanın yedeğini almanız şiddetle önerilir.</p>
                                <p><b>Yedeklerin bulunduğu dizin: </b><span id="yol"><?php echo strtolower(htmlpath('./'.BACKUPDIR)); ?></span></p>
                            </div>
                            </div>
                        </div><!-- / <div class="card"> -->
                    </div><!-- / <div id="accordion"> -->
        </div><!-- / <div class="col-sm-12"> -->
        </div><!-- / <div class="row mb-2"> -->
    </div><!-- / <div class="container-fluid"> -->
    </section><!-- / <section class="content"> -->
    <!-- Bilgilendirme Satırı Sonu -->



        </div><!-- / <div class="content-wrapper"> -->
        
<script type='text/javascript'>
    var satir = '';
    var query = '';
    var tarih = '';
    var firma = '';
</script>
<?php 
include('includes/footer.php');
?>
