@extends('layouts.app')

@section('content')
<section class="vh-100">
    <div class="container-fluid h-custom">
        <h1>Home</h1>

        <div class="card-body">
            <table id="datatable" class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>John Doe</td>
                        <td>johndoe@example.com</td>
                        <td>Admin</td>
                    </tr>
                    <tr>
                        <td>Jane Smith</td>
                        <td>janesmith@example.com</td>
                        <td>User</td>
                    </tr>
                    <!-- Add more rows here -->
                </tbody>
            </table>
        </div>
    </div>
    <div class="d-flex flex-column flex-md-row text-center text-md-start justify-content-between py-4 px-4 px-xl-5 bg-black">
        <!-- Copyright -->
        <div class="text-white mb-3 mb-md-0">
            <img src="{{ asset('images/logo_white.png') }}" class="img-fluid" alt="Sample image">
        </div>
        <!-- Copyright -->
    </div>
    <script>
        $(document).ready(function() {
            var table = $('#datatable').DataTable({
                // Opções de configuração
            });

            // Adicionar a funcionalidade de pesquisa
            $('#datatable_filter input').unbind().bind('keyup', function() {
                table.search(this.value).draw();
            });
        });
    </script>
</section>
@endsection
