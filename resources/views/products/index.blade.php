@extends('layouts.admin')

@section('title', __('product.Product_List'))
@section('content-header', __('product.Product_List'))
@section('content-actions')
<a href="{{route('products.create')}}" class="btn btn-primary">{{ __('product.Create_Product') }}</a>
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }}">
@endsection
@section('content')
<div class="card product-list">
    <div class="card-body">
        <table  id="example2" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>{{ __('product.ID') }}</th>
                    <th>{{ __('product.Name') }}</th>
                    <th>{{ __('product.Image') }}</th>
                    <th>{{ __('product.Barcode') }}</th>
                    <th>Harga Beli</th>
                    <th>Harga Jual</th>
                    <th>Keuntungan</th>
                    <th>Jumlah Stok</th>
                    <th>Satuan</th>
                    <th>{{ __('product.Status') }}</th>
                    
                    <th>{{ __('product.Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                <tr>
                    <td>{{$product->id}}</td>
                    <td>{{$product->name}}</td>
                    <td><img class="product-img" src="{{ Storage::url($product->image) }}" alt=""></td>
                    <td>{{$product->barcode}}</td>
                    <td>{{number_format($product->hargabeli, 2,',','.')}}</td>
                    <td>{{number_format($product->price, 2,',','.')}}</td>
                    <td>{{number_format($product->price-$product->hargabeli, 2,',','.')}} ({{number_format(($product->price-$product->hargabeli)/$product->hargabeli*100, 1,',','.')}}%)</td>
                    <td>{{$product->quantity}}</td>
                    <td>{{$product->satuan}}</td>
                    <td>
                        <span class="right badge badge-{{ $product->status ? 'success' : 'danger' }}">{{$product->status ? __('common.Active') : __('common.Inactive') }}</span>
                    </td>
                    
                    <td>
                        <a href="{{ route('products.edit', $product) }}" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                        <button class="btn btn-danger btn-delete" data-url="{{route('products.destroy', $product)}}"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
    </div>
</div>
@endsection

@section('js')
<!-- jQuery -->
<script src="{{ asset('adminlte3/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('adminlte3/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- DataTables  & Plugins -->
<script src="{{ asset('adminlte3/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('adminlte3/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('adminlte3/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('adminlte3/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>

<!-- AdminLTE App -->
<script src="{{ asset('adminlte3/dist/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('adminlte3/dist/js/demo.js') }}"></script>

<script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script type="module">
    $(document).ready(function() {
        $(document).on('click', '.btn-delete', function() {
            var $this = $(this);
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                title: '{{ __('product.sure ') }}', // Wrap in quotes
                text: '{{ __('product.really_delete ') }}', // Wrap in quotes
                icon: 'warning', // Fix the icon string
                showCancelButton: true,
                confirmButtonText: '{{ __('product.yes_delete ') }}', // Wrap in quotes
                cancelButtonText: '{{ __('product.No ') }}', // Wrap in quotes
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    $.post($this.data('url'), {
                        _method: 'DELETE',
                        _token: '{{ csrf_token() }}' // Wrap in quotes
                    }, function(res) {
                        $this.closest('tr').fadeOut(500, function() {
                            $(this).remove();
                        });
                    });
                }
            });
        });
    });

</script>
<script>
  $(function () {
     


    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,

    });
    


  });
</script>
@endsection