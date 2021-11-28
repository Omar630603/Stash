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
            style=" text-align: center; border-radius: 10px">
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
                <a href="{{ route('branch.transactions') }}" class="btn btn-info">Transactions</a>
                <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-reference="parent">
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu mr-2">
                    <a class="dropdown-item" href="{{ route('branch.transactions', ['status' => 0]) }}">Unpaid</a>
                    <a class="dropdown-item" href="{{ route('branch.transactions', ['status' => 1]) }}">Paid</a>
                    <a class="dropdown-item" href="{{ route('branch.transactions', ['status' => 2]) }}">Disapproved</a>
                    <a class="dropdown-item" href="{{ route('branch.transactions', ['status' => 3]) }}">Approved</a>
                    <a class="dropdown-item" href="{{ route('branch.transactions', ['status' => 4]) }}">Deleted</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('branch.transactions') }}">All
                        Transactions</a>
                </div>
            </div>
        </div>
        @if(count($transactions)>0)
        <div class="tableWrapper">
            <table id="transactionTable">
                <thead>
                    <tr>
                        <th class="column">Date</th>
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
                        <td data-label="Date" class="column">
                            <p class="btn-sm btn-light">{{$transaction->created_at}}
                                @if ($transaction->transaction_madeBy)
                                <i data-toggle="tooltip" title="Transaction Made By Branch"
                                    class="noUse-hover float-right far fa-building"></i>
                                @else
                                <i data-toggle="tooltip" title="Transaction Made By Customer"
                                    class="refresh-hover float-right fas fa-user-tag"></i>
                                @endif
                            </p>
                        </td>
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
                            <p class="btn-sm btn-dark">Paid</p>
                            @elseif ($transaction->transactions_status == 2 )
                            <p class="btn-sm btn-danger">Disapproved</p>
                            @elseif ($transaction->transactions_status == 3 )
                            <p class="btn-sm btn-success">Approved</p>
                            @elseif ($transaction->transactions_status == 4 )
                            <p class="btn-sm btn-secondary">Deleted</p>
                            @endif
                        </td>
                        <td style="display: flex; gap: 5px; flex-wrap: wrap; justify-content: flex-end"
                            data-label="Action" class="column">
                            @if ($transaction->transactions_status == 0)
                            <a data-toggle="modal" data-target="#payTransaction{{$transaction->ID_Transaction}}"
                                style="text-decoration: none;cursor: pointer">
                                <i data-toggle="tooltip" title="Pay" class="use-hover fas fa-receipt icons"
                                    aria-hidden="true"></i>
                            </a>
                            @elseif ($transaction->transactions_status == 1)
                            <a target="_blank" rel="noopener noreferrer"
                                href="{{ asset('storage/'.$transaction->proof) }}" data-toggle="tooltip"
                                title="View Proof" style="text-decoration: none;cursor: pointer">
                                <i class="use-hover fas fa-info-circle icons" aria-hidden="true"></i>
                            </a>
                            <a href="{{ route('branch.approveTransaction', $transaction) }}"
                                style="text-decoration: none;cursor: pointer">
                                <i data-toggle="tooltip" title="Approve Transaction"
                                    class="use-hover fas fa-check-circle icons"></i>
                            </a>
                            <a href="{{ route('branch.disapproveTransaction', $transaction) }}"
                                style="text-decoration: none;cursor: pointer">
                                <i data-toggle="tooltip" title="Disapprove Transaction"
                                    class="delete-hover fas fa-ban icons"></i>
                            </a>
                            @elseif ($transaction->transactions_status == 2)
                            <a target="_blank" rel="noopener noreferrer"
                                href="{{ asset('storage/'.$transaction->proof) }}" data-toggle="tooltip"
                                title="View Proof" style="text-decoration: none;cursor: pointer">
                                <i class="use-hover fas fa-info-circle icons" aria-hidden="true"></i>
                            </a>
                            <a href="{{ route('branch.approveTransaction', $transaction) }}"
                                style="text-decoration: none;cursor: pointer">
                                <i data-toggle="tooltip" title="Approve Transaction"
                                    class="use-hover fas fa-check-circle icons"></i>
                            </a>
                            @elseif ($transaction->transactions_status == 3)
                            <a target="_blank" rel="noopener noreferrer"
                                href="{{ asset('storage/'.$transaction->proof) }}" data-toggle="tooltip"
                                title="View Proof" style="text-decoration: none;cursor: pointer">
                                <i class="use-hover fas fa-info-circle icons" aria-hidden="true"></i>
                            </a>
                            <a href="{{ route('branch.disapproveTransaction', $transaction) }}"
                                style="text-decoration: none;cursor: pointer">
                                <i data-toggle="tooltip" title="Disapprove Transaction"
                                    class="delete-hover fas fa-ban icons"></i>
                            </a>
                            @endif
                            @if ($transaction->transactions_status == 4)
                            <a data-toggle="modal" data-target="#deleteTransaction{{$transaction->ID_Transaction}}"
                                style="text-decoration: none;cursor: pointer">
                                <i data-toggle="tooltip" title="Return To Unpaid Transaction"
                                    class="refresh-hover fas fa-sync icons"></i>
                            </a>
                            @else
                            <a data-toggle="modal" data-target="#deleteTransaction{{$transaction->ID_Transaction}}"
                                style="text-decoration: none;cursor: pointer">
                                <i data-toggle="tooltip" title="Delete Transaction"
                                    class="delete-hover far fa-trash-alt icons"></i>
                            </a>
                            @endif
                            <div class="modal fade" id="payTransaction{{$transaction->ID_Transaction}}" tabindex="-1"
                                role="dialog" aria-labelledby="payTransaction{{$transaction->transactions_description}}"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header" style="justify-content: center">
                                            <h5 class="modal-title"
                                                id="payTransaction{{$transaction->ID_Transaction}}Title">
                                                Pay: {{$transaction->transactions_description}}
                                            </h5>
                                        </div>
                                        <div class="modal-body">
                                            <div class="alert-success" style="padding: 10px; border-radius: 10px">
                                                <form action="{{ route('branch.payTransaction', $transaction) }}"
                                                    id="payTransaction{{$transaction->ID_Transaction}}Form"
                                                    enctype="multipart/form-data" method="POST">
                                                    @csrf
                                                    <p>
                                                        <center><strong>!! This Will Pay The Order
                                                                {{$transaction->transactions_description}}!!</strong>
                                                            <br>Choose Payment Bank And Upload The Payment Proof.
                                                            Then Click Pay to Continue
                                                            the Process
                                                        </center>
                                                    </p>

                                                    <div class="container headerOrder" style="text-align: left">
                                                        <div class="container">
                                                            <div>
                                                                <label for="capacity"><strong>Pay Order
                                                                        {{$transaction->transactions_description}}
                                                                        <small>(This will add the
                                                                            payment details for
                                                                            the
                                                                            extension transaction with
                                                                            price:
                                                                            {{$transaction->transactions_totalPrice}})</small>
                                                                    </strong></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="container" style="padding: 10px 15px"
                                                        id="addPaymentforTransaction{{$transaction->ID_Transaction}}">
                                                        <div class="headerOrder row">
                                                            <div class="form-group" style="margin: 10px 0">
                                                                <select name="ID_Bank" style="width: 100%"
                                                                    class="select2">
                                                                    <option value="0">Select Bank
                                                                    </option>
                                                                    @php
                                                                    $bankNo = 1;
                                                                    @endphp
                                                                    @foreach ($banks as $bank)
                                                                    <option value="{{$bank->ID_Bank}}">
                                                                        {{$bankNo++}}- (
                                                                        {{$bank->bank_name}} )
                                                                        -
                                                                        @ {{$bank->accountNo}}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div style="margin: 10px 0">
                                                                <a style="width: 100%;"
                                                                    onclick="$('#proofInputImageTransaction{{$transaction->ID_Transaction}}').click(); return false;"
                                                                    class="btn btn-sm btn-outline-light">Add
                                                                    Payment Proof</a>
                                                                <input
                                                                    onchange="showPaymentProof({{$transaction->ID_Transaction}})"
                                                                    id="proofInputImageTransaction{{$transaction->ID_Transaction}}"
                                                                    style="display: none;" type="file" name="proof">
                                                                <input
                                                                    style="display: none; margin-top: 5px; text-align: center; width: 100%"
                                                                    disabled style="display: none"
                                                                    id="proofPhotoTransaction{{$transaction->ID_Transaction}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-sm btn-outline-secondary"
                                                data-dismiss="modal">Close</button>
                                            <button
                                                onclick="$('#payTransaction{{$transaction->ID_Transaction}}Form').submit();"
                                                type="button" class="btn btn-sm btn-outline-success">Pay</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="deleteTransaction{{$transaction->ID_Transaction}}" tabindex="-1"
                                role="dialog"
                                aria-labelledby="deleteTransaction{{$transaction->transactions_description}}"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header" style="justify-content: center">
                                            <h5 class="modal-title"
                                                id="deleteTransaction{{$transaction->ID_Transaction}}Title">
                                                Delete: {{$transaction->transactions_description}}
                                            </h5>
                                        </div>
                                        <div class="modal-body">
                                            <div class="alert-danger" style="padding: 10px; border-radius: 10px">
                                                <form action="{{ route('branch.deleteTransaction', $transaction) }}"
                                                    id="deleteTransaction{{$transaction->ID_Transaction}}Form"
                                                    enctype="multipart/form-data" method="POST">
                                                    @csrf
                                                    <p>
                                                        <center><strong>!! This Will Delete The Order
                                                                {{$transaction->transactions_description}}!!</strong>
                                                            <br>Click Delete to Continue
                                                            the Process
                                                        </center>
                                                    </p>
                                                    <div class="form-check" style="margin-bottom: 10px">
                                                        @if ($transaction->transactions_status == 0)
                                                        <div>
                                                            <input checked name="deleteTransactionType"
                                                                class="checkDeleteType form-check-input" type="checkbox"
                                                                value="1">
                                                            <label class="form-check-label" for="flexCheckDefault">
                                                                Delete The Transaction Completely
                                                            </label>
                                                        </div>
                                                        @elseif ($transaction->transactions_status == 4)
                                                        <div>
                                                            <input checked name="deleteTransactionType"
                                                                class="checkDeleteType form-check-input" type="checkbox"
                                                                value="2">
                                                            <label class="form-check-label" for="flexCheckDefault">
                                                                Return The Transaction To Unpaid Status
                                                            </label>
                                                        </div>
                                                        @else
                                                        <div>
                                                            <input name="deleteTransactionType"
                                                                class="checkDeleteType form-check-input" type="checkbox"
                                                                value="1">
                                                            <label class="form-check-label" for="flexCheckDefault">
                                                                Delete The Transaction Completely
                                                            </label>
                                                        </div>
                                                        <div>
                                                            <input checked name="deleteTransactionType"
                                                                class="checkDeleteType form-check-input" type="checkbox"
                                                                value="2">
                                                            <label class="form-check-label" for="flexCheckDefault">
                                                                Return The Transaction To Unpaid Status
                                                            </label>
                                                        </div>
                                                        @endif
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-sm btn-outline-secondary"
                                                data-dismiss="modal">Close</button>
                                            <button
                                                onclick="$('#deleteTransaction{{$transaction->ID_Transaction}}Form').submit();"
                                                type="button" class="btn btn-sm btn-outline-danger">
                                                @if($transaction->transactions_status == 4)
                                                Return
                                                @else
                                                Delete
                                                @endIf</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
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
<script>
    $(document).ready(function(){
        $('#transactionTable').DataTable( {
            "pagingType": "full_numbers",
            "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]]
        });
        $('.checkPaymentTransaction').click(function() {
            $('.checkPaymentTransaction').not(this).prop('checked', false);
        });
        $('.checkDeleteType').click(function() {
            $('.checkDeleteType').not(this).prop('checked', false);
        });
        
    });
</script>
<script>
    $(".select2").select2({
        theme: "bootstrap-5",
        selectionCssClass: "select2--small", // For Select2 v4.1
        dropdownCssClass: "select2--small",
        });
    function showPaymentProof(id) {
        var proofInputImageTransaction = document.getElementById('proofInputImageTransaction'+id);
        var proofPhotoTransaction = document.getElementById('proofPhotoTransaction'+id);
        proofPhotoTransaction.style.display = '';
        proofPhotoTransaction.value = 'File Name:' + proofInputImageTransaction.files[0].name;
    }
</script>
@endsection