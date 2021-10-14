<div class="modal fade" id="checkLoginSession" tabindex="-1" role="dialog" aria-labelledby="checkLoginSessionTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"></h5>
      </div>
      <div class="modal-body">
        You have been logged out of LxP.<br>The account has been logged in to a different browser.
      </div>
      <div class="modal-footer text-center">
        <button type="button" id="confirm_single_session" class="btn btn-primary">Confirm</button>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
	$(document).ready(function(){

		// var single_session = setInterval(function(){

			$.ajax({
	            type: "get",
	            url: "{{route('check.session')}}",
	            dataType: "json",
	            success: function (response) {
	            	// if(response.stop_loop)
	            	// {
	            	// 	clearInterval(single_session);
	            	// }

	            	if(response.logout)
	            	{
	            		$("#checkLoginSession").modal("show")
	            	}
	            },
	            error: function (jqXHR) {
	            }
	        });

		},1000);

	// });


	$(document).on("click","#confirm_single_session",function(){
		window.location.href = "{{route('frontend.index')}}"
	});

</script>