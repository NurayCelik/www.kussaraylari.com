
<div class="altmenucizgi1"></div>
<footer class="footer_bg">

  <div class="altmenucizgi"></div>
 <div class="container max1200px"> 
  <div class="row">
    <div class="col-md-3 col-sm-3 col-xs-6">
        <img src="images/ankaLogo1.jpeg" class="img-circle footerimg"/>
       
       </div>
       <div class="col-md-3 col-sm-3 col-xs-6 altblokstil">
          <ul>
            <li><a href="index.php">anasayfa</a></li>
            <li><a href="hakkimizda.php">hakkımızda</a></li>
            <li><a href="saraylarimiz.php">saraylarımız</a></li>
            <li><a href="blog.php">blog</a></li>
            <li><a href="iletisim.php">iletişim</air></li>
          </ul>
       
       </div>
       <?php 
  $stmt=$DB_con->prepare('SELECT * from sosyal_medya where sosyal_id');
  $stmt->execute();
      while($row=$stmt->fetch())
          {
            if(extract($row))
                  {
  ?>
    <div class="col-md-3 col-sm-3 col-xs-6 altblokstil2">
       <div class="altfaceblok">
        <div>
        <span>
          <a href="<?php echo $row['facebook_ad'];?>">
          <svg width="25" height="25">
            <rect x="0" y="0" rx="15" ry="15" width="24" height="24"
          style="fill:#60aaeb;stroke:#60aaeb;stroke-width:5;opacity:1" />
            <text fill="#3a384c" font-size="19" font-weight="bold"; font-family="Sans-serif"
          x="9" y="20">f</text>
          </svg>
            Facebook</a>
        </span>
      </div>
        <br>
        <div>
         <span>
          <a href="<?php echo $row['twitter'];?>">
          <svg width="25" height="25">
            <rect x="0" y="0" rx="15" ry="15" width="24" height="24"
          style="fill:#60aaeb;stroke:#60aaeb;stroke-width:5;opacity:1" />
            <image href="images/twitter1.png" height="25" width="25" x="0" y="0" style="color: #3a384c;">
          </svg>
            Twitter</a>
        </span>
      </div>
        <br>
        <div>
         <span> 
          <a href="<?php echo $row['google_ad'];?>">
          <svg width="25" height="25">
            <rect x="0" y="0" rx="15" ry="15" width="24" height="24"
          style="fill:#60aaeb;stroke:#60aaeb;stroke-width:5;opacity:1" />
            <text fill="#3a384c" font-size="19" font-weight="bold"; font-family="Sans-serif"
          x="0" y="18">g<a style="font-size: 14px; font-weight: 600;">+</a></text>
          </svg>
           Google</a>
        </span>
       </div>
      </div>
   </div>
   <?php
      }
    }  

   ?>
        <div class="col-md-3  col-sm-3 col-xs-6 altblokstil3">
       <b>ANKA KUŞ SARAYLARI SANAT &nbsp;TASARIM YAZILIM</b>
      <div class="adrescizgi">
       <div>
        <span class="footer_adres"><img src="images/footer1.png"></span>Ekinci Mah. Kardelen Cad. No: 43 <br> &emsp;&emsp;&nbsp;Antakya / HATAY
       </div>
       <div>
          <span class="footer_tel"><img src="images/footer2.png"></span> 
        Tel: 0 532 600 19 24
          <div>
          &emsp;&emsp;&nbsp;e-mail : info<span style="color:#d64161;font-size:20px; margin-right: 0px; padding-top: 0px;">@</span>kussaraylari.com
       </div>
       </div>
    </div>
  </div>
  <div class="col-md-12 col-sm-3  col-xs-6 yazar">
  Copyright <span>Ⓒ</span> 2018 | <a href="index.php" style="color: #494d50;"><span> www.kussaraylari.com</span></a> | Made By Nuray Çelik & Anka Yazılım
</div>
  </div>
</div>

</footer>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/saray.js" type="text/javascript"></script>
     <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
     <script src="bootstrap/js/bootstrap.min.js"></script>
   
  </body>
</html>