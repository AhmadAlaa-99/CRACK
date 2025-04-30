@extends('layouts.master') <!-- Extend your layout -->

@section('title', 'Admin Dashboard')

@section('content')
    <style>
        body {
            background-color: #000;
            /* Dark background */
            color: #fff;
            /* Light text */
        }

        .sidebar {
            background-color: #2a2a2a;
            /* Dark gray for sidebar */
            min-height: 100vh;
            padding-top: 20px;
        }

        .sidebar a {
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
            display: block;
        }

        .sidebar a:hover {
            background-color: #ff3d3d;
            /* Red hover effect */
            color: #fff;
        }

        .navbar {
            background-color: #2a2a2a;
        }

        .table {
            color: #fff;
        }

        .table th,
        .table td {
            color: #fff;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #343a40;
        }

        .table-striped tbody tr:hover {
            background-color: #495057;
        }

        .btn-primary {
            background-color: #ff3d3d;
            border: none;
        }

        .btn-primary:hover {
            background-color: #e63946;
        }

        .btn-link {
            background: none;
            border: none;
            padding: 0;
            color: inherit;
            font: inherit;
            cursor: pointer;
        }

        /* Sidebar Styling */
        .sidebar {
            background-color: #2a2a2a;
            color: #fff;
            min-height: 100vh;
            padding: 20px;
            /* Add consistent padding */
            width: 250px;
            /* Fixed width for sidebar */
            position: fixed;
            /* Fix the sidebar to the left */
            top: 0;
            left: 0;
        }

        /* Main Content Styling */
        .content {
            margin-left: 250px;
            /* Same as the sidebar width */
            padding: 20px;
            /* Add padding to the main content */
            background-color: #000;
            /* Match background color */
            color: #fff;
            min-height: 100vh;
        }

        @media (max-width: 768px) {
            .sidebar {
                position: absolute;
                width: 100%;
                height: auto;
            }

            .content {
                margin-left: 0;
            }
        }
    </style>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="sidebar">
                <div class="text-center mb-4">
                    <img src="{{ asset('img/logo.png') }}" alt="Logo" width="150">
                    <h4>Admin Dashboard</h4>
                </div>
                <a href="{{ route('dashboard') }}">Dashboard</a>
                <a href="{{ route('files.index') }}">Files</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-link text-white p-0 m-0">Logout</button>
                </form>
            </div>

            <!-- Main Content -->
            <div class="col-md-9">
                <div class="container">
                    <h2 class="mt-4">All Users</h2>
                    <table class="table table-striped mt-4">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Country</th>
                                <th>User IP</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->city }}</td>
                                    <td>{{ $user->last_login_ip }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">No users found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
