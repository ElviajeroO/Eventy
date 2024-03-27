<?php

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exceptio;

    require 'PHPMailer-master/src/Exceptio.php';
    require 'PHPMailer-master/src/PHPMailer.php';
    require 'PHPMailer-master/src/SMTP.php';

    $mail = new PHPMailer();

    $mail->Mailer = "smtp";
    $mail->isSMTP();
    $mail->CharSet = "UTF-8";
    $mail->SMTPDebug= 0;
    $mail->SMTPAuth= true;
    $mail->SMTPSecure= 'ssl';
    $mail->Host= 'smtp.gmail.com';
    $mail->Port= '465';

    $mail->Username= 'mateustrabalhoexp';
    $mail->Password= 'ujjc kllj upvo otag';
    $mail->setFrom('mateusdaniel2509@gmail.com', 'EMPRESA');
    $mail->Subject = "SEXOOOOOOOOOOOOO";
    
    $mail->addAddress('mateustrabalhoexp@gmail.com', '');
    $mail->msgHTML("Mensagem");

    $mail->send();


?>
