<?php
ob_start();
session_start();
error_reporting( ~E_NOTICE );
require_once '../dbconfig.php';
date_default_timezone_set('Europe/Istanbul');

if(!isset($_SESSION['name']))
	{ 
	header("location:login.php"); 
	}
	else 
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
		$sira = $_POST['id'];
		$seri = $_POST['seri'];
		$model = $_POST['model'];
		$boyut = $_POST['boyut'];
        $agirlik = $_POST['agirlik'];
        $malzeme = $_POST['malzeme'];
		
		$imgFile = @$_FILES['resim']['name'];
		$tmp_dir = $_FILES['resim']['tmp_name'];
		$imgSize = $_FILES['resim']['size'];
		
		
		
		if(empty($model)){
			$errMSG = "Lütfen Moadel Adı Yazınız.";
		}
		else if(empty($seri)){
			$errMSG = "Lütfen Seri Adı Yazınız.";
		}
		
		else
		{
			$upload_dir = "../image/galeri_images/"; 
	
			$imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); 
		
			
			$valid_extensions = array('jpeg', 'jpg', 'png', 'gif',''); 
		
			
			$blogResim = rand(1000,1000000).".".$imgExt;
				
			
			if(in_array($imgExt, $valid_extensions)){			
				
                if($imgSize < 5000000)				
                {
					$islem=@move_uploaded_file($tmp_dir,$upload_dir.$blogResim);
					if($islem) echo "islem başarılı"; else "islem başarrısız";
				}
				else{
					$errMSG = "Lütfen 5MB den daha küçük boyutlu resim yükleyiniz...";
				}
			}
			else{
				$errMSG = "Sadece JPG, JPEG, PNG & GIF Uzantılı Dosyalara İzin Var.";		
			}
		}
        
        
        if(!isset($errMSG))
		{

            $stmt = $DB_con->prepare('INSERT INTO galeri (seri_ad,model_ad,boyut,agirlik,malzeme,resim_ad ) VALUES(:gseri, :gmodel, :gboyut, :gagirlik, :gmalzeme, :gresim)');
			$stmt->bindParam(':gseri',$seri);
			$stmt->bindParam(':gmodel',$model);
			$stmt->bindParam(':gboyut',$boyut);
			$stmt->bindParam(':gagirlik',$agirlik);
			$stmt->bindParam(':gmalzeme',$malzeme);
            $stmt->bindParam(':gresim',$blogResim);
      
			
			if($stmt->execute())
			{
				$successMSG = "Yeni Kayıt Başarıyla Eklendi...";
				header("refresh:2;galeri.php"); 
				
			}
			else
			{
				$errMSG = "Kayıt Sırasında Hata Oluştu....";
			}
		}
	}
?>
	<?php
	
	$stmt = $DB_con->prepare('SELECT * FROM admintbl ORDER BY admin_id desc limit 1');
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
<h1 class="h2">Galeri Ekle <a class="btn btn-default buton_guncelle" href="galeri.php"> <span class="glyphicon glyphicon-backward"></span>     Galeri</a></h2>
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
				alert('Kaydınız Başarılı...Yeni Model Ekleyebilirsiniz...');
				window.location.href='galeri.php';
				</script></strong>
    </div>
    <?php
	$sira   	= "";
	$seri   	= "";
	$model  	= "";
	$boyut      = "";
	$agirlik    = "";
    $malzeme	= "";
    $imgFile    = "";
    
		
	
}


?>   


<form method="post" enctype="multipart/form-data" class="form-horizontal form_bicim">
<table class="table table-bordered table-responsive">
<tr>
    <td><label class="control-label">Seri Ad</label></td>
    <td><input class="form-control" type="text" required="required" name="seri" placeholder="Seri Adı Giriniz..." value="<?php echo $seri; ?>" /></td>
</tr>
<tr>
    <td><label class="control-label">Model Ad</label></td>
    <td><input class="form-control" type="text" required="required" name="model" placeholder="Model Adı Giriniz..." value="<?php echo $model; ?>" /></td>
</tr>
<tr>
    <td><label class="control-label">Boyutlar</label></td>
    <td><input class="form-control" type="text"  required="required" name="boyut" placeholder="Boyutları Giriniz..." value="<?php echo $boyut; ?>" /></td>
</tr>
<tr>
    <td><label class="control-label">Ağırlık</label></td>
    <<td><input class="form-control" type="text" required="required"  name="agirlik" placeholder="Ağırlığı Giriniz..." value="<?php echo $agirlik; ?>" /></td>
</tr>
<tr>
    <td><label class="control-label">Malzeme</label></td>
	<td><input class="form-control" type="text" name="malzeme"  required="required" placeholder="Malzeme Adı Yazınız..." value="<?php echo $malzeme; ?>" ></td>
</tr>
<tr>
    <td><label class="control-label">Galeri Resim</label></td>
    <td><input class="input-group" type="file" name="resim" accept="image/*" /></td>
</tr>
<tr>
    <td colspan="2"><button type="submit" name="btnsave" class="btn btn-default btn_kayit">
    <span class="glyphicon glyphicon-save"></span> save</button>
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


<script src="bootstrap/js/bootstrap.min.js"></script>



</body>
</html>