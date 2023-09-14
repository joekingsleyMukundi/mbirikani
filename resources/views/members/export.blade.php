@extends('layouts.app_pdf')


@section('content')

    <table class="table table-bordered table-condensed">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">MGR Group Society Number</th>
            <th scope="col">MGR Membership</th>
            <th scope="col">First Name</th>
            <th scope="col">Last Name</th>
            <th scope="col">ID No</th>
            <th scope="col">Phone</th>
            <th scope="col">Email</th>
            <th scope="col">Sex</th>
            <th scope="col">Kra</th>
            <th scope="col">Number Of Parcels</th>
        </tr>
        </thead>
        <tbody>
        @foreach($members as $member)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{ "MCS/" . $member->id}}</td>
                <td>{{$member->membership_number}}</td>
                <td>{{$member->first_name}}</td>
                <td>{{$member->last_name}}</td>
                <td>{{$member->id_no}}</td>
                <td>{{$member->phone}}</td>
                <td>{{$member->email}}</td>
                <td>{{$member->sex}}</td>
                <td>{{$member->kra}}</td>
                <td>{{count($member->allocations)}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection

@section('script')

@endsection
