<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>E-Zona Integritas| {{ $title }}</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('template/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('template/dist/css/adminlte.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('template') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet"
        href="{{ asset('template') }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('template') }}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
        <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('template') }}/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="{{ asset('template') }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        {{-- Navbar --}}
        @include('layouts.backEnd.navbar')
        {{-- EndNavbar --}}

        {{-- Sidebar --}}
        @include('layouts.backEnd.sidebar')
        {{-- EndSidebar --}}
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">{{ $title }}</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">

                                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                @isset($master)
                                    <li class="breadcrumb-item"><a href="/{{ $link }}">{{ $master }}</a></li>
                                @endisset
                                <li class="breadcrumb-item active">{{ $title }}</li>


                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        {{-- Content --}}
                        @yield('content')
                        {{-- EndContent --}}

                    </div>
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->


        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- To the right -->
            <div class="float-right d-none d-sm-inline">
                <a href="https://adminlte.io">Evaluasi Zona
                    Integritas</a>.
            </div>
            <!-- Default to the left -->
            <strong>Copyright &copy; {{ date('Y') }} </strong>
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="{{ asset('template/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('template/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('template/dist/js/adminlte.min.js') }}"></script>
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('template') }}/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset('template') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('template') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="{{ asset('template') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="{{ asset('template') }}/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset('template') }}/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="{{ asset('template') }}/plugins/jszip/jszip.min.js"></script>
    <script src="{{ asset('template') }}/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="{{ asset('template') }}/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="{{ asset('template') }}/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="{{ asset('template') }}/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="{{ asset('template') }}/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    {{-- Select search --}}
    <!-- Select2 -->
    <script src="{{ asset('template') }}/plugins/select2/js/select2.full.min.js"></script>
    <!-- Page specific script -->
    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": true,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
 
    {{-- mengelola dropdown --}}
    @if (Request::is('tpi'))
    <script type="text/javascript">
        let baris=1;
        $("#rowAdder").click(function() {
            baris= baris+1;
            newRowAdd =
                '<div id="row" class="form-group">' +
                '<div class="input-group"><div class="input-group-prepend">' +
                '<button class="btn btn-danger" id="DeleteRow" type="button">' +
                '<i class="bi bi-trash"></i>Delete</button> </div>' +
                '<select id="pref'+baris+'select" class="form-control preferenceSelect" name="anggota[]">' +
                '<option value="">Pilih Anggota Tim '+baris+' </option>' +
                '@foreach ($anggota as $value)@if (old("anggota") == $value->id)' +
                '<option value="{{ $value->id }}" selected>{{ $value->name }} </option >' +
                '@else <option value="{{ $value->id }}">{{ $value->name }}</option> @endif @endforeach'+
                '</select></div></div>';

            

            $('#newinput').append(newRowAdd);
        });

        $("body").on("click", "#DeleteRow", function() {
            $(this).parents("#row").remove();
        })
    </script>

    @endif

    {{-- Dropdown Satker --}}   
    @if (Request::is('tpi/*'))
    <script type="text/javascript">
        let baris=1;
        $("#rowSatker").click(function() {
            baris+=1;
            newSatker =
                '<div id="rowSatker" class="form-group">' +
                '<div class="input-group"><div class="input-group-prepend">' +
                '<button class="btn btn-danger" id="DeleteRow" type="button">' +
                '<i class="bi bi-trash"></i>Delete</button> </div>' +
                '<select id="prefselect'+baris+'" class="select2bs4 form-control preferenceSelect" name="satker_id[]"> required' +
                '<option value="">Pilih Satuan kerja '+baris+' </option>' +
                '@foreach ($satker as $value)@if (old("satker_id") == $value->id)' +
                '<option value="{{ $value->id }}" selected>{{ $value->nama_satker }} </option >' +
                '@else <option value="{{ $value->id }}">{{ $value->nama_satker }}</option> @endif @endforeach'+
                '</select></div></div>';
            $('#inputSatker').append(newSatker);
        });

        $("body").on("click", "#DeleteRow", function() {
            $(this).parents("#rowSatker").remove();
        })
    </script>
    @endif
   
    {{-- @if (count($errors) > 0)
        <script type="text/javascript">
            $(document).ready(function() {
                $('#tambah').modal('show');
            });
        </script>
    @endif --}}

    <script>
        $(document).ready(function() {
            $(".preferenceSelect").change(function() {
                // Get the selected value
                var selected = $("option:selected", $(this)).val();
                // Get the ID of this element
                var thisID = $(this).attr("id");
                // Reset so all values are showing:
                $(".preferenceSelect option").each(function() {
                    $(this).show();
                });
                $(".preferenceSelect").each(function() {
                    if ($(this).attr("id") != thisID) {
                        $("option[value='" + selected + "']", $(this)).attr("disabled", true);
                    }
                });

            });
        });
    </script>

    {{-- Select search --}}
    <script>
    $(function () {
        $('.select2bs4').select2({
        theme: 'bootstrap4'
    })
    });
    </script>


{{-- Coba --}}
    <script>
        $(".PLUS, .MIN").click(function(){
        var itemVal = parseInt($(this).siblings(".InputText").val());
        if ($(this).hasClass('MIN'))
        itemVal--;      
        else
        itemVal++;
        $(this).siblings(".InputText").val(itemVal);
});
    </script>
</body>

</html>
