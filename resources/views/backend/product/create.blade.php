@extends('backend.layouts.master')

@section('main-content')
    <div class="card">
        <h5 class="card-header">Thêm sản phẩm</h5>
        <div class="card-body">
            <form method="post" action="{{ route('product.store') }}">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="inputTitle" class="col-form-label">Tiêu đề <span class="text-danger">*</span></label>
                    <input id="inputTitle" type="text" name="title" placeholder="Nhập tiêu đề"
                        value="{{ old('title') }}" class="form-control">
                    @error('title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="summary" class="col-form-label">Tóm tắt <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="summary" name="summary">{{ old('summary') }}</textarea>
                    @error('summary')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description" class="col-form-label">Mô tả</label>
                    <textarea class="form-control" id="description" name="description">{{ old('description') }}</textarea>
                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>


                <div class="form-group">
                    <label for="is_featured">Nổi bật ?</label><br>
                    <input type="checkbox" name='is_featured' id='is_featured' value='1' checked> Yes
                </div>
                {{-- {{$categories}} --}}

                <div class="form-group">
                    <label for="cat_id">Danh mục sản phẩm <span class="text-danger">*</span></label>
                    <select name="cat_id" id="cat_id" class="form-control">
                        <option value="">--Lựa chọn danh mục sản phẩm--</option>
                        @foreach ($categories as $key => $cat_data)
                            <option value='{{ $cat_data->id }}'>{{ $cat_data->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group d-none" id="child_cat_div">
                    <label for="child_cat_id">Danh mục con</label>
                    <select name="child_cat_id" id="child_cat_id" class="form-control">
                        <option value="">--Lựa chọn danh mục con--</option>
                        {{-- @foreach ($parent_cats as $key => $parent_cat)
                  <option value='{{$parent_cat->id}}'>{{$parent_cat->title}}</option>
              @endforeach --}}
                    </select>
                </div>

                <div class="form-group">
                    <label for="price" class="col-form-label">Đơn giá <span class="text-danger">*</span></label>
                    <input id="price" type="number" name="price" placeholder="Nhập giá" value="{{ old('price') }}"
                        class="form-control">
                    @error('price')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="discount" class="col-form-label">Giảm giá(%)</label>
                    <input id="discount" type="number" name="discount" min="0" max="100"
                        placeholder="Nhập phần trăm giảm giá" value="{{ old('discount') }}" class="form-control">
                    @error('discount')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>


                <div class="form-group">
                    <label for="brand_id">Thương hiệu</label>
                    {{-- {{$brands}} --}}

                    <select name="brand_id" class="form-control">
                        <option value="">--Lựa chọn thương hiệu--</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="condition">Tình trạng</label>
                    <select name="condition" class="form-control">
                        <option value="">--Lựa chọn tình trạng--</option>
                        <option value="default">Default</option>
                        <option value="new">New</option>
                        <option value="hot">Hot</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="stock">Số lượng <span class="text-danger">*</span></label>
                    <input id="quantity" type="number" name="stock" min="0" placeholder="Nhập số lượng"
                        value="{{ old('stock') }}" class="form-control">
                    @error('stock')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="inputPhoto" class="col-form-label">Ảnh <span class="text-danger">*</span></label>
                    <div id="photo-container">
                        @if (old('photos'))
                            @foreach (old('photos') as $photo)
                                <div class="input-group mb-2">
                                    <input type="text" name="photos[]" class="form-control"
                                        value="{{ $photo }}" readonly>
                                    <span class="input-group-btn">
                                        <button class="btn btn-danger remove-photo" type="button">Xóa</button>
                                    </span>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <button type="button" class="btn btn-primary" id="select-photo">Thêm ảnh</button>
                    @error('photos')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>




                <div class="form-group">
                    <label for="status" class="col-form-label">Trạng thái <span class="text-danger">*</span></label>
                    <select name="status" class="form-control">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                    @error('status')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <button class="btn btn-success" type="submit">Thêm sản phẩm</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('backend/summernote/summernote.min.css') }}">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
@endpush
@push('scripts')
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script src="{{ asset('backend/summernote/summernote.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>


    <script>
        $('#lfm').filemanager('image');

        $(document).ready(function() {
            $('#summary').summernote({
                placeholder: "Viết một đoạn mô tả ngắn.....",
                tabsize: 2,
                height: 100
            });
        });

        $(document).ready(function() {
            $('#description').summernote({
                placeholder: "Viết mô tả chi tiết.....",
                tabsize: 2,
                height: 150
            });
        });
        // $('select').selectpicker();
    </script>

    <script>
        $('#cat_id').change(function() {
            var cat_id = $(this).val();
            if (cat_id != null) {
                $.ajax({
                    url: "/admin/category/" + cat_id + "/child",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: cat_id
                    },
                    type: "POST",
                    success: function(response) {
                        if (typeof(response) != 'object') {
                            response = $.parseJSON(response);
                        }
                        var html_option = "<option value=''>----Select sub category----</option>";
                        if (response.status) {
                            var data = response.data;
                            if (data) {
                                $('#child_cat_div').removeClass('d-none');
                                $.each(data, function(id, title) {
                                    html_option += "<option value='" + id + "'>" + title +
                                        "</option>";
                                });
                            }
                        } else {
                            $('#child_cat_div').addClass('d-none');
                        }
                        $('#child_cat_id').html(html_option);
                    }
                });
            }
        });

        $(document).ready(function() {

            // Xóa input ảnh
            $(document).on('click', '.remove-photo', function() {
                $(this).closest('.input-group').remove();
            });

            // Mở File Manager
            $('#select-photo').click(function() {
                let route_prefix = "/filemanager"; // Laravel File Manager URL
                window.open(route_prefix + '?type=image', 'FileManager', 'width=900,height=600');
            });

            // Hàm xử lý khi chọn ảnh từ File Manager
            window.SetUrl = function(urls) {
                console.log(urls); // Kiểm tra dữ liệu trả về

                urls.forEach(urlObj => {
                    let imageUrl = typeof urlObj === 'object' ? urlObj.url :
                        urlObj; // Lấy URL từ object nếu có

                    $('#photo-container').append(`
                    <div class="input-group mb-2">
                        <input type="text" name="photos[]" class="form-control" value="${imageUrl}" readonly>
                        <span class="input-group-btn">
                            <button class="btn btn-danger remove-photo" type="button">Xóa</button>
                        </span>
                    </div>
                `);
                });
            };
        });
    </script>
@endpush
