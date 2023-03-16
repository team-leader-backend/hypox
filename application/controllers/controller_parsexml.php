<?php

class Controller_Parsexml extends Controller
{
	function action_index()
	{
        $baseCat = '/var/www/medik.support/tmp';
        $compositionCatalog = scandir($baseCat);
        foreach($compositionCatalog as $oneDir) {
            if(($oneDir=='.')||($oneDir=='..')||($oneDir=='...')) continue;
            if(@scandir($baseCat.'/'.$oneDir)) {
                $manyFiles = scandir($baseCat . '/' . $oneDir);
                foreach ($manyFiles as $oneFile){
                    if(($oneFile=='.')||($oneFile=='..')||($oneFile=='...')) continue;
                    $this->parseXML($baseCat . '/' . $oneDir.'/'.$oneFile);
                }
            }else{
                $this->parseXML($baseCat . '/' . $oneDir);
            }
        }
	}
    function parseXML($fileName){
         $xmls = simplexml_load_file($fileName);
         $xml = json_decode(json_encode($xmls), true);
         unset($xmls);
         self::out_d(key($xml));
    }
}