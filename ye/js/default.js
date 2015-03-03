function trim(str){
  return str.replace(/(^\s+)|(\s+$)/g, "");
}
$('.deleteBtn').click(function(e){
	if(confirm('确定要删除吗？') == 0)
	{
		e.preventDefault();
	}
});
$('.watchBtn').click(function(e){
	if(confirm('确定要观看该电影吗？') == 0)
	{
		e.preventDefault();
	}
});
$('.readBtn').click(function(e){
	if(confirm('确定要读该书吗？') == 0)
	{
		e.preventDefault();
	}
});
$('#insertBtn').click(function(){
		$('#editForm').hide();
		$('#insertForm').show();
	});
$('#insertCancel').click(function(){
	$('#insertForm').hide();
});
$('#editCancel').click(function(){
	$('#editForm').hide();
});
$('#c_cancel').click(function(){
	$('#insert_c').hide();
});
$('#e_cancel').click(function(){
	$('#insert_e').hide();
});
$('#c_list_cancel').click(function(){
	$('#show_c_listdiv').hide();
});
$('#e_list_cancel').click(function(){
	$('#show_e_listdiv').hide();
});
$('.add_c').click(function(){
	$('#insert_e').hide();
	$('#c_id').val($(this).attr('id'));
	$('#insert_c').show();
});
$('.add_e').click(function(){
	$('#insert_c').hide();
	$('#e_id').val($(this).attr('id'));
	$('#insert_e').show();
});