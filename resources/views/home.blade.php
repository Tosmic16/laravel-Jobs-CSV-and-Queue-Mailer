@extends('layout')
@section('content')

    
@endsection<H1>Upload a CSV File</H1>
<form enctype='multipart/form-data' method="post" action="/csvupload">
    <input type="file" name="csv">
@csrf
    <input type="submit">
</form>

@endsection