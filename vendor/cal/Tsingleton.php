<?php

namespace cal;

trait Tsingleton
{
    private static ?self $instance = null; //сдесь может быть либо экзампдяр класса либо null

    private function __construct()
    {
    }

    //после функц через двоиточие написано то, что будет возвращать
    public static function getInstance(): static
    {
        //self всегда будет создавать экземпляр текущего класса,
        //а static всегда будет создавать экземпляр класса-наследника, если таковой есть
        //если в static instance что-то есть, то вернём его. В противном случае в static instance запишем экземпляр класса
        return static::$instance ?? static::$instance = new static();
    }

}