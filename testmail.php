<?php
ini_set( 'display_errors', 1);
error_reporting( E_ALL );
$from = "test@dmsguinee.com";
$to ="d.amadoumouctar@yahoo.fr";
$subject = "votre facture";
$message = 'Merci de trouver votre facture en cliquant sur ce lien http://logescom.dmsguinee.com/abda/recherche.php?recreditc=abda210015';
$headers = "From:" . $from;
mail($to,$subject,$message, $headers);
echo "L'email a été envoyé.";

$list_emails_to = array('johndoe@ovh.net','maxlamenace@ovh.net');
foreach ($list_emails_to  as $key => $email) {
  $mail->AddAddress($email);
}


$mail->AddAttachment('./doc/content/rapport.pdf','Rapport_2018.pdf');
?>