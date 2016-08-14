<?php 
	class Validate{
		private $_passed = false,
				$_errors = array(),
				$_db = null;
		public function __construct(){
			$this->_db = DB::getInstance();
		}

		public function check($source, $items = array()){
			foreach($items as $item => $rules){
				foreach($rules as $rule => $ruleValue){
					//echo "Item: {$item}, Rule: {$rule} must be Value: {$ruleValue} <br />";
					//Because we are checking defined value against user submitted value i.e. in $source.
					$value = trim($source[$item]);
					$item = escape($item);

					if($rule == 'required' && empty($value)){
						$this->addError("{$item} is required");
					}
					else if(!empty($value)){
						switch($rule){
							case 'min':
								if(strlen($value) < $ruleValue){
									$this->addError("{$item} must be a minimum of {$ruleValue} character.");
								}
							break;
							case 'max':
								if(strlen($value) > $ruleValue){
									$this->addError("{$item} must be a maximum of {$ruleValue} character.");
								}
							break;
							case 'matches':
								//User submitted Value (which is rePassword) must match with password(since ruleValue is pre set to 'password' in rules of array)
								if($value != $source[$ruleValue]){
									$this->addError("{$ruleValue} must match {$item}");
								}
							break;
							case 'unique':
								//Here $item represents 'username' for the first loop while $value represents user submitted value.
								$check = $this->_db->get($ruleValue, array($item, '=', $value));
								if($check->count()){
									$this->addError("{$item} already exists!");
								}
							break;
							default:
						}
					}
				}
			}

			if(empty($this->_errors)){
				$this->_passed = true;
			}
			return $this;
		}

		private function addError($error){
			$this->_errors[] = $error;
		}

		public function errors(){
			return $this->_errors;
		}

		public function passed(){
			return $this->_passed;
		}
	}
 ?> 
