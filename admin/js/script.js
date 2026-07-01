

const toggler = document.querySelector(".btn");
toggler.addEventListener("click",function(){
    document.querySelector("#sidebar").classList.toggle("collapsed");
});


new DataTable('#studentTable', {

    responsive: true,

    pageLength: 10,

    lengthMenu: [
        [5,10,25,50,100],
        [5,10,25,50,100]
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