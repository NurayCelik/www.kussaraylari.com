<?php
include 'header.php';

function tcevir($tarih){
	$tr = explode("-",$tarih); 
	$tarih1 = $tr[2]."-".$tr[1]."-".$tr[0]; 
	return $tarih1;
}
?>



<section class="container max1110px ">
<ol class="breadcrumb yenibreadcrumb">
  <li><a href="index.php">Anasayfa</a></li>
  <li class="active">Blog</li>
</ol>

<div class="page-header blogum">
<h3>BLOG</h3><h5>Güncel Makaleler</h5>
  <div class="row">
  <div class="col-md-8 blogsecimage1 blogborder" > 
        <p>
          <img src="images/UnknowKusEvi.JPG"  class="img-responsive img-rounded" alt="" style="height:482px; width:100%; image-size:contain;"/>
        </p>
 </div>  
<div class="col-md-4 blog_md_4son" style="float:right;width:30%; height:100%;">
    <div class="list-group arsiv_duzen">
      <a href="#" class="list-group-item arsiv1" id="list_baslik">
        Blog Arşivi
      </a>
      <?php
      $numperpage = 7; 
      $countsql = $DB_con->prepare("SELECT COUNT(makale_id) from blog");
      $countsql->execute();
      $row = $countsql->fetch();
      $numrecords = $row[0];
      
      $numlinks = ceil($numrecords/$numperpage);
      $page = isset($_GET['start1'])?(int)$_GET['start1'] : 1;
      if($page < 1) $page = 1; 
      if($page > $numrecords) $page = $numrecords;
      $start1 =($page-1) * $numperpage;
      
      $stmt=$DB_con->prepare("SELECT * from blog limit $start1,$numperpage");
      $stmt->execute();
      While($row=$stmt->fetch()){
        if( extract($row)){
                 ?>
      <a href="arsiv.php?#<?php echo $row['baslik_id'];?>" class="list-group-item arsiv_baslik" onMouseOver="this.style.color='#061b2d'"
   onMouseOut="this.style.color='#0e4371'"><?php echo $row['makale_baslik'];?></a> 
      
        <?php
           }
        }
    
    ?>
    <div align="center" >
  <ul class="pagination">
<?php


 
 $geri = (int)$page-1;
 $next = (int)$page + 1;
 
 $sayfa_goster = 5; 
 
$en_az_orta = ceil($sayfa_goster/2);
$en_fazla_orta = ($numlinks+1) - $en_az_orta;
 
$sayfa_orta = $page;
if($sayfa_orta < $en_az_orta) $sayfa_orta = $en_az_orta;
if($sayfa_orta > $en_fazla_orta) $sayfa_orta = $en_fazla_orta;
 
$sol_sayfalar = round($sayfa_orta - (($sayfa_goster-1) / 2));
$sag_sayfalar = round((($sayfa_goster-1) / 2) + $sayfa_orta); 
 
if($sol_sayfalar < 1) $sol_sayfalar = 1;
if($sag_sayfalar > $numlinks) $sag_sayfalar = $numlinks;
 
if($page != 1) echo '<li><a href="blog.php?start1='.($geri).'">&lt; önceki</a></li>';
 
for($s = $sol_sayfalar; $s <= $sag_sayfalar; $s++) {
    if($page == $s) {
        echo  '<li class="active secili"><a>'.$s.'</a></li>';
    } else{
      echo  '<li><a href="blog.php?start1='.$s.'" style="cursor:pointer;">'.$s.'</a></li>';
      }
}
 
if($page != $numlinks) echo ' <li><a href="?start1='.$next.'">sonraki &gt;</a></li>';


?>
</ul>
      </div>
  </div>
</div>
<div class="clearfix"></div> 
<div class="row">

<?php
$numperpage = 3;
$countsql = $DB_con->prepare("SELECT COUNT(makale_id) from blog");
$countsql->execute();
$row = $countsql->fetch();
$numrecords = $row[0];

$numlinks = ceil($numrecords/$numperpage);
$page = isset($_GET['start'])?(int)$_GET['start'] : 1;
if($page < 1) $page = 1; 
if($page > $numrecords) $page = $numrecords;
$start =($page-1) * $numperpage;

$stmt=$DB_con->prepare("SELECT * from blog limit $start,$numperpage");
$stmt->execute();
while($row=$stmt->fetch())
		{
      if(extract($row))
            {
             ?>
<div class="col-md-8 blogsecimage blogborder" > 
    <div class="bloke">
        <h3 id="<?php echo $row['baslik_id']; ?>" class="bilgibaslikblog"><?php echo $row['makale_baslik']; ?><br>
        <date style="text-align: right; padding-right: 200px; font-size: 13px; color:#262626;"> <?php echo tcevir($row['makale_tarih']);?>, Av. Murat Çelik</date><br></h3>
        <p><?php echo $row['makale_icerik'];?>
        </p>

    </div> 
 </div>        
 
<div class="col-md-4 blog_md_4">
  <?php
  
  if(count($row['makale_resim'])>0)
  {
    ?>
    
  <img src="admin/image/blog_images/<?php echo $row['makale_resim']; ?>" class="img-responsive img-rounded" alt="" width="500px" height="350px"> 
 
   <?php
  }
  if(count($row['makale_url'])>0)
  {
    ?>
    <?php echo $row['makale_url'];?>
  
<?php
  }
  
  ?>
  
 </div>
    
    
<div class="clearfix"></div> 

<?php
      }
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
 
if($page != 1) echo '<li><a href="blog.php?start=1">&lt;&lt; ilk sayfa</a></li>';
if($page != 1) echo '<li><a href="blog.php?start='.($geri).'">&lt; önceki</a></li>';
 
for($s = $sol_sayfalar; $s <= $sag_sayfalar; $s++) {
    if($page == $s) {
        echo  '<li class="active secili"><a ">'.$s.'</a></li>';
    } else{
      echo  '<li><a href="blog.php?start='.$s.'" style="cursor:pointer;">'.$s.'</a></li>';
      }
}
 
if($page != $numlinks) echo ' <li><a href="?start='.$next.'">sonraki &gt;</a></li>';
if($page != $numlinks) echo ' <li><a href="?start='.$numlinks.'">son sayfa &gt;&gt;</a></li>';

?>
</ul>
    </div>


</div>
</div>

</section>
<?php
include 'footer.php';
?>