@extends('layouts.app_pdf')


@section('content')

    <table class="table table-bordered table-condensed">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>

        </tr>
        </thead>
        <tbody>
        @foreach($areas as $area)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$area->name}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection

@section('script')

@endsection
