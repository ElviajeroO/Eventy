<?php

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    function mandar($email, $codigo_aut){

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

        $mail->addAddress($email);
        $mail->Subject = "Código de Autenticação";

        $mail->msgHTML($codigo_aut);

        $mail->send();
    }

?>
