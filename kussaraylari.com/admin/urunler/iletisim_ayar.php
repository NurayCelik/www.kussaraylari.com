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

			$id             =   $_POST['edit_id'];//istediğimiz bir id nosu vererek de güncelleme işlemi yapılır. diğer sayfadan gönderilmeden yani..
			$sirket_ad    	= 	$_POST['sirket_ad'];
			$adres 			=	$_POST['adres'];
			$telefon    	= 	$_POST['telefon'];
			$email 			=	$_POST['email'];
			
			$update = $DB_con->prepare('UPDATE iletisim SET  
				 sirket_ad=:cad,
				 adres =:cadres,
				 telefon=:ctelefon,
				 email=:cemail
				 WHERE iletisim_id=:cid');
	
				$update->bindParam(':cid',$id);
				$update->bindParam(':cad',$sirket_ad);
				$update->bindParam(':cadres',$adres);
				$update->bindParam(':ctelefon',$telefon);
				$update->bindParam(':cemail',$email);
				$result = $update->execute();	
				
			if($result){
				$successMSG = "Güncelleme Başarılı...";
				
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
<h1 class="h2">İletişim Bilgileriniz<a class="btn btn-default buton_guncelle" href="index.php"> <span class="glyphicon glyphicon-backward"></span>     anasayfa</a></h2>

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
				window.location.href='iletisim_ayar.php';
				</script></strong>
    </div>
    <?php
	
	
}

?>   
<?php
	$stmt = $DB_con->prepare('SELECT * FROM iletisim ORDER BY iletisim_id asc limit 1');
	$stmt->execute();
	while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
		if(@extract($row)){

?>

<form method="post" action="" enctype="multipart/form-data" class="form-horizontal form_bicim">
<table class="table table-bordered table-responsive">
<tr>
    <td><label class="control-label">Şirket Adı</label></td>
    <td><input class="form-control" type="text" required="required" name="sirket_ad" placeholder="Şirket Adını Yazınız..." value="<?php echo $sirket_ad; ?>" /></td>
</tr>
<tr>
    <td><label class="control-label">Şirket Adresi</label></td>
    <td><input class="form-control" type="text" required="required" name="adres" placeholder="Adresi Yazınız..." value="<?php echo $adres; ?>" /></td>
</tr>
<tr>
    <td><label class="control-label">Şirket Telefonu</label></td>
    <td><input class="form-control" type="text" required="required" name="telefon" placeholder="Telefon No Yazınız..." value="<?php echo $telefon; ?>" /></td>
</tr>
<tr>
    <td><label class="control-label">E-mail Adresi</label></td>
    <td><input class="form-control" type="text" required="required" name="email" placeholder="E-mail Adresini Yazınız..." value="<?php echo $email; ?>" /></td>
</tr>
<tr>
	 <input type="hidden" name="edit_id" value="<?php echo $iletisim_id; ?>" />
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