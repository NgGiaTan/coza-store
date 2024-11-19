@extends('admin.main')

@section('head')
<link rel="stylesheet" href="/summernote/summernote.min.css">
@endsection
@section('content')
<form action="" method="post">
    <div class="card-body">
        <div class="form-group">
            <label>Tên danh mục</label>
            <input type="text" name="name" value="{{$menu->name}}" class="form-control" placeholder="Nhập tên danh mục">
        </div>

        <div class="form-group">
            <label>Danh mục</label>
            <select name="parent_id" class="form-control">
                <option value="0" {{ $menu->parent_id == 0 ? 'selected' : '' }}>Danh Mục Cha</option>
                
                @foreach($menus as $menuParent)
                    <option value="{{ $menuParent->id }}" 
                        {{ $menu->parent_id == $menuParent->id ? 'selected' : '' }}
                        {{ $menu->id == $menuParent->id ? 'disabled' : '' }}>
                        {{ $menuParent->name }}
                    </option> 
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Mô tả</label>
            <textarea name="description" class="form-control">{{$menu->description}}</textarea>
        </div>
        <div class="form-group">
            <label>Mô tả chi tiết</label>
            <textarea id="editor" name="content" class="form-control">{{$menu->content}}</textarea>
        </div>
        <div class="form-group">
            <label for="">Kích hoạt</label>
            <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" value="1" id="active" name="active" {{$menu->active == 1 ? ' checked ': ''}}>
                <label for="active" class="custom-control-label">Có</label>
            </div>
            <div class="custom-control custom-radio">
                <input type="radio" value="0" class="custom-control-input" id="no_active" name="active"  {{$menu->active == 0 ? ' checked ': ''}}>
                <label for="no_active" class="custom-control-label">Không</label>
            </div>
        </div>
    </div>
    <!-- /.card-body -->

    <div class="card-footer">
        <button type="submit" class="btn btn-primary">Cập Nhật Danh mục</button>
    </div>
    @csrf 
</form>
@endsection

@section('footer')
<script src="/summernote/summernote.min.js"></script>
<script>
    $(document).ready(function() {
        $('#editor').summernote();
    });
</script>
@endsection