@extends('layouts.app')
@section('content')
    <div class="my-3">
        <h1 class="title1 ">Follow up Members </h1>
    </div>
    <x-admin.alert />

    <div class="mb-5 row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive" data-example-id="hoverable-table">
                        <table id="ShipTable" class="table table-hover ">
                            <thead>
                                <tr>
                                    <th>Balance</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Inv. plan</th>
                                    <th>Status</th>
                                    <th>Date registered</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $list)
                                    <tr>
                                        <td>${{ $list->account_bal }}</td>
                                        <td>{{ $list->name }}</td>
                                        <td>{{ $list->l_name }}</td>
                                        <td>{{ $list->email }}</td>
                                        <td>{{ $list->phone_number }}</td>
                                        @if (isset($list->dplan->name))
                                            <td>{{ $list->dplan->name }}</td>
                                        @else
                                            <td>NULL</td>
                                        @endif
                                        <td>{{ $list->status }}</td>
                                        <td>{{ \Carbon\Carbon::parse($list->created_at)->toDayDateTimeString() }}</td>
                                        <td>
                                            <a class="m-1 btn btn-info btn-sm" data-toggle="modal"
                                                data-target="#editModal{{ $list->id }}">Edit Status</a>
                                        </td>
                                    </tr>

                                    <div id="editModal{{ $list->id }}" class="modal fade" role="dialog">
                                        <div class="modal-dialog">
                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                <div class="modal-header ">
                                                    <h4 class="modal-title">Edit this User status</h4>
                                                    <button type="button" class="close "
                                                        data-dismiss="modal">&times;</button>
                                                </div>
                                                <div class="modal-body ">
                                                    <form method="post" action="{{ route('updateuser') }}">
                                                        <div class="form-group">
                                                            <h5 class=" ">User Status</h5>
                                                            <textarea name="userupdate" id="" rows="5" class="form-control  " placeholder="Enter here" required>{{ $list->userupdate }}</textarea>
                                                        </div>
                                                        <input type="hidden" name="id" value="{{ $list->id }}">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <input type="submit" class="btn btn-primary" value="Save">

                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /send all users email Modal -->
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
