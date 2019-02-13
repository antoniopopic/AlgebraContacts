<?php

class Validation{
    
    private $db = null;
    private $passed = false;
    private $errors = array();

    public function __contruct(){
        $this->db = DB::getInstance();
    }

    public function check($items=array()){
        foreach ($items as $item => $rules) {
            foreach ($rules as $rule => $rule_value) {
                
                $item = escape($item);
                $value = trim(Input::get($item));

                if ($rule === 'required' && empty($value)) {
                    $this->addError($item, "Field $item must is required.");
                }elseif(!empty($value)) {
                    switch ($rule) {
                        case 'min':
                            if(strlen($value) < $rule_value){
                                $this->addError($item, "Field $item must have minimum of $rule_value characters.");
                            }
                            break;
                        
                        case 'max':
                            if(strlen($value) > $rule_value){
                                $this->addError($item, "Field $item must have maximum of $rule_value characters.");
                            }
                            break;
                        
                        case 'unique':
                            $check = $this->db->get('id', $rule_value, [$item, '=', $value])->getCount();
                            if($check){
                                $this->addError($item, "$item already exists");
                            }
                            break;

                        case 'matches':
                            if($value != Input::get('password')){
                                $this->addError($item, "Field $item must match $rule_value.");
                            }
                            break;

                        /* case 'zadaca':
                            # code...
                            break; */
                    }
                }
            }
        }
        if(empty($this->errors)){
            $this->passed=true;
        }
        return $this;
    }

    private function addError($item, $error){
        $this->errors[$item] = $error;
    }

    public function hasError($field){
        if(isset($this->errors[$field])){
            return $this->errors[$field];
        }
        return false;
    }

    public function getErrors(){
        return $this->errors;
    }

    public function passed(){
        return $this->passed;
    }
}

?>