var manageProductTable;

$(document).ready(function() {
	// top nav bar 
	$('#navProduct').addClass('active');

	// $('#productImage').val("DFD.drawio.png");
	// manage product data table
	manageProductTable = $('#manageProductTable').DataTable({
		'ajax': 'php_action/fetchProduct.php',
		'order': [],
	});

	console.log(manageProductTable)

	// add product modal btn clicked
	$("#addProductModalBtn").unbind('click').bind('click', function() {
		// // product form reset
		$("#submitProductForm")[0].reset();		

		// remove text-error 
		$(".text-danger").remove();
		// remove from-group error
		$(".form-group").removeClass('has-error').removeClass('has-success');

		$("#productImage").fileinput({
	      overwriteInitial: true,
		    maxFileSize: 2500,
		    showClose: false,
		    showCaption: false,
		    browseLabel: '',
		    removeLabel: '',
		    browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
		    removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
		    removeTitle: 'Cancel or reset changes',
		    elErrorContainer: '#kv-avatar-errors-1',
		    msgErrorClass: 'alert alert-block alert-danger',
		    defaultPreviewContent: '<img src="assests/images/photo_default.png" alt="Profile Image" style="width:100%;">',
		    layoutTemplates: {main2: '{preview} {remove} {browse}'},								    
	  		allowedFileExtensions: ["jpg", "png", "gif", "JPG", "PNG", "GIF"]
			});   

		// submit product form
		$("#submitProductForm").unbind('submit').bind('submit', function() {
		
			// form validation
			var productImage = $("#productImage").val();
			var productName = $("#productName").val();
			var quantity = $("#quantity").val();
			var rate = $("#rate").val();
			var brandName = $("#brandName").val();
			var categoryName = $("#categoryName").val();
			var productStatus = $("#productStatus").val();
	
			if(productImage == "") {
				$("#productImage").closest('.center-block').after('<p class="text-danger">Product Image field is required</p>');
				$('#productImage').closest('.form-group').addClass('has-error');
			}	else {
				// remov error text field
				$("#productImage").find('.text-danger').remove();
				// success out for form 
				$("#productImage").closest('.form-group').addClass('has-success');	  	
			}	// /else

			if(productName == "") {
				$("#productName").after('<p class="text-danger">Product Name field is required</p>');
				$('#productName').closest('.form-group').addClass('has-error');
			}	else {
				// remov error text field
				$("#productName").find('.text-danger').remove();
				// success out for form 
				$("#productName").closest('.form-group').addClass('has-success');	  	
			}	// /else

			if(quantity == "") {
				$("#quantity").after('<p class="text-danger">Quantity field is required</p>');
				$('#quantity').closest('.form-group').addClass('has-error');
			}	else {
				// remov error text field
				$("#quantity").find('.text-danger').remove();
				// success out for form 
				$("#quantity").closest('.form-group').addClass('has-success');	  	
			}	// /else

			if(rate == "") {
				$("#rate").after('<p class="text-danger">Rate field is required</p>');
				$('#rate').closest('.form-group').addClass('has-error');
			}	else {
				// remov error text field
				$("#rate").find('.text-danger').remove();
				// success out for form 
				$("#rate").closest('.form-group').addClass('has-success');	  	
			}	// /else

			if(brandName == "") {
				$("#brandName").after('<p class="text-danger">Brand Name field is required</p>');
				$('#brandName').closest('.form-group').addClass('has-error');
			}	else {
				// remov error text field
				$("#brandName").find('.text-danger').remove();
				// success out for form 
				$("#brandName").closest('.form-group').addClass('has-success');	  	
			}	// /else

			if(categoryName == "") {
				$("#categoryName").after('<p class="text-danger">Category Name field is required</p>');
				$('#categoryName').closest('.form-group').addClass('has-error');
			}	else {
				// remov error text field
				$("#categoryName").find('.text-danger').remove();
				// success out for form 
				$("#categoryName").closest('.form-group').addClass('has-success');	  	
			}	// /else

			if(productStatus == "") {
				$("#productStatus").after('<p class="text-danger">Product Status field is required</p>');
				$('#productStatus').closest('.form-group').addClass('has-error');
			}	else {
				// remov error text field
				$("#productStatus").find('.text-danger').remove();
				// success out for form 
				$("#productStatus").closest('.form-group').addClass('has-success');	  	
			}	// /else

			if(productImage && productName && quantity && rate && brandName && categoryName && productStatus) {
				// submit loading button
				$("#createProductBtn").button('loading');

				var form = $(this);
				var formData = new FormData(this);

				$.ajax({
					url : form.attr('action'),
					type: form.attr('method'),
					data: formData,
					dataType: 'json',
					cache: false,
					contentType: false,
					processData: false,
					success:function(response) {

						if(response.success == true) {
							// submit loading button
							$("#createProductBtn").button('reset');
							
							$("#submitProductForm")[0].reset();

							$("html, body, div.modal, div.modal-content, div.modal-body").animate({scrollTop: '0'}, 100);
																	
							// shows a successful message after operation
							$('#add-product-messages').html('<div class="alert alert-success">'+
		            '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
		            '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
		          '</div>');

							// remove the mesages
		          $(".alert-success").delay(500).show(10, function() {
								$(this).delay(3000).hide(10, function() {
									$(this).remove();
								});
							}); // /.alert

		          // reload the manage student table
							manageProductTable.ajax.reload(null, true);

							// remove text-error 
							$(".text-danger").remove();
							// remove from-group error
							$(".form-group").removeClass('has-error').removeClass('has-success');

						} // /if response.success
						
					},
					error: function(e){
						console.log(e)
					} // /success function
				}); // /ajax function
			}	 // /if validation is ok 					

			return false;
		}); // /submit product form

	}); // /add product modal btn clicked
	

	// remove product 	
	var $categorySelect = $('#categoryName');
	var $onBrandCategorySelect = $('#brandName');

	$categorySelect.on('change', function() {
		// Code to filter and display brands goes here
		var selectedCategory = $categorySelect.val();
		var $onBrandCategoryOptions = $onBrandCategorySelect.find('option');
		$onBrandCategoryOptions.each(function() {
			var $option = $(this);
			var onBrandCategory = $option.data('onbrand-category');
			console.log(typeof onBrandCategory)
			if (onBrandCategory == selectedCategory || !selectedCategory) {
			  $option.show();
			} else {
			  $option.hide();
			}
		  });
	});

}); // document.ready fucntion

