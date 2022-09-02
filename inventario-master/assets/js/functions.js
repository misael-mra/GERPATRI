
function suggetion() {

     $('#sug_input').keyup(function(e) {

         var formData = {
             'equipment_tombo' : $('input[name=tombo]').val()
         };

         if(formData['equipment_tombo'].length >= 1){

           // process the form
           $.ajax({
               type        : 'POST',
               url         : 'ajax.php',
               data        : formData,
               dataType    : 'json',
               encode      : true
           })
               .done(function(data) {
                   //console.log(data);
                   $('#result').html(data).fadeIn();
                   $('#result li').click(function() {

                     $('#sug_input').val($(this).text());
                     $('#result').fadeOut(500);

                   });

                   $("#sug_input").blur(function(){
                     $("#result").fadeOut(500);
                   });

               });

         } else {

           $("#result").hide();

         };

         e.preventDefault();
     });

}

$('#sug-form').submit(function(e) {
      var formData = {
          'e_tombo' : $('input[name=tombo]').val()
      };
        // process the form
        $.ajax({
            type        : 'POST',
            url         : 'ajax.php',
            data        : formData,
            dataType    : 'json',
            encode      : true
        })
            .done(function(data) {
                //console.log(data);
                $('#equipment_info').html(data).show();

            }).fail(function() {
                $('#equipment_info').html(data).show();
            });
      e.preventDefault();
});

$(document).ready(function() {

    //tooltip
    $('[data-toggle="tooltip"]').tooltip();

    $('.submenu-toggle').click(function () {
        $(this).parent().children('ul.submenu').toggle(200);
    });
    //Suggestions for finding product names
    suggetion();

    // Datatables for Normal Tables
    if($('.datatable-active').length)
    $('.datatable-active').DataTable({
        bJQueryUI: true,
        sPaginationType: "full_numbers",
        pageLength: 10,
        lengthMenu: [ [12, 24, 36, -1], [12, 24, 36, "All"] ],
        oLanguage: {
            sLengthMenu: "",
            //"sLengthMenu": "Mostrar _MENU_ registros por página",
            sZeroRecords: "Nenhum registro encontrado",
            sInfo: "Mostrando _START_ / _END_ de _TOTAL_ registro(s)",
            sInfoEmpty: "Mostrando 0 / 0 de 0 registros",
            sInfoFiltered: "(filtrado de _MAX_ registros)",
            sSearch: "Pesquisar",
            oPaginate: {
                sFirst: "Início",
                sPrevious: "Anterior",
                sNext: "Próximo",
                sLast: "Último"
            }
        },
        responsive: true,        
        aaSorting: [[0, 'asc']],
        aoColumnDefs: [
            {orderable: false}

        ]
    });
    
    if($('.datatable-button-active').length)
    $('.datatable-button-active').DataTable({
        bJQueryUI: true,
        sPaginationType: "full_numbers",
        pageLength: 10,
        lengthMenu: [ [12, 24, 36, -1], [12, 24, 36, "All"] ],
        oLanguage: {
            sLengthMenu: "",
            //"sLengthMenu": "Mostrar _MENU_ registros por página",
            sZeroRecords: "Nenhum registro encontrado",
            sInfo: "Mostrando _START_ / _END_ de _TOTAL_ registro(s)",
            sInfoEmpty: "Mostrando 0 / 0 de 0 registros",
            sInfoFiltered: "(filtrado de _MAX_ registros)",
            sSearch: "Pesquisar",
            oPaginate: {
                sFirst: "Início",
                sPrevious: "Anterior",
                sNext: "Próximo",
                sLast: "Último"
            }
        },
        responsive: true,        
        dom: 'Bfrtip',        
        buttons: [            
            {
                extend: 'copyHtml5',                
                exportOptions: {
                    columns: ':visible'
                },
                text: 'Copiar'
            },
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'pdfHtml5',                
                exportOptions: {
                    columns: ':visible'
                },
                orientation: 'landscape',
                pageSize: 'LEGAL'
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: ':visible'
                },
                text: 'Imprimir'
            },
            {
                extend: 'colvis',
                text: 'Visibilidade das Colunas'
            }

        ]
    });
    

});

  
