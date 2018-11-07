<?php
$input = [
	"21750001600019183206098031",
	"21920009400015180171103013",
	"21750001600019183171142069",
	"21750001600019182222364053",
	"21750001600019182220107075",
	"21750001600019182225233056",
	"21750001600019182226170113",
	"21750001600019182226153026",
	"21750001600019182223106055",
	"21750001600019182219023038"
];

$output = array();

foreach ($input as $serial) {
	$numApa = file_get_contents("https://www.stationnement.gouv.fr/api/v1/encrypte?plaintText=".$serial);


	for ($cleApa = 0; $cleApa < 100; $cleApa++) { 
		$apa = json_decode(file_get_contents("https://www.stationnement.gouv.fr/api/v1/recherche/apa?numApa=".$numApa."&cleApa=".substr("0".$cleApa, -2)),1);
		
		// echo substr("0".$cleApa, -2)." : ".$apa['statutPaiementAPA']['valeur'].PHP_EOL;
		if($apa['statutPaiementAPA']['valeur'] != "ERREUR")
		{
			$output[$serial] = $apa;
			$output[$serial]['checkoutUrl'] = "https://www.stationnement.gouv.fr/fps/apa/".$numApa."/".substr("0".$cleApa, -2);
			continue 2;
			
			/*
			$apaCrypto = json_decode(file_get_contents("https://www.stationnement.gouv.fr/api/v1/recherche/apaCrypto?numApa=".$numApa."&cleApa=".substr("0".$cleApa, -2)));
			*/
		}
	}
}

foreach($output as $row)
 echo $row['checkoutUrl'].PHP_EOL;