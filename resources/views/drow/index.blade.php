<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script src="/js/jquery.js"></script>
			<meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
	<table> 
		<p>欢迎来到抽奖页面</p>
		
			<button id="button">点击此处开始抽奖</button>
		
	</table>
</body>
</html>

<script type="text/javascript">
	$('#button').on('click',function(){

		$.ajax({
			   headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/drow/add',
                type: 'post',
                dataType:'json',
                success:function(d){
                    console.log(d);
                }
		})
	})
</script>