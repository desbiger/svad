<?php


class myValidation
{
    public $errors = array();

    public $text = null;

    public $result = true;

    public $label = null;


    /**
     * @param $text
     * @param $variants
     * @param $label
     * @return $this
     *
     */
    public function check($text,$variants,$label)
    {
        $this->label = $label;
        foreach($variants as $v){
            $this->{$v}($text);
        }
        return $this;
    }

    public function email($text)
    {
        $preg = "/[0-9a-zA-Z_-]+@[0-9a-zA-Z_-]+\.[a-zA-Z-_]{0,5}/";
        if(!preg_match($preg,$text)){
            $this->errors[$this->label][] ="<div class='error_text'>". "Поле '".$this->label."' не является адресом email" . "</div>";
            $this->result = false;
        }
        return $this;
    }

    public function noEmpty($text)
    {
        if ($text == '') {
            $this->errors[$this->label][] ="<div class='error_text'>". 'Поле \''.$this->label.'\' не может быть пустым' . "</div>";
            $this->result = false;
        }
        return $this;
    }

}