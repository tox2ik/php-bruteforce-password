<?php

namespace tox2ik\Traits;

trait SetOrGetTrait {
	/**
	 * Cute helper that assigns a variable when called with two arguments.
	 * The idea is to avoid two mutators for most (if not all) fields.
	 *
	 * @param $callersArgv array parameters of the function that called us.
	 * @param $targetProperty address of the property that will be assigned to.
	 * @return GeneralAdminPage|mixed value of $targetProperty or reference to self (when in set mode)
     *
     * Example
     *
     *      class Foo
     *      {
     *          use Myworkout\Trait\SetOrGetTrait;
     *          public function bar()
     *          {
     *              return $this->SetOrGet(func_get_args(), $this->barProperty);
     *          }
     *      }
	 */
	protected function setOrGet($callersArgv, &$targetProperty) {
		if (count($callersArgv) > 0) {
			$targetProperty = $callersArgv[0];
			return $this;
		}
		return $targetProperty;
		
	}
}

?>
