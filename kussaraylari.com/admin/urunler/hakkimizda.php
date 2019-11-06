<?php
ob_start();
session_start();
error_reporting( ~E_NOTICE );
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
		if(isset($_POST['btn_save_updates'])){

			$id                 =   $_GET['edit_id'];//istediğimiz bir id nosu vererek de güncelleme işlemi yapılır. diğer sayfadan gönderilmeden yani..
			$baslik      		=   $_POST['baslik'];
			$giris    			= 	$_POST['giris'];
			$ortak1_ad 			=	$_POST['ortak1_ad'];
			$ortak1_icerik    	= 	$_POST['ortak1_icerik'];
			$ortak2_ad 			=	$_POST['ortak2_ad'];
			$ortak2_icerik      = 	$_POST['ortak2_icerik'];
			
			$update = $DB_con->prepare('UPDATE hakkimizda SET  
				 baslik=:hbaslik,
				 giris =:hgiris,
				 ortak1_ad=:hortak1_ad,
				 ortak1_icerik=:hortak1_icerik,
				 ortak2_ad=:hortak2_ad,
				 ortak2_icerik=:hortak2_icerik 
				 WHERE hakkimizda_id=:hid');
				
				$update->bindParam(':hid',$id);
				$update->bindParam(':hbaslik',$baslik);
				$update->bindParam(':hgiris',$giris);
				$update->bindParam(':hortak1_ad',$ortak1_ad);
				$update->bindParam(':hortak1_icerik',$ortak1_icerik);
				$update->bindParam(':hortak2_ad',$ortak2_ad);
				$update->bindParam(':hortak2_icerik',$ortak2_icerik);
				$result = $update->execute();	
				
			if($result){
				$successMSG = "Güncelleme Başarılı...";
				
				//header("refresh:1;hakkimizda.php?islem=tamam"); 
			}
			else{
				$errMSG = "Güncelleme Gerçekleşmedi!";
			}
		
		
		}
	
	
?>

<?php
	$stmt = $DB_con->prepare('SELECT * FROM admintbl ORDER BY admin_id asc limit 1');
	$stmt->execute();
	while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
		if(@extract($row)){

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="tr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no" />
<title>Kuş Sarayları Admin Panel</title>
<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="../bootstrap/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="../bootstrap/css/style.css">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="//cdn.ckeditor.com/4.6.1/standard/ckeditor.js"></script>
</head>

<body>


    <div class="container boyut">
		<div>
	<img src="../image/admin_images/<?php echo $row['admin_foto']; ?>" class="img-rounded" width="100px" style="float:left;"height="100px" />
		</div>	 
	<div class="yonet">
		 <a class="navbar-brand yonetim_paneli"  href="#" title='Yönetim Paneli'>Yönetim Paneli</a>
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
<div class="container makale_form col-md-8 col-xs-6">
<h1 class="h2">Hakkımızda Sayfa Düzenleme <a class="btn btn-default buton_guncelle" href="index.php"> <span class="glyphicon glyphicon-backward"></span>     anasayfa</a></h2>

<?php
		}
	}
?>

<?php
if(isset($errMSG)){
        ?>
        <div class="alert alert-danger">
            <span class="glyphicon glyphicon-info-sign"></span> <strong><?php echo $errMSG; ?></strong>
        </div>
        <?php
}
else if(isset($successMSG)){
    ?>
	
    <div class="alert alert-success">
          <strong><span class="glyphicon glyphicon-info-sign"></span> <?php echo $successMSG; ?><script>
				alert('Güncelleme Başarılı...');
				window.location.href='hakkimizda.php';
				</script></strong>
    </div>
    <?php
	
	
}

?>   
<?php
	$stmt = $DB_con->prepare('SELECT * FROM hakkimizda ORDER BY hakkimizda_id asc limit 1');
	$stmt->execute();
	while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
		if(@extract($row)){

?>

<form method="post" action="hakkimizda.php?edit_id=<?php echo $hakkimizda_id;?>" enctype="multipart/form-data" class="form-horizontal form_bicim">
<table class="table table-bordered table-responsive">
<tr>
    <td><label class="control-label">Hakkımızda Başlık</label></td>
    <td><input class="form-control" type="text" required="required" name="baslik" placeholder="Hakkımızda Başlık Giriniz..." value="<?php echo $baslik; ?>" /></td>
</tr>
<tr>
    <td><label class="control-label">Giriş Yazısı</label></td>
    <td><textarea  class="icerik_alan" required="required" name="giris" placeholder="Giriş Yazı Giriniz..." ><?php echo $giris; ?></textarea></td>
</tr>
<tr>
    <td><label class="control-label">Birinci Ortak Ad</label></td>
    <td><input class="form-control" type="text" required="required" name="ortak1_ad" placeholder="Ortak Adı Yazınız..." value="<?php echo $ortak1_ad; ?>" /></td>
</tr>
<tr>
    <td><label class="control-label">Birinci Ortak İçerik</label></td>
    <td><textarea  class="icerik_alan" required="required" name="ortak1_icerik" placeholder="İçerik Giriniz..." ><?php echo $ortak1_icerik; ?></textarea></td>
</tr>

<tr>
	<tr>
    <td><label class="control-label">İkinci Ortak Ad</label></td>
    <td><input class="form-control" type="text" required="required" name="ortak2_ad" placeholder="Ortak Adı Yazınız..." value="<?php echo $ortak2_ad;?>" /></td>
</tr>
<tr>
    <td><label class="control-label">İkinci Ortak İçerik</label></td>
    <td><textarea class="icerik_alan" required="required" name="ortak2_icerik" placeholder="İçerik Giriniz..." ><?php echo $ortak2_icerik; ?></textarea></td>
</tr>

</tr>
<tr>
	<td colspan="2"><button type="submit" name="btn_save_updates" class="btn btn-default btn_kayit"><span class="glyphicon glyphicon-edit"></span> güncelle</button></td>
   
</tr>
</table>

</form>
<?php

		}
	}	
	
?>	</div>
	</div>

<div class="container">
<footer>
<div class="col-md-12 footer_duzen">
  <a href="wwww.ankayazilim.com"><strong> Anka Yazılım	&	©2018 Bütün Hakları Saklıdır.</strong></a>
</div>
</footer>

</div>


<!-- Latest compiled and minified JavaScript -->
<script src="bootstrap/js/bootstrap.min.js"></script>



</body>
</html>