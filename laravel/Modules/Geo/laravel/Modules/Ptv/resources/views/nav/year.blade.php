aria-label="month year navigation">
<form method="get">
  	<ul class="pagination justify-content-center">
		<li>
			{{ Form::bsText('year',date('Y')) }}
		<li>
		<li>
			<br/>
			<button type="submit" class="btn btn-info">
				<i class="fas fa-filter"></i>
			</button>
		</li>
	</ul>
</form>
</nav>