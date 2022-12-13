<?php
    function URLarray ($url = NULL) {
        if ($url===NULL) {$url = $_SERVER['REQUEST_URI']; }
        return explode("/", parse_url($url, PHP_URL_PATH));
    }

    function connectSQLite($sql, $file) {
        $pdo = new PDO('sqlite:'.$file);
        $statement = $pdo->query($sql);
        $rows = $statement -> fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }

    function polishPostCodeVerifier($postcode) {
        $reg1 = '/^\d{2}-\d{3}$/';
        $reg2 = '/^\d{5}$/';
        return (preg_match($reg1, $postcode) || preg_match($reg2, $postcode));
     }
     
     function polishPostCodeModifier($postcode) {
        if(preg_match('/^\d{5}$/', $postcode)) {
            $newpostcode = str_split($postcode);
            return $newpostcode[0].$newpostcode[1]."-".$newpostcode[2].$newpostcode[3].$newpostcode[4];
        }
        return $postcode;
     }
?>