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

if(isset($_POST['btnsave']))
{
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
			$upload_dir = "../image/admin_images/"; 
	
			$imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); 
		
			
			$valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); 
		
			
			$blogResim = rand(1000,1000000).".".$imgExt;
				
			
			if(in_array($imgExt, $valid_extensions)){			
				
				if($imgSize < 5000000)				{
					move_uploaded_file($tmp_dir,$upload_dir.$blogResim);
                   
				}
				else{
					$errMSG = "Lütfen 5MB den daha küçük boyutlu resim yükleyiniz...";
				}
			}
			else{
				$errMSG = "Sadece JPG, JPEG, PNG & GIF Uzantılı Dosyalara İzin Var.";		
			}
		
        
        
        if(!isset($errMSG))
		{
			$stmt = $DB_con->prepare('INSERT INTO admintbl (admin_realname, admin_ad, admin_sifre, admin_foto) VALUES(:kreal, :kad, :ksifre, :kfoto)');
            $stmt->bindParam(':kreal',$gercekad, PDO::PARAM_STR);
            $stmt->bindParam(':kad',$kullaniciad, PDO::PARAM_STR);
            $stmt->bindParam(':ksifre',$hashed_password, PDO::PARAM_STR);
            $stmt->bindParam(':kfoto',$blogResim, PDO::PARAM_STR);
            
        
            if($stmt->execute())
            {
					$successMSG = "Yeni Kayıt Başarıyla Eklendi...";
					echo $successMSG;
                    header("refresh:1;duzen.php"); // redirects image view page after 1 seconds.
                    
            }
            else
            {
                    $errMSG = "Kayıt Sırasında Hata Oluştu....";
            }
	    }
	}
}	
?>



<?php
	
	$stmt = $DB_con->prepare('SELECT * FROM admintbl ORDER BY admin_id limit 1');
	$stmt->execute();
	$row=$stmt->fetch(PDO::FETCH_ASSOC);
	@extract($row);
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
	<img src="../image/admin_images/<?php echo $row['admin_foto'];?>" class="img-rounded" width="100px" style="float:left;"height="100px" />
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
<h1 class="h2">Kulanıcı Bilgileriniz <a class="btn btn-default buton_guncelle" href="index.php"> <span class="glyphicon glyphicon-backward"></span>     anasayfa</a></h2>
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
				alert('Kaydınız Başarılı...');
				//window.location.href='makale.php';
				</script></strong>
    </div>
    <?php
    $gercekad       ="";
    $kullaniciad    ="" ;
    $sifre 			="";
    $imgFile        ="";
}
?>  
<?php
	
	$stmt = $DB_con->prepare('SELECT * FROM admintbl ORDER BY admin_id limit 1');
	$stmt->execute();
	
	if($stmt->rowCount() > 0)
	{
		while($row=$stmt->fetch(PDO::FETCH_ASSOC))
		{
			extract($row);
			?>
<form method="post" action="duzen1.php" enctype="multipart/form-data" class="form-horizontal form_bicim yazi">
<table class="table table-bordered table-responsive">
<tr>
    <td class="genislik"><label class="control-label yeni_lab2">Adınız Soyadınız</label></td>
	<td><label class="control-label yeni_labl"><?php echo $row['admin_realname']; ?></label></td>
</tr>
<tr>
    <td class="genislik"><label class="control-label yeni_lab2">Kullanıcı Adınız</label></td>
	<td><label class="control-label yeni_labl"><?php echo $row['admin_ad']; ?></label></td>
</tr>
<tr >
    <td class="genislik"><label class="control-label yeni_lab2">Kullanıcı Şifreniz</label></td>
	<td><label class="control-label yeni_labl"><?php echo $row['admin_sifre']; ?></label></td>
</tr>
<tr>
    <td class="genislik"><label class="control-label yeni_lab2">Kullanıcı Foto</label></td>
    <td><p><img src="../image/admin_images/<?php echo $row['admin_foto']; ?>" class="img-rounded" style="background-size:cover;" height="150x" width="150px" /></p>
	</td>
</tr>
<tr>
    <td colspan="2"><input type="hidden" name="edit_id" value="<?php echo $admin_id; ?>" /><button type="submit" title="Düzenlemek İçin Tıklayınız" name="btn_save_updates" class="btn_duzen"><span class="glyphicon glyphicon-edit"></span> düzenle</button></td></td>
</tr>
</table>
</form>

<?php
  }
 }
 else
	{
		?>
        <div class="col-xs-12">
        	<div class="alert alert-warning">
            	<span class="glyphicon glyphicon-info-sign"></span> &nbsp; Veri Bulunamadı ...
            </div>
        </div>
        <?php
	}
	
?>





<!-------------------------------------------------------------->


<form method="post" enctype="multipart/form-data" class="form-horizontal form_bicim form_goruntulenmez">
<table class="table table-bordered table-responsive">
<tr>
    <td><label class="control-label yeni_labl">Adınız Soyadınız</label></td>
    <td><input class="form-control" type="text" required="required" name="gercekad" placeholder="Adınızı-Soyadınızı yazınız..." value="<?php echo $gercekad; ?>" /></td>
</tr>
<tr>
    <td><label class="control-label yeni_labl">Kullanıcı Adınız</label></td>
    <td><input class="form-control" type="text" required="required" name="ad" placeholder="Kullanıcı adınızı yazınız..." value="<?php echo $kullaniciad; ?>" /></td>
</tr>
<tr>
    <td><label class="control-label yeni_labl">Kullanıcı Şifreniz</label></td>
    <td><input class="form-control" type="password" required="required" name="sifre" placeholder="Şifrenizi yazınız..." value="<?php echo $sifre; ?>" /></td>
</tr>
<tr>
    <td><label class="control-label yeni_labl">Kullanıcı Foto</label></td>
    <td><input class="input-group" type="file" required="required" name="foto" accept="image/*"/></td>
	
</tr>
<tr>
<td colspan="2"><button type="submit" name="btnsave" class="btn btn-default btn_kayit">
    <span class="glyphicon glyphicon-save"></span> kaydet</button>
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