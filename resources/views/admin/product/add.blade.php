@extends('admin.main')

@section('head')
<link rel="stylesheet" href="/summernote/summernote.min.css">
@endsection
@section('content')
<form action="" method="post"  enctype="multipart/form-data">
    <div class="card-body">

        <div class="row">
            <!-- Tên Sản Phẩm -->
            <div class="col-md-6">
                <div class="form-group">
                    <label>Tên Sản Phẩm</label>
                    <input type="text" value="{{ old('name') }}" name="name" class="form-control" placeholder="Nhập tên sản phẩm">
                </div>
            </div>

            <!-- Danh mục -->
            <div class="col-md-6">
                <div class="form-group">
                    <label>Danh mục</label>
                    <select name="menu_id" class="form-control">
                        <option value="0">Danh Mục Cha</option>
                        @foreach($menus as $menu)
                        <option value="{{$menu->id}}">{{$menu->name}}</option> 
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Giá Gốc -->
            <div class="col-md-6">
                <div class="form-group">
                    <label>Giá Gốc</label>
                    <input type="number" value="{{ old('price') }}" name="price" class="form-control"></input>
                </div>
            </div>

            <!-- Giá Giảm -->
            <div class="col-md-6">
                <div class="form-group">
                    <label>Giá Giảm</label>
                    <input type="number" value="{{ old('price_sale') }}" name="price_sale" class="form-control"></input>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- Giá Gốc -->
            <div class="col-md-6">
                <div class="form-group">
                    <label>Số Lượng</label>
                    <input type="number" value="{{ old('in_stock') }}" name="in_stock" class="form-control"></input>
                </div>
            </div>
        </div>
        <!-- Ảnh sản phẩm -->
        <div class="form-group">
            <label>Ảnh Sản Phẩm</label>
            <input type="file" class="form-control-file" id="upload">
            <div id="image_show">

            </div>
            <input type="hidden" name="thumb" id="thumb">
        </div>

        <!-- Mô tả -->
        <div class="form-group">
            <label>Mô tả</label>
            <textarea name="description" value="{{ old('description') }}" class="form-control"></textarea>
        </div>

        <!-- Mô tả chi tiết -->
        <div class="form-group">
            <label>Mô tả chi tiết</label>
            <textarea id="content" value="{{ old('content') }}" name="content" class="form-control"></textarea>
        </div>

        <!-- Kích hoạt -->
        <div class="form-group">
            <label >Kích hoạt</label>
            <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" value="1" id="active" name="active" checked="">
                <label for="active" class="custom-control-label">Có</label>
            </div>
            <div class="custom-control custom-radio">
                <input type="radio" value="0" class="custom-control-input" id="no_active" name="active">
                <label for="no_active" class="custom-control-label">Không</label>
            </div>
        </div>

    </div>
    <!-- /.card-body -->

    <div class="card-footer">
        <button type="submit" class="btn btn-primary">Thêm Sản Phẩm Danh mục</button>
    </div>

    @csrf
</form>

@endsection

@section('footer')
<script src="/summernote/summernote.min.js"></script>
<script>
    $(document).ready(function() {
        $('#content').summernote();
    });
</script>
@endsection