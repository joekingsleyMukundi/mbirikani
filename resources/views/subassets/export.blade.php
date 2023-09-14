@extends('layouts.app_pdf')


@section('content')

    <table class="table table-bordered table-condensed">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Area</th>
            <th scope="col">Land Category</th>
            <th scope="col">Hectares</th>
            <th scope="col">Acres</th>
            <th scope="col">Survey No</th>
            <th scope="col">Parcel No</th>
        </tr>
        </thead>
        <tbody>
        @foreach($subassets as $subasset)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$subasset->area->name}}</td>
                <td>{{$subasset->area->uses->name}}</td>
                <td>{{round($subasset->acres/2.4710538146717,2)}}</td>
                <td>{{round($subasset->acres,2)}}</td>
                <td>{{$subasset->survey_no}}</td>
                <td>{{$subasset->parcel_no}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection

@section('script')

@endsection
