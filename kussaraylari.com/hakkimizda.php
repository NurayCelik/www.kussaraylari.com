<?php
include 'header.php';
?>



<section class="container max1110px ">
<!-- hakkımızda başlık için letter-spacing:0.07em; gibi
satır yüksekliği içinline-height:1.5em; -->
  <ol class="breadcrumb yenibreadcrumb">
    <li><a href="index.php">Anasayfa</a></li>
    <li class="active">Hakkımızda</li>
  </ol>

  <div class="page-header hakkimizda">
    <h2>HAKKIMIZDA</h2>
      <div class="row">
      <?php
      $stmt=$DB_con->prepare("SELECT * from hakkimizda where hakkimizda_id=1 limit 1");
      $stmt->execute();
      while($row=$stmt->fetch())
          {
            if(extract($row))
                  {
                  ?>
     
        <div class="col-md-12 hakkimdasecimage hakborder"> 
          <h3 id= "askimiz"><?php echo $row['baslik'];?></h3>
            <p id="giris">
              <?php echo $row['giris'];?>
            </p>
              <div class="col-md-6 hakimage">
                <h5><b><?php echo $row['ortak1_ad'];?></b></h5>
                  <p>
                    <img src="images/nuray.jpg" class="img-thumbnail" alt="Nuray ÇELİK" width="200" height="200"> 
                  <?php echo $row['ortak1_icerik'];?>
                  </p>

              </div>
            <div class="col-md-6 hakimage">
              <h5><b><?php echo $row['ortak2_ad'];?></b></h5>
                <img src="images/murat.jpg" class="img-thumbnail" alt="Murat ÇELİK" width="200" height="200"> 
                <p>
                   <?php echo $row['ortak2_icerik'];?>
                </p>           
            </div>
        </div>
        <?php
              }
          }
        ?>  
      </div>
  </div>
</section>
<?php
include 'footer.php';
?>