<?php
namespace core;

class CheckField extends Field
{


        protected $class;
        protected $id;

        public function buildWidget()
    {
        $widget = '';

        if (!empty($this->errorMessage)) {
            $widget .= $this->errorMessage . '<br />';
        }

        $widget .= '<label>' . $this->label . '</label> <input type="checkbox"  name="' . $this->name . '"';

        if (!empty($this->id)) {
            $widget .= ' id="' . $this->id . '"';
        }

        if (!empty($this->class)) {
            $widget .= ' class="' . $this->class . '"';
        }
        if (!empty($this->value)) {
            $widget .= 'checked';
        }


        $widget .= '>';



        return $widget . '</input>';
    }



        public function setClass($class)
    {
        $this->class = $class;

    }

        public function setId($id)
    {
        $this->id = $id;

    }




}