let globalPrice
function releaseProduct(productId) {
	// productId.preventDefault();

	const rowData = $(productId).closest('tr').find('td')[3];
	console.log('iam the element', rowData.innerHTML);
	if(productId) {
		$("#productId1").remove();		
		// remove text-error 
		$(".text-danger").remove();
		// remove from-group error
		$(".form-group").removeClass('has-error').removeClass('has-success');
		// modal spinner
		$('.div-loading').removeClass('div-hide');
		// modal div
		$('.div-result').addClass('div-hide');

		$.ajax({
			url: 'php_action/fetchSelectedProduct.php',
			type: 'post',
			data: {productId: $(productId).data('id')},
			dataType: 'json',
			success:function(response) {	
				console.log(response);	
			// alert(response.product_image);
				// modal spinner
				$('.div-loading').addClass('div-hide');
				// modal div
				$('.div-result').removeClass('div-hide');				

				$("#getProductImage1").attr('src', 'stock/'+response.product_image);

				$("#editProductImage1").fileinput({		      
				});  

				// $("#editProductImage").fileinput({
		  //     overwriteInitial: true,
			 //    maxFileSize: 2500,
			 //    showClose: false,
			 //    showCaption: false,
			 //    browseLabel: '',
			 //    removeLabel: '',
			 //    browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
			 //    removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
			 //    removeTitle: 'Cancel or reset changes',
			 //    elErrorContainer: '#kv-avatar-errors-1',
			 //    msgErrorClass: 'alert alert-block alert-danger',
			 //    defaultPreviewContent: '<img src="stock/'+response.product_image+'" alt="Profile Image" style="width:100%;">',
			 //    layoutTemplates: {main2: '{preview} {remove} {browse}'},								    
		  // 		allowedFileExtensions: ["jpg", "png", "gif", "JPG", "PNG", "GIF"]
				// });  

				// product id 
				$(".editProductFooter1").append('<input type="hidden" name="productId1" id="productId1" value="'+response.product_id+'" />');				
				$(".editProductPhotoFooter1").append('<input type="hidden" name="productId1" id="productId1" value="'+response.product_id+'" />');				
				
				// product name
				$("#editProductName1").val(response.product_name);
				// quantity
				$("#editQuantity1").val(rowData.innerHTML);
				// rate
				$("#editRate1").val(response.price);

				globalPrice = response.price;
				// brand name
				$("#editBrandName1").val(response.brand_id);
				// category name
				$("#editCategoryName1").val(response.categories_id);

				$("#manufactured_date1").val(response.manufactured_date);

				$("#expiry_date1").val(response.expiry_date);
				// status
				$("#editProductStatus1").val(response.active);

				$("#releaseUnit").val(response.unit);

				// update the product data function
				$("#releaseProductForm").unbind('submit').bind('submit', function(e) {
					e.preventDefault();
					console.log("hit");
					// form validation
					var productImage = $("#editProductImage1").val();
					var productName = $("#editProductName1").val();
					var quantity = $("#editQuantity1").val();
					var rate = $("#editRate1").val();
					var brandName = $("#editBrandName1").val();
					var categoryName = $("#editCategoryName1").val();
					var unit = $("#uom").val();
					var productStatus = $("#editProductStatus1").val();
					var releaseQuantity = $('#releaseQuantity').val();

					if(releaseQuantity == "") {
						$("#releaseQuantity").after('<p class="text-danger">Product Status field is required</p>');
						$('#releaseQuantity').closest('.form-group').addClass('has-error');
					}else if(Number(releaseQuantity) > Number(quantity)){
						$("#releaseQuantity").after('<p class="text-danger">Quantity exceeds from the available items.</p>');
						$('#releaseQuantity').closest('.form-group').addClass('has-error');
					}else if(Number(releaseQuantity) <= 0){
						$("#releaseQuantity").after('<p class="text-danger">Quantity must not be less than or equal to 0</p>');
						$('#releaseQuantity').closest('.form-group').addClass('has-error');
					}	
					else {
						// remov error text field
						$("#releaseQuantity").find('.text-danger').remove();
						// success out for form 
						$("#releaseQuantity").closest('.form-group').addClass('has-success');
						
						if(releaseQuantity && brandName && rate && quantity && productName) {

							// submit loading button
							$("#releaseProductBtn1").button('loading');
	
							var form = $(this).get(0);
							var formData = new FormData(form);
	
							$.ajax({
								url : 'php_action/releaseProduct.php',
								type: 'post',
								data: formData,
								dataType: 'json',
								cache: false,
								contentType: false,
								processData: false,
								success:function(response) {
									console.log(response);
									if(response.success == true) {
										// submit loading button
										$("#releaseProductBtn").button('reset');																		
	
										$("html, body, div.modal, div.modal-content, div.modal-body").animate({scrollTop: '0'}, 100);
																				
										// shows a successful message after operation
										$('#release-product-messages').html('<div class="alert alert-success">'+
											'<button type="button" class="close" data-dismiss="alert">&times;</button>'+
											'<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
										'</div>');
	
										// remove the mesages
										  $(".alert-success").delay(500).show(10, function() {
											$(this).delay(3000).hide(10, function() {
												$(this).remove();
											});
										}); // /.alert
	
										$(".text-danger").remove();
										// remove from-group error
										$(".form-group").removeClass('has-error').removeClass('has-success');

										form.reset();
										let releaseProductModal = jQuery('#releaseProductModal');
										releaseProductModal.modal();
										releaseProductModal.modal('hide');
									} // /if response.success
									
									refreshDataTable();
								},
								error: function(response) {
									$('#release-product-messages').html('<div class="alert alert-danger">'+
											'<button type="button" class="close" data-dismiss="alert">&times;</button>'+
											'<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
										'</div>');
								}
							}); // /ajax function
						}else{
							console.log('not present')
						}	 // /if validation is ok 					
	
						return false;
					}	// /else					

					
				}); // update the product data function
			} // /success function
		}); // /ajax to fetch product image

				
	} else {
		alert('error please refresh the page');
	}
} // /edit product function


