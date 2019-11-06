<?php
include 'header.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<iframe src="https://www.google.com/maps/d/embed?mid=1_o--4rPhKjQWb4L6If9AxxM8vDWpvXmX" width="100%" height="480"  style="border:0"></iframe>
<section class="container max990px secimage1">
  <?php 
  $stmt=$DB_con->prepare('SELECT * from iletisim where iletisim_id');
  $stmt->execute();
      while($row=$stmt->fetch())
          {
            if(extract($row))
                  {
  ?>
<div class="col-md-6 ilet_sol_blok_baslik">
  <b><?php echo $row['sirket_ad'];?></b>

  <div class="ilet_sol_adresBlok">
    <div>Adres : <span><?php echo $row['adres'];?></span>
    </div>
  </div>

  <div class="ilet_sol_adresBlok">
    <div>Telefon : <span><?php echo $row['telefon'];?></span>
    </div>
  </div> 
    
  <div class="ilet_sol_adresBlok"> 
    <div>E-mail : <span><?php echo $row['email'];?></span> 
    </div>
  </div> 
</div>
<?php 
    }
  }
?>
<div class="col-md-6 ilet_sag ilet_usttenayrac" id="siparis">
  <b class="ilet_sag_blok_baslik">İLETİŞİM FORMU<span>Bilgi ve Sipariş İçin : </span></b>

  <form id="contact-form" action="gonder.php" method="post" enctype="multipart/form-data">
  <div class="form-group">
    <label for="exampleInputEmail1">Ad Soyad</label>
    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Ad Soyad" name="ad" />
    </div>

    <div class="form-group">
    <label for="exampleInputEmail1">Telefon</label>
    <input type="tel" class="form-control" id="exampleInputEmail1" placeholder="Telefon" name="tel" />
  </div>

  <div class="form-group">
    <label for="exampleInputEmail1">e-mail</label>
    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="e-mail" name="email" />
  </div>
   <div class="form-group">
    <label for="exampleInputEmail1">Konu</label>
    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Konu" name="konu" />
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">Mesaj</label>
    <textarea class="form-control" rows="3" placeholder="Mesajınızı Yazınız" name="mesaj"></textarea>
  </div>
  
  
 <div class="form-group"><button class="formbuton" type="submit" onclick="javascript:window.location.href='gonder.php';return true;" name="iletisimform">Gönder <i class="fa fa-send" style="font-size:15px"></i></button>
 </div>
</form>
</div>
</section>

<?php
include 'footer.php';
?>