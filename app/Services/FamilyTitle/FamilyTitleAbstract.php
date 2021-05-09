<?php


namespace App\Services\FamilyTitle;


abstract class FamilyTitleAbstract
{
    const GT_TITLE = 0;
    const LT_TITLE = 1;

    protected $memberA;
    protected $memberB;

    public function __construct($memberA, $memberB)
    {
        $this->memberA = $memberA;
        $this->memberB = $memberB;
    }

    abstract public function callTitle();
}
