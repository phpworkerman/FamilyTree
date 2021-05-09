<?php


namespace App\Services;


use App\Models\Family;
use App\Services\FamilyTitle\FamilyTitleFactory;

class FamilyService
{
    protected $error;

    public function add($data)
    {
        if (!$this->isNormalEthic($data)) {
            $this->error = '不符合伦理的创建';
            return false;
        }

        try {
            $family = new Family();
            $family->fill($data);
            $family->save();

            return true;
        } catch (\Exception $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }

    public function update($data, $id)
    {
        if (!$this->isNormalEthic($data)) {
            $this->error = '不符合伦理的创建';
            return false;
        }

        try {
            $family = Family::find($id);
            $family->fill($data);
            $family->save();

            return true;
        } catch (\Exception $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }

    public function delete($id)
    {
        $family = Family::where('father_id', $id)->orWhere('mother_id', $id)->first();
        if ($family) {
            $this->error = '该成员下有其它成员，不支持删除';
            return false;
        }

        try {
            Family::destroy($id);
            return true;
        } catch (\Exception $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }

    public function getTree()
    {
        $family = Family::all();

        return $this->treeData($family, 0);
    }

    public function treeData($family, $parentId)
    {
        $data = [];
        foreach ($family as $key => $member) {
            $memberParentId = $this->getMemberParentId($member);
            if ($memberParentId == $parentId) {
                $data[$member->id] = [
                    'id'       => $member->id,
                    'name'     => $member->name,
                    'gender'   => $member->gender,
                    'birthday' => $member->birthday,
                    'child'    => $this->treeData($family, $member->id),
                ];
            }
        }

        return $data;
    }

    /**
     * 获取成员的父级ID
     * @param $member object 家庭成员
     * @return int
     */
    public function getMemberParentId($member)
    {
        $id = 0;
        if (!$member->father_id && !$member->mother_id) {
            return $id;
        } else {
            return $member->father_id ?: $member->mother_id;
        }
    }

    /**
     * 获取家庭称谓
     * @param $memberAId
     * @param $memberBId
     * @return string|void
     */
    public function getMemberTitle($memberAId, $memberBId)
    {
        $memberA = Family::find($memberAId);
        $memberB = Family::find($memberBId);

        $familyFactory = new FamilyTitleFactory($memberA, $memberB);
        return $familyFactory->callTitle();
    }

    public function getMenGroup()
    {
        return Family::where('gender', Family::GENDER_MEN)->get();
    }

    public function getWomenGroup()
    {
        return Family::where('gender', Family::GENDER_WOMEN)->get();
    }

    public function getError()
    {
        return $this->error;
    }

    public function getOneById($id)
    {
        return Family::find($id);
    }

    public function getAll()
    {
        return Family::All();
    }

    public function isNormalEthic($data)
    {
        if ($data['father_id'] && $data['mother_id']) {
            $parents         = Family::whereIn('id', [$data['father_id'], $data['mother_id']])->get();
            $grandParentsIds = [];
            foreach ($parents as $parent) {
                $grandParentsIds[] = $parent->father_id;
                $grandParentsIds[] = $parent->mother_id;
            }

            if (array_sum($grandParentsIds)) {
                return false;
            }
        }

        return true;
    }
}
