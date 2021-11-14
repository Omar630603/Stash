@extends('layouts.appBranch')

@section('content')
<div class="container-fluid">
    <div>
        @if ($message = Session::get('fail'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert" style="border-radius: 10px">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>
                <p style="margin: 0">{{ $message }}</p>
            </strong>
        </div>
        @elseif ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert"
            style=" text-align: center; border-radius: 20px">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>
                <p style="margin: 0">{{ $message }}</p>
            </strong>
        </div>
        @endif
    </div>
</div>
<div class="container-fluid">
    @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 10px">
        <strong>Whoops!</strong> There were some problems with your input.<br>
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
</div>
<div class="container-fluid" style="min-height: 400px">
    <div class="container-fluid">
        <div class="headerS" style="display: flex; justify-content: space-between">
            <h3>{{$msg}} Transactions in {{$branch->branch_name}} branch
            </h3>
            <div class="btn-group">
                <a href="{{ route('branch.transactions') }}" class="btn btn-info">View
                    Transactions</a>
                <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{ route('branch.transactions', ['status' => 0]) }}">Unpaid</a>
                    <a class="dropdown-item" href="{{ route('branch.transactions', ['status' => 1]) }}">Paid</a>
                    <a class="dropdown-item" href="{{ route('branch.transactions', ['status' => 2]) }}">Disapproved</a>
                    <a class="dropdown-item" href="{{ route('branch.transactions', ['status' => 3]) }}">Approved</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('branch.transactions') }}">All
                        Transactions</a>
                </div>
            </div>
        </div>
        @if(count($transactions)>0)
        <table>
            <thead>
                <tr>
                    <th class="column">Bank</th>
                    <th class="column">Order</th>
                    <th class="column">Description</th>
                    <th class="column">Amount</th>
                    <th class="column">Status</th>
                    <th class="column">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $transaction)
                <tr>
                    <td data-label="Bank" class="column">
                        @if ($transaction->ID_Bank == Null)
                        <p class="btn-sm btn-light">No bank (not paid yet)</p>
                        @else
                        @foreach ($banks as $bank)
                        @if ($transaction->ID_Bank == $bank->ID_Bank)
                        <p class="btn-sm btn-light">{{$bank->bank_name}} - {{$bank->accountNo}}</p>
                        @endif
                        @endforeach
                        @endif
                    </td>
                    <td data-label="Order" class="column" data-toggle="tooltip" title="Order Details">
                        <a href="{{ route('branch.orderDetails', ['order'=>$transaction->ID_Order]) }}">
                            <p class="btn-sm btn-info">{{$transaction->unit_name}}</p>
                        </a>
                    </td>
                    <td data-label="Description" class="column">
                        <p class="btn-sm btn-light">{{$transaction->transactions_description}}</p>
                    </td>
                    <td data-label="Amount" class="column">
                        <p class="btn-sm btn-light">{{$transaction->transactions_totalPrice}}</p>
                    </td>
                    <td data-label="Status" class="column">
                        @if ($transaction->transactions_status == 0 )
                        <p class="btn-sm btn-warning">Unpaid</p>
                        @elseif ($transaction->transactions_status == 1 )
                        <p class="btn-sm btn-success">Paid</p>
                        @elseif ($transaction->transactions_status == 2 )
                        <p class="btn-sm btn-danger">Disapproved</p>
                        @elseif ($transaction->transactions_status == 3 )
                        <p class="btn-sm btn-success">Approved</p>
                        @endif
                    </td>
                    <td data-label="Action" class="column">
                        @if ($transaction->transactions_status == 0)
                        <a data-toggle="tooltip" title="Pay" style="text-decoration: none;cursor: pointer">
                            <i class="use-hover fas fa-receipt icons" aria-hidden="true"></i>
                        </a>
                        <a data-toggle="tooltip" title="Delete Transaction"
                            style="text-decoration: none;cursor: pointer">
                            <i class="delete-hover far fa-trash-alt icons"></i>
                        </a>
                        @elseif ($transaction->transactions_status == 1)
                        <a target="_blank" rel="noopener noreferrer" href="{{ asset('storage/'.$transaction->proof) }}"
                            data-toggle="tooltip" title="View Proof" style="text-decoration: none;cursor: pointer">
                            <i class="use-hover fas fa-info-circle icons" aria-hidden="true"></i>
                        </a>
                        <a data-toggle="tooltip" title="Approve Transaction"
                            style="text-decoration: none;cursor: pointer">
                            <i class="delete-hover fas fa-check-circle icons"></i>
                        </a>
                        <a data-toggle="tooltip" title="Disapprove Transaction"
                            style="text-decoration: none;cursor: pointer">
                            <i class="delete-hover fas fa-ban icons"></i>
                        </a>
                        <a data-toggle="tooltip" title="Delete Transaction"
                            style="text-decoration: none;cursor: pointer">
                            <i class="delete-hover far fa-trash-alt icons"></i>
                        </a>
                        @elseif ($transaction->transactions_status == 2)
                        <a target="_blank" rel="noopener noreferrer" href="{{ asset('storage/'.$transaction->proof) }}"
                            data-toggle="tooltip" title="View Proof" style="text-decoration: none;cursor: pointer">
                            <i class="use-hover fas fa-info-circle icons" aria-hidden="true"></i>
                        </a>
                        <a data-toggle="tooltip" title="Approve Transaction"
                            style="text-decoration: none;cursor: pointer">
                            <i class="delete-hover fas fa-check-circle icons"></i>
                        </a>
                        <a data-toggle="tooltip" title="Delete Transaction"
                            style="text-decoration: none;cursor: pointer">
                            <i class="delete-hover far fa-trash-alt icons"></i>
                        </a>
                        @elseif ($transaction->transactions_status == 3)
                        <a target="_blank" rel="noopener noreferrer" href="{{ asset('storage/'.$transaction->proof) }}"
                            data-toggle="tooltip" title="View Proof" style="text-decoration: none;cursor: pointer">
                            <i class="use-hover fas fa-info-circle icons" aria-hidden="true"></i>
                        </a>
                        <a data-toggle="tooltip" title="Disapprove Transaction"
                            style="text-decoration: none;cursor: pointer">
                            <i class="delete-hover fas fa-ban icons"></i>
                        </a>
                        <a data-toggle="tooltip" title="Delete Transaction"
                            style="text-decoration: none;cursor: pointer">
                            <i class="delete-hover far fa-trash-alt icons"></i>
                        </a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="headerS">
            <h3>
                No Transactions Found<br>
                <small>This Branch has no {{$msg}} transactions</small>
            </h3>
        </div>
        @endif
    </div>
</div>
@endsection