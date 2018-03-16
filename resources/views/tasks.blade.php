@extends('layouts.front')

@section('content')
    <div class="col-4">
        <div class="card">
            <div class="card-header">
                Change user balance
            </div>
            <div class="card-body">
                <form action="/task/changeBalance">
                    <div class="form-group">
                        <label for="user_id">User</label>
                        <select class="form-control" name="user_id" id="user_id">
                            @foreach($users as $user)
                                <option value="{{$user->id}}">{{$user->id}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="amount">Amount (may be less zero)</label>
                        <input type="number" id="amount" name="amount" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label for="isHold">Is Hold</label>
                        <input type="checkbox" id="isHold" name="isHold" />
                    </div>

                    <div class="form-group">
                        <input type="submit" class="btn btn-primary send" value="Send"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="card">
            <div class="card-header">
                Transfer from User to User
            </div>
            <div class="card-body">
                <form action="/task/transferBalance">
                    <div class="form-group">
                        <label for="from">User from</label>
                        <select class="form-control" name="from" id="from">
                            @foreach($users as $user)
                                <option value="{{$user->id}}">{{$user->id}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="from">User to</label>
                        <select class="form-control" name="to" id="to">
                            @foreach($users as $user)
                                <option value="{{$user->id}}">{{$user->id}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input type="number" id="amount" min="1" name="amount" class="form-control"/>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary send" value="Send" />
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection