jQuery(document).ready(function($) {

//********************************************************
// AJAX drag and drop sort
//********************************************************
    var sortList = $('#custom-type-list');
 
    sortList.sortable({
        update: function(event, ui) {
            $('#loading-animation').show(); // Show the animate loading gif while waiting
 
            opts = {
                url: ajaxurl, // ajaxurl is defined by WordPress and points to /wp-admin/admin-ajax.php
                type: 'POST',
                async: true,
                cache: false,
                dataType: 'json',
                data:{
                    action: 'sortable_sort', // Tell WordPress how to handle this ajax request
                    order: sortList.sortable('toArray').toString() // Passes ID's of list items in  1,3,2 format
                },
                success: function(response) {
                    $('#loading-animation').hide(); // Hide the loading animation
                    return;
                },
                error: function(xhr,textStatus,e) {  // This can be expanded to provide more information
                    alert('There was an error saving the updates');
                    $('#loading-animation').hide(); // Hide the loading animation
                    return;
                }
            };
            $.ajax(opts);
        }
    });

//********************************************************
// what, you're still here? It's over. Go home.
//********************************************************


});