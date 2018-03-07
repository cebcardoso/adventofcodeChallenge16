<?php

class ChallengeSixteen {
	private $inputArray;
	private $programs;
	const SPIN = 's';
	const EXCHANGE = 'x';
	const PARTNER = 'p';
	
	function __construct() {
		$this->programs = 'abcdefghijklmnop';
        $this->inputArray = explode(',', file_get_contents('input.txt'));
    }
	
	public function getInputArray() {
		return $this->inputArray;
	}

	public function getPrograms() {
		return $this->programs;
	}
	
	public function setPrograms($programs) {
		$this->programs = $programs;
	}

	function pr($array) {
		echo '<pre>';
		print_r($array);
		echo '</pre>';
	}
	
	/*
	* Accepts spin factor
	* Performs spin on programs and updates programs
	*/
	function performSpin($spin) {
		$programsToChange = $this->getPrograms();
		$newPrograms = '';
		$count = 1;
		
		for ($k = 0; $k < strlen($programsToChange); $k++) {
			$newPrograms[($k + $spin) % strlen($programsToChange)] = $programsToChange[$k];
		}
		
		ksort($newPrograms);
		
		$this->setPrograms(implode($newPrograms));
	}
	
	/*
	* Accepts positions for exchange
	* Exchanges positions and updates programs
	*/
	function performExchange($positions) {
		$programsToChange = $this->getPrograms();
		$position1Value = $programsToChange[$positions[0]];
		$position2Value = $programsToChange[$positions[1]];
		$programsToChange[$positions[0]] = $position2Value;
		$programsToChange[$positions[1]] = $position1Value;
		$this->setPrograms($programsToChange);
	}
	
	/*
	* Accepts progeams for partnering
	* Gets positions and exchanges values and updates programs
	*/
	function performPartner($programsPartner) {
		$programsToChange = $this->getPrograms();
		$position1Key = array_search($programsPartner[0], str_split($programsToChange));
		$position2Key = array_search($programsPartner[1], str_split($programsToChange));
		$position1KeyValue = $programsToChange[$position1Key];
		$position2KeyValue = $programsToChange[$position2Key];
		$programsToChange[$position1Key] = $position2KeyValue;
		$programsToChange[$position2Key] = $position1KeyValue;
		$this->setPrograms($programsToChange);
	}
	
	/*
	* Loops over dance moves and calls specfic actions while updating programs
	*/	
	function extractActions() {
		foreach ($this->inputArray as $action) {
			$actionType = $action[0];
			$instruction = substr($action, 1, strlen($action) - 1);
			
			switch ($actionType) {
				case self::SPIN:
					$this->performSpin(1);
					break;
				case self::EXCHANGE:
					$positions = explode("/", $instruction);
					$this->performExchange($positions);
					break;
				case self::PARTNER:
					$programsPartner = explode("/", $instruction);
					$this->performPartner($programsPartner);
					break;
			}
		}
	}
}

	$challengeSixteen = new ChallengeSixteen();
	$challengeSixteen->extractActions();
	echo 'Final dance order: ' . $challengeSixteen->getPrograms();
?>