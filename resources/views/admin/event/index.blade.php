@extends('layouts.app')

@section('content')
<div id="all_events">
    @include('admin.event.includes.ajaxIndex')
</div>

@push('scripts')
<link rel="stylesheet" type="text/css" href="{{ asset('bower_components/jquery-ui/themes/base/all.css') }}"/>
<script>
    $(function () {
        $("#accordion").accordion({
            collapsible: true
        });
    });

    $("#all_events").on("submit", "form[name=frm_update_event]", function (e) {
        e.preventDefault();
        ajaxCaller($(this));
        return false;
    }); // end update event click event

    $("#all_events").on("click", ".delete_event", function () {
        var msgText = '<strong style="color:red">Warning!</strong><br><br>Are you sure that you want to Delete event ?';

        // add class to main div to mark as deleted
        $(this).closest('.event-item').addClass("to_be_deleted");

        // get the event id
        var event_id = $(this).attr('data-id');

        var isSaved = true;

        if (event_id == 0) {
            isSaved = false;
        }

        confirmDelete(msgText, $(this).closest("form"), isSaved);

        return false;
    }); // end delete event click event

    // click on add new button
    $("#all_events").on("click", "#add_new_event", function () {
        addNewSection();
    });

    $("#all_events").on("submit", "form[name=frm_create_event]", function (e) {
        e.preventDefault();

        ajaxCaller($(this));
        return false;
    }); // end create event click event


    function addNewSection() {
        makeAllSectionsInactive();
        var new_form = $("#hidden_form .event-item").clone();
        $("#sort-event").append(new_form);

        $("#sort-event .event-item").last().find(".fa").removeClass("fa-angle-down").addClass("fa-angle-up");
        $("#sort-event .event-item").last().addClass("active");
        ;

    }

    function confirmDelete(msgText, frmCaller, isSaved) {

        noty({
            text: msgText,
            layout: 'center',
            buttons: [
                {
                    addClass: 'btn btn-success btn-clean',
                    text: 'Ok',
                    onClick: function ($noty) {
                        $noty.close();

                        if (isSaved) {
                            // call the ajax to delete the event
                            ajaxCaller(frmCaller);
                        } else {
                            $(".to_be_deleted").remove();
                        }


                    }
                },
                {
                    addClass: 'btn btn-danger btn-clean',
                    text: 'Cancel',
                    onClick: function ($noty) {
                        $noty.close();
                    }
                }
            ]
        })
    }

    function ajaxCaller(frmCaller) {

        var url = frmCaller.attr("action");
        var requestData = frmCaller.serialize();
        var frmName = frmCaller.attr("name");

        var selSuccessMessage = $("#alert_messages .alert-success .content");
        var selSuccessMessageContainer = $("#alert_messages .alert-success");

        var selFailMessage = $("#alert_messages .alert-danger .content");
        var selFailMessageContainer = $("#alert_messages .alert-danger");

        selSuccessMessageContainer.hide();
        selFailMessageContainer.hide();

        // call the ajax method
        $.ajax({
            url: url,
            type: 'POST',
            data: requestData,
            success: function (retData) {
                if (retData.status === 'success') {
                    // show the deleted confirmation to the user
                    selSuccessMessage.html(retData.msg);
                    selSuccessMessageContainer.fadeIn(200);

                    // in case of success only
                    if (frmName == "frm_delete_event") {
                        // remove the deleted event div
                        $(".to_be_deleted").remove();
                    } else if (frmName == "frm_create_event") {
                        ajaxRefreshPage(retData.msg);
                    } else if (frmName == "frm_update_event") {
                        // show event title from form input    
                        $(".title_"+frmCaller.attr("data-index")).html(frmCaller.find("input[name=title]").val())
                    }

                } else {

                    selFailMessageContainer.fadeIn(200);

                    if (retData.msg instanceof Array || typeof retData.msg === 'object') {
                        // show the error messages
                        var alertContent = '<strong id="welcome">Please fix the following errors:</strong><br>';
                        selFailMessage.html(alertContent);

                        $.each(retData.msg, function (key, value) {
                            $('#' + key).addClass('has-error');
                            selFailMessage.html(selFailMessage.html() + value + '<br>');
                        });
                    } else {
                        selFailMessage.html(retData.msg);
                    }


                    if (frmName == "frm_delete_event") {
                        $(".to_be_deleted").removeClass("to_be_deleted");
                    }
                }
            },
            error: function (retData) {
                selFailMessage.html("Error , Please try again later");
                selFailMessageContainer.fadeIn(200);

                if (frmName == "frm_delete_event") {
                    $(".to_be_deleted").removeClass("to_be_deleted");
                }

            }
        });
    }


    function ajaxRefreshPage(message) {

        var selSuccessMessage = $("#alert_messages .alert-success .content");
        var selSuccessMessageContainer = $("#alert_messages .alert-success");

        var selFailMessage = $("#alert_messages .alert-danger .content");
        var selFailMessageContainer = $("#alert_messages .alert-danger");

        selSuccessMessageContainer.hide();
        selFailMessageContainer.hide();
        // call the ajax method
        $.ajax({
            url: '{!! route("indexEvent") !!}',
            type: 'GET',
            success: function (retData) {
                // refresh the whole page
                $("#all_events").html(retData);
                // add a message to notify the user
                selSuccessMessage.html(message);
                selSuccessMessageContainer.fadeIn(200);
            },
            error: function (retData) {
                selFailMessage.html("Error , Please refresh the page");
                selFailMessageContainer.fadeIn(200);
            },
            complete: function () {
                // activate sorting
                activateSorting();
            }
        });
    }

</script>
@endpush  
@endsection
