@extends('layouts.app')


@section('contents')

<div class="container-fluid">



    <!-- USERS TABLE -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive-sm"
                style="overflow-y:auto;; margin-top:25px; margin-bottom: 10px; font-size; 10px;" id="content">
                <div style="position:absolute; top:13px; right:320px">

                    <input type="text" id="searchInput">
                </div>
                <table class="table table-sm table-hover table-bordered" id="tablemanager" width="100%" cellspacing="0">
                    <div class="row" style="margin-bottom: 7px;">
                        <div class="col"></div>
                        <div class="col"></div>
                    </div>
                    <thead>
                        <tr>

                            <th class="text-center">Activty Date</th>
                            <th class="text-center">Type</th>
                            <th class="text-center">Details</th>
                            <th class="text-center">User</th>


                        </tr>
                    </thead>

                    <tbody>
                        @foreach($ActivityLogs as $logs)
                                                @php
                                                    $type = explode(' ', trim($logs['actdetails']))[0];
                                                @endphp
                                                <tr>
                                                    <td class="text-center">{{ $logs['actdate'] }}</td>
                                                    @if ($type == "INSERT")
                                                        <td class="text-center">{{ $type }} &nbsp;<i class="fas fa-fw fa-plus text-success"></i>
                                                        </td>
                                                    @elseif ($type == "UPDATE")
                                                        <td class="text-center">{{ $type }} &nbsp;<i
                                                                class="fas fa-fw fa-edit text-darker-warning"></i>
                                                        </td>
                                                    @else
                                                        <td class="text-center">{{ $type }}</i>
                                                        </td>
                                                    @endif
                                                    <td class="text-center">{{ $logs['actdetails'] }}</td>
                                                    <td class="text-center">{{ $logs['actby'] }}</td>

                                                </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


@endsection