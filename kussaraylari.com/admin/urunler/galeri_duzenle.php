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
	
		$sonuc= (isset($_POST['edit_id']) && !empty($_POST['edit_id']));
		if($sonuc)
		{
		$id = $_POST['edit_id']; 
		$stmt_edit = $DB_con->prepare('SELECT seri_ad, model_ad, boyut, agirlik, malzeme, resim_ad FROM galeri WHERE galeri_id =:gid');
		$stmt_edit->execute(array(':gid'=>$id));
		$edit_row = $stmt_edit->fetch(PDO::FETCH_ASSOC);
		extract($edit_row);

		}
	
		if(isset($_POST['btn_updates']))
		{
		
		$id = $_POST['edit_id']; 
		echo $id;
		$stmt_edit = $DB_con->prepare('SELECT seri_ad, model_ad, boyut, agirlik, malzeme, resim_ad FROM galeri WHERE galeri_id =:gid');
		$stmt_edit->execute(array(':gid'=>$id));
		$edit_row = $stmt_edit->fetch(PDO::FETCH_ASSOC);
		extract($edit_row);
		
		$seri = $_POST['seri'];
		$model = $_POST['model'];
		$boyut = $_POST['boyut'];
        $agirlik = $_POST['agirlik'];
        $malzeme = $_POST['malzeme'];
		
		$imgFile = @$_FILES['resim']['name'];
		$tmp_dir = $_FILES['resim']['tmp_name'];
		$imgSize = $_FILES['resim']['size'];
		
					
		if($imgFile)
		{ 
			$image_file_path='../../admin/image/galeri_images/';
			$upload_dir = '../image/galeri_images/'; 	
			$imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); 
			$valid_extensions = array('jpeg','JPEG', 'jpg', 'JPG','png', 'gif',''); 
			$blogResim = rand(1000,1000000).".".$imgExt;
			if(in_array($imgExt, $valid_extensions))
			{			
				if($imgSize < 5000000)
				{
					
					$result= @unlink($image_file_path.$edit_row['resim_ad']);
					if($result)
						echo "unlink başarılı";else echo "unlink başarısız";

					$islem=@move_uploaded_file($tmp_dir,$upload_dir.$blogResim);
					if($islem)
						echo "upload başarılı";else echo "upload başarısız";
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
			
			$blogResim = $edit_row['resim_ad']; 
			
		}	
		
			
        if(!isset($errMSG))
			{
            	$update = $DB_con->prepare('UPDATE galeri
                    SET seri_ad=:gseri,
                        model_ad=:gmodel,
                        boyut=:gboyut,
                        agirlik=:gagirlik,
                        malzeme=:gmalzeme,
                        resim_ad=:gresim
                 	WHERE galeri_id=:gid');

				$update->bindParam(':gid',$id);
				$update->bindParam(':gseri',$seri);
				$update->bindParam(':gmodel',$model);
				$update->bindParam(':gboyut',$boyut);
                $update->bindParam(':gagirlik',$agirlik);
                $update->bindParam(':gmalzeme',$malzeme);
				$update->bindParam(':gresim',$blogResim);
				$result = $update->execute();	
						
	            if(@$result){
					$successMSG = "Güncelleme Başarılı...";
					header("refresh:1;galeri.php"); 
				}
				else{
					$errMSG = "Güncelleme Gerçekleşmedi!";
				}
			
			}
						
						
	}

	else
	{
		//header("Location: galeri.php");
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
<h1 class="h2">Galeri Güncelle <a class="btn btn-default buton_exit" href="galeri.php"><span class="glyphicon glyphicon-backward"></span> galeri
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

<form method="post" action="galeri_duzenle.php" enctype="multipart/form-data" class="form-horizontal form_bicim">
<table class="table table-bordered table-responsive">
<tr>
    <td class="genislik"><label class="control-label yeni_labl"><?php echo $id; ?>. Seri Adı</label></td>
    <td><input class="form-control" type="text" required="required" name="seri" placeholder="Seri Ad Yazınız..." value="<?php echo $seri_ad; ?>" /></td>
</tr>
<tr>
    <td class="genislik"><label class="control-label yeni_labl"> Model Ad</label></td>
    <td><input class="form-control" type="text" required="required" name="model" placeholder="Model Adı yazınız..." value="<?php echo $model_ad; ?>" /></td>
</tr>
<tr>
    <td class="genislik"><label class="control-label yeni_labl"> Boyutlar</label></td>
    <td><input class="form-control" type="text" class="input-group" required="required" name="boyut"  placeholder="Boyutları yazınız..." value="<?php echo $boyut; ?>" /></td>
</tr>
<tr>
    <td class="genislik"><label class="control-label yeni_labl"> Ağırlık</label></td>
	<td><input class="form-control" type="text" class="input-group" required="required" name="agirlik" placeholder="Ağırlığı yazınız..." value="<?php echo $agirlik; ?>" /></td>
</tr>
<tr>
    <td class="genislik"><label class="control-label yeni_labl"> Malzeme</label></td>
	<td><input class="form-control" type="text" class="input-group" required="required" name="malzeme" placeholder="Malzeme adı yazınız..."value="<?php echo $malzeme; ?>" /></td>
</tr>
<tr>
    <td class="genislik"><label class="control-label yeni_labl"> Galeri Resim</label></td>
    <td><p><img src="../image/galeri_images/<?php echo $resim_ad; ?>" height="150px" width="150px" /></p>
	<input class="input-group" type="file" name="resim" accept="image/*" />
	</td>
</tr>

<tr>
	<td><input type="hidden" name="edit_id" value="<?php echo $id; ?>" />
    <td colspan="3"><button type="submit" name="btn_updates" class="btn btn-default btn_kayit" onclick="return confirm('Düzenlemek İstediğinizden Emin misiniz?')">
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