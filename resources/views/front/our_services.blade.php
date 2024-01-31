@extends("front.$version.layout")

@section('pagename')
- {{__('banks')}}
@endsection

@section('meta-keywords', "$be->packages_meta_keywords")
@section('meta-description', "$be->packages_meta_description")


@section('breadcrumb-title', __('banks'))
@section('breadcrumb-subtitle', $be->pricing_subtitle)
@section('breadcrumb-link', __('banks'))


@section('content')
<div class="container">
        <div class="row ">
            <div class="col-12 col-md-4  mt-4 ">
                                    @foreach($categories as $category)
                           <h1 value="{{$category->id}}">
                               {{$category->name}}
                               <p id="sub_category_id"></p>
                               
                           </h1>
                                    @endforeach


            </div>
            


        </div>
        
    </div>
    
    
        <script>
        $(document).ready(function() {
            $('select').select2({ height: '50px'});
            $("select[name='category_id']").on('change', function() {
                $("#service_id").removeAttr('disabled');

                let langId = $(this).val();
                let url = "{{url('/')}}/request/" + langId + "/get_services";

                $.get(url, function(data) {
                    let options = `<option value="" disabled selected>حدد الخدمة</option>`;

                    if (data.length == 0) {
                        options += `<option value="" disabled>${'لا يوجد خدمات متاحة حالياً'}</option>`;
                    } else {
                        for (let i = 0; i < data.length; i++) {
                            options +=`<option value="${data[i].id}">${data[i].name}</option>`;
                        }
                    }

                    $("#service_id").html(options);
                });
            });

            $("select[name='maincategory_id']").on('load', function() {
                $("#sub_category_id").removeAttr('disabled');

                let langId = $(this).val();
                let url = "{{url('/')}}/request/" + langId + "/get_subcategories";

                $.get(url, function(data) {
                    let options = `<option value="" disabled selected>حدد القسم الفرعي</option>`;

                    if (data.length == 0) {
                        options += `<option value="" disabled>${'لا يوجد قسم فرعي'}</option>`;
                    } else {
                        for (let i = 0; i < data.length; i++) {
                            options +=`<option value="${data[i].id}">${data[i].name}</option>`;
                        }
                    }

                    $("#sub_category_id").html(options);
                });
            });

        });
    </script>

    
    @endsection




