$(document).ready(function(){
    var url = "../mypage/action.php"
 
	//問い合わせ　一覧表示
	Display();

    	//一覧表示
	function Display()
	{
		var action = "Display";
		$.ajax({
			url: url,
			method:"POST",
			data:{action:action},
			success:function(data)
			{
				$('#image_data').html(data);
			}
		})
	}
 
	//追加ボタンクリック
	$(document).on('click','#add',function(){
		$('#image_form')[0].reset();
		$('.modal-title').text("画像の追加");
		$('.modal-title').removeClass("text-warning");
		$('.modal-title').removeClass("text-danger");
		$('.modal-title').addClass("text-success");
		$('#image_id').val('');
		$('#action').val('insert');
		$('#insert').val('登録');
		$('#imageModal').modal('show');	
	});
 
	//開いたフォームの登録　あるいは　変更ボタンクリック
	$('#image_form').submit(function(event){
		event.preventDefault();
		var image_name = $('#image').val();
		var formData = new FormData(this);
		//for (item of formData) {
		//	console.log(item);
		//}
		if(image_name == ''){
			alert("画像ファイルを選択してください");return false;
		}else{
			//UPLOADされた画像の拡張子を取得
			var extension = $('#image').val().split('.').pop().toLowerCase();
			if(jQuery.inArray(extension,['gif','png','jpg','jpeg']) == -1){
				alert("GIF、PNG、JPG、JPEGファイルのみです");$('#image').val('');
				return false;
			}else{
				$.ajax({
					url: url,
					method:"POST",
					data: formData,
					contentType:false,
					processData:false,
					success:function(data){
						Display();
						alert(data);
						$('#image_form')[0].reset();
						$('#imageModal').modal('hide');	
					}
				});
			}
		}
	});
 
 
	//変更ボタンクリック
	$(document).on('click','.update',function(){
		$('#image_id').val($(this).attr("id"));//idを取得
		//alert($(this).attr("id"));
		$('.modal-title').text("画像の変更");
		$('.modal-title').removeClass("text-success");
		$('.modal-title').removeClass("text-danger");
		$('.modal-title').addClass("text-warning");
		$('#action').val("update");
		$('#insert').val("変更");
		$('#imageModal').modal('show');	
	});
 
	//削除ボタンクリック
	$(document).on('click','.delete',function(){
		var image_id = $(this).attr("id");//idを取得
		var action = "delete";
		if(confirm("画像を削除しますが宜しいですか？")){	
			//alert(image_id);		
			$.ajax({
				url: url,
				method:"POST",
				data:{image_id:image_id, action:action},
				success:function(data){
					Display();
					alert(data);
				}
			});
		}else{
			return false;
		}
	});
});