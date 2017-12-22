<footer id="footer">
	<div>
		<a href="/">
			<div class="icon i-1"></div>
			<p>首页</p>
		</a>
	</div>
	<div>
		<a href="/goods_join">
			<div class="icon i-2"></div>
			<p>限时批发</p>
		</a>
	</div>
	<div>
		<a href="/carts">
			<div class="icon i-3"></div>
			<p>购物车</p>
		</a>
	</div>
	<div>
		<a href="/center">
			<div class="icon i-4"></div>
			<p>个人中心</p>
		</a>
	</div>			
</footer>

<script type="text/javascript">
	$(function(){
		var url = window.location.pathname;
		switch(url)
		{
		case '/':
			$('.i-1').addClass('on');
			break;
		case '/goods_join':
			$('.i-2').addClass('on');
			break;
		case '/carts':
			$('.i-3').addClass('on');
			break;
		case '/center':
			$('.i-4').addClass('on');
		 	break;
		default:
			$('.i-1').addClass('on');
		}
	});
</script>