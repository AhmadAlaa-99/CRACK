@extends('layouts.master')

@section('title', 'File Management')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-4 bg-dark text-white">
                    <div class="card-header bg-secondary">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">purchases Management</h4>
                        
                        </div>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <div class="table-responsive">
                           <table class="table table-dark table-striped">
    <thead>
        <tr>
            <th>name</th>
            <th>email</th>
            <th>ip_address</th>
          
            <th>status</th>
            <th>Date</th>
            <th>download_allowed</th>
        </tr>
    </thead>
    <tbody>
        @foreach($purchases as $purchase)
            <tr>
                <td>{{ $purchase->user->name }}</td>
                <td>{{ $purchase->user->email }}</td>
                <td>{{ $purchase->ip_address }}</td>
     
                <td>
                    <span class="badge bg-{{ $purchase->status === 'completed' ? 'success' : 'warning' }}">
                        {{ $purchase->status }}
                    </span>
                </td>
                <td>{{ $purchase->created_at->format('Y-m-d H:i') }}</td>
                <td>
    @if($purchase->download_allowed)
        <form method="POST"
              action="{{ route('purchases.revoke', $purchase) }}">
            @csrf @method('PATCH')
            <button class="btn btn-sm btn-danger">
            Re-lock
            </button>
        </form>
    @else
        <form method="POST"
              action="{{ route('purchases.allow', $purchase) }}">
            @csrf @method('PATCH')
            <button class="btn btn-sm btn-success">
                Unlock
            </button>
        </form>
    @endif
</td>

            </tr>
        @endforeach
    </tbody>
</table>


                        </div>

                        <div class="d-flex justify-content-end mt-3">
                          {{ $purchases->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection






