<?php
function out_d($arr)
{
    print_r($arr);
}

function parseXML($fileName, $link)
{
    $xmls = simplexml_load_file($fileName);
    $xml = json_decode(json_encode($xmls), true);
    unset($xmls);
    gc_collect_cycles();
    $tablename = key($xml);
//    out_d("CHECK TABLE ".$tablename."\n");
    if (empty($tablename)) {
        return null;
    } else {
        $query = mysqli_query($link, "CHECK TABLE " . $tablename);
        $row = mysqli_fetch_assoc($query);
        if ($row['Msg_text'] == 'OK') {
            // Таблица есть
        } else {
            // Таблицы нет, нужно создавать с полями из ключей массива
            $sql = "CREATE TABLE `".$tablename."` (";
            foreach(array_keys($xml[$tablename][0]) as $field){
                var_dump($field);
                if(empty($field)){
                    $sql .= "`" . $field . "` VARCHAR( 256 ) CHARACTER SET utf8 COLLATE utf8mb3_general_ci NULL ";
                }else {
                    if (is_numeric($field)) {
                        $sql .= "`" . $field . "` INT(10) ,";
                    } else {
                        $len = mb_strlen($xml[$tablename][0][$field]);
                        if ($len < 256) {
                            $sql .= "`" . $field . "` VARCHAR( 256 ) CHARACTER SET utf8 COLLATE utf8mb3_general_ci NULL ";
                        } elseif ($len < 512) {
                            $sql .= "`" . $field . "` VARCHAR( 512 ) CHARACTER SET utf8 COLLATE utf8mb3_general_ci NULL ";
                        } else {
                            $sql .= "`" . $field . "` VARCHAR( 2512 ) CHARACTER SET utf8 COLLATE utf8mb3_general_ci NULL ";
                        }
                        $sql .= ") ENGINE = INNODB";
                    }
                }
                out_d($sql."\n");
            }
        }
    }
}

$link = mysqli_connect('localhost', 'root4', 'iLiLa(4884)', 'test') or die('Not connect DB novost');
mysqli_query($link, "SET NAMES 'utf8';");
mysqli_query($link, "SET CHARACTER SET 'utf8';");
mysqli_query($link, "SET SESSION collation_connection = 'utf8mb4_unicode_ci';");

$baseCat = '/var/www/medik.support/tmp';
$compositionCatalog = scandir($baseCat);
foreach ($compositionCatalog as $oneDir) {
    if (($oneDir == '.') || ($oneDir == '..') || ($oneDir == '...')) continue;
    if (@scandir($baseCat . '/' . $oneDir)) {
        $manyFiles = scandir($baseCat . '/' . $oneDir);
        foreach ($manyFiles as $oneFile) {
            if (($oneFile == '.') || ($oneFile == '..') || ($oneFile == '...')) continue;
            parseXML($baseCat . '/' . $oneDir . '/' . $oneFile, $link);
        }
    } else {
        parseXML($baseCat . '/' . $oneDir, $link);
    }
}
