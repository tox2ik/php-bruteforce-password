<?php

namespace spec\tox2ik;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use tox2ik\PasswordCracker;

/**
 * 
 */
class PasswordCrackerSpec extends ObjectBehavior
{

	public function let()
	{
		$this->correctPassword('abc')->shouldReturn($this);
		$this->correctPassword()->shouldReturn('abc');
		$this->dictionary('abc')->shouldReturn($this);
		$this->min(3)->max(3);
		$this->initz();
		
	}
	
    function it_is_initializable()
    {
        $this->shouldHaveType('tox2ik\PasswordCracker');
    }
	
	function it_advances_slot()
	{

		$this->getWord()     ->shouldReturn('aaa');
		$this->advanceSlot(0)->shouldReturn('aab');
		$this->advanceSlot(0)->shouldReturn('aac');
		$this->advanceSlot(0)->shouldReturn('aba');
		$this->advanceSlot(0)->shouldReturn('abb');
		$this->advanceSlot(0)->shouldReturn('abc');
		$this->advanceSlot(0)->shouldReturn('aca');
		$this->advanceSlot(0)->shouldReturn('acb');
		$this->advanceSlot(0)->shouldReturn('acc');
		$this->advanceSlot(0)->shouldReturn('baa');
		$this->advanceSlot(0)->shouldReturn('bab');
		$this->advanceSlot(0)->shouldReturn('bac');
		$this->advanceSlot(0)->shouldReturn('bba');
		$this->advanceSlot(0)->shouldReturn('bbb');
		$this->advanceSlot(0)->shouldReturn('bbc');
		$this->advanceSlot(0)->shouldReturn('bca');
		$this->advanceSlot(0)->shouldReturn('bcb');
		$this->advanceSlot(0)->shouldReturn('bcc');
		$this->advanceSlot(0)->shouldReturn('caa');
		$this->advanceSlot(0)->shouldReturn('cab');
		$this->advanceSlot(0)->shouldReturn('cac');
		$this->advanceSlot(0)->shouldReturn('cba');
		$this->advanceSlot(0)->shouldReturn('cbb');
		$this->advanceSlot(0)->shouldReturn('cbc');
		$this->advanceSlot(0)->shouldReturn('cca');
		$this->advanceSlot(0)->shouldReturn('ccb');
		$this->advanceSlot(0)->shouldReturn('ccc');
	}

	function it_detects_correct_password()
	{
		
		$this->crack()->shouldReturn('abc');
		$this->attempts()->shouldReturn(6);
		
		
		$this->correctPassword('ccc');
		$this->crack()->shouldReturn('ccc');
		$this->attempts()->shouldReturn(27);

		$this->dictionary('0123456789');
		$this->correctPassword('9999');
		$this->min(4)->max(4);
		$this->crack()->shouldReturn('9999');
		$this->attempts()->shouldReturn(10000);
	}
	
	function it_accepts_arbitraryCallback()
	{
		$this->correctPassword('bbb');
		$this->checkPassCallback(function($word){
			return $word === 'bbb';
		});
	}
	
	function it_initializes_combinations()
	{
		$this->dictionary('0123456789');
		
		
		//$this->initCombo(4531)->shouldReturn([ 3 => 4, 2 => 3, 1 => 5, 0 => 1, ]);
		$this->initCombo(4531)->shouldHaveKeyWithValue(3, 4);
		$this->initCombo(4531)->shouldHaveKeyWithValue(2, 5);
		$this->initCombo(4531)->shouldHaveKeyWithValue(1, 3);
		$this->initCombo(4531)->shouldHaveKeyWithValue(0, 1);
		
		
	}
	

}
