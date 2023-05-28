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
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('template') }}/plugins/summernote/summernote-bs4.min.css">
    {{-- Accordion --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/4.5.6/css/ionicons.min.css">
    <link rel="stylesheet" href="/css/style.css"> {{-- https://preview.colorlib.com/theme/bac/accordion-03/ --}}

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('template') }}/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <link href="{{ asset('landingPage') }}/img/bps.png" rel="icon">


</head>

<body
    class="hold-transition sidebar-mini {{ Request::is('tpi*') || Request::is('satker*') || Request::is('lke*') || Request::is('prov/evaluasi*') ? 'sidebar-collapse' : '' }}">
    <div class="wrapper">
        <!-- Preloader -->
        <div id="my-element" class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{ asset('landingPage/img/reformasi.png') }}" alt="AdminLTELogo"
                height="150" width="150">
        </div>

        {{-- Navbar --}}
        @include('layouts.backEnd.navbar')
        {{-- EndNavbar --}}

        {{-- Sidebar --}}
        @include('layouts.backEnd.sidebar')
        {{-- EndSidebar --}}
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div id="header" class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">{{ $title }}</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">

                                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                                @isset($master)
                                    <li class="breadcrumb-item"><a href="{{ $link }}">{{ $master }}</a>
                                    </li>
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
                <b href="https://adminlte.io">Evaluasi Zona
                    Integritas</b>.
            </div>
            <!-- Default to the left -->
            <strong>Copyright &copy; {{ date('Y') }} </strong>
        </footer>
    </div>
    <!-- ./wrapper -->

    {{-- Scroll to Top --}}
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="fas fa-arrow-up"></i></a>
    <script src="{{ asset('landingPage') }}/js/main.js"></script>


    {{-- Font Awesome updated --}}
    <script src="https://kit.fontawesome.com/48de642077.js" crossorigin="anonymous"></script>

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
    <!-- Summernote -->
    <script src="{{ asset('template') }}/plugins/summernote/summernote-bs4.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="{{ asset('template') }}/plugins/sweetalert2/sweetalert2.min.js"></script>
    {{-- Export to excel -> https://docs.sheetjs.com/ --}}
    <script script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script>
    {{-- Export File by excel --}}
    <script>
        function exportFile() {
            var wb = XLSX.utils.table_to_book(document.getElementById('excel'));
            XLSX.writeFile(wb, 'sample.xlsx');

        }

        function exportFile2() {
            var wb = XLSX.utils.table_to_book(document.getElementById('excel2'));
            XLSX.writeFile(wb, 'sample.xlsx');

        }
    </script>
    {{-- toast --}}
    <script>
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
        if (Session::has('success')) {
            Toast.fire({
                icon: 'success',
                title: "{{ Session::get('success') }}"
            })
        }
    </script>
    {{-- Accordion --}}
    {{-- Accordion --}}
    <script defer src="https://static.cloudflareinsights.com/beacon.min.js/vaafb692b2aea4879b33c060e79fe94621666317369993"
        integrity="sha512-0ahDYl866UMhKuYcW078ScMalXqtFJggm7TmlUtp0UlD4eQk0Ixfnm5ykXKvGJNFjLMoortdseTfsRT8oCfgGA=="
        data-cf-beacon='{"rayId":"796cb3b09d786bff","token":"cd0b4b3a733644fc843ef0b185f98241","version":"2022.11.3","si":100}'
        crossorigin="anonymous"></script>
    <!-- Page specific script -->
    {{-- AdminLTE Costumize --}}
    <script>
        $(function() {
            $('#summernote').summernote({
                height: 200, // set editor height
                minHeight: null, // set minimum height of editor
                maxHeight: null, // set maximum height of editor
                focus: true // set focus to editable area after initializing summe
            });
            $("#example1").DataTable({
                "responsive": false,
                "lengthChange": true,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": false,
                "lengthChange": false,
                "searching": false,
                "ordering": false,
                "info": false,
                "autoWidth": false,
                "buttons": ["csv", "excel", "pdf"],

                "responsive": true,

            }).buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');

        });
    </script>
    {{-- Dropdown pertanyaan --}}
    @if (Request::is('pertanyaan*'))
        <script type="text/javascript">
            $("#rowAdder").click(function() {
                newData =
                    '<div id="rowAdder"<div class="form-group">' +
                    '<div class="input-group"><div class="input-group-prepend">' +
                    '<button class="btn btn-danger" id="DeleteRow" type="button">' +
                    '<i class="bi bi-trash"></i>Delete</button> </div>' +
                    '<input required type="text" class="form-control" id="dokumen" name="dokumen[]"' +
                    'placeholder="Isi  Nama Dokumen"></div</div>';
                $('#newinput').append(newData);
            });

            $("body").on("click", "#DeleteRow", function() {
                $(this).parents("#rowAdder").remove();
            })
        </script>
        <script type="text/javascript">
            $("#row").click(function() {
                newData =
                    '<div id="row"<div class="form-group">' +
                    '<div class="input-group"><div class="input-group-prepend">' +
                    '<button class="btn btn-danger" id="DeleteRow" type="button">' +
                    '<i class="bi bi-trash"></i>Delete</button> </div>' +
                    '<input required type="text" class="form-control" id="rincian" name="input[]"' +
                    'placeholder="Isi Opsi"></div</div>';
                $('#new').append(newData);
            });

            $("body").on("click", "#DeleteRow", function() {
                $(this).parents("#row").remove();
            })
        </script>
    @endif
    <script>
        $(document).ready(function() {
            toggleFields
                (); // call this first so we start out with the correct visibility depending on the selected form values
            // this will call our toggleFields function every time the selection value of our other field changes
            $("#type").change(function() {
                toggleFields();
            });

        });
        // this toggles the visibility of other server
        function toggleFields() {
            if ($("#type").val() === "input")
                $("#input*").show();
            else
                $("#input*").hide();
        }
    </script>
    {{-- checkbox --}}
    <script>
        const select = document.querySelector('#type');
        const inputContainer = document.querySelector('#inputContainer');

        select.addEventListener('change', function() {
            const selectedValue = this.value;

            if (selectedValue === 'checkbox1') {
                inputContainer.innerHTML =
                    '<label>Opsi</label>' +
                    '<input type="hidden" name="type" value="checkbox">' +
                    // Ya
                    ' <div class="form-group">' +
                    '<input type="text" class="form-control"name = "rincian[]" value="{{ old('rincian[]') }}" ' +
                    'required placeholder = "Opsi Ya" >' +
                    '<input type="hidden" name="bobot1" value="1">' +
                    // Tidak
                    '<input type="text" class="form-control"name = "rincian[]" value="{{ old('rincian[]') }}"  ' +
                    'required placeholder = "Opsi Tidak" >' +
                    '<input type="hidden" name="bobot2" value="0">  </div>';
            } else if (selectedValue === 'checkbox2') {
                inputContainer.innerHTML =
                    '<label>Opsi</label>' +
                    '<input type="hidden" name="type" value="checkbox">' +
                    // A
                    '   <div class="form-group">' +
                    '<input type="text" class="form-control"name = "rincian[]" value="{{ old('rincian[]') }}" ' +
                    'required placeholder = "Opsi A" >' +
                    '<input type="hidden" name="bobot1" value="1">' +
                    // B
                    '<input type="text" class="form-control"name = "rincian[]" value="{{ old('rincian[]') }}"  ' +
                    'required placeholder = "Opsi B" >' +
                    '<input type="hidden" name="bobot2" value="0.5">' +
                    // C
                    '<input type="text" class="form-control"name = "rincian[]" value="{{ old('rincian[]') }}"  ' +
                    'required placeholder = "Opsi C" >' +
                    '<input type="hidden" name="bobot3" value="0">  </div>';
            } else if (selectedValue === 'checkbox3') {
                inputContainer.innerHTML =
                    '<label>Opsi</label>' +
                    '<input type="hidden" name="type" value="checkbox">' +
                    // A
                    '   <div class="form-group">' +
                    '<input type="text" class="form-control"name = "rincian[]" value="{{ old('rincian[]') }}" ' +
                    'required placeholder = "Opsi A" >' +
                    '<input type="hidden" name="bobot1" value="1">' +
                    // B
                    '<input type="text" class="form-control"name = "rincian[]" value="{{ old('rincian[]') }}"  ' +
                    'required placeholder = "Opsi B" >' +
                    '<input type="hidden" name="bobot2" value="0.67">' +
                    // C
                    '<input type="text" class="form-control"name = "rincian[]" value="{{ old('rincian[]') }}"  ' +
                    'required placeholder = "Opsi C" >' +
                    '<input type="hidden" name="bobot3" value="0.33">' +
                    // D
                    '<input type="text" class="form-control"name = "rincian[]" value="{{ old('rincian[]') }}"  ' +
                    'required placeholder = "Opsi D" >' +
                    '<input type="hidden" name="bobot4" value="0">  </div>';
            } else if (selectedValue === 'checkbox4') {
                inputContainer.innerHTML =

                    '<label>Opsi</label>' +
                    '<input type="hidden" name="type" value="checkbox">' +
                    // A
                    '   <div class="form-group">' +
                    '<input type="text" class="form-control"name = "rincian[]" value="{{ old('rincian[]') }}" ' +
                    'required placeholder = "Opsi A" >' +
                    '<input type="hidden" name="bobot1" value="1">' +
                    // B
                    '<input type="text" class="form-control"name = "rincian[]" value="{{ old('rincian[]') }}"  ' +
                    'required placeholder = "Opsi B" >' +
                    '<input type="hidden" name="bobot2" value="0.75">' +
                    // C
                    '<input type="text" class="form-control"name = "rincian[]" value="{{ old('rincian[]') }}"  ' +
                    'required placeholder = "Opsi C" >' +
                    '<input type="hidden" name="bobot3" value="0.5">' +
                    // D
                    '<input type="text" class="form-control"name = "rincian[]" value="{{ old('rincian[]') }}"  ' +
                    'required placeholder = "Opsi D" >' +
                    '<input type="hidden" name="bobot4" value="0.25">' +
                    // E
                    '<input type="text" class="form-control"name = "rincian[]" value="{{ old('rincian[]') }}"  ' +
                    'required placeholder = "Opsi E" >' +
                    '<input type="hidden" name="bobot5" value="0">  </div>';
            } else {
                inputContainer.innerHTML = '';

            }
        });
    </script>


    {{-- Select search --}}
    <script>
        $(function() {
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        });
    </script>
    {{-- Untuk Input Field pertanyaan --}}


    {{-- File input --}}
    <script>
        $('.custom-file input').change(function(e) {
            var files = [];
            for (var i = 0; i < $(this)[0].files.length; i++) {
                files.push($(this)[0].files[i].name);
            }
            $(this).next('.custom-file-label').html(files.join(', '));
        });
    </script>
    <!-- Stay In Position when refresh -->
    <script>
        // Menambahkan event listener pada tombol submit di setiap kartu accordion
        var submitButtons = document.querySelectorAll('.collapse .submit-button');
        submitButtons.forEach(function(button) {
            button.addEventListener('click', function(e) {
                // Menyimpan ID kartu dan indeks baris yang di-submit ke localStorage
                var cardId = e.target.closest('.collapse').getAttribute('id');
                var rowIndex = e.target.closest('.rowAccordion').rowIndex;
                localStorage.setItem('submittedCardId', cardId);
                localStorage.setItem('submittedRowIndex', rowIndex - 1);

            });
        });
        // Memeriksa localStorage setelah halaman dimuat ulang
        window.onload = function() {
            var submittedCardId = localStorage.getItem('submittedCardId');
            var submittedRowIndex = localStorage.getItem('submittedRowIndex');
            if (submittedCardId !== null && submittedRowIndex !== null) {
                // Menemukan elemen kartu yang sesuai dengan ID yang disimpan
                var card = document.getElementById(submittedCardId);
                if (card !== null) {
                    // Mengaktifkan kartu yang sesuai
                    card.classList.add('show');
                    // Menemukan elemen baris yang sesuai dengan indeks yang disimpan
                    var rows = card.querySelectorAll('.rowAccordion');
                    if (submittedRowIndex >= 0 && submittedRowIndex < rows.length) {
                        var row = rows[submittedRowIndex];
                        // Mempertahankan posisi scroll pada baris yang sesuai
                        row.scrollIntoView();
                    }
                }
                localStorage.removeItem('submittedCardId');
                localStorage.removeItem('submittedRowIndex');
            }
        };
    </script>
</body>

</html>
