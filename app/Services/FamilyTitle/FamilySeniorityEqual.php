<?php


namespace App\Services\FamilyTitle;


use App\Models\Family;

class FamilySeniorityEqual extends FamilyTitleAbstract
{
    const TITLE = [
        'men'   => [
            'partner'         => ['丈夫'],
            'sameFather'      => ['哥哥', '弟弟',],
            'sameGrandMother' => ['表哥', '表弟',],
            'sameGrandFather' => ['堂哥', '堂弟',],
        ],
        'women' => [
            'partner'         => ['妻子'],
            'sameFather'      => ['姐姐', '妹妹',],
            'sameGrandMother' => ['表姐', '表妹',],
            'sameGrandFather' => ['堂姐', '堂妹',],
        ],
    ];

    public function callTitle()
    {
        if($this->isPartner()){
            return $this->outputResult('partner');
        }

        if ($this->isSameFather()) {
            return $this->outputResult('sameFather');
        }

        if ($this->isSameGrandFather()) {
            return $this->outputResult('sameGrandFather');
        }

        return $this->outputResult('sameGrandMother');
    }

    public function outputResult($parentType)
    {
        $compareAge = strtotime($this->memberA->birthday) < strtotime($this->memberB->birthday) ? self::LT_TITLE : self::GT_TITLE;
        $compareAgeDiff = $compareAge == self::LT_TITLE ? self::GT_TITLE : self::LT_TITLE;

        if($parentType == 'partner'){
            $compareAge = self::GT_TITLE;
            $compareAgeDiff = self::GT_TITLE;
        }

        $result = $this->memberA->name . '喊' . $this->memberB->name . self::TITLE[$this->memberB->gender][$parentType][$compareAge];
        $result .= '，';
        $result .= $this->memberB->name . '喊' . $this->memberA->name . self::TITLE[$this->memberA->gender][$parentType][$compareAgeDiff];

        return $result;
    }

    public function isSameFather()
    {
        if ($this->memberA->father_id == $this->memberB->father_id) {
            return true;
        }

        return false;
    }

    public function isSameGrandFather()
    {
        $fatherGroup = Family::whereIn('id', [$this->memberA->father_id, $this->memberB->father_id])->select('father_id')->get();

        $grandFatherId = [];
        foreach ($fatherGroup as $key => $father) {
            $grandFatherId[] = $father->father_id;
        }

        if (count($grandFatherId) == 2 && $grandFatherId[0] == $grandFatherId[1]) {
            return true;
        }

        return false;
    }

    public function isPartner()
    {
        if(!$this->memberA->father_id && !$this->memberA->mother_id && !$this->memberB->father_id && !$this->memberB->mother_id){
            return true;
        }

        return false;
    }
}
