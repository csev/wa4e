<?php

function plus($x, $y) {
    return $x + $y;
}

class Thing {
    public $value;
    private $a;
    protected $b;

    function __construct($start=0) {
        echo("Construct\n");
        var_dump($this->value);
        $this->value = $start;
        $value = 12345;
        var_dump($this->value);
        echo("Done\n");
    }

    public static function add($x, $y) {
        // Cannot use $this
        echo("Adding $x $y \n");
        return $x + $y;
    }

    public function increment($x) {
        $this->value += $x;
        echo("New:" . $this->value . "\n");
    }

    public function inc2($x, $y) {
        $this->increment($x);
        $this->increment($y);
    }

    public function add10() {
        $this->value = self::add($this->value, 10);
        $this->value = $this->add($this->value, 10);
        $this->inc2();
    }

    function __destruct() {
        echo("AAAAAAAAAAAAAARGH!!\n");
    }

}

$y = plus(3,4);

$y = Thing::add(3,4);

$z = new Thing(7);
$a = new Thing(10);

$z->increment(4);

$a->increment(5);

$y = $z->add(5,6);

unset($z);
echo("The last line\n");


