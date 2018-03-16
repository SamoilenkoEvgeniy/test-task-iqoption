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
                    var btn = row.operation_status === 'hold' ?
                        "<a class='btn btn-danger unHold' data-action='unHoldRefuse' data-operation-id='" + row.id + "' href='#'>refuse</a>" +
                        " <a class='btn btn-primary unHold' data-action='unHoldAccept' data-operation-id='" + row.id + "' href='#'>unHold</a>" : "";
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

    $('.send').click(function(e) {

        e.preventDefault();

        var that = $(this),
            form = that.parents("form").first();


        $.ajax({
            url: form.attr('action'),
            data: form.serialize(),
            success: function (response) {
                console.log('success');
            },
            error: function() {
                console.log('error');
            }
        });

        return false;
    });

    $(document).on('click', '.unHold', function (e) {
        e.preventDefault();

        var that = $(this),
            operation_id = that.data('operation-id'),
            action = that.data('action');

        $.ajax({
            url: '/task/changeOperationStatus',
            data: {
                operation_id: operation_id,
                action: action
            },
            success: function () {
                that.parents('td').first().html("");
            }
        });
        return false;
    });

});