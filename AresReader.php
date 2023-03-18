<?php

class AresReader {

    public function __construct($ic, $language = 'cz') {
		$this->link = 'https://wwwinfo.mfcr.cz/cgi-bin/ares/darv_res.cgi';
		$this->ic = $ic;
		$this->language = $language;
	}

    private function file_get_contents_curl() {
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_HEADER, 0);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_URL, $this->link . "?ico=" . $this->ic . "&jazyk=" . $this->language . "&xml=1");
	    $data = curl_exec($ch);
	    curl_close($ch);
	    return $data;
	}

    public function print() {

        $in = $this->file_get_contents_curl();
		$tag = array('ICO' => 'IČ', 'OF' => 'Firma', 'N' => 'Město', 'NU' => 'Ulice', 'CD' => 'ČP', 'PSC' => 'PSČ', 'NPF' => 'Právní forma', 'Nazev_NACE' => 'ekonomických činností', 'KPP' => 'velikostní kat. dle počtu zam.', 'Zuj_kod_orig' => 'ZÚJ kód', 'NZUJ' => 'ZÚJ');
		
		foreach ($tag as $key => $value) { 
			preg_match_all('/<D:'.$key.'>(.*?)</s', $in, $out);

			if(!$out[1] && $key == "ICO") {
				$output['error'] = 'Nenalezeno';
				break;
			}

			$output[$key] = array(
				'name' => $value,
				'value' => @$out[1][0]
			);
		}

		return $output;
        
    }
}

?>