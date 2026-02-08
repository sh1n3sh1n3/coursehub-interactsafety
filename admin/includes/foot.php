<script src="js/jquery-3.1.1.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="js/plugins/flot/jquery.flot.js"></script>
<script src="js/plugins/flot/jquery.flot.tooltip.min.js"></script>
<script src="js/plugins/flot/jquery.flot.spline.js"></script>
<script src="js/plugins/flot/jquery.flot.resize.js"></script>
<script src="js/plugins/flot/jquery.flot.pie.js"></script>
<script src="js/plugins/peity/jquery.peity.min.js"></script>
<script src="js/demo/peity-demo.js"></script>
<script src="js/inspinia.js"></script>
<script src="js/plugins/pace/pace.min.js"></script>
<script src="js/plugins/blueimp/jquery.blueimp-gallery.min.js"></script>
<script src="js/plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="js/plugins/gritter/jquery.gritter.min.js"></script>
<script src="js/plugins/sparkline/jquery.sparkline.min.js"></script>
<script src="js/demo/sparkline-demo.js"></script>
<script src="js/plugins/chartJs/Chart.min.js"></script>
<script src="js/plugins/toastr/toastr.min.js"></script>
<script src="js/plugins/dataTables/datatables.min.js"></script>
<script src="js/plugins/dataTables/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="ckeditor/ckeditor.js"></script> 
<script src="js/plugins/select2/select2.full.min.js"></script>
<link href="ckeditor/skins/kama/editor.css" rel="stylesheet">
<script>
$('.custom-file-input').on('change', function() {
   let fileName = $(this).val().split('\\').pop();
   $(this).next('.custom-file-label').addClass("selected").html(fileName);
});
	$(document).ready(function(){
	    $('select.select').select2();
	    var current_title = $(document).attr('title');
		$('.dataTables-example').DataTable({
			pageLength: 25,
			responsive: true,
			"ordering": false,
			dom: '<"html5buttons"B>lTfgitp',
			buttons: [
				{
				    extend: 'csv',
				    text:   'Export',
                    filename: current_title,
				},
			]

		});

	});

</script>
<!-- Bootstrap markdown -->
<script src="js/plugins/bootstrap-markdown/bootstrap-markdown.js"></script>
<script src="js/plugins/bootstrap-markdown/markdown.js"></script>