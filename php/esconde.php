<?php

    function esconde($caminho_entrada, $caminho_saida, $data) {

        $image = imagecreatefrompng($caminho_entrada);
        if (!$image) {
            die('Carrego n familia');
        }

        $width = imagesx($image);
        $height = imagesy($image);
        
        $data .= "\0";

        $binary_data = '';
        foreach (str_split($data) as $char) {
            $binary_data .= sprintf("%08b", ord($char));
        }

        $data_length = strlen($binary_data);
        $data_index = 0;

        for ($l = 0; $l < $height; $l++) {
            for ($c = 0; $c < $width; $c++) {
                if ($data_index < $data_length) {
                    $color = imagecolorat($image, $c, $l);
                    $r = ($color >> 16) & 0xFF;
                    $g = ($color >> 8) & 0xFF;
                    $b = $color & 0xFF;

                    $b = ($b & 0xFE) | $binary_data[$data_index];
                    $data_index++;

                    $nova_cor = imagecolorallocate($image, $r, $g, $b);
                    imagesetpixel($image, $c, $l, $nova_cor);
                }
            }
        }

        // Salva a imagem modificada
        imagepng($image, $caminho_saida);
        imagedestroy($image);
    }

    $imagem_entrada = '../img/porco.png';
    $imagem_saida = '../img/porco.png';

    $dado = file_get_contents("../banco_de_dados.txt");

?>
