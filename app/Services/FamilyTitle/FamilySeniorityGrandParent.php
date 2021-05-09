<?php


namespace App\Services\FamilyTitle;


use App\Models\Family;

class FamilySeniorityGrandParent extends FamilyTitleAbstract
{
    const TITLE = [
        'men'   => [
            'grandParent'     => ['爷爷', '孙子',],
            'sameGrandMother' => ['姥爷', '外孙',],
        ],
        'women' => [
            'grandParent'     => ['奶奶', '孙女',],
            'sameGrandMother' => ['姥姥', '外孙女',],
        ],
    ];

    public function callTitle()
    {
        if ($this->isGrandParent()) {
            return $this->outputResult('grandParent');
        } else {
            return $this->outputResult('sameGrandMother');
        }
    }

    public function outputResult($parentType)
    {
        $compareAge = strtotime($this->memberA->birthday) < strtotime($this->memberB->birthday) ? self::LT_TITLE : self::GT_TITLE;
        $compareAgeDiff = $compareAge == self::LT_TITLE ? self::GT_TITLE : self::LT_TITLE;

        $result = $this->memberA->name . '喊' . $this->memberB->name . self::TITLE[$this->memberB->gender][$parentType][$compareAge];
        $result .= '，';
        $result .= $this->memberB->name . '喊' . $this->memberA->name . self::TITLE[$this->memberA->gender][$parentType][$compareAgeDiff];

        return $result;
    }

    public function isGrandParent()
    {
        if (($this->memberA->father_id && !$this->memberB->father_id) || ($this->memberB->father_id && !$this->memberA->father_id)) {
            return true;
        }

        return false;
    }
}
