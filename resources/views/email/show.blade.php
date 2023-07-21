@extends('layout')
@section('content')

    <form method="POST" action="/mailer">
    <input type="text" name="subject" placeholder="Email Subject" required>
    <input type="text" name="body" placeholder="Email Body" required>
    <input type="submit" >
    @csrf
</form>

@endsection