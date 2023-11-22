<?php 
// Bismillahirrahmanirrahim
session_start();
require_once('includes/connect.php');
require_once('check-login.php');
require_once("includes/turkcegunler.php");



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
                                <li class="breadcrumb-item active">Dashboard v3</li>
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
                                Veritabanı Geri Yükleme Hakkında Bilmeniz Gerekenler !
                                </button>
                            </h5>
                            </div>

                            <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                            <div class="card-body">
                                <p>Buradan daha önce yedeklediğiniz veri tabanı veya tabloları geri yükleyebilirsiniz</p>
                                <p>Tüm web siteler için geçerli olan herhangi bir saldırı veya yanlışlıkla verilerin silinmesi durumlarda web sitenin geri getirilmesi için zaman zaman belirli aralıklarda veri tabanı yedeklenmesi gerekir.</p>
                                <p>Bu script hem veri tabanı yedekleme hem de geri yükleme imkanı sağlamaktadır.</p>
                                <p>Yönetim panelinde ayarları değiştirme ve veya ürünleri ekleme ve veya silme gibi çalışmalara başlamadan önce veri tabanını yedeklemenizi öneririz hatta tabloları ayrı ayrı yedekleme seçeneğini kullanarak yedeklemenizi öneririz</p>
                                <p>Tabloları ayrı ayrı yedeklemenin avantajı tüm veri tabını geri yükleme yerine geri getirmek istediğiniz bir veya birden fazla tabloları ayrı ayrı geri yükleme imkanı sağlamasıdır.</p>
                                <p>Buradan yedeklerinizi geri yükleme yapabileceğiniz gibi DENEME MODUNDA yükleme yaparak alınan yedeğin geri yüklemede herhangi bir sorun çıkarıp çıkarmayacağını yani yedeklemenin sağlıklı yapılıp yapılmadığını da test etmiş olursunuz (yedeğin sorunsuz olduğunu garantilemez).</p>
                                <p><b>Not:</b> Buradan geri yükleme yapıldığında yedeğin içinde mevcut tablo adı ile sunucudaki veri tabanındaki tablo adı ile eşleşenler silinerek yerine yedekten geri yüklenecektir. Eşleşmeyen tablolar ise silinmeden kalacaktır.</p>
                            </div>
                            </div>
                        </div><!-- / <div class="card"> -->
                    </div><!-- / <div id="accordion"> -->
        </div><!-- / <div class="col-sm-12"> -->
        </div><!-- / <div class="row mb-2"> -->
    </div><!-- / <div class="container-fluid"> -->
    </section><!-- / <section class="content"> -->
    <!-- Bilgilendirme Satırı Sonu -->

    <!-- Gövde İçerik Başlangıcı -->
    <section class="content">
    <div class="container-fluid">
        <div class="row mb-2">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body p-0">


                </div><!-- / <div class="card-body p-0"> -->
            </div><!-- / <div class="card"> -->
        </div><!-- / <div class="col-sm-12"> -->
        </div><!-- / <div class="row mb-2"> -->
    </div><!-- / <div class="container-fluid"> -->
    </section><!-- / <section class="content"> -->
    <!-- Gövde İçerik Sonu -->

    <!-- Gövde İçerik Başlangıcı -->
    <section class="content">
    <div class="container-fluid">
        <div class="row mb-2">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body p-0">


                </div><!-- / <div class="card-body p-0"> -->
            </div><!-- / <div class="card"> -->
        </div><!-- / <div class="col-sm-12"> -->
        </div><!-- / <div class="row mb-2"> -->
    </div><!-- / <div class="container-fluid"> -->
    </section><!-- / <section class="content"> -->
    <!-- Gövde İçerik Sonu -->


<br />
        </div><!-- / <div class="content-wrapper"> -->

        

<?php 
include('includes/footer.php');
?>
