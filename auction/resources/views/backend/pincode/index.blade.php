@extends('backend.layouts.app')

@section('content')

    <div class="aiz-titlebar text-left mt-2 mb-3">
        <div class="align-items-center">
            <h1 class="h3">{{translate('All Pincode')}}</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-7">
            <div class="card">
        <div class="card-header">
            <h3 class="mb-0 h6">{{translate('Pincode')}}</h3>
        </div>
        <div class="card-body">
            <table class="table aiz-table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th width="10%">#</th>
                    <th>{{translate('Code')}}</th>
                    <th>{{translate('Show/Hide')}}</th>
                    <th>{{translate('Option')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($countries as $key => $country)
                    <tr>
                        <td>{{ ($key+1) + ($countries->currentPage() - 1)*$countries->perPage() }}</td>
                        <td>{{ $country->pincode }}</td>
                        <td>
                            <label class="aiz-switch aiz-switch-success mb-0">
                                <input onchange="update_status(this)" value="{{ $country->id }}" type="checkbox" <?php if($country->status == 1) echo "checked";?> >
                                <span class="slider round"></span>
                            </label>
                        </td>
                        <td>
                            <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('pincode.destroy', $country->id)}}" title="{{ translate('Delete') }}">
                                <i class="las la-trash"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="aiz-pagination">
                {{ $countries->links() }}
            </div>
        </div>
    </div>
        </div>
        <div class="col-md-5">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{ translate('Add New Pincode') }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('pincode.store') }}" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="name">{{translate('Pincode')}}</label>
                        <input type="text" placeholder="{{translate('Pincode')}}" name="pincode" class="form-control" required>
                    </div>
                    <div class="form-group mb-3 text-right">
                        <button type="submit" class="btn btn-primary">{{translate('Add')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
@endsection

@section('modal')
    @include('modals.delete_modal')
@endsection

@section('script')
    <script type="text/javascript">

        function update_status(el){
            if(el.checked){
                var status = 1;
            }
            else{
                var status = 0;
            }
            $.post('{{ route('pincode.status') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
                if(data == 1){
                    AIZ.plugins.notify('success', '{{ translate('Pincode status updated successfully') }}');
                }
                else{
                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                }
            });
        }

    </script>
@endsection
