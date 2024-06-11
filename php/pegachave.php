<?php
    function extract_from_image($caminho) {

        $img = imagecreatefrompng($caminho);
        if (!$img) {
            die('Carrego n familia');
        }

        $width = imagesx($img);
        $height = imagesy($img);

        $bin = '';

        for ($l = 0; $l < $height; $l++) {
            for ($c = 0; $c < $width; $c++) {
                $cor = imagecolorat($img, $c, $l);
                $b = $cor & 0xFF;

                $bin .= ($b & 1);
            }
        }

        imagedestroy($img);

        $data = '';

        for ($i = 0; $i < strlen($bin); $i += 8) {
            $byte = substr($bin, $i, 8);
            if ($byte === '00000000') break; 
            $data .= chr(bindec($byte));
        }

        return $data;
    }
?>
