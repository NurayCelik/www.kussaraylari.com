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

		
		$sonuc= (isset($_POST['edit_id']) && !empty($_POST['edit_id']));
		if($sonuc)
		{
			$id = $_POST['edit_id'];
			$stmt_edit = $DB_con->prepare('SELECT admin_realname, admin_ad, admin_sifre, admin_foto FROM admintbl WHERE admin_id =:kid');
			$stmt_edit->execute(array(':kid'=>$id));
			$edit_row = $stmt_edit->fetch(PDO::FETCH_ASSOC);
			extract($edit_row);
		}	
		if(isset($_POST['btn_updates']))
		{
			$id = $_POST['edit_id'];
			$stmt_edit = $DB_con->prepare('SELECT admin_realname, admin_ad, admin_sifre, admin_foto FROM admintbl WHERE admin_id =:kid');
			$stmt_edit->execute(array(':kid'=>$id));
			$edit_row = $stmt_edit->fetch(PDO::FETCH_ASSOC);
			extract($edit_row);
			

			$gercekad       =   $_POST['gercekad'];
			$kullaniciad    = 	$_POST['ad'];
			$sifre 			=	$_POST['sifre'];
			$options = array('cost' => 11);
       		$hashed_password =  password_hash($sifre, PASSWORD_BCRYPT,$options);
			$imgFile        = 	@$_FILES['foto']['name'];
			$tmp_dir        = 	$_FILES['foto']['tmp_name'];
			$imgSize 		=   $_FILES['foto']['size'];
		
			if($imgFile)
			{ 
				$image_file_path='../../admin/image/admin_images/';
				$upload_dir = "../image/admin_images/"; // upload directory	
				$imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension
				$valid_extensions = array('jpeg', 'jpg', 'png', 'gif',''); // valid extensions
				$blogResim = rand(1000,1000000).".".$imgExt;
				if(in_array($imgExt, $valid_extensions))
				{					
					if($imgSize < 5000000)
					{
						
						$result= @unlink($image_file_path.$edit_row['admin_foto']);
						if($result)
						echo "işlem başarılı";else echo "işlem başarısız";
						$islem=move_uploaded_file($tmp_dir,$upload_dir.$blogResim);
						if($islem)
							echo "işlem başarılı";
					}
					else
					{
						$errMSG = "Dosya boyutunuz 5MB dan küçük olmalı...";
					}
				}
				else
				{
					$errMSG = "Sadece JPG, JPEG, PNG & GIF uzantılı fotoğraflara izin var....";		
				}	
			}
		else
		{
			// if no image selected the old image remain as it is.
			$blogResim = $edit_row['admin_foto']; // old image from database
		}	
						
		
		if(!isset($errMSG))
		{
			$update = $DB_con->prepare('UPDATE admintbl
			SET  admin_realname=:kreal,
				 admin_ad =:kad,
				 admin_sifre=:ksifre,
				 admin_foto=:kfoto
			WHERE admin_id=:kid');

			$update->bindParam(':kid',$id);
			$update->bindParam(':kreal',$gercekad);
			$update->bindParam(':kad',$kullaniciad);
			$update->bindParam(':ksifre',$hashed_password);
			$update->bindParam(':kfoto',$blogResim);
			$result = $update->execute();	
					
			if(@$result){
				$successMSG = "Güncelleme Başarılı...";
				header("refresh:3;duzen.php"); //3 SANİYEDE GÖNDERİR
			}
			else{
				$errMSG = "Güncelleme Gerçekleşmedi!";
			}
		
		
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
<h1 class="h2">Hesabı Güncelle <a class="btn btn-default buton_exit" href="index.php"><span class="glyphicon glyphicon-backward"></span> anasayfa
    </a></h2>
<?php
		}
	}
?>


<?php
if(isset($successMSG)){
        ?>
        <div class="alert alert-success">
            <span class="glyphicon glyphicon-info-sign"></span> <strong><?php echo $successMSG; ?></strong>
        </div>
        <?php
}
?>

<form method="post" enctype="multipart/form-data" class="form-horizontal form_bicim">
<table class="table table-bordered table-responsive">
<tr>
    <td class="genislik"><label class="control-label yeni_lab2" >Adınız Soyadınız</label></td>
    <td><input class="form-control  yeni_lab1" type="text" required="required" name="gercekad" placeholder="Adınızı-Soyadınızı yazınız..." value="<?php echo $admin_realname; ?>" /></td>
</tr>
<tr>
    <td class="genislik"><label class="control-label yeni_lab2">Kullanıcı Adınız</label></td>
    <td><input class="form-control yeni_lab1" type="text" required="required" name="ad" placeholder="Kullanıcı adınızı yazınız..." value="<?php echo $admin_ad; ?>" /></td>
</tr>
<tr ><td class="genislik"><label class="control-label yeni_lab2">Kullanıcı Şifreniz</label></td>
    <td><input class="form-control yeni_lab1" type="password" required="required" name="sifre" placeholder="Şifrenizi yazınız..." value="<?php echo $admin_sifre; ?>" /></td>
</tr>
<tr>
    <td class="genislik"><label class="control-label yeni_lab2">Kullanıcı Foto</label></td>
    <td><p><img src="../image/admin_images/<?php echo $admin_foto ?>" class="img-rounded" style="background-size:cover;" height="150px" width="150px" /></p>
	<input class="input-group" type="file" name="foto" accept="image/*" />
	</td>
</tr>
<tr>
	<td colspan="3"><input type="hidden" name="edit_id" value="<?php echo $admin_id; ?>" /><button type="submit" name="btn_updates" class="btn btn-default btn_kayit"><span class="glyphicon glyphicon-save"></span> güncelle
		</button>
	</td>
	
</tr>

</table>

</form>


		</div>
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