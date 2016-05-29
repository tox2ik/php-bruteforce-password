<?php

namespace tox2ik;

use tox2ik\Traits\SetOrGetTrait;

class PasswordCracker
{
	use SetOrGetTrait;
	
	protected $correctPass;
	protected $dictionary;
	protected $dictionaryLength;
	protected $min;
	protected $max;
	protected $attempts = 1;
	
	protected $characterSlot = [];
	protected $characterSlotIndex = [];

	protected $currentMax;
	protected $currentSlot;

	protected $checkPassCallback = null;

	public function attempts() { return $this->setOrGet(func_get_args(), $this->attempts); }
	public function max() { return $this->setOrGet(func_get_args(), $this->max); }
	public function min() { return $this->setOrGet(func_get_args(), $this->min); }
    public function correctPassword() { return $this->setOrGet(func_get_args(), $this->correctPass); }
    public function dictionary() { return $this->setOrGet(func_get_args(), $this->dictionary); }
	public function checkPassCallback() { return $this->setOrGet(func_get_args(), $this->checkPassCallback); }
	
	public function initz()
	{
		$this->dictionaryLength = strlen($this->dictionary);
		$this->characterSlotIndex = [];
		$this->characterSlot = [];

		for ($i = 0; $i < $this->max; $i++) {
			$this->characterSlotIndex[$i] = 0;
			$this->characterSlot[$i] = $this->dictionary[$this->characterSlotIndex[$i]];
		}

		$combos = pow(strlen($this->dictionary), $this->max);
		//elogm(['min' => $this->min, 'max' => $this->max, 'combinations' => $combos]);
		
		$this->currentMax = $this->max;
		
	}
	
	public function crack()
	{
		$this->initz();
		$i = 0;

		$this->attempts = 1;
		$this->currentMax = $this->min;
		$this->currentSlot = 0;
		
		$combos = pow($this->dictionaryLength, $this->max);
		while ($i < $combos) {
			
			$i++;
			if ($answer = $this->checkCombination($i)) {
				return $answer;
			}
			
			$this->attempts++;
		}
		
		return false;
		
		
	}
	
	public function checkCombination($combo)
	{
		$word = $this->getWord();
		if ($this->checkPassCallback === null) {
			if ($word == $this->correctPass) {
				return $word;
			}
		} else {
			if (call_user_func($this->checkPassCallback, $word)) {
				return $word;
			}
		}

		$this->advanceSlot($this->currentSlot);
		
		return false;
	}
	
	public function advanceSlot($slot)
	{
		if ($slot == $this->max) {
			echo "Tried $this->attempts passwords.\n";
			exit(1);
		}
		$this->characterSlotIndex[$slot]++;
		
		if ($this->characterSlotIndex[$slot] == $this->dictionaryLength) {
			$this->characterSlotIndex[$slot] = $this->dictionaryLength-1;
			$this->advanceSlot($slot+1);
			$this->characterSlotIndex[$slot] = 0;
		}
		return $this->getWord();
	}
	
	public function getWord()
	{
		$word = "";
		for ($i = $this->currentMax-1; $i >= 0; $i--) {
			$this->characterSlot[$i] = $this->dictionary[$this->characterSlotIndex[$i]];
			$word = $word . $this->characterSlot[$i];
		}
		return $word;
		
	}
	
	public function initCombo($combo)
	{

		$dl = strlen($this->dictionary);
		$power = [];
		$i=0;
		while (($a = pow($dl, $i)) < $combo) {
			$i++;
		}
		$leftmost = $i-1;

		$iter = 2150;
		$i = 0;
		while ($leftmost >= 0 and $iter > 0) {
			while (($a = pow($dl, $leftmost) * $i) < $combo) {
				$iter--;
				$i++;
				$power[$leftmost] = $i-1;
			}
			$combo -= pow($dl, $leftmost) * $power[$leftmost];
			$leftmost--;
			$i = 0;
		}
		$power[$leftmost+1] = $combo;
		
		return $power;
	}

}
