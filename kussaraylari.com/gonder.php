
<?php
//var_dump($_POST);
include 'admin/dbconfig.php';

function dbinsert($fields, &$values) {//update function
    $insert = '';
    $values = array();
    $s=0;
    
		foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            $insert .= ":$field,";
            $values[] = getir($_POST[$field],"-"); 
            $s++;
        }
      }
  	
     return rtrim($insert, ',');
 }

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

if(isset($_POST['iletisimform']))
{   
	ini_set('SMTP', 'smtp.yourisp.com');
	ini_set( 'display_errors', 1 );
    error_reporting( E_ALL );
	require("class.phpmailer.php");
	
	$giris="*Form Bilgisi"."<br>";

	$ad=getir("ad","-");
	$tel=getir("tel","-");
	$email=getir("email","-");
	$konu=getir("konu","-");
	$mesaj=getir("mesaj","-");
	$date =date("d/m/y - G:i:s");
	$id='';
	

			$fields = explode(" ","ad tel email konu mesaj");
			
			$query  = "insert into gelenform (ad, tel, email, konu, mesaj) values(".dbinsert($fields, $values).")";
			
			$stmt=$DB_con->prepare($query);

			$stmt->bindParam(':ad',$ad);
			$stmt->bindParam(':tel',$tel);
			$stmt->bindParam(':email',$email);
			$stmt->bindParam(':konu',$konu);
			$stmt->bindParam(':mesaj',$mesaj);
			$stmt->execute();
         
			if ($stmt)  
			$msg= "islem başarılı";
			else $msg= "islem başarısız";
			
			
			/*
			$mail = new PHPMailer();
    
			$mail->IsSMTP();                                   // send via SMTP
			$mail->Host     = "mail.kussaraylari.com"; // SMTP servers
			$mail->SMTPAuth = true;     // turn on SMTP authentication
			$mail->Username = "info@kussaraylari.com";  // SMTP username
			$mail->Password = "ZeynUp10"; // SMTP password
			$mail->Port     = 587; 
			$mail->From     = $email; // smtp kullanýcý adýnýz ile ayný olmalý
			$mail->Fromname = $ad;
			$mail->AddAddress("nuraykeskincelik@hotmail.com","Nuray Çelik");
			$mail->AddAddress("av.muratcelik@hotmail.com","Murat Çelik");
			$mail->Subject  =  $konu;
			$mail->Body     =  implode("    ",$_POST);
			
			
			if(!$mail->Send())
			{
			   echo "Mesaj Gönderilemedi <p>";
			   echo "Mailer Error: " . $mail->ErrorInfo;
			   $msg= "Form Bilgisi E-poosta adresine gönderilmedi"; 
			   exit;
			}
			else{
			echo "Mesaj Gönderildi";
			$msg= "Form Bilgisi E-poosta adresine gönderildi";
			}
		*/


	$form=$date."<br>".$ad."<br>".$tel."<br>".$email."<br>".$konu."<br>".$mesaj;
	$dt="form.php";
	$dosya = fopen($dt,"a");
	
	if($dosya)
	{
		echo "<br>";
		//echo "Dosya var!";
		//echo "<br>";
		
		//$formyeni=str_replace("<br>","\n",$form);
		//echo "\n";
		$giris="*Form Bilgisi\n";
		fwrite($dosya,$giris);
		$sonuclar=explode("<br>",$form);
		foreach($sonuclar as $indis=>$formyeni)
		{
			$yazilacak=$indis.". ".$formyeni."\n";	
			echo "\n";
			
			fwrite($dosya,$yazilacak);
			
			
		}
			fwrite($dosya,"\n-----------------------\n");
			
			fclose($dosya);
			echo "<br>";
			echo "<body style='background-color:#f0e2c2;'><div style='font-size:20px; height:200px; width:50%; background-color: f0e2c2; text-align:left; border:5px solid #3e4444; margin:100px 250px 0px 300px;  padding:25px 5px 5px; 0px;background-image: url(images/largeboyut/yesil.jpg); background-repeat: no-repeat; background-position: right; background-size: contain;'><b>Form Bilgileriniz Kaydedildi! İlginize Teşekkür Ederiz...</b><br><br><br><a href='iletisim.php' style='font-size:15px; color:#3e4444; float:right; cursor:pinter;'>İletişim Sayfasına Geri Dön</a></div></body>\n";
			
	} 
	else
	{
		echo "<body style='background-color:#F0F7D4; border:10px solid #1e88e3;'><div style='color: #fff; font-size:20px; height:50px; width:400px; background-color: red; text-align:center; border:3px solid red; margin:0px; padding:20px 0px 5px; 0px ; '><b>Bilgiler kaydedilmedi!</b><br><br><br><a href='iletisim.php' style='font-size:12px; color:#fff; float:right; cursor:pointer;'>İletişim Sayfasına Geri Dön</a></div></body>";	
	}
	}
	
	else echo '<div style ="color: red; font-size:18px; text-align:center; margin:100px 250px 0px 300px; padding-top:40px; padding-bottom:0px;border-top:2px solid darkgrey;border-bottom:2px solid darkgrey; width:50%; height:200px; position:absolute;"><b>Form bilgileriniz kaydedilmedi! Lütfen form bilgilerinizi kontrol ediniz!</b><br><br><br><br><br><a href="iletisim.php" style="font-size:12px; color:rgba(0,0,1,1);float:right; cursor:pointer;">İletişim Sayfasına Geri Dön</a></div>';
	?>