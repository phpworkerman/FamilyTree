<?php


namespace App\Services\FamilyTitle;


use App\Models\Family;

class FamilyTitleFactory
{
    protected $memberA;
    protected $memberB;

    public function __construct($memberA, $memberB)
    {
        $this->memberA = $memberA;
        $this->memberB = $memberB;
    }

    public function callTitle()
    {
        $compareSeniority = $this->compareSeniority();
        if ($compareSeniority == 0) {
            $familySeniority = new FamilySeniorityEqual($this->memberA, $this->memberB);
        } elseif ($compareSeniority == 1) {
            $familySeniority = new FamilySeniorityParent($this->memberA, $this->memberB);
        } elseif ($compareSeniority == 2) {
            $familySeniority = new FamilySeniorityGrandParent($this->memberA, $this->memberB);
        } else {
            $familySeniority = new FamilySeniorityGrandParent($this->memberA, $this->memberB);
        }

        return $familySeniority->callTitle();
    }

    public function compareSeniority()
    {
        return abs($this->getMemberSeniority($this->memberA) - $this->getMemberSeniority($this->memberB));
    }

    public function getMemberSeniority($member)
    {
        $seniority = 1;
        if ($this->isAncestor($member)) {
            return $seniority;
        }

        $family   = Family::All();
        $parentId = $member->father_id ?: $member->mother_id;
        return $this->findAncestor($family, $parentId, $seniority);
    }

    public function findAncestor($family, $parentId, $seniority)
    {
        foreach ($family as $key => $member) {
            if ($member->id == $parentId && !$this->isAncestor($member)) {
                $currentParentId = $member->father_id ?: $member->mother_id;
                $seniority       += $this->findAncestor($family, $currentParentId, $seniority);
            }

            if ($member->id == $parentId && $this->isAncestor($member)) {
                $seniority++;
            }
        }

        return $seniority;
    }

    public function isAncestor($member)
    {
        if (!$member->father_id && !$member->mother_id) {
            return true;
        }

        return false;
    }
}
