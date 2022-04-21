$(document).ready(function(){
var nowDate = new Date();
var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);
 $('.datepicker1 ').datepicker({
            uiLibrary: 'bootstrap',
			format: 'yyyy-mm-dd',
			startDate: nowDate 
        });
		 $('.datepicker2 ').datepicker({
            uiLibrary: 'bootstrap',
			format: 'yyyy-mm-dd',
			
        });

});
$('form').on('beforeSubmit', function (e) {
	$(".loading").show();
	$('.btn-hide').hide();
	return true;
});
function changeavailabilty(tablename,tableid){
			 $.ajax({
				 type: 'post',
				 url: 'changeproductavailabilty',
				 data: {
				 tablename:tablename,
				 tableid:tableid
				 },		
				 success: function (response) {
					/* silence is golden */ 
				 }	 
				 });
}

function changestatus(tablename,tableid){
			 $.ajax({
				 type: 'post',
				 url: 'changeproductstatus',
				 data: {
				 tablename:tablename,
				 tableid:tableid
				 },		
				 success: function (response) {
					/* silence is golden */ 
				 }	 
				 });
}
function changeloginaccess(tablename,tableid){
	$.ajax({
				 type: 'post',
				 url: 'changeloginaccess',
				 data: {
				 tablename:tablename,
				 tableid:tableid
				 },		
				 success: function (response) {
					/* silence is golden */ 
				 }	 
				 });
}
function editcategory(id){
var request = $.ajax({
  url: "editcategorypopup",
  type: "POST",
  data: {id : id},
}).done(function(msg) {
	$('#foodcategerybody').html(msg);
	$('#updatefoodcategery').modal('show');
});
}
function updatepilot(id){
	
var request = $.ajax({
  url: "updatepilotpopup",
  type: "POST",
  data: {id : id},
}).done(function(msg) {
	$('#pilotbody').html(msg);
	$('#updatepilot').modal('show');
});
}
function editcoupon(id){
	
var request = $.ajax({
  url: "editcouponpopup",
  type: "POST",
  data: {id : id},
}).done(function(msg) {
	$('#editcouponbody').html(msg);
	$('#editcoupon').modal('show');
});
}

function qrcode(id)
{
	alert(id);
}
function editproductpopup(id){
var request = $.ajax({
  url: "editproductpopup",
  type: "POST",
  data: {id : id},
}).done(function(msg) {

	$('#editproductbody').html(msg);
	$('#editproduct').modal('show');
});	
}
function edittablepopup(id)
{
var request = $.ajax({
  url: "edittablepopup",
  type: "POST",
  data: {id : id},
}).done(function(msg) {
	$('#edittablebody').html(msg);
	$('#edittable').modal('show');
});		
}
function billview(id){


        var form=document.createElement('form');
        form.setAttribute('method','post');
        form.setAttribute('action','tablebill');
        form.setAttribute('target','_blank');

    var hiddenField = document.createElement("input");
    hiddenField.setAttribute("name", "id");
    hiddenField.setAttribute("type", "hidden");
    hiddenField.setAttribute("value", id);
    form.appendChild(hiddenField);

    document.body.appendChild(form);
    form.submit();    


}
function updateingredient(id)
{
var request = $.ajax({
  url: "updateingredientpopup",
  type: "POST",
  data: {id : id},
}).done(function(msg) {
	$('#ingredientbody').html(msg);
	$('#updateingredient').modal('show');
});		
}

function editrewardpopup(id)
{
var request = $.ajax({
  url: "editrewardpopup",
  type: "POST",
  data: {id : id},
}).done(function(msg) {
	$('#editrewardbody').html(msg);
	$('#editreward').modal('show');
});		
}

function editappnotification(id)
{
var request = $.ajax({
  url: "editappnotificationpopup",
  type: "POST",
  data: {id : id},
}).done(function(msg) {
	$('#editeditappnotificationbody').html(msg);
	$('#editappnotification').modal('show');
});		
}
function editbanner(id)
{
var request = $.ajax({
  url: "editbannerpopup",
  type: "POST",
  data: {id : id},
}).done(function(msg) {
	$('#editbannerbody').html(msg);
	$('#editbanner').modal('show');
});		
}

function editcoupon(id)
{
var request = $.ajax({
  url: "editcouponpopup",
  type: "POST",
  data: {id : id},
}).done(function(msg) {
	$('#editcouponbody').html(msg);
	$('#editcoupon').modal('show');
});		
}

function editmerchant(id)
{
var request = $.ajax({
  url: "editmerchantpopup",
  type: "POST",
  data: {id : id},
}).done(function(msg) {
	$('#editmerchantbody').html(msg);
	$('#editmerchant').modal('show');
});		
}

function editpaytypes(id)
{
var request = $.ajax({
  url: "editpaytypespopup",
  type: "POST",
  data: {id : id},
}).done(function(msg) {
	$('#paytypesbody').html(msg);
	$('#updatepaytypes').modal('show');
});		
}

function editgrouping(id){
var request = $.ajax({
  url: "editgroupingpopup",
  type: "POST",
  data: {id : id},
}).done(function(msg) {
	$('#foodcategerybody').html(msg);
	$('#updatefoodcategery').modal('show');
});
}
function editcontestpopup(id)
{
var request = $.ajax({
  url: "editcontestpopup",
  type: "POST",
  data: {id : id},
}).done(function(msg) {
	$('#editcontestbody').html(msg);
	$('#editcontest').modal('show');
});		
}

function editcontestparticpants(id)
{
var request = $.ajax({
  url: "editcontestparticpants",
  type: "POST",
  data: {id : id},
}).done(function(msg) {
	res = JSON.parse(msg);
var data = '  <table id="example" class="table table-striped table-bordered ">\
                      <tr>\
                         <th>S No</th>\
						<th>Contest Participant Merchant</th>\
						<tbody>';
						for(j=0;j<res.length;j++){
					data += '<tr><td>'+(j+1)+'</td><td>'+res[j]['storename']+'</td></tr>';			
						}
					data += '</tbody>\</table>';
	$('#contestmerchantsbody').html(data);
	$('#contestmerchants').modal('show');
});		
}

function storetypechange(id)
{
var request = $.ajax({
  url: "updatestoretype",
  type: "POST",
  data: {id : id},
}).done(function(msg) {
	$('#editstorebody').html(msg);
	$('#editstore').modal('show');
});		
}