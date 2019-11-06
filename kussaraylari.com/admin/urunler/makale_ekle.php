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
		$sira = $_POST['id'];
		$tarih = $_POST['tarih'];
		$baslik = $_POST['baslik'];
		$baslik_id = $_POST['baslik_id'];
		$icerik = $_POST['icerik'];
		
		$imgFile = @$_FILES['resim']['name'];
		$tmp_dir = $_FILES['resim']['tmp_name'];
		$imgSize = $_FILES['resim']['size'];
		$url = $_POST['url'];
		
		
		if(empty($icerik)){
			$errMSG = "Lütfen Makale Yazınız.";
		}
		else if(empty($baslik)){
			$errMSG = "Lütfen Makale Başlığı Yazınız.";
		}
		
		else
		{
			$upload_dir = "../image/blog_images/"; 
	
			$imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); 
		
			
			$valid_extensions = array('jpeg', 'jpg', 'png', 'gif',''); 
		
			
			$blogResim = rand(1000,1000000).".".$imgExt;
				
			
			if(in_array($imgExt, $valid_extensions)){			
				
				if($imgSize < 5000000)				
				{
					move_uploaded_file($tmp_dir,$upload_dir.$blogResim);
					
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
			$stmt = $DB_con->prepare('INSERT INTO blog (makale_baslik,baslik_id,makale_tarih,makale_icerik,makale_resim,makale_url) VALUES(:bbaslik, :bbaslik_id, :btarih, :bicerik, :bresim,:burl)');
			$stmt->bindParam(':bbaslik',$baslik);
			$stmt->bindParam(':bbaslik_id',$baslik_id);
			$stmt->bindParam(':btarih',$tarih);
			$stmt->bindParam(':bicerik',$icerik);
			$stmt->bindParam(':bresim',$blogResim);
			$stmt->bindParam(':burl',$url);
			
			
			if($stmt->execute())
			{
				$successMSG = "Yeni Kayıt Başarıyla Eklendi...";
				header("refresh:2;makale.php"); 
				
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
<h1 class="h2">Makale Ekle <a class="btn btn-default buton_guncelle" href="makale.php"> <span class="glyphicon glyphicon-backward"></span>     makaleler</a></h2>



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
				alert('Kaydınız Başarılı...Yeni Makale Ekleyebilirsiniz...');
				window.location.href='makale.php';
				</script></strong>
    </div>
    <?php
	$sira   	= "";
	$tarih   	= "";
	$baslik  	= "";
	$baslik_id  = "";
	$icerik     = "";
	$imgFile    = "";
	$url	    ="";
	
}


?>   


<form method="post" enctype="multipart/form-data" class="form-horizontal form_bicim">
<table class="table table-bordered table-responsive">
<tr>
    <td><label class="control-label">Makale Başlık</label></td>
    <td><input class="form-control" type="text" required="required" name="baslik" placeholder="Makale Başlık Giriniz..." value="<?php echo $baslik; ?>" /></td>
</tr>
<tr>
    <td><label class="control-label">Başlık id</label></td>
    <td><input class="form-control" type="text" required="required" name="baslik_id" placeholder="Makale Başlık Giriniz..." value="<?php echo $baslik_id; ?>" /></td>
</tr>
<tr>
    <td><label class="control-label">Makale Tarih</label></td>
    <td><input class="form-control" type="date" name="tarih"  value="<?php echo date("Y-m-d"); ?>" /></td>
</tr>
<tr>
    <td><label class="control-label">Makale İçerik</label></td>
    <td><textarea  class="ckeditor icerik_alan" id="editor1" required="required" name="icerik" placeholder="Makale İçerik Giriniz..." ><?php echo $icerik; ?></textarea></td>
</tr>
<script type="text/javascript">


                   CKEDITOR.replace( 'editor1',
                   {
                    filebrowserBrowseUrl : 'ckfinder/ckfinder.html',
                    filebrowserImageBrowseUrl : 'ckfinder/ckfinder.html?type=Images',
                    filebrowserFlashBrowseUrl : 'ckfinder/ckfinder.html?type=Flash',
                    filebrowserUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                    filebrowserImageUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
                    filebrowserFlashUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash',
                    forcePasteAsPlainText: true
                  } 
                  );
</script>
<tr>
    <td><label class="control-label">Makale Resim</label></td>
    <td><input class="input-group" type="file" name="resim" accept="image/*" /></td>
</tr>
<tr>
    <td><label class="control-label">Makale Url</label></td>
	<td><input class="input-group" type="text" name="url" style="width:100%; height:40px;" placeholder="Makale Url Yazınız..." value="<?php echo $url; ?>" ></td>
</tr>
<tr>
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


<!-- Latest compiled and minified JavaScript -->
<script src="bootstrap/js/bootstrap.min.js"></script>



</body>
</html>