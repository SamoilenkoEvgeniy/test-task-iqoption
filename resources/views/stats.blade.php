@extends('layouts.front')

@section('content')
    <div class="col-12">
        <table class="table">
            <tr>
                <th>user_id</th>
                <th>balance</th>
            </tr>
            @foreach($users as $user)
                <tr>
                    <td>{{$user->id}}</td>
                    <td>{{$user->balance}}</td>
                    <td>
                        <button data-user-id="{{$user->id}}" type="button" class="btn btn-primary loadOperationsData"
                                data-toggle="modal" data-target="#operationsModal">
                            {{$user->operations->count()}}
                        </button>
                    </td>
                </tr>
            @endforeach
        </table>
        <br/>
        <a href="/stats/reset" class="btn btn-danger">Reset</a>
    </div>

    <div class="modal" id="operationsModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Операции</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span id="loader">loading...</span>
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Cost</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody id="operationsModalBody"></tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection