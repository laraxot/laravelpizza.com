function popupcontent(feature, layer) {
	var customPopup = `
	<div class="card" style="width: 18rem;">
	<img src="##image_src##" class="card-img-top" alt="..." width="100px">
	<div class="card-body">
	<h5 class="card-title">##title##</h5>
	<p class="card-text">##subtitle##
	<br/><i class="fas fa-map-marker-alt"></i> ##formatted_address##
	</p>
	</div>
	<div class="card-footer">
	<a href="##url##" class="btn btn-primary"> &raquo; </a>
	</div>
	</div>`;
	//console.log(feature);
	for (var prop in feature) {
		$val=feature[prop];
		if($val==null) $val='';
		customPopup = customPopup.replace('##' + prop + '##', $val);
	}
	return customPopup;
} 