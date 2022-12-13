<?php
    require('scripts.php');

    header("Content-type: application/json; charset=UTF-8");
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE"); 
    header("Access-Control-Allow-Headers: Content-Type");

    $path = URLarray();
    if ($_SERVER['REQUEST_METHOD'] == "GET") {
        $result = array();
        $result['API_Owner'] = 'Michal Futera';
        $result['API_Owner_Link'] = 'https://linktr.ee/mjfutera';
        $result['Result'] = 'No postcode provided';
        if(isset($path[2])){
            if($path[2] == 'pl'){
                if(polishPostCodeVerifier($path[3])){
                    $correctPostcode = polishPostCodeModifier($path[3]);
                    $sql = 'SELECT postcode, location, voivodeship, county FROM polish WHERE postcode="'.$correctPostcode.'" LIMIT 1';
                    $result['Result'] = connectSQLite($sql, 'postCodes.db')[0];
                } else {
                    $result['Result'] = 'Wrong postcode';
                }
            }
        }
        $count = connectSQLite('SELECT COUNT(*) FROM polish', 'postCodes.db');
        $result['CodesInDB'] = $count[0]['COUNT(*)'];

        echo json_encode($result);
    }
?>