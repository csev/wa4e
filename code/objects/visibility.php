<?php

class MyClass
{
    public $pub = 'Public';
    protected $pro = 'Protected';
    private $priv = 'Private';

    function printHello()
    {
        echo $this->pub."\n";
        echo $this->pro."\n";
        echo $this->priv."\n";
    }
}

$obj = new MyClass();
echo $obj->pub."\n"; // Works
echo $obj->pro."\n"; // Fatal Error
echo $obj->priv."\n"; // Fatal Error
$obj->printHello(); // Shows Public, Protected and Private

class MyClass2 extends MyClass
{

    function printHello()
    {
        echo $this->pub."\n";
        echo $this->pro."\n";
        echo $this->priv."\n"; // Undefined
    }
}

echo("--- MyClass2 ---\n");
$obj2 = new MyClass2();
echo $obj2->pub."\n"; // Works
$obj2->printHello(); // Shows Public, Protected, Undefined

// From http://www.php.net/manual/en/language.oop5.visibility.php


