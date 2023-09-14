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
        @foreach($assetuses as $assetuse)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$assetuse->name}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection

@section('script')

@endsection