function editProduct(productId = null) {
	var Peso = new Intl.NumberFormat('en-US', {
		style: 'currency',
		currency: 'PHP',
	});

	if(productId) {
		$("#productId").remove();		
		// remove text-error 
		$(".text-danger").remove();
		// remove from-group error
		$(".form-group").removeClass('has-error').removeClass('has-success');
		// modal spinner
		$('.div-loading').removeClass('div-hide');
		// modal div
		$('.div-result').addClass('div-hide');

		$.ajax({
			url: 'php_action/fetchSelectedProduct.php',
			type: 'post',
			data: {productId: productId},
			dataType: 'json',
			success:function(response) {	
				console.log(response);	
			// alert(response.product_image);
				// modal spinner
				$('.div-loading').addClass('div-hide');
				// modal div
				$('.div-result').removeClass('div-hide');				

				$("#getProductImage").attr('src', 'stock/'+response.product_image);

				$("#editProductImage").fileinput({		      
				});  

				// $("#editProductImage").fileinput({
		  //     overwriteInitial: true,
			 //    maxFileSize: 2500,
			 //    showClose: false,
			 //    showCaption: false,
			 //    browseLabel: '',
			 //    removeLabel: '',
			 //    browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
			 //    removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
			 //    removeTitle: 'Cancel or reset changes',
			 //    elErrorContainer: '#kv-avatar-errors-1',
			 //    msgErrorClass: 'alert alert-block alert-danger',
			 //    defaultPreviewContent: '<img src="stock/'+response.product_image+'" alt="Profile Image" style="width:100%;">',
			 //    layoutTemplates: {main2: '{preview} {remove} {browse}'},								    
		  // 		allowedFileExtensions: ["jpg", "png", "gif", "JPG", "PNG", "GIF"]
				// });  

				// product id 
				$(".editProductFooter").append('<input type="hidden" name="productId" id="productId" value="'+response.product_id+'" />');				
				$(".editProductPhotoFooter").append('<input type="hidden" name="productId" id="productId" value="'+response.product_id+'" />');				
				
				// product name
				$("#editProductName").val(response.product_name);
				// quantity
				$("#editQuantity").val(response.quantity);
				// rate
				$("#editRate").val(response.price);
				// brand name
				$("#editBrandName").val(response.brand_id);
				// category name
				$("#editCategoryName").val(response.categories_id);

				$("#manufactured_date").val(response.manufactured_date);

				$("#expiry_date2").val(response.expiry_date);
				// status
				$("#editProductStatus").val(response.active);

				$("#unit").val(response.unit);

				// update the product data function
				$("#editProductForm").unbind('submit').bind('submit', function() {

					// form validation
					var productImage = $("#editProductImage").val();
					var productName = $("#editProductName").val();
					var quantity = $("#editQuantity").val();
					var rate = $("#editRate").val();
					var brandName = $("#editBrandName").val();
					var categoryName = $("#editCategoryName").val();
					var productStatus = $("#editProductStatus").val();
					let unit = $("#unit").val();
								

					if(productName == "") {
						$("#editProductName").after('<p class="text-danger">Product Name field is required</p>');
						$('#editProductName').closest('.form-group').addClass('has-error');
					}	else {
						// remov error text field
						$("#editProductName").find('.text-danger').remove();
						// success out for form 
						$("#editProductName").closest('.form-group').addClass('has-success');	  	
					}	// /else

					if(quantity == "") {
						$("#editQuantity").after('<p class="text-danger">Quantity field is required</p>');
						$('#editQuantity').closest('.form-group').addClass('has-error');
					}	else {
						// remov error text field
						$("#editQuantity").find('.text-danger').remove();
						// success out for form 
						$("#editQuantity").closest('.form-group').addClass('has-success');	  	
					}	// /else

					if(rate == "") {
						$("#editRate").after('<p class="text-danger">Rate field is required</p>');
						$('#editRate').closest('.form-group').addClass('has-error');
					}	else {
						// remov error text field
						$("#editRate").find('.text-danger').remove();
						// success out for form 
						$("#editRate").closest('.form-group').addClass('has-success');	  	
					}	// /else

					if(brandName == "") {
						$("#editBrandName").after('<p class="text-danger">Brand Name field is required</p>');
						$('#editBrandName').closest('.form-group').addClass('has-error');
					}	else {
						// remov error text field
						$("#editBrandName").find('.text-danger').remove();
						// success out for form 
						$("#editBrandName").closest('.form-group').addClass('has-success');	  	
					}	// /else

					if(categoryName == "") {
						$("#editCategoryName").after('<p class="text-danger">Category Name field is required</p>');
						$('#editCategoryName').closest('.form-group').addClass('has-error');
					}	else {
						// remov error text field
						$("#editCategoryName").find('.text-danger').remove();
						// success out for form 
						$("#editCategoryName").closest('.form-group').addClass('has-success');	  	
					}	// /else

					if(productStatus == "") {
						$("#editProductStatus").after('<p class="text-danger">Product Status field is required</p>');
						$('#editProductStatus').closest('.form-group').addClass('has-error');
					}	else {
						// remov error text field
						$("#editProductStatus").find('.text-danger').remove();
						// success out for form 
						$("#editProductStatus").closest('.form-group').addClass('has-success');	  	
					}	// /else	
					
					if(unit == "") {
						$("#unit").after('<p class="text-danger">UOM field is required</p>');
						$('#unit').closest('.form-group').addClass('has-error');
					}	else {
						// remov error text field
						$("#unit").find('.text-danger').remove();
						// success out for form 
						$("#unit").closest('.form-group').addClass('has-success');	  	
					}	// /else	

					if(productName && quantity && rate && brandName && categoryName && productStatus && unit) {
						// submit loading button
						$("#editProductBtn").button('loading');

						var form = $(this);
						var formData = new FormData($(this));

						console.log(formData);

						$.ajax({
							url : form.attr('action'),
							type: form.attr('method'),
							data: formData,
							dataType: 'json',
							cache: false,
							contentType: false,
							processData: false,
							success:function(response) {
								console.log(response);
								if(response.success == true) {
									// submit loading button
									$("#editProductBtn").button('reset');																		

									$("html, body, div.modal, div.modal-content, div.modal-body").animate({scrollTop: '0'}, 100);
																			
									// shows a successful message after operation
									$('#edit-product-messages').html('<div class="alert alert-success">'+
				            '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
				            '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
				          '</div>');

									// remove the mesages
				          $(".alert-success").delay(500).show(10, function() {
										$(this).delay(3000).hide(10, function() {
											$(this).remove();
										});
									}); // /.alert

				          // reload the manage student table
									manageProductTable.ajax.reload(null, true);

									// remove text-error 
									$(".text-danger").remove();
									// remove from-group error
									$(".form-group").removeClass('has-error').removeClass('has-success');

								} // /if response.success
								
							} // /success function
						}); // /ajax function
					}	 // /if validation is ok 					

					return false;
				}); // update the product data function

				// update the product image				
				$("#updateProductImageForm").unbind('submit').bind('submit', function() {					
					// form validation
					var productImage = $("#editProductImage").val();					
					
					if(productImage == "") {
						$("#editProductImage").closest('.center-block').after('<p class="text-danger">Product Image field is required</p>');
						$('#editProductImage').closest('.form-group').addClass('has-error');
					}	else {
						// remov error text field
						$("#editProductImage").find('.text-danger').remove();
						// success out for form 
						$("#editProductImage").closest('.form-group').addClass('has-success');	  	
					}	// /else

					if(productImage) {
						// submit loading button
						$("#editProductImageBtn").button('loading');

						var form = $(this);
						var formData = new FormData(this);

						$.ajax({
							url : form.attr('action'),
							type: form.attr('method'),
							data: formData,
							dataType: 'json',
							cache: false,
							contentType: false,
							processData: false,
							success:function(response) {
								
								if(response.success == true) {
									// submit loading button
									$("#editProductImageBtn").button('reset');																		

									$("html, body, div.modal, div.modal-content, div.modal-body").animate({scrollTop: '0'}, 100);
																			
									// shows a successful message after operation
									$('#edit-productPhoto-messages').html('<div class="alert alert-success">'+
				            '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
				            '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
				          '</div>');

									// remove the mesages
				          $(".alert-success").delay(500).show(10, function() {
										$(this).delay(3000).hide(10, function() {
											$(this).remove();
										});
									}); // /.alert

				          // reload the manage student table
									manageProductTable.ajax.reload(null, true);

									$(".fileinput-remove-button").click();

									$.ajax({
										url: 'php_action/fetchProductImageUrl.php?i='+productId,
										type: 'post',
										success:function(response) {
										$("#getProductImage").attr('src', response);		
										}
									});																		

									// remove text-error 
									$(".text-danger").remove();
									// remove from-group error
									$(".form-group").removeClass('has-error').removeClass('has-success');

								} // /if response.success
								
							} // /success function
						}); // /ajax function
					}	 // /if validation is ok 					

					return false;
				}); // /update the product image

			} // /success function
		}); // /ajax to fetch product image

				
	} else {
		alert('error please refresh the page');
	}
} // /edit product function

