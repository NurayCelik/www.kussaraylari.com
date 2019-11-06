<?php
ob_start();
session_start();
require_once '../dbconfig.php';
date_default_timezone_set('Europe/Istanbul');

if(!isset($_SESSION['name']))
	{ //If session not registered
	header("location:login.php"); // Redirect to login.php page
	}
	else //Continue to current page
	header( 'Content-Type: text/html; charset=utf-8' );
	
	$timeout = 10*60;//1O MİNUTES 
	if (isset($_SESSION['logged'])){

	  if ($_SESSION['logged'] + 10 * 60 < time()) {

	     // session timed out
	     session_unset();     // unset $_SESSION variable for the run-time 
	     session_destroy();   // destroy session data in storage
	  } else {
	  	$_SESSION['logged'] +=$timeout;
	    // session ok
	 }
}



	$stmt = $DB_con->prepare('SELECT * FROM admintbl ORDER BY admin_id');
	$stmt->execute();
	
	if($stmt->rowCount() >= 0)
	{
	$row=$stmt->fetch(PDO::FETCH_ASSOC);
		if(@extract($row)){
?>		

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="tr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no" />
<title>Kuş Sarayları Blog Yazıları</title>
<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="../bootstrap/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="../bootstrap/css/style.css">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
</head>

<body>
<div class="container boyut">
		<div>
	<img src="../image/admin_images/<?php echo $row['admin_foto']; ?>" class="img-rounded" width="100px" style="float:left;"height="100px" />
		</div>	 
	<div class="yonet">
		 <a class="navbar-brand yonetim_paneli"  href="#"title='Yönetim Paneli'>Yönetim Paneli</a>
        </div>
		<div class="profil">
		<a class="btn btn-default profil_boyut" href="logout.php?durum=exit">Çıkış </a>
	</div>
	 </div>


<div class="container tablo_ust">

		<div class="col-md-4 col-xs-4 tablo_makale" id="tablo">
		  <h5>Site Ayarları</h5>
			<ul id="tablo_orta">
						<a class="navbar-brand tablo_sol" href="index.php"><li>* Anasayfa</li></a>
						<a class="navbar-brand tablo_sol" href="hakkimizda.php"><li>* Hakkımızda Sayfa Duzenle</li></a>
						<a class="navbar-brand tablo_sol" href="makale.php"><li>* Blog Düzenle</li></a>
						<a class="navbar-brand tablo_sol" href="galeri.php"><li>* Galeri Düzenle</li></a>
						<a class="navbar-brand tablo_sol" href="iletisim_ayar.php"><li>* İletişim Bilgileri Düzenle</li></a>
						<a class="navbar-brand tablo_sol" href="sosyal_medya_ayar.php"><li>* Sosyal Medya Düzenle</li></a>
						<a class="navbar-brand tablo_sol" href="duzen.php"><li>* Kullanıcı Hesabı Düzenle</li></a>
						<a class="navbar-brand tablo_sol" href="formdan_gelen.php"><li>* İletişim Formundan Gelen Mesajlar</li></a>

			</ul>		
		</div>
	<div class="col-md-8 col-xs-6" id="duzen_yazi" style="padding-left:80px;">
		<h3>Hoş Geldiniz <?php echo $row['admin_realname']; ?></h3> 
		<br>
		<br>
		
		<p class="page-header">
					Düzenlemelerinizi Site Ayarları Bölümünden Yapabilirsiniz.
		</p>
		
    </div>
    
<br />

<div class="row">
	<?php		     
		}	
	else
	
	{
		?>
        <div class="col-xs-12">
        	<div class="alert alert-warning">
            	<span class="glyphicon glyphicon-info-sign"></span> Veri Bulunamadı ...
            </div>
        </div>
        <?php
	}
	}
?>
</div>	

<div class="row">

<div class="col-md-12 footer_duzen">
  <a href="wwww.ankayazilim.com"><strong> Anka Yazılım	&	©2018 Bütün Hakları Saklıdır.</strong></a>
</div>

</div>


<!-- Latest compiled and minified JavaScript -->
<script src="bootstrap/js/bootstrap.min.js"></script>


</body>
</html>