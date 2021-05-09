<?php


namespace App\Services\FamilyTitle;


use App\Models\Family;

class FamilySeniorityParent extends FamilyTitleAbstract
{
    const TITLE = [
        'men'   => [
            'parent'          => ['爸爸', '儿子'],
            'sameGrandParent' => ['叔伯', '侄子'],
            'sameGrandMother' => ['舅舅', '外甥'],
        ],
        'women' => [
            'parent'          => ['妈妈', '女儿'],
            'sameGrandParent' => ['姑姑', '侄女'],
            'sameGrandMother' => ['姨妈', '外甥女'],
        ],
    ];

    public function callTitle()
    {
        if ($this->isParent()) {
            return $this->outputResult('parent');
        } elseif ($this->isGrandMother()) {
            return $this->outputResult('sameGrandMother');
        } else {
            return $this->outputResult('sameGrandParent');
        }
    }

    public function outputResult($parentType)
    {
        $compareAge     = strtotime($this->memberA->birthday) < strtotime($this->memberB->birthday) ? self::LT_TITLE : self::GT_TITLE;
        $compareAgeDiff = $compareAge == self::LT_TITLE ? self::GT_TITLE : self::LT_TITLE;

        $result = $this->memberA->name . '喊' . $this->memberB->name . self::TITLE[$this->memberB->gender][$parentType][$compareAge];
        $result .= '，';
        $result .= $this->memberB->name . '喊' . $this->memberA->name . self::TITLE[$this->memberA->gender][$parentType][$compareAgeDiff];

        return $result;
    }

    public function isParent()
    {
        $parentAId = [$this->memberA->father_id, $this->memberA->mother_id];
        $parentBId = [$this->memberB->father_id, $this->memberB->mother_id];

        if (in_array($this->memberB->id, $parentAId) || in_array($this->memberA->id, $parentBId)) {
            return true;
        }

        return false;
    }

    public function isGrandMother()
    {
        $parentA = Family::find($this->memberA->mother_id);
        $parentB = Family::find($this->memberB->mother_id);

        if ((!$this->memberA->father_id && isset($parentA->gender) && $parentA->gender == Family::GENDER_WOMEN) ||
            (!$this->memberB->father_id && isset($parentB->gender) && $parentB->gender == Family::GENDER_WOMEN)) {
            return true;
        }

        return false;
    }
}