// remove product 
function removeProduct(productId = null) {
	if(productId) {
		// remove product button clicked
		$("#removeProductBtn").unbind('click').bind('click', function() {
			// loading remove button
			$("#removeProductBtn").button('loading');
			$.ajax({
				url: 'php_action/removeProduct.php',
				type: 'post',
				data: {productId: productId},
				dataType: 'json',
				success:function(response) {
					// loading remove button
					$("#removeProductBtn").button('reset');
					if(response.success == true) {
						// remove product modal
						$("#removeProductModal").modal('hide');

						// update the product table
						manageProductTable.ajax.reload(null, false);

						// remove success messages
						$(".remove-messages").html('<div class="alert alert-success">'+
		            '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
		            '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
		          '</div>');

						// remove the mesages
	          $(".alert-success").delay(500).show(10, function() {
							$(this).delay(3000).hide(10, function() {
								$(this).remove();
							});
						}); // /.alert
					} else {

						// remove success messages
						$(".removeProductMessages").html('<div class="alert alert-success">'+
		            '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
		            '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
		          '</div>');

						// remove the mesages
	          $(".alert-success").delay(500).show(10, function() {
							$(this).delay(3000).hide(10, function() {
								$(this).remove();
							});
						}); // /.alert

					} // /error
				} // /success function
			}); // /ajax fucntion to remove the product
			return false;
		}); // /remove product btn clicked
	} // /if productid
} // /remove product function

