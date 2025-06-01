@extends('layouts.app')

@section('content')
    <div class="container" style="max-width:1000ps">
       
        <form action="" method="post">
            @csrf
            <input type="text" class="form-control mb-2" name="title" >
            <textarea name="body" class="form-control mb-2" placeholder="Body"></textarea>
            <select name="category_id" id="" class="form-select mb-2" >
                <option value="1">News</option>
                <option value="1">Tech</option>
            </select>
            <button class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection