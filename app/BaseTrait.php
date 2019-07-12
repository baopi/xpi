<?php
namespace App;

trait BaseTrait
{
    private static $limit = 0;
    private static $offset = 0;
    private static $order;

    public function setPerPageLimit(int $n)
    {
        static::$limit = $n;
    }

    public function setCurrentOffset(int $n)
    {
        static::$offset = $n;
    }

    public function setOrder($order)
    {
        static::$order = $order;
    }

    public function getPerPageLimit(): ?int
    {
        return static::$limit;
    }

    public function getCurrentOffset(): ?int
    {
        return static::$offset;
    }

    public function getOrder()
    {
        return static::$order;
    }

    public function getPrimaryKey(): string
    {
        return $this->primaryKey;
    }
}