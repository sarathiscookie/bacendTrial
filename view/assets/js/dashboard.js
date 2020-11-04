/* globals Feather:false */
'use strict'

$(document).ready( function(){
$('.add').on('click', function(){
  $('#County').val('');
  $('#Country').val('');
  $('#town').val('');
  $('#Description').val('');
  $('#Price').val('');
  $('#Address').val('');
  $('#bedrooms').val('');
  $('#bathroom').val('');
  $('#Property').val('');
  $('#id').val('');
  $("input:radio").attr("checked", false);
});


  $('#userTable').on('click', 'a.edit', function (e) {

    $('#County').val('');
    $('#Country').val('');
    $('#town').val('');
    $('#Description').val('');
    $('#Price').val('');
    $('#Address').val('');
    $('#bedrooms').val('');
    $('#bathroom').val('');
    $('#Property').val('');
    $('#id').val('');
    $("input[name='sale_rent']").val('');

    var id = $(this).attr('id');
    $.ajax({
      type: "edit",
      method:"post",
      url: "edit.php",
      data: {id:id},
      dataType: 'json',
      success: function (data) {
        $('#id').val(data.id);
       $('#County').val(data.county);
        $('#Country').val(data.country);
        $('#town').val(data.town);
        $('#Description').val(data.description);
        $('#Price').val(data.price);
        $('#Address').val(data.address);
        $("#mediaData").html('<img src="' + data.thumbnail + '" />');
        $('#bedrooms option[value="'+data.bedrooms+'"]').prop('selected', true);
        $('#bathroom option[value="'+data.bathrooms+'"]').prop('selected', true);
        $('#Property option[value="'+data.Property+'"]').prop('selected', true);
        if(data.type=='sale') {
          $("#sale").attr('checked','checked');
        } else {
          $("#rent").attr('checked','checked');
        }
        $("input[name='sale_rent']:checked").val(data.type);
      },
      error: function (data) {
        alert(data);
      },

      });
  });

  $('#userTable').on('click', 'a.delete', function (e) {
    var id = $(this).attr('id');
    $('#id').val(id);
 });

 $('#delete').on('click', function (e) {
     var del = $('#id').val();
     $.ajax({
      type: "add",
      method:"post",
      url: "delete.php",
      data: {id:del},
      success: function (data) {
          alert(data);
          location.reload();
      },
      error: function (data) {
      alert(data);
      }
      });
 });

  $(".forSubmit").on('click',function($e) {
    $e.preventDefault();
   var County = $("#County").val();
   var Country = $("#Country").val();
   var town = $("#town").val();
   var Address = $("#Address").val();
   var Price = $("#Price").val();
   var bedrooms = $("#bedrooms").val();
   var bathroom = $("#bathroom").val();
   var Property = $("#Property").val();
   var salerent = $("input[name='salerent']:checked").val();
   var Description = $("#Description").val();
   var id =$("#id").val();
   var form = $("#uploadData")[0];
   var formData = new FormData(form);
   if(County=="") {
    alert("Please enter county");
    return false;
   }
   if(Country=="") {
    alert("Please enter Country");
    return false;
   }
   if(town=="") {
    alert("Please enter town");
    return false;
   }
   if(Address=="") {
    alert("Please enter Address");
    return false;
   }
   if(Price=="") {
    alert("Please enter Price");
    return false;
   }

   if(!$.isNumeric(Price)) {
    alert("Please enter numbers for price");
    return false;
   } 

   if(bedrooms=="") {
    alert("Please select bedrooms");
    return false;
   }
   if(bathroom=="") {
    alert("Please select bathroom");
    return false;
   }
   if(Property=="") {
    alert("Please select Property");
    return false;
   }   
   if(salerent=="") {
    alert("Please select sale /Rent");
    return false;
   }
   if(Description=="") {
    alert("Please select Description");
    return false;
   }

   $.ajax({
    type: "add",
    method:"post",
    url: "insert.php",
    data: formData,
    success: function (data) {
        alert(data);
        location.reload();
    },
    error: function (data) {
    alert(data);
    },
    cache: false,
    contentType: false,
    processData: false
    });
});

  


});


