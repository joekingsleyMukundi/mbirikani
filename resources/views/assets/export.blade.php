@extends('layouts.app_pdf')


@section('content')

    <table class="table table-bordered table-condensed">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Hectares</th>
            <th scope="col">Acres</th>
        </tr>
        </thead>
        <tbody>
        @foreach($assets as $asset)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$asset->name}}</td>
                <td>{{ round($asset->total_acres/2.4710538146717,2) }}</td>
                <td>{{$asset->total_acres}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection

@section('script')

@endsection
