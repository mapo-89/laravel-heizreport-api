<?php
/*
 * DocumentHelper.php
 * @author Manuel Postler <info@postler.de>
 * @copyright 2025 Manuel Postler
 */

namespace Mapo89\LaravelHeizreportApi\Api\Utils;

use Exception;

class DocumentHelper
{
    /**
     * Create project parameter array.
     *
     * @param string $projektKey
     * @param array $parameters
     * @return array
     * @throws Exception
     */
    static function getProjectParameters(string $projektKey, array $parameters): array
    {
        return [
            'projektKey' => $projektKey,
            'projektData' => [
                'email' => $parameters['email'] ?? '',
                'projektName' => $parameters['projektName'] ?? '', //Eine eigene interne Projektbezeichnung
                'projektPostleitzahl' => $parameters['projektPostleitzahl'] ?? 33449,
                'projektArtHeizung' => $parameters['projektArtHeizung'] ?? 1, //1= Gasheizung, 2=Ölheizung, 3=Brennwert-Gasheizung, 4=Brennwert-Ölheizung, 5=Pellet, 6=Fernwärme int(1-6)
                'projektAlterHeizung' => $parameters['projektAlterHeizung'] ?? 1, //1=ab 1995, 2=zwischen 1980 bis 1995, 3=vor 1980 int(1-3)
                'projektBewohner' => $parameters['projektBewohner'] ?? 4, //Anzahl Bewohner int(1-8)
                'projektJahresverbrauch' => $parameters['projektJahresverbrauch'] ?? '', //in kwh int()
                'projektBaujahr' => $parameters['projektBaujahr'] ?? 1985, //int()
                'projektTrinkwasser' => $parameters['projektTrinkwasser'] ?? 1, //1=über Heizungsanlage (mit Zirkulation), 2=über Heizungsanlage (ohne Zirkulation),3=sonstiges System int(1-3)
                'projektWaermeerzeugerSolarStatus' => $parameters['projektWaermeerzeugerSolarStatus'] ?? '',  //on=Solarthermieanlage vorhanden, 'leer'=nicht vorhanden string()
                'projektWaermeerzeugerSolarArt' => $parameters['projektWaermeerzeugerSolarArt'] ?? 0, //1=für Warmwasser, 2=für Heizung und Warmwasser int(1-2)
                'projektKollektorflaecheSolar' => $parameters['projektKollektorflaecheSolar'] ?? 0, //Kollektorfläche in qm int()
                'projektWaermeerzeugerHolzStatus' => $parameters['projektWaermeerzeugerHolzStatus'] ?? '', //on=Holzkamin vorhanden, 'leer'=nicht vorhanden string()
                'projektJahresverbrauchHolz' => $parameters['projektJahresverbrauchHolz'] ?? 0, //in Raummeter int()
                'projektWaermeerzeugerHolzArt' => $parameters['projektWaermeerzeugerHolzArt'] ?? 0, //1=Fichte, 2=Tanne, 3=Kieferm, 4=Birke, 5=Buche, 6=Eiche
                'anrede' => $parameters['anrede'] ?? 0, //0=Frau, 1=Herr
                'vorname' => $parameters['vorname'] ?? '',
                'name' => $parameters['name'] ?? '',
                'strasse' => $parameters['strasse'] ?? '',
                'hausnummer' => $parameters['hausnummer'] ?? '',
                'plz' => $parameters['plz'] ?? '',
                'ort' => $parameters['ort'] ?? '',
                'telefon' => $parameters['telefon'] ?? '',
                'bemerkungen' => $parameters['bemerkungen'] ?? '',
            ]
        ];
    }
}
