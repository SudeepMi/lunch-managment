"use strict";
var KTDatatablesDataSourceHtml= {
    init:function() {

        var $table = $('.dataTable-init');
    	var table = $table.DataTable({
		    pageLength: 10,
		    responsive: true,
            buttons:["print", "copyHtml5", "excelHtml5", "csvHtml5", "pdfHtml5"],
            processing:!0,

		});


    	$("#export_print").on("click", function(e) {
            e.preventDefault(), table.button(0).trigger()
        }),
        $("#export_copy").on("click", function(e) {
            e.preventDefault(), table.button(1).trigger()
        }),
        $("#export_excel").on("click", function(e) {
            e.preventDefault(), table.button(2).trigger()
        }),
        $("#export_csv").on("click", function(e) {
            e.preventDefault(), table.button(3).trigger()
        }),
        $("#export_pdf").on("click", function(e) {
            e.preventDefault(), table.button(4).trigger()
        });

        $("#kt_search").on("click", function(a) {
            a.preventDefault();
            var e= {};
            $(".kt-input").each(function() {
                var t=$(this).data("col-index");
                e[t]?e[t]+="|"+$(this).val(): e[t]=$(this).val()
            }
            ), $.each(e, function(a, e) {
                table.column(a).search(e||"", !1, !1)
            }
            ), table.table().draw()
        }
        ),
        $("#kt_reset").on("click", function(a) {
            a.preventDefault(), $(".kt-input").each(function() {
                $(this).val(""), table.column($(this).data("col-index")).search("", !1, !1)
            }
            ), table.table().draw()
        }
        )

    }
}

;
jQuery(document).ready(function() {
    KTDatatablesDataSourceHtml.init();
});
