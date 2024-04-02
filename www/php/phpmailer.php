<?php
    //require 'mailer/PHMailerAutoload.php';
    
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';

    $mail = new PHPMailer();

    $mail->Mailer = "smtp";
    $mail->isSMTP();
    $mail->CharSet = "UTF-8";
    $mail->SMTPDebug= 0;
    $mail->SMTPAuth= true;
    $mail->SMTPSecure= 'ssl';
    $mail->Host= 'smtp.gmail.com';
    $mail->Port= 465;

    $mail->Username= 'mateustrabalhoexp';
    $mail->Password= 'ujjc kllj upvo otag';
    $mail->setFrom('mateustrabalhoexp@gmail.com', 'EMPRESA');
    
    $mail->addAddress('mateusdaniel2509@gmail.com', '');
    $mail->Subject = "SEXOOOOOOOOOOOOO";

    $mail->msgHTML("Mensagem");

    $mail->send();


?>
