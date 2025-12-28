@extends('layouts.main')

@section('title', 'Halaman Nilai')

@section('content')

<h3>Perulangan For</h3>
@for ($i = 1; $i <= 10; $i++)
    {{ $i }} <br>
@endfor

<hr>

<h3>Nilai Mahasiswa</h3>
<ul>
@foreach ($nilai as $n)
    <li>{{ $n }}</li>
@endforeach
</ul>

@endsection
