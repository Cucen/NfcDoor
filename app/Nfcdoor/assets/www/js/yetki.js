var serviceURL = "http://192.168.1.5/nfcdoor/services/";

var employees;

 $(document).delegate('#yetki', 'pageshow', function() {
	getEmployeeList();

});

function getEmployeeList() {

$("select").bind ("change", function (event)
{
        $.getJSON('http://192.168.1.5/esovtajlocal9/services/getaraclar.php', function(data) {
		employees = data.items;
		$('#employeeList li').remove();
		$.each(employees, function(index, employee) {
		
			$('#employeeList').append('<li data-icon="custom" id="iconcustom"><a  rel="external" href="#detailsPage?id=' + employee.idaraclar + '">' +
					'<img src="pics/' + employee.image + '"/>' +
					'<h4>' + employee.marka + ' ' + employee.yer + '</h4>' +
					'<p>' + employee.Belge_Turu + '</p>' +
					'</a></li>');	
		});
	
		$('#employeeList').listview('refresh');
	});
	
   	
	 $('#employeeList').listview('refresh');
}

