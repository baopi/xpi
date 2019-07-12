<?php
namespace App\Services;

class ParserFromValidate
{
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function __get($property)
    {
        return $this->data[$property] ?? null;
    }
}