$('#releaseType1').on('click', function (){
	// console.log(typeof($('#editRate1').val()))
	let convertedPrice = (parseFloat(globalPrice) * 0.05) + parseFloat(globalPrice)
	$('#editRate1').val(convertedPrice)
})

$('#releaseType2').on('click', function (){
	// console.log(typeof($('#editRate1').val()))
	let convertedPrice = (parseFloat(globalPrice) * 0.1) + parseFloat(globalPrice)
	$('#editRate1').val(convertedPrice)
})

function clearForm(oForm) {
	// var frm_elements = oForm.elements;									
	// console.log(frm_elements);
	// 	for(i=0;i<frm_elements.length;i++) {
	// 		field_type = frm_elements[i].type.toLowerCase();									
	// 		switch (field_type) {
	// 	    case "text":
	// 	    case "password":
	// 	    case "textarea":
	// 	    case "hidden":
	// 	    case "select-one":	    
	// 	      frm_elements[i].value = "";
	// 	      break;
	// 	    case "radio":
	// 	    case "checkbox":	    
	// 	      if (frm_elements[i].checked)
	// 	      {
	// 	          frm_elements[i].checked = false;
	// 	      }
	// 	      break;
	// 	    case "file": 
	// 	    	if(frm_elements[i].options) {
	// 	    		frm_elements[i].options= false;
	// 	    	}
	// 	    default:
	// 	        break;
	//     } // /switch
	// 	} // for
}

