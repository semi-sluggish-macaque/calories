<?php

namespace cal;

class Registry
{
    use Tsingleton;

    protected static array $properties = [];

    public function  setProperty($name, $value)
    {
        self::$properties[$name] = $value;
    }

    public function getProperty($name)
    {
        //если self::$properties[$name] == true, тогда вернём его, в противном случае null
        return self::$properties[$name] ?? null;
    }
    public function getProporties(): array
    {
        return self::$properties;
    }

}