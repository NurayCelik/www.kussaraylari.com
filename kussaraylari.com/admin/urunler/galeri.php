<?php
ob_start();
session_start();
require_once '../dbconfig.php';
date_default_timezone_set('Europe/Istanbul');


if(!isset($_SESSION['name']))
	{ 
	header("location:login.php"); 
	}
	else 
    {
	header( 'Content-Type: text/html; charset=utf-8' );
    }
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
    if(isset($_POST['btn_delete']))
        {
            
            $id = $_POST['delete_id'];
            echo  $id;
            $stmt_select = $DB_con->prepare('SELECT resim_ad FROM galeri WHERE galeri_id =:gid');
            $stmt_select->execute(array(':gid'=>$id));
            $imgRow=$stmt_select->fetch(PDO::FETCH_ASSOC);
            unlink("../image/galeri_images/".$imgRow['resim_ad']);
            
            
            $stmt_delete = $DB_con->prepare('DELETE FROM galeri WHERE galeri_id =:gid');
            $stmt_delete->bindParam(':gid',$id);
            $stmt_delete->execute();
           
        }

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
<h1 class="h2">Galeri & Modeller<a class="btn btn-default buton_ekle" href="galeri_ekle.php"> <span class="glyphicon glyphicon-plus "></span> Model Ekle</a></h1>

<?php
$numperpage = 3;
$countsql = $DB_con->prepare("SELECT COUNT(galeri_id) from galeri");
$countsql->execute();
$row = $countsql->fetch();
$numrecords = $row[0];

$numlinks = ceil($numrecords/$numperpage);
$page = isset($_GET['start'])?(int)$_GET['start'] : 1;
if($page < 1) $page = 1; 
if($page > $numrecords) $page = $numrecords;
$start =($page-1) * $numperpage;

$stmt=$DB_con->prepare("SELECT * from galeri limit $start,$numperpage");
$stmt->execute();
$sayi=0;
while($row=$stmt->fetch()){
      
    if(extract($row)){
    
    ?>
    
<form method="post" action="" enctype="multipart/form-data" class="form-horizontal form_bicim">
<table class="table table-bordered table-responsive tablo_cizgi">
<tr>
    <td class="genislik"><label class="control-label"><?php echo $galeri_id; ?>. Seri Adı</label></td>
    <td><?php echo $row['seri_ad']; ?></td>
</tr>
<tr>
    <td class="genislik"><label class="control-label">    Model Ad</label></td>
    <td><?php echo $row['model_ad']; ?></td>
</tr>
<tr>
    <td class="genislik"><label class="control-label">    Boyutlar</label></td>
	<td><?php echo $row['boyut']; ?></td>
</tr>
<tr>
    <td class="genislik"><label class="control-label" >    Ağırlık</label></td>
	<td><?php echo $row['agirlik']; ?></p></td>
</tr>
<tr>
    <td class="genislik"><label class="control-label" >    Malzeme</label></td>
	<td><?php echo $row['malzeme']; ?></p></td>
</tr>
<tr>
    <td class="genislik"><label class="control-label">    Galeri Resim</label></td>
    <td><p><img src="../image/galeri_images/<?php echo $row['resim_ad']; ?>" class="img-rounded" style="background-size:contain;" height="200px" width="200px" /></p>
    </td>
</tr>
</table>
</form>

<div class="kutu1" style="float: left; padding: 10px;">
<form method="post" action="galeri_duzenle.php">
    <tr>
        <td ><input type="hidden" name="edit_id" value="<?php echo $galeri_id; ?>" />
        <button type="submit" title="Düzenlemek İçin Tıklayınız" name="btn_save_updates" class="btn_duzen"><span class="glyphicon glyphicon-edit"></span> düzenle</button></td>
    </tr>
</form>
<br>
</div>
<div class="kutu2" style="float: left;">
<form method="post" action="galeri.php">
    <tr>
        <td><input type="hidden" name="delete_id" value="<?php echo $galeri_id; ?>" />
        <button type="submit" title="Silmek İçin Tıklayınız" name="btn_delete" class="btn_sil1" onclick="return confirm('Silmek İstediğinizden Emin misiniz?')"><span class="glyphicon glyphicon-trash"></span> sil</button></td>
    </tr>
</form>
</div>
<br>
<br>
<br>

<?php
$sayi++;
	if($sayi==3)
	{ ?>
		<a class="btn btn-info" href="galeri.php" style="background:#60aaeb; float:right; margin:5px;"><span class="glyphicon glyphicon-backward"></span>   Başa Dön</a>

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
<?php
      }
   
  
?>
<div align="center" class="col-md-12">
	<ul class="pagination">
 <?php
 $geri = (int)$page-1;
 $next = (int)$page + 1;
 

$sayfa_goster = 7;
 
$en_az_orta = ceil($sayfa_goster/2);
$en_fazla_orta = ($numlinks+1) - $en_az_orta;
 
$sayfa_orta = $page;
if($sayfa_orta < $en_az_orta) $sayfa_orta = $en_az_orta;
if($sayfa_orta > $en_fazla_orta) $sayfa_orta = $en_fazla_orta;
 
$sol_sayfalar = round($sayfa_orta - (($sayfa_goster-1) / 2));
$sag_sayfalar = round((($sayfa_goster-1) / 2) + $sayfa_orta); 
 
if($sol_sayfalar < 1) $sol_sayfalar = 1;
if($sag_sayfalar > $numlinks) $sag_sayfalar = $numlinks;
 
if($page != 1) echo '<li><a href="'.$_SERVER['PHP_SELF'].'?start=1">&lt;&lt; ilk sayfa</a></li>';
if($page != 1) echo '<li><a href="'.$_SERVER['PHP_SELF'].'?start='.($geri).'">&lt; önceki</a></li>';
 
for($s = $sol_sayfalar; $s <= $sag_sayfalar; $s++) {
    if($page == $s) {
        echo  '<li class="active secili"><a ">'.$s.'</a></li>';
    } else{
      echo  '<li><a href="'.$_SERVER['PHP_SELF'].'?start='.$s.'" style="cursor:pointer;">'.$s.'</a></li>';
      }
}
 
if($page != $numlinks) echo ' <li><a href="?start='.$next.'">sonraki &gt;</a></li>';
if($page != $numlinks) echo ' <li><a href="?start='.$numlinks.'">son sayfa &gt;&gt;</a></li>';

?>
</ul>
    </div>
<br>


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