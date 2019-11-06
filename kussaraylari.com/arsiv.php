<?php
include 'header.php';

function tcevir($tarih){
	$tr = explode("-",$tarih); 
	$tarih1 = $tr[2]."-".$tr[1]."-".$tr[0]; 
	return $tarih1;
}
?>



<section class="container max1110px ">
<!-- hakkımızda başlık için letter-spacing:0.07em; gibi
satır yüksekliği içinline-height:1.5em; -->
<ol class="breadcrumb yenibreadcrumb">
  <li><a href="index.php">Anasayfa</a></li>
  <li class="active">Blog</li>
</ol>

<div class="page-header blogum">
  <h3>BLOG</h3><h5>Güncel Makaleler</h5>
  <div class="row">
  <div class="col-md-8 blogsecimage1 blogborder" > 
        <p>
          <img src="images/UnknowKusEvi.JPG"  class="img-responsive img-rounded" alt="" style="height:462px; width:100%; image-size:contain;"/>
        </p>
 </div> 
 <div class="col-md-4 blog_md_4son" style="float:right;width:30%; height:100%;">
    <div class="list-group arsiv_duzen">
      <a class="list-group-item arsiv1" id="list_baslik">
        Blog Arşivi
      </a>
      <?php
      $numperpage = 7; // sayfada gösterilecek içerik miktarını belirtiyoruz.
      $countsql = $DB_con->prepare("SELECT COUNT(makale_id) from blog");
      $countsql->execute();
      $row = $countsql->fetch();
      $numrecords = $row[0];
      
      $numlinks = ceil($numrecords/$numperpage);
      $page = isset($_GET['start'])?(int)$_GET['start'] : 1;
      if($page < 1) $page = 1; 
      if($page > $numrecords) $page = $numrecords;
      $start =($page-1) * $numperpage;
      /*$start +=1;//Sayfada ilk haber daha önce çekildiği için veritabanından, 
                 //limiti startın bir fazlasında başlattık.Aynı makaleyi göstermemek için 
                 //böyle bir durum olmasa bir artırmayız.
      //echo "start is".$start.'<br>';*/
      $stmt=$DB_con->prepare("SELECT * from blog limit $start,$numperpage");
      $stmt->execute();
      While($row=$stmt->fetch()){
        if( extract($row)){
                 
                      //$id=$row[0];
                      //$baslik=$row[1];
                     
                  
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
 
 $sayfa_goster = 5; // tek sayı seç ortada seçili olması için
 
$en_az_orta = ceil($sayfa_goster/2);
$en_fazla_orta = ($numlinks+1) - $en_az_orta;
 
$sayfa_orta = $page;
if($sayfa_orta < $en_az_orta) $sayfa_orta = $en_az_orta;
if($sayfa_orta > $en_fazla_orta) $sayfa_orta = $en_fazla_orta;
 
$sol_sayfalar = round($sayfa_orta - (($sayfa_goster-1) / 2));
$sag_sayfalar = round((($sayfa_goster-1) / 2) + $sayfa_orta); 
 
if($sol_sayfalar < 1) $sol_sayfalar = 1;
if($sag_sayfalar > $numlinks) $sag_sayfalar = $numlinks;
 
if($page != 1) echo '<li><a href="arsiv.php?start='.($geri).'">&lt; önceki</a></li>';
 
for($s = $sol_sayfalar; $s <= $sag_sayfalar; $s++) {
    if($page == $s) {
        echo  '<li class="active secili" style="cursor:pointer;" "><a>'.$s.'</a></li>';
    } else{
      echo  '<li><a href="arsiv.php?start='.$s.'" style="cursor:pointer;">'.$s.'</a></li>';
      }
}
 
if($page != $numlinks) echo ' <li><a href="?start='.$next.'">sonraki &gt;</a></li>';


?>
</ul>
      </div>
  </div>
</div>
<div class="clearfix"></div>

<?php
  $stmt = $DB_con->prepare('SELECT * FROM blog order by makale_id asc limit 1000');
	$stmt->execute();
	
	if($stmt->rowCount() > 0)
	{
   
		while($row=$stmt->fetch(PDO::FETCH_ASSOC))
		{
            if(extract($row))
            {
         ?>
<div class="col-md-8 blogsecimage blogborder"> 
    <div>
        <h3 id="<?php echo $row['baslik_id']; ?>" class="bilgibaslikblog"><?php echo $row['makale_baslik']; ?><br>
        <date style="text-align: right; padding-right: 200px; font-size: 13px; color:#262626;"> <?php echo tcevir($row['makale_tarih']);?>, Av. Murat Çelik</date><br></h3>
        <p><?php echo $row['makale_icerik'];?></p>
    </div> <a class="btn btn-info" href="blog.php" style="background:#60aaeb;"> Geri Dön</a>
  </div>  
        
  
  <div class="col-md-4 blog_md_4">
  <?php
  if(count($row['makale_resim'])>0){
    ?>
    <div>
  <img src="admin/image/blog_images/<?php echo $row['makale_resim']; ?>" class="img-responsive" alt="" width="350px" height="200px"> 
   </div>
   
   <?php
  }
  if(count($row['makale_url'])>0)
  {
    ?>
        <div class="embed-responsive embed-responsive-16by9 video_height">
            <?php echo $row['makale_url'];?>
        </div>
<?php
  }
  ?>
  </div> 
    
<div class="clearfix"></div> 

<?php
      }
    }
 } 
?>





</div>
</div>

</section>
<?php
include 'footer.php';
?>