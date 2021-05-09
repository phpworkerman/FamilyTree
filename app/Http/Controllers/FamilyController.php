<?php

namespace App\Http\Controllers;

use App\Http\Requests\FamilyCreate;
use App\Services\FamilyService;
use Illuminate\Http\Request;

class FamilyController extends Controller
{
    /**
     * 家谱列表
     *
     * @param FamilyService $familyService
     * @return \Illuminate\View\View
     */
    public function index(FamilyService $familyService)
    {
        $familyTree = $familyService->getTree();
        $members = $familyService->getAll();
        return view('index', ['familyTree' => $familyTree, 'members' => $members, 'title' => '']);
    }

    /**
     * 添加家庭成员
     *
     * @param FamilyService $familyService
     * @return \Illuminate\View\View
     */
    public function create(FamilyService $familyService)
    {
        $menGroup = $familyService->getMenGroup();
        $womenGroup = $familyService->getWomenGroup();
        return view('create', ['menGroup' => $menGroup, 'womenGroup' => $womenGroup]);
    }

    /**
     * 保存成员信息
     *
     * @param  FamilyCreate  $request
     * @param FamilyService $familyService
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function store(FamilyCreate $request, FamilyService $familyService)
    {
        $request->validated();

        $result = $familyService->add($request->all());
        if($result === false){
            return redirect('family/create')->withErrors($familyService->getError())->withInput();
        }

        return redirect('family');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param FamilyService $familyService
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit(FamilyService $familyService, $id)
    {
        $member = $familyService->getOneById($id);
        $menGroup = $familyService->getMenGroup();
        $womenGroup = $familyService->getWomenGroup();

        return view('edit', ['member' => $member, 'menGroup' => $menGroup, 'womenGroup' => $womenGroup]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  FamilyCreate  $request
     * @param FamilyService $familyService
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function update(FamilyCreate $request, FamilyService $familyService, $id)
    {
        $request->validated();
        $result = $familyService->update($request->all(), $id);
        if($result === false){
            return redirect('family/'.$id.'/edit')->withErrors($familyService->getError())->withInput();
        }

        return redirect('family');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param FamilyService $familyService
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function destroy(FamilyService $familyService, $id)
    {
        $familyService->delete($id);
        return redirect('family')->withErrors($familyService->getError())->withInput();
    }

    /**
     * @param FamilyService $familyService
     */
    public function title(FamilyService $familyService)
    {
        $memberAId = request('memberA');
        $memberBId = request('memberB');
        if($memberAId == $memberBId){
            return redirect('family')->withErrors('请选择不同的成员')->withInput();
        }

        $title = $familyService->getMemberTitle($memberAId, $memberBId);
        $familyTree = $familyService->getTree();
        $members = $familyService->getAll();
        return view('index', ['familyTree' => $familyTree, 'members' => $members, 'title' => $title]);
    }
}
