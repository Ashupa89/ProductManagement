<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product List</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-2">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Product List</h2>
            </div>
            <div class="pull-right mb-2">
                <a class="btn btn-success" href="{{ route('products.create') }}"> Create Product</a>
            </div>
        </div>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <form action="{{ route('products.delete') }}" method="Post">
        @error('id')
        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
        @enderror
        <table class="table table-bordered">
            <tr>
                <th>S.No</th>
                <th>Product Name</th>
                <th>Product Price</th>
                <th>Product UPC</th>
                <th>Product Status</th>
                <th>Product Image</th>
                <th width="280px">Action</th>
                <th>
                    <input class="btn btn-danger" type="submit" name="submit" value="Delete All Products"/>
                    <label for="checkAll"><input type="checkbox" id="checkAll"> Select All</label>
                </th>
            </tr>

            @foreach ($products as $Product)
                <tr>
                    <td>{{ $Product->id }}</td>
                    <td>{{ $Product->name }}</td>
                    <td>{{ $Product->price }}</td>
                    <td>{{ $Product->UPC }}</td>
                    <td>{{ $Product->status ? 'Placed ': "process"}}</td>
                    <td>
                        @if($Product->image) <img src="{{url('files/'.$Product->image)}}" width="100px" height="100px" alt="">
                    @endif</td>
                    <td>
                        <form action="{{ route('products.destroy',$Product->id) }}" method="Post">
                            <a class="btn btn-primary" href="{{ route('products.edit',$Product->id) }}">Edit</a>
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                    <td class="text-center"><input name='id[]' type="checkbox" id="checkItem"
                                                   value="{{ $Product->id }}">
                        @csrf
                        @method('DELETE')
                    </td>
                </tr>
            @endforeach
        </table>
    </form>
    {!! $products->links() !!}

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script language="javascript">
        $("#checkAll").click(function () {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
    </script>
</div>
</body>
</html>
