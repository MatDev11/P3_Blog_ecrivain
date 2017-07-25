<?php
namespace core;

class TextField extends Field
{
    protected $cols;
    protected $rows;
    protected $class;
    protected $id;

    public function buildWidget()
    {
        $widget = '';

        if (!empty($this->errorMessage)) {
            $widget .='<p class="alert alert-danger">'. $this->errorMessage . '<p />';
        }

        $widget .= '<label>' . $this->label . '</label> <textarea name="' . $this->name . '"';

        if (!empty($this->id)) {
            $widget .= ' id="' . $this->id . '"';
        }

        if (!empty($this->class)) {
            $widget .= ' class="' . $this->class . '"';
        }

        if (!empty($this->cols)) {
            $widget .= ' cols="' . $this->cols . '"';
        }

        if (!empty($this->rows)) {
            $widget .= ' rows="' . $this->rows . '"';
        }

        $widget .= '>';

        if (!empty($this->value)) {
            $widget .= htmlspecialchars($this->value);
        }

        return $widget . '</textarea>';
    }

    public function setCols($cols)
    {
        $cols = (int)$cols;

        if ($cols > 0) {
            $this->cols = $cols;
        }
    }

    public function setRows($rows)
    {
        $rows = (int)$rows;

        if ($rows > 0) {
            $this->rows = $rows;
        }
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