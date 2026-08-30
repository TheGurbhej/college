

const toggler = document.querySelector(".btn");
toggler.addEventListener("click", function () {
    document.querySelector("#sidebar").classList.toggle("collapsed");
});


new DataTable('#studentTable', {

    responsive: true,

    pageLength: 10,

    lengthMenu: [
        [5, 10, 25, 50, 100],
        [5, 10, 25, 50, 100]
    ],

    ordering: true,

    searching: true,

    paging: true,

    info: true,


    columnDefs: [
        {
            orderable: false,
            targets: [7]
        }
    ]

});



// Department wali js table 
$(document).ready(function () {
    // 1. Initialize DataTable
    $('#departmentsTable').DataTable({
        "pageLength": 10
    });

    // 2. Pass data to Edit Modal
    $('.edit-btn').on('click', function () {
        var id = $(this).data('id');
        var code = $(this).data('code');
        var name = $(this).data('name');
        var hod = $(this).data('hod');
        var status = $(this).data('status');

        $('#edit_id').val(id);
        $('#edit_code').val(code);
        $('#edit_name').val(name);
        $('#edit_hod').val(hod);
        $('#edit_status').val(status);
    });

    // 3. Pass data to Delete Modal
    $('.delete-btn').on('click', function () {
        var id = $(this).data('id');
        $('#delete_id').val(id);
    });
});
