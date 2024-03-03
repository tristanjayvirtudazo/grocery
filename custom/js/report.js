$(document).ready(function() {
	// order date picker
	$("#startDate1").datepicker();
	$("#startDate2").datepicker();
	$("#startDate3").datepicker();
	// order date picker
	$("#endDate1").datepicker();
	$("#endDate2").datepicker();
	$("#endDate3").datepicker();

	let attendanceData;

	$("#getAttendanceReportForm").unbind('submit').bind('submit', function() {
		
		var startDate = $("#startDate1").val();
		var endDate = $("#endDate1").val();
		let data = {
			start_date: startDate,
			end_date: endDate
		}

		console.log(data)

		if(startDate == "" || endDate == "") {
			if(startDate == "") {
				$("#startDate1").closest('.form-group').addClass('has-error');
				$("#startDate1").after('<p class="text-danger">The Start Date is required</p>');
			} else {
				$(".form-group").removeClass('has-error');
				$(".text-danger").remove();
			}

			if(endDate == "") {
				$("#endDate1").closest('.form-group').addClass('has-error');
				$("#endDate1").after('<p class="text-danger">The End Date is required</p>');
			} else {
				$(".form-group").removeClass('has-error');
				$(".text-danger").remove();
			}
		} else {
			$(".form-group").removeClass('has-error');
			$(".text-danger").remove();

			var form = $(this);
			$('#attendanceTable').attr('hidden',false);
			$('#productTable').attr('hidden',true);
			$('#releaseTable').attr('hidden',true);

			$.ajax({
				url: 'php_action/getAttendanceReport.php',
				type: 'GET',
				data: data,
				success:function(response) {
					//Clear table first
					while($('#attendanceList').firstChild){
						$('#attendanceList').removeChild($('#attendanceList').firstChild)
					}
					//append data
					attendanceData = response;
					console.log(response)
					response.forEach(element => {
						const tr = `<tr>
										<td>${element.date}</td>
										<td>${element.full_name}</td>
										<td>${element.time_in}</td>
										<td>${element.time_out}</td>
										<td>${element.branch_name}</td>
										<td>${element.workHours}</td>
									</tr>`
						$('#attendanceList').prepend(tr)
						
					});
				} // /success
			});	// /ajax

		} // /else

		return false;
	});

	$("#getProductReportForm").unbind('submit').bind('submit', function() {
		
		var startDate = $("#startDate2").val();
		var endDate = $("#endDate2").val();

		let data = {
			start_date: startDate,
			end_date: endDate
		}

		if(startDate == "" || endDate == "") {
			if(startDate == "") {
				$("#startDate2").closest('.form-group').addClass('has-error');
				$("#startDate2").after('<p class="text-danger">The Start Date is required</p>');
			} else {
				$(".form-group").removeClass('has-error');
				$(".text-danger").remove();
			}

			if(endDate == "") {
				$("#endDate2").closest('.form-group').addClass('has-error');
				$("#endDate2").after('<p class="text-danger">The End Date is required</p>');
			} else {
				$(".form-group").removeClass('has-error');
				$(".text-danger").remove();
			}
		} else {
			$(".form-group").removeClass('has-error');
			$(".text-danger").remove();

			var form = $(this);

			$('#attendanceTable').attr('hidden',true);
			$('#productTable').attr('hidden',false);
			$('#releaseTable').attr('hidden',true);

			$.ajax({
				url: 'php_action/getProductReport.php',
				type: 'GET',
				data: data,
				success:function(response) {
					console.log(response)
					//Clear table first
					while($('#productList').firstChild){
						$('#productList').removeChild($('#productList').firstChild)
					}
					//append data
					response.forEach(element => {
						let status;
						if(element.status > 0){
							status = "<label class='label label-success'>Available</label>"
						}else{
							status = "<label class='label label-danger'>Not Available</label>"
						}
						const tr = `<tr>
										<td>${element.product_name}</td>
										<td>${element.price}</td>
										<td>${element.quantity}</td>
										<td>${element.brand_name}</td>
										<td>${element.categories_name}</td>
										<td>${element.manufactured_date}</td>
										<td>${element.expiry_date}</td>
										<td>${status}</td>
										<td>${element.branch}</td>
									</tr>`
						$('#productList').prepend(tr)
						
					});
				} // /success
			});	// /ajax
			

		} // /else

		return false;
	});

	$("#getReleaseReportForm").unbind('submit').bind('submit', function() {
		
		var startDate = $("#startDate3").val();
		var endDate = $("#endDate3").val();
		let data = {
			start_date: startDate,
			end_date: endDate
		}

		if(startDate == "" || endDate == "") {
			if(startDate == "") {
				$("#startDate3").closest('.form-group').addClass('has-error');
				$("#startDate3").after('<p class="text-danger">The Start Date is required</p>');
			} else {
				$(".form-group").removeClass('has-error');
				$(".text-danger").remove();
			}

			if(endDate == "") {
				$("#endDate3").closest('.form-group').addClass('has-error');
				$("#endDate3").after('<p class="text-danger">The End Date is required</p>');
			} else {
				$(".form-group").removeClass('has-error');
				$(".text-danger").remove();
			}
		} else {
			$(".form-group").removeClass('has-error');
			$(".text-danger").remove();

			var form = $(this);

			$('#attendanceTable').attr('hidden',true);
			$('#productTable').attr('hidden',true);
			$('#releaseTable').attr('hidden',false);

			$.ajax({
				url: 'php_action/getReleaseReport.php',
				type: 'GET',
				data: data,
				success:function(response) {
					console.log(response)
					// Clear table first
					while($('#releaseList').firstChild){
						$('#releaseList').removeChild($('#releaseList').firstChild)
					}
					//append data
					response.forEach(element => {
						const tr = `<tr>
										<td>${element.product_name}</td>
										<td>${element.total_released}</td>
										<td>${element.brand_name}</td>
										<td>${element.categories_name}</td>
										<td>${element.release_date}</td>
										<td>${element.branch}</td>
										<td>${element.total_released_price}</td>
									</tr>`

						$('#releaseList').prepend(tr)
					});
					// const totalTr = `<tr>
					// 						<td colspan="6"><h2>Total</h2></td>
					// 						<td>&#8369; <?= revenueCount($second_query) ?></td>
					// 					</tr>`
						
					// $('#releaseList').append(totalTr)
				} // /success
			});	// /ajax

		} // /else

		return false;
	});

	$('#exportReleases').on('click', function (){
		$('#manageProductTable3').table2excel({
			name: "Releases Report",
			filename: "Releases Report",
			fileext: ".xls"
		})
	})

	$('#exportProduct').on('click', function (){
		$('#manageProductTable2').table2excel({
			name: "Products Report",
			filename: "Products Report",
			fileext: ".xls"
		})
	})

	$('#exportAttendance').on('click', function (){
		$('#manageAttendanceTable1').table2excel({
			exclude: ".noExl",
			name: "DTR",
			filename: "DTR",
			fileext: ".xls"
		})
	})


	$("#employeeSearch").on("keyup", function() {
		var value = $(this).val().toLowerCase();
		$("#manageAttendanceTable1 tbody tr").each(function() {
			if ($(this).text().toLowerCase().indexOf(value) > -1) {
				$(this).removeClass("noExl"); // Remove the class "noExl" if it exists
				$(this).show();
			} else {
				$(this).addClass("noExl"); // Add the class "noExl" to rows that don't match
				$(this).hide();
			}
		});
	});
	
});