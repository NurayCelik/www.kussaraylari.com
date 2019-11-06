<?php
include 'header.php';

?>

<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
    <li data-target="#carousel-example-generic" data-slide-to="3"></li>
    <li data-target="#carousel-example-generic" data-slide-to="4"></li>
    <li data-target="#carousel-example-generic" data-slide-to="5"></li>
    <li data-target="#carousel-example-generic" data-slide-to="6"></li>
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner imgslide" role="listbox">
    <div class="item active">
      <img src="images/4bird.jpeg" alt="Slider 1">
      </div>
    <div class="item">
      <img src="images/3bird.jpeg" alt="Slider 3">
      </div>
    <div class="item">
      <img src="images/1bird.jpeg" alt="Slider 4"> 
      </div>  
    <div class="item">
      <img src="images/5bird.jpeg" alt="Slider 5">
    </div>
    <div class="item">
      <img src="images/6bird.jpeg" alt="Slider 6">
    </div>
    <div class="item">
      <img src="images/7bird.jpeg" alt="Slider 7">
    </div>
    
  </div>

  <!-- Controls -->
  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
    <span class="glyphicon slide_icon_left" aria-hidden="true"><</span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
    <span class="glyphicon slide_icon_right" aria-hidden="true">></span>
    <span class="sr-only">Next</span>
  </a>
</div>
<section class="container sectionstyle max1110px">
  <div class="row">
    <div class="col-md-8 secimage">
      <?php
    $stmt = $DB_con->prepare('SELECT * FROM blog ORDER BY makale_id asc limit 1');
	  $stmt->execute();
	
    if($stmt->rowCount() > 0)
    {
      while($row=$stmt->fetch(PDO::FETCH_ASSOC))
      {
        extract($row);
        ?>
    <h2 class="bilgibaslik" id="yeniden"><?php echo $row['makale_baslik'];?></h2>
          <p class="bilgibaslikaciklama">
          <?php echo substr($row['makale_icerik'],0,3000);?>...</p><br>
        <div class="devami"><a href="blog.php?id=#yeniden" style="color:#e8f3fc;  font-size:12px; float: center;">Yazının Devamı >></a></div>
      <?php }
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
	
?></div> 

    <div class="col-md-4 sideborder">
     <div class="anasayfa_dikey_hiza">
    <div class="panel panelbackground">
      <div class="panel-heading panelrengi">Geçmişten Günümüze Kuş Sarayları</div>
        <div class="panel-body">
          <div class="embed-responsive embed-responsive-16by9 video_height">
            <iframe width="560" height="500" src="https://www.youtube.com/embed/nzqd52V1zlY" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
          </div>
        </div>
      </div>
    </div> 
    <div class="clearfix"></div>
     <div class="bilgibaslik1">
           <a href="saraylarimiz.php"><h4>Kuş Saraylarımız</h4></a>
         <div>
           <a href="saraylarimiz.php"><img src="images/anka.jpg" class="img-responsive" alt="Nostalji Serisi" width="326" height="550px" style="height: 250px;"> </a>
        </div>
            <p class="bilgibaslikaciklama1">Modellerimizi tasarlarken kalite ve estetik kaygılar bizim için önemliydi. Kuş Saraylarımız, yapımı tamamlanmış ya da tamamlanmamış apartman gibi binaların yanında okul ve camilerle park ve bahçelerin uygun alanlarına monte edilebilmektedir. Mimari, inşaat mühendisliği ve peyzaj mimarlığı projelerinde modellerimiz kullanılabilmektedir.</p>
        <div class="anasayfa_blog_yazi">
          <a href="saraylarimiz.php">Tasarımlarımızı incelemek ve sipariş vermek için Tıklayın...</a>
        </div>
    </div> 
  </div>    
  </div>

<div class="clearfix"></div>
  <div class="row">
    <div class="col-md-4 col-sm-6 col-xs-6 blokstil">
      <div class="bilgiblok1"></div>
      <span><br>Kuş Saraylarına İhtiyaç Var mı?</span>
      <p>Birçok yönden gereklilik var:<br>Sevgi <b>Sorumluluk</b> ve İlgi...</p>
        <div><button class="blokstilbuton" onclick="location.href='arsiv.php?id=#sevgi'" type="button">Ayrıntılar »</button></a></div>
      
    </div>
    <div class="col-md-4 col-sm-6 col-xs-6 blokstil">
      <div class="bilgiblok2"></div>
      <span><br>İşimiz Değil Aşkımız...</span>
        <p>Kamu otoritesinin konuyu sahiplenmesini sağlayacak bir vizyonu uhdemizde nasıl sergileriz?</p>
       <div><button class="blokstilbuton" onclick="location.href='arsiv.php?id=#isimiz'">Ayrıntılar »</button></div>
        
    </div>

    <div class="col-md-4 col-sm-6 col-xs-6 blokstil">
      <div class="bilgiblok3"></div>
      <span><br>Destekçilerimiz</span><br> 
      <p>En büyük destekçilerimiz gökyüzündeki dostlarmız.</p>
<br>
 <div><button class="blokstilbuton" onclick="location.href='blog.php?id=#destek'">Ayrıntılar »</button></div>
    </div>
  </div>
</section>
<?php
include 'footer.php';
?>