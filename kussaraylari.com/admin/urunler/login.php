<?php
    ob_start();
    session_start();
    error_reporting( ~E_NOTICE );
    require_once '../dbconfig.php';
    date_default_timezone_set('Europe/Istanbul');

   function sqlonleme($data)
  {
    $data = str_replace("select","",$data);
    $data = str_replace("SELECT","",$data);
    $data = str_replace("*", "", $data);
    $data = str_replace("from","",$data);
    $data = str_replace("FROM","",$data);
    return $data;
  }

  function check_input($data)
 {  
  
  $data1 = trim($data);
  $data2 = stripslashes($data1);
  $data3 = htmlspecialchars($data2);
   
    return sqlonleme($data3);
 }


function getir($key, $varsayilan)
{
  if(isset($_POST[$key]))
  {
        return check_input($_POST[$key]);
  }
  else

  return $varsayilan;
}
   
      $msg='';
      
       
      if(isset($_POST['btngiris']) && isset($_POST['ad']) && !empty($_POST['ad']) && isset($_POST['sifre']) && !empty($_POST['sifre']))
    {
        $ad = getir("ad","-");
        $sifre = getir("sifre","-");
       
        $stmt=$DB_con->prepare('SELECT * FROM admintbl WHERE admin_ad =?');
        $stmt->execute([$ad]);
        $result=$stmt->fetch();
        
        try{
            if($stmt->rowCount()>0 && password_verify($sifre, $result['admin_sifre'])){
              $_SESSION['name']= $ad;
              $_SESSION['logged'] = time();
              header('Location: index.php');
              exit();
             }
            else{
              $msg="Yanlış kullanıcı ad ve şifre";?>
              
              <div class="alert alert-danger"><?php echo $msg;?>
         
            </div>
            <?php
              header("Location:login.php?msg=$msg");
            }
          }
        
        catch(PDOException $e){ 
          
          return false;
           }
           ob_end_flush();
        }
        elseif ($_GET['durum']=="exit"){
          session_destroy();
          session_unset();
          $msg = "Başarıyla Çıkış Yaptınız.";
          header("Location: login.php?msg=$msg",TRUE,302); 
          header("Cache-Control: no-cache, no-store, must-revalidate, Pragma:no-cache, Expires:0");
          header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
          
          die();
          exit();
        }
        
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

<div class="col-md-8 login_orta">   
<div class="box">
  <h2>Yönetim Paneli</h2>
 <form method="post" enctype="multipart/form-data" class="form-horizontal">
  <div class="inputbox">
    <label class="control-label"> Kullanıcı Adınız</label><input class="form-control" type="text" required="required" name="ad" value="<?php echo $kullanici_ad; ?>" />
  <div class="inputbox">
    <label class="control-label">Şifreniz</label>
    <input class="form-control" type="password" required="required" name="sifre" />
  </div>
  <div class="inputbox">
    <button type="submit" name="btngiris" class="btn btn-default">giriş   <span class="glyphicon glyphicon-log-in"></span>
    </button>
    </tr>    
  </div>
</form>
</div>
<div class="col-md-6 login_footer">
  <a href="wwww.ankayazilim.com"><strong> Anka Yazılım	&	©2018 Bütün Hakları Saklıdır.</strong></a>
</div>
</div>


<!-- Latest compiled and minified JavaScript -->
<script src="bootstrap/js/bootstrap.min.js"></script>



</body>
</html>