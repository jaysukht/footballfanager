@extends('layouts.include.admin')

@section('content')
    {{--  DataTable Responsive CSS --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{ asset('assets/js/toastify/src/toastify.css') }}">
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="filter-top-sec">
        <div class="report-selectbox filter-select-all-widht">
            <label class="form-label">
                <i class="ti ti-adjustments"></i> Show
            </label>
            <select id="filter_date_range" class="form-select select2">
                <option value="20">20</option>
                <option value="40">40</option>
                <option value="60">60</option>
                <option value="80">80</option>
                <option value="100">100</option>
                <option value="-1">All</option>
            </select>
        </div>
    </div>
    <div class="filter-top-sec request-wrapper">
        <div class="manageuser">
            <a href="{{ route('admin.all-referee.create') }}" class="btn common-btn">Add</a>
        </div>
    </div>
    
    <div class="dashboard-table-sec oddeven-table search-mt">
        <table id="match-table" class="display table responsive nowrap" width="100%">
            <thead>
                <tr>
                    <th>#ID</th>
                    <th>Title</th>
                    <th>League</th>
                    <th>Season</th>
                    <th>
                        @foreach ($languages as $language)
                            <img src="{{ asset('assets/images/language_flags/' . $language->lang_flag) }}" 
                                 alt="{{ $language->fullname }}" 
                                 title="{{ $language->fullname }}" 
                                 style="width: 30px; height: 20px; margin: 3px; border-radius: 3px; cursor: pointer;">
                        @endforeach
                    </th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
    @include('admin.modal.deleterecord')
@endsection

@section('scripts')
    {{-- jQuery FIRST --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    {{-- DataTables CORE --}}
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    {{--  DataTables Responsive --}}
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="{{ asset('assets/js/toastify/src/toastify.js') }}"></script>
    <script src="{{ asset('assets/js/message.js') }}"></script>
    <script>
        $(document).ready(function() {
            var table = $('#match-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                autoWidth: false, //  IMPORTANT (fix cloneNode issue)
                pageLength: 20,
                ajax: {
                    url: '{{ route('admin.all-referee.data') }}',
                    dataType: 'json',
                    data: function(d) {
                        d.filter_language = $('#filter_language').val();
                    }
                },
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'post_title',
                        name: 'post_title'
                    },
                    {
                        data: 'league_id',
                        name: 'league_id'
                    },
                    {
                        data: 'season_id',
                        name: 'season_id'
                    },
                    {
                        data: 'languages',
                        name: 'languages',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                order: [
                    [0, 'desc']
                ],
                language: {
                    search: "",
                    searchPlaceholder: "Search...",
                    paginate: {
                        previous: '<i class="bi bi-chevron-left"></i>',
                        next: '<i class="bi bi-chevron-right"></i>'
                    }
                },
                dom: '<"row mb-3"<"col-sm-6 seach"><"col-sm-6 text-end"f>>rt<"row mt-3"<"col-sm-6"i><"col-sm-6"p>>',
                initComplete: function() {
                    let searchInput = $('.dataTables_filter input');
                    searchInput.addClass('form-control');
                }
            });

            // Page length filter
            $('#filter_date_range').on('change', function() {
                let val = $(this).val();
                table.page.len(val === '-1' ? -1 : parseInt(val)).draw();
            });
            // Filter by filter_language
            $('#filter_language').on('change', function() {
                table.ajax.reload();
            });

            $(document).on('click', '.show-remove-modal', function() {
                $('.delete-record-id').val($(this).data('deleteid'));
                $('#deleteRecordModal').modal('show');
            });
            //Start delete user modal
            $(document).on('click', '.delete-record', function() {
                let $btn = $(this);
                let deleteid = $('.delete-record-id').val();
                let url = "{{ route('admin.all-referee.delete') }}";
                let $loader = $btn.find('.loader-ajax');
                $loader.removeClass('d-none');
                $btn.prop('disabled', true);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    url: url,
                    method: "POST",
                    data: {
                        deleteid: deleteid
                    },
                    success: function(res) {
                        if (res.status === true) {
                            SuccessMsg(res.message);
                        } else {
                            ErrorMsg(res.message ?? 'Algo salio mal', '#e6514c');
                        }
                    },
                    error: function(r) {
                        let res = r.responseJSON;
                        ErrorMsg(res?.message ?? 'Algo salio mal', '#e6514c');
                    },
                    complete: function() {
                        $loader.addClass('d-none');
                        $('#deleteRecordModal').on('hidden.bs.modal', function() {
                            window.location.reload();
                        }).modal('hide');
                        $btn.prop('disabled', false);
                    }
                });
            });
        });
    </script>
@endsection
