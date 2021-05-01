<?php


class Validator
{
    private $passed = false, $erorrs = [], $db = null;

    public function __construct()
    {
        $this->db = QueryBuilder::getInstance();
    }

    public function check($source, $items=[]){
        foreach ($items as $item=>$rules){
            foreach ($rules as $rule => $rule_value){
                $value = $source[$item];
                if($rule == 'required' && empty($value)){
                    $this->addError("{$item} is required");
                } else if (!empty($value)){
                    switch ($rule){
                        case 'min':
                            if(strlen($value)<$rule_value){
                                $this->addError("{$item} must be a minimum of {$rule_value} characters.");
                            }
                            break;

                        case 'max':
                            if(strlen($value)>$rule_value){
                                $this->addError("{$item} must be a maximum of {$rule_value} characters.");
                            }
                            break;

                        case 'matches':
                            if($value != $source[$rule_value]){
                                $this->addError("{$rule_value} must match {$item}");
                            }
                            break;

                        case 'email':
                            if(!filter_var($value, FILTER_VALIDATE_EMAIL)){
                                $this->addError("{$item} is not an email");
                            }
                            break;

                        case 'unique':
                            $check = $this->db->get($rule_value,[$item => $value]);
                            if($check){
                                $this->addError("{$item} already exists.");
                            }
                            break;

                        case 'extension':
                            $fileName = $value['name'];
                            $allowedExtension = $rule_value;
                            $fileExtension = strtolower(end(explode('.', $fileName)));
                            if($fileName !== '' && !in_array($fileExtension, $allowedExtension, true)){
                                $this->addError("invalid {$item} format");
                            }
                            break;
                    }
                }
            }
        }

        if(empty($this->erorrs)){//если true-пустая переменная, то выполняется
            $this->passed = true;
        }
        return $this;
    }

    public function addError($error)
    {
        return $this->erorrs[] = $error;
    }

    public function errors(){
        return $this->erorrs;
    }

    public function passed()
    {
        return $this->passed;
    }


}