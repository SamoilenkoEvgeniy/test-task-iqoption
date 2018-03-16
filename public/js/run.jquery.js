$(document).ready(function () {

    $('#operationsModal .table').hide();

    $('.loadOperationsData').click(function (e) {
        var that = $(this),
            user_id = that.data('user-id');
        $.ajax({
            url: '/data/operations/load',
            dataType: 'JSON',
            data: {
                user_id: user_id
            },
            success: function (response) {
                $('#operationsModal .table').show();
                $('#loader').hide();
                $('#operationsModalBody').html("");

                for (var i = 0; i < response.operations.length; i++) {
                    var row = response['operations'][i];
                    var btn = row.operation_status === "hold" ? "<a href=\'\'>Run</a>" : "";
                    $('#operationsModalBody').append("" +
                        "<tr>" +
                        "<td>" + row.operation_costs + "</td>" +
                        "<td>" + row.operation_status + "</td>" +
                        "<td>" + btn + "</td>" +
                        "</tr>");
                }
            }
        });
    });

});