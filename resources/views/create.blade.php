<!-- 保存在 resources/views/child.blade.php 文件中 -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">添加家庭成员</div>
                    <div class="text-center p-2">
                        @foreach($errors->all() as $error)
                            <p class="text-danger">{{ $error }}</p>
                        @endforeach
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('create') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">姓名</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autofocus>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="gender" class="col-md-4 col-form-label text-md-right">性别</label>

                                <div class="col-md-6">
                                    <select name="gender" id="gender" class="form-control" required>
                                        <option value="">请选择性别</option>
                                        <option value="men" @if(old('gender') == 'men') selected @endif>男</option>
                                        <option value="women" @if(old('gender') == 'women') selected @endif>女</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="birthday" class="col-md-4 col-form-label text-md-right">生日</label>

                                <div class="col-md-6">
                                    <input type="text" id="birthday" name="birthday" class="form-control" value="{{ old('birthday') }}"/>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="father_id" class="col-md-4 col-form-label text-md-right">父亲</label>

                                <div class="col-md-6">
                                    <select name="father_id" id="father_id" class="form-control">
                                        <option value="">请选择父亲</option>
                                        @foreach($menGroup as $men)
                                            <option value="{{ $men->id }}" @if(old('father_id') == $men->id) selected @endif>{{ $men->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="mother_id" class="col-md-4 col-form-label text-md-right">母亲</label>

                                <div class="col-md-6 form-group">
                                    <select name="mother_id" id="mother_id" class="form-control">
                                        <option value="">请选择母亲</option>
                                        @foreach($womenGroup as $women)
                                            <option value="{{ $women->id }}" @if(old('mother_id') == $women->id) selected @endif>{{ $women->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">提交</button>
                                    <button type="button" class="btn btn-outline-primary" onclick="history.go(-1);">返回</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
