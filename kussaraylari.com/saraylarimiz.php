<link href='https://fonts.googleapis.com/css?family=Raleway:300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="css/lightbox.min.css">
	<link rel="stylesheet" type="text/css" href="css/style_galeri.css">
	<script type="text/javascript" src="js/lightbox-plus-jquery.min.js"></script>
	
	<?php include 'header.php';?>
	
    




	<section class="container yeni_container">
		<h1>Kuş Saraylarımız / Galeri</h1>
		<p class="ps">Modellerimizi tasarlarken kalite ve estetik kaygılar bizim için önemliydi. Her mimaride tarihsel anlam ve görselliği bulabilirsiniz. Büyük bir titizlikle ortaya çıkarılan saraylarımız, tamamlanmış ya da tamamlanmamış istediğiniz bina ve apartmanların dış cephesine monte edilebilmektedir. Kuş Saraylarımız, apartman gibi binaların yanında okul ve camilerle park ve bahçelerin uygun alanları için de güzel bir seçenektir. Mimari, inşaat mühendisliği ve peyzaj mimarlığı projelerinde modellerimiz kullanılabilmektedir. Beğendiğiniz modellerimizden satın almak için ve modellerle ilgili ayrıntılı bilgi için gerek telefon ile gerekse iletişim sayfasından form göndererek bizimle irtibata geçebilirsiniz.</p>
		
		<div class="row">

		<?php
		$numperpage = 4;
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
		while($row=$stmt->fetch())
				{
		      if(extract($row))
		            {
		             ?>
			<div class="col-md-6"> 
				<div class="thumbnail">
					<a href="admin/image/galeri_images/<?php echo $row['resim_ad'];?>" data-lightbox="mygallery" data-title="<?php echo $row['seri_ad'];?> Serisinden <?php echo $row['model_ad'];?>"><img src="admin/image/galeri_images/<?php echo $row['resim_ad'];?>" alt="<?php echo $row['seri_ad'];?> Serisinden <?php echo $row['model_ad'];?>"></a>
					<div class="captain">
						<p class="modelboyut"><b>Boyutlar:</b> <etiket style="color:#1667af;"><?php echo $row['boyut'];?></etiket></p>
						<p class="modelboyut"><b>Ağırlık:</b> <etiket style="color:#1667af;"><?php echo $row['agirlik'];?> </etiket></p>
						<p class="modelboyut"><b>Malzeme:</b> <etiket style="color:#1667af;"><?php echo $row['malzeme'];?> </etiket></p>
						<p class="modelboyut"><a href="iletisim.php?id=#siparis"><b><?php echo $row['model_ad'];?> Modelimizden Satın Almak İçin Tıklayınız</b> >></b></a></p>
					</div>
				</div>
			</div>

		<?php
			     }
			 }
			  
		?>
		<div align="center" class="col-md-12">
			<ul class="pagination" id="paginat">
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
		        echo  '<li class="active secili1"><a ">'.$s.'</a></li>';
		    } else{
		      echo  '<li><a href="'.$_SERVER['PHP_SELF'].'?start='.$s.'" style="cursor:pointer;">'.$s.'</a></li>';
		      }
		}
		 
		if($page != $numlinks) echo ' <li><a href="?start='.$next.'">sonraki &gt;</a></li>';
		if($page != $numlinks) echo ' <li><a href="?start='.$numlinks.'">son sayfa &gt;&gt;</a></li>';

		?>
		</ul>
		    </div>
			
		


		</div>
	</section>	
<?php
include 'footer.php';
?>