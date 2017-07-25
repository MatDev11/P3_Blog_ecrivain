<?php
namespace core;

class StringField extends Field
{
    protected $maxLength;
    protected $class;
    protected $id;

    public function buildWidget()
    {
        $widget = '';

        if (!empty($this->errorMessage))
        {
            $widget .= '<p class="alert alert-danger">'. $this->errorMessage . '<p />';
        }

        $widget .= '<label>'.$this->label.'</label>
    <input  type="text" name="'.$this->name.'"';

        if (!empty($this->id)) {
            $widget .= ' id="' . $this->id . '"';
        }

        if (!empty($this->class)) {
            $widget .= ' class="' . $this->class . '"';
        }

        if (!empty($this->value))
        {
            $widget .= ' value="'.htmlspecialchars($this->value).'"';
        }

        if (!empty($this->maxLength))
        {
            $widget .= ' maxlength="'.$this->maxLength.'"';
        }

        return $widget .= ' />';
    }

    public function setClass($class)
    {
        $this->class = $class;

    }

    public function setId($id)
    {
        $this->id = $id;

    }

    public function setMaxLength($maxLength)
    {
        $maxLength = (int) $maxLength;

        if ($maxLength > 0)
        {
            $this->maxLength = $maxLength;
        }
        else
        {
            throw new \RuntimeException('La longueur maximale doit être un nombre supérieur à 0');
        }
    }



}