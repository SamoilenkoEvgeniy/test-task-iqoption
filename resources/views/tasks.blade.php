@extends('layouts.front')

@section('content')
    <div class="col-4">
        <div class="card">
            <div class="card-header">
                Add changeBalance Task
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
                        <label for="amount">Amount (may be low zero)</label>
                        <input type="number" id="amount" name="amount" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label for="isHold">Is Hold</label>
                        <input type="checkbox" id="isHold" name="isHold" />
                    </div>

                    <div class="form-group">
                        <input type="submit" class="btn btn-primary send" value="Send" />
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection