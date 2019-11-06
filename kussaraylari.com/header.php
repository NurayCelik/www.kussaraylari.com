<?php 
include 'admin/dbconfig.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="tr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge;text/html;charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta name="description" content="Nuray Çelik & Anka Yazılım ">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Anka Kuş Sarayları</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="fonts" rel="stylesheet">
    <link href="css/lightbox.min.css" rel="stylesheet">    
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script type="text/javascript" src="js/saray.js"></script>
    
    <script src="//cdn.ckeditor.com/4.6.1/standard/ckeditor.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]> <![endif]-->
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

  </head>
  <body>
    <?php
    
    
    
    function ip_visitor_country()
    {

    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];
    $country  = "Unknown";

    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://www.geoplugin.net/json.gp?ip=".$ip);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    $ip_data_in = curl_exec($ch); // string
    curl_close($ch);

    $ip_data = json_decode($ip_data_in,true);
    $ip_data = str_replace('&quot;', '"', $ip_data); // for PHP 5.2 see stackoverflow.com/questions/3110487/

    if($ip_data && $ip_data['geoplugin_countryName'] != null) {
        $country = $ip_data['geoplugin_countryName'];
    }

    return 'IP: '.$ip.' # Country: '.$country;
    }

    $visit=ip_visitor_country()." \nend\n*************************************************\n\n\n"; // output Coutry name
    
    
     function getRealIpAddr()
    {
    if(!empty($_SERVER['HTTP_CLIENT_IP']))
    {
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
    }
    
    
    $ip = @$_SERVER['REMOTE_ADDR'];
    $proxyAdress = "\nProxy Adres = ".@$_SERVER['HTTP_X_FORWARDED_FOR']; 
    $url= "\nurl adresi = ".@$_SERVER['HTTP_REFERER']; 
    $xml = simplexml_load_file("http://www.geoplugin.net/xml.gp?ip=".getRealIpAddr());
    $ip_ulke= "\nIP ülke = ".$xml->geoplugin_countryName;
    $ayrinti="";
    foreach ($xml as $key => $value)
    {
       $ayrinti .=  $key . "= " . $value .  " \n" ;
    }
    $yeniAyrinti= "\nAyrıntılı Bilgiler = ".$ayrinti."\n";
    $linki = "linki = ".@$_SERVER['REQUEST_URI'];
    $webpage ="\nWeb Sayfası = ".$_SERVER['SCRIPT_NAME'];
    $complete_path = $_SERVER['SCRIPT_FILENAME'];
    $hostname = @$_SERVER['HTTP_HOST']."\n";
    //$hostname1 = "\nBu host mu? ".@$_SERVER['host']."\n";
    $browser = $_SERVER['HTTP_USER_AGENT'];
    $veri = date ("d-m-Y / H:i:s");
    $invoegen = $veri." - \nip numarası= ".$ip."\nHostname= ".$hostname."\ncomplete_path = ".$complete_path."\n";
    $fopen = fopen("iplogin.php","a");
    fwrite ($fopen,$invoegen);
    fwrite ($fopen,$linki);
    fwrite ($fopen,$webpage);
    //fwrite ($fopen,$hostname1);
    fwrite ($fopen,$proxyAdress);
    fwrite ($fopen,$url);
    fwrite ($fopen,$ip_ulke);
    fwrite ($fopen,$yeniAyrinti);
    fwrite ($fopen,$visit);
    
    
    fclose($fopen); 

?>
    <header class="menucizgi">
      <nav class="navbar navbar-default container max1200px pad0 nav_bg nav_alttan0px">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header mobilheader">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand sifirlaicerik" href="index.php"><img src="images/ankaLogo2.jpeg" class="img-responsive" width="100" height="auto"></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav sagahizala">
        <li><a href="index.php" class="anaimg"><img src="images/home.png"> ANASAYFA</a></li>
        <li><a href="hakkimizda.php" class="hakimg"><img src="images/aboutus.png"> HAKKIMIZDA</a></li>
        <li><a href="saraylarimiz.php" class="sarayimg"><img src="images/queen.png"> SARAYLARIMIZ</a></li>
        <li><a href="blog.php" class="blogimg"><img src="images/blog.png"> BLOG</a></li>
        <li><a href="iletisim.php" class="iletisimimg"><img src="images/iletisim.png"> İLETİŞİM</a></li>
        <div class="container whatsapp">
           <a href="#" data-toggle="tooltip" data-placement="bottom" title="05326001924" class="a1"> <img src="images/whatsapp.png" width="40" height="40"> Whatsapp İletişim : <no>0 532 600 19 24</no></a> 
         </div>
      </ul>
     
     </div><!-- /.navbar-collapse -->
    

 </div><!-- /.container-fluid -->
</nav>

</header>