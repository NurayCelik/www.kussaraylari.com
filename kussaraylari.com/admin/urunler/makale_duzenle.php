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
		$stmt_edit = $DB_con->prepare('SELECT makale_baslik, baslik_id, makale_tarih, makale_icerik, makale_resim, makale_url FROM blog WHERE makale_id =:bid');
		$stmt_edit->execute(array(':bid'=>$id));
		$edit_row = $stmt_edit->fetch(PDO::FETCH_ASSOC);
		extract($edit_row);
		}	
		
	
	if(isset($_POST['btn_updates']))
	{
		$id = $_POST['edit_id'];
		echo $id;
		$stmt_edit = $DB_con->prepare('SELECT makale_baslik, baslik_id, makale_tarih, makale_icerik, makale_resim, makale_url FROM blog WHERE makale_id =:bid');
		$stmt_edit->execute(array(':bid'=>$id));
		$edit_row = $stmt_edit->fetch(PDO::FETCH_ASSOC);
		extract($edit_row);

		$tarih = $_POST['tarih'];
		$baslik = $_POST['baslik'];
		$baslik_id = $_POST['baslik_id'];
		$icerik = $_POST['icerik'];
		$imgFile = $_FILES['resim']['name'];
		$tmp_dir = $_FILES['resim']['tmp_name'];
		$imgSize = $_FILES['resim']['size'];
		$url = $_POST['url'];
		
					
		if($imgFile)
		{ 
			$image_file_path='../../admin/image/blog_images/';
			$upload_dir = "../image/blog_images/"; // upload directory	
			$imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension
			$valid_extensions = array('jpeg', 'jpg', 'png', 'gif',''); // valid extensions
			$blogResim = rand(1000,1000000).".".$imgExt;
			if(in_array($imgExt, $valid_extensions))
			{			
				if($imgSize < 5000000)
				{
					if(strlen($edit_row['makale_resim'])<0)
					move_uploaded_file($tmp_dir,$upload_dir.$blogResim);
					else {
					$result= @unlink($image_file_path.$edit_row['makale_resim']);
					if($result)
						echo "unlink başarılı";else echo "unlink başarısız";
					$islem=@move_uploaded_file($tmp_dir,$upload_dir.$blogResim);
					if($islem)
						echo "işlem başarılı";else echo "işlem başarısız";
					}
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
			
			$blogResim = $edit_row['makale_resim']; 
			
		}	
		
			
							
			
			if(!isset($errMSG))
			{
					
				$update = $DB_con->prepare('UPDATE blog
				SET  makale_baslik=:bbaslik,
					 baslik_id=:bbaslik_id,
					 makale_tarih=:btarih,
					 makale_icerik=:bicerik,
					 makale_resim=:bresim,
					 makale_url=:burl
				WHERE makale_id=:bid');
				
				$update->bindParam(':bid',$id);
				$update->bindParam(':bbaslik',$baslik);
				$update->bindParam(':bbaslik_id',$baslik_id);
				$update->bindParam(':btarih',$tarih);
				$update->bindParam(':bicerik',$icerik);
				$update->bindParam(':bresim',$blogResim);
				$update->bindParam(':burl',$url);
				$result = $update->execute();	
				if(@$result){
					$successMSG = "Güncelleme Başarılı...";
					//header("refresh:1;makale.php"); 
				}
				else{
					$errMSG = "Güncelleme Gerçekleşmedi!";
				}
			}
	}
	else
		{
			//header("Location: makale.php");
		}

	$stmt = $DB_con->prepare('SELECT * FROM admintbl ORDER BY admin_id limit 1');
	$stmt->execute();
	while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
		if(@extract($row))
		{
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
<h1 class="h2">Makale Güncelle <a class="btn btn-default buton_exit" href="makale.php"><span class="glyphicon glyphicon-backward"></span> makaleler
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
    <td class="genislik"><label class="control-label yeni_labl"><?php echo $id; ?>. Makale Başlık</label></td>
    <td><input class="form-control" type="text" required="required" name="baslik" placeholder="Makale Başlık Giriniz..." value="<?php echo $makale_baslik; ?>" /></td>
</tr>
<tr>
    <td class="genislik"><label class="control-label yeni_labl">Başlık id</label></td>
    <td><input class="form-control" type="text" required="required" name="baslik_id" placeholder="Başlık id giriniz..." value="<?php echo $baslik_id; ?>" /></td>
</tr>
<tr>
    <td class="genislik"><label class="control-label yeni_labl">Makale Tarih</label></td>
    <td><input class="form-control" type="text" required="required" name="tarih" placeholder="Makale Tarih Giriniz..." value="<?php echo $makale_tarih; ?>" /></td>
</tr>
<tr>
    <td class="genislik"><label class="control-label yeni_labl">Makale İçerik</label></td>
	<td><textarea  class="ckeditor icerik_alan" id="editor1" required="required" name="icerik" placeholder="Makale İçerik Giriniz..."><?php echo $makale_icerik; ?></textarea></td>
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
    <td class="genislik"><label class="control-label yeni_labl">Makale Resim</label></td>
    <td><p><img src="../image/blog_images/<?php echo $makale_resim; ?>" height="150px" width="150px" /></p>
	<input class="input-group" type="file" name="resim" accept="image/*" />
	</td>
</tr>
<tr>
    <td class="genislik"><label class="control-label yeni_labl">Makale Url</label></td>
	<td><input type="textarea" class="input-group"  name="url" style="width:100%; height:100px;" placeholder="Makale Url Yazınız..."><?php echo $makale_url; ?></textarea></td>
</tr>
<tr><input type="hidden" name="edit_id" value="<?php echo $id; ?>" />
    <td colspan="3"><button type="submit" name="btn_updates" class="btn btn-default btn_kayit">
    <span class="glyphicon glyphicon-save"></span> güncelle</button>
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