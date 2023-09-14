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
            <th scope="col">Member</th>
            <th scope="col">MGR Membership</th>

        </tr>
        </thead>
        <tbody>
        @foreach($allocations as $allocation)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$allocation->area->name}}</td>
                <td>{{$allocation->area->uses->name}}</td>
                <td>{{round($allocation->acres/2.4710538146717,2)}}</td>
                <td>{{round($allocation->acres,2)}}</td>
                <td>{{$allocation->survey_no}}</td>
                <td>{{$allocation->parcel_no}}</td>
                <td>{{$allocation->member->name}}</td>
                <td>{{$allocation->member->membership_number}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection

@section('script')

@endsection