function refreshDataTable() {
	manageProductTable.ajax.reload(null, false);
  }

function checkAction(elem) {
	let obj = {}
	obj = {
		'productName' : $(elem).data('name'),
		'unit'		  : $(elem).closest('tr').find('td')[4].innerHTML,
		'brand'		  : $(elem).data('brand'),
		'category'	  : $(elem).data('category'),
		'price'		  : $(elem).data('price'),
		'page'	  	  : '',
		'productId'	  : $(elem).data('id')
	}

	console.log(obj);
	
	if($(elem).data('action') === 'edit'){
		$('.dynamic-title').text(' Edit Product')
		obj['page'] = "productPage"
		$.ajax({
			url: 'php_action/checkItemGrouping.php',
			type: 'get',
			data: {obj: obj},
			dataType: 'json',
			success: function(res){
				console.log(res);
				if(res['items'] > 1){
					$('#selectEditTbody').empty();
					$('#dialogBtn').attr('data-target','#selectEditModal');
					$.each(res['data'], function(i, row){
						let tRow = `<tr>
										<td>${row['product_name']}</td>
										<td>${row['price']}</td>
										<td>${row['quantity']}</td>
										<td>${row['expiry_date']}</td>
										<td>
											<button 
												type="button" 
												class="btn btn-primary" 
												id="toEditBtn" 
												data-toggle="modal" 
												data-dismiss="modal"
												data-target="#editProductModal"
												onclick="editProduct(${row['product_id']})">
												Edit
											</button>
										</td>
									</tr>`;
	
						$('#selectEditTbody').append(tRow);
						console.log(tRow);
					})
					// $(elem).data('target', '#selectEditModal');
				}else{
					// console.log('fuck you')
					let productId = res['data'][0].product_id;
					// $(elem).data('target', '#editProductModal');
					$('#dialogBtn').attr('data-target','#editProductModal');
					$('#dialogBtn').on('click', editProduct(productId));
					// $('#editProductModal').fadeIn();
				}
			}
		})
	}else if($(elem).data('action') === 'delete') {
		$('.dynamic-title').text(' Delete Product')
		obj['page'] = $(elem).data('page')
		$.ajax({
			url: 'php_action/checkItemGrouping.php',
			type: 'get',
			data: {obj: obj},
			dataType: 'json',
			success: function(res){
				console.log(res);
				if(res['items'] > 1){
					$('#selectEditTbody').empty();
					$('#dialogBtn').attr('data-target','#selectEditModal');
					$.each(res['data'], function(i, row){
						let tRow = `<tr>
										<td>${row['product_name']}</td>
										<td>${row['price']}</td>
										<td>${row['quantity']}</td>
										<td>${row['expiry_date']}</td>
										<td>
											<button 
												type="button" 
												class="btn btn-danger" 
												id="toEditBtn"
												data-toggle="modal" 
												data-dismiss="modal"
												data-target="#removeProductModal"
												onclick="removeProduct(${row['product_id']})">
												Delete
											</button>
										</td>
									</tr>`;
	
						$('#selectEditTbody').append(tRow);
						console.log(tRow);
					})
					// $(elem).data('target', '#selectEditModal');
				}else{
					// console.log('fuck you')
					let productId = res['data'][0].product_id;
					// $(elem).data('target', '#editProductModal');
					$('#dialogBtn').attr('data-target','#removeProductModal');
					$('#dialogBtn').on('click', removeProduct(productId));
					// $('#editProductModal').fadeIn();
				}
			}
		})
	}
	
}

