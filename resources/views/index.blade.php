<!-- 保存在 resources/views/child.blade.php 文件中 -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <span class="font-weight-bold">家谱图列</span>
                        <a href="{{ url('family/create') }}"><button class="btn btn-primary float-right">添加成员</button></a>
                    </div>
                    <div class="text-center p-2">
                        @foreach($errors->all() as $error)
                            <p class="text-danger">{{ $error }}</p>
                        @endforeach
                    </div>

                    <div class="card-body">
                        <ul>
                        @foreach($familyTree as $family)
                            <li>{{ $family['name'] }}({{ $family['gender'] == 'men' ? '男' : '女' }} | {{ $family['birthday'] }})
                                <a href="{{ url('family/'.$family['id'].'/edit') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                    <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                                </svg>
                                </a>
                            @if($family['child'])
                                @include('familyTree', ['childs' => $family['child']])
                            @endif
                            </li>
                        @endforeach
                        </ul>
                    </div>
                </div>
                <div class="card mt-2">
                    <div class="card-header">
                        <span class="font-weight-bold">家庭称谓转换</span>
                    </div>

                    <div class="card-body">
                        <form method="get" action="{{ route('title') }}">
                            @csrf

                            <div class="form-group row">
                                <div class="col-md-5">
                                    <select name="memberA" id="memberA" class="form-control">
                                        <option value="">请选择成员A</option>
                                        @foreach($members as $member)
                                            <option value="{{ $member['id'] }}">{{ $member['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-5">
                                    <select name="memberB" id="memberB" class="form-control">
                                        <option value="">请选择成员B</option>
                                        @foreach($members as $member)
                                            <option value="{{ $member['id'] }}">{{ $member['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary">输出</button>
                                </div>
                            </div>
                        </form>
                        <p>{{ $title }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<style>
    .card-body ul li {
        padding: 10px;
        font-size: 16px;
    }
</style>
