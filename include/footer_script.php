<script src="js/jquery-2.2.4.min.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery-plugin-collection.js"></script>
<script src="js/revolution-slider/js/jquery.themepunch.tools.min.js"></script>
<script src="js/revolution-slider/js/jquery.themepunch.revolution.min.js"></script>
<script type="text/javascript" src="js/revolution-slider/js/extensions/revolution.extension.actions.min.js"></script>
<script type="text/javascript" src="js/revolution-slider/js/extensions/revolution.extension.carousel.min.js"></script>
<script type="text/javascript" src="js/revolution-slider/js/extensions/revolution.extension.kenburn.min.js"></script>
<script type="text/javascript" src="js/revolution-slider/js/extensions/revolution.extension.layeranimation.min.js"></script>
<script type="text/javascript" src="js/revolution-slider/js/extensions/revolution.extension.migration.min.js"></script>
<script type="text/javascript" src="js/revolution-slider/js/extensions/revolution.extension.navigation.min.js"></script>
<script type="text/javascript" src="js/revolution-slider/js/extensions/revolution.extension.parallax.min.js"></script>
<script type="text/javascript" src="js/revolution-slider/js/extensions/revolution.extension.slideanims.min.js"></script>
<script type="text/javascript" src="js/revolution-slider/js/extensions/revolution.extension.video.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
<script src="js/select2.full.min.js"></script>
<script src="js/custom.js"></script>
<script>
    $(document).ready(function () {
        $('select').select2();
        $('#datatable').DataTable({
            bFilter: false,
            "sDom": 'Rfrtlip',
            "language": {
                  "info": "Showing _START_ to _END_ of _TOTAL_ rows",
                  "lengthMenu":     " _MENU_ rows per page",
                    paginate: {
                      next: '&#129170;',
                      previous: '&#129168;'
                    }
            },
        });
    });
    $(document).ready(function (e) {
    $("#account_form_popup").on('submit',(function(e) {
      e.preventDefault();
      var account_password = $("#account_password").val();
      var account_cpassword = $("#account_cpassword").val();
      var account_username = $("#account_username").val();
      var account_fname = $("#account_fname").val();
      var account_lname = $("#account_lname").val();
      var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
      if(account_username != '' && account_password != '' && account_fname != '' && account_lname != '' && account_cpassword != '') {
	    if(account_password == account_cpassword) {
	        if(regex.test(account_username) == true) {
              $.ajax({
                   url: "register.php",
                   type: "POST",
                   data:  new FormData(this),
                   contentType: false,
                   cache: false,
                   processData:false,
                   success: function(data) {
                       if(data == 'success') {
                           $("#CreateErr").css('display', 'none');
                            $("#Createmsg").css('display', 'block');
            	            $.ajax({
                               url: "resendcode.php",
                               type: "POST",
                               data:  {val : account_username},
                                beforeSend: function(){
                                    $("#myloaderotp").css("display","block");
                                    $("#myloaderotp").css("background","url(images/preloaders/5.gif) center / 75px 75px no-repeat");
                                    $("#submitbtn").prop("disabled", true);
                                },
                               success: function(resp) { console.log(resp);
                                    $("#myloaderotp").css("display","none");
                                    $("#submitbtn").prop("disabled", false);
                                   if(resp == '1') {
                        		        $('#OTPModalemaill').text('').text(account_username);
                        		        $('#Resendemail').val('').val(account_username);
                        		        $('#OTPModal').modal('show');
                                   } else {
                                       $('#OTPModal').modal('hide');
                                   }
                              },       
                            });
                          $("#Createmsg").html('').html("We've sent an email with your code to "+account_username);
                            // window.location.href="account.php";
                       } else {
                            $("#Createmsg").css('display', 'none');
                           $("#CreateErr").css('display', 'block');
                           $("#CreateErr").html('').html(data);
                       }
                     
                  },       
                });
    		} else {
    		    $("#createemailerr").css('display', 'block');
    			$("#createemailerr").text('Not a valid email address!!'); return false;
    		}
    		} else {
    		    $("#CreateErr").css('display', 'block');
    			$("#CreateErr").text('Passwords do not match!'); 
    			$("#account_cpassword").focus(); return false;
    		}} else {
    		    $("#CreateErr").css('display', 'block');
    			$("#CreateErr").text('Please fill out all required fields!!'); return false;
    		}
     }));
     $("#reservation_form_popup").on('submit',(function(e) {
      e.preventDefault();
      $.ajax({
           url: "login.php",
           type: "POST",
           data:  new FormData(this),
           contentType: false,
           cache: false,
           processData:false,
           success: function(data) {
               if(data == 'success') {
                   $("#LoginErr").css('display', 'none');
                    $("#Loginmsg").css('display', 'block');
                   $("#Loginmsg").html('').html('Login Success.');
                    window.location.href="account.php";
               } else {
                    $("#Loginmsg").css('display', 'none');
                   $("#LoginErr").css('display', 'block');
                   $("#LoginErr").html('').html(data);
               }
             
          },       
        });
     }));
     $("#reset_form_popup").on('submit',(function(e) {
      e.preventDefault();
      $.ajax({
           url: "resetpassword.php",
           type: "POST",
           data:  new FormData(this),
           contentType: false,
           cache: false,
           processData:false,
            beforeSend: function(){
                $("#myloader").css("display","block");
                $("#myloader").css("background","url(images/preloaders/5.gif) center / 75px 75px no-repeat");
                $("#resetbtn").prop("disabled", true);
            },
           success: function(data) {
                $("#resetbtn").prop("disabled", false);
                 $("#myloader").css("display","none");
                 $("#myloader").css("background","#fff");
               if(data == 'success') {
                   $("#ResetPasswordErr").css('display', 'none');
                    $("#ResetPasswordmsg").css('display', 'block');
                   $("#ResetPasswordmsg").html('').html('Password successfully sent to your registered email address. Please check you email.');
        		        $('#LoginModal').modal('hide');
        		        setTimeout(function(){
                          $('#PasswordModal').modal('hide')
                        }, 5000);
                    
               } else {
                    $("#ResetPasswordmsg").css('display', 'none');
                   $("#ResetPasswordErr").css('display', 'block');
                   $("#ResetPasswordErr").html('').html(data);
               }
             
          },       
        });
     }));
     $("#otp_form").on('submit',(function(e) {
          e.preventDefault();
          $.ajax({
               url: "checkOTP.php",
               type: "POST",
               data:  new FormData(this),
               contentType: false,
               cache: false,
               processData:false,
            beforeSend: function(){
                $("#myloaderotp").css("display","block");
                $("#myloaderotp").css("background","url(images/preloaders/5.gif) center / 75px 75px no-repeat");
                $("#submitbtn").prop("disabled", true);
            },
               success: function(resp) {
                $("#myloaderotp").css("display","none");
                $("#submitbtn").prop("disabled", false);
                   if(resp == 'Yes') {
        		        $('#OTPModal').modal('hide');
                       $("#Createmsg").css('display', 'block');
                       $("#CreateErr").css('display', 'none');
                       $("#Createmsg").html('').html('Verification Success. Please continue to login.');
                        $("#otp_form")[0].reset();
                          $('#AccountModal').modal('hide');
        		            $('#VerSucModal').modal('show');
                        
                   } else {
                           $("#CreateErr").css('display', 'none');
                            $("#Createmsg").css('display', 'none');
        		      //  $('#OTPModal').modal('hide');
                       $("#OTPErr").css('display', 'block');
                       $("#OTPmsg").css('display', 'none');
                        $("#otp_form")[0].reset();
                       $("#OTPErr").html('').html('Verification failed. Please try again!');
                   }
              },       
            });
         }));
    });
        $('#account_cpassword').on('keyup', function () {
          if ($('#account_password').val() == $('#account_cpassword').val()) {
            $('#account_err_message').html('Password Matched.').css('color', 'green');
          } else 
            $('#account_err_message').html('Passwords do not match!').css('color', 'red');
        });
        function showAccPassword(){
            // toggle the type attribute
            password = document.querySelector(`#account_password`);
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            // toggle the eye slash icon
            document.querySelector(`#toggle_password`).classList.toggle('fa-eye-slash');
        }
        function showAccCPassword(){
            // toggle the type attribute
            password = document.querySelector(`#account_cpassword`);
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            // toggle the eye slash icon
            document.querySelector(`#toggle_cpassword`).classList.toggle('fa-eye-slash');
        }
        
        function resendcode() {
            var val = $("#Resendemail").val();
            $.ajax({
               url: "resendcode.php",
               type: "POST",
               data:  {val : val},
                beforeSend: function(){
                    $("#myloaderotp").css("display","block");
                    $("#myloaderotp").css("background","url(images/preloaders/5.gif) center / 75px 75px no-repeat");
                    $("#submitbtn").prop("disabled", true);
                },
               success: function(resp) { console.log(resp);
                    $("#myloaderotp").css("display","none");
                    $("#submitbtn").prop("disabled", false);
                   if(resp == '1') {
                       $("#resendmsg").html('').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> We've resent an email with your code to <br>"+val);
                   } else {
                       $("#resendmsg").html('').html('Something wrong!!');
                   }
              },       
            });
        }
        $( document ).ready(function(e) {
         $("#importformheader").on('submit',(function(e) {
          e.preventDefault();
          $.ajax({
               url: "checkPrivatecourseheader.php",
               type: "POST",
               data:  new FormData(this),
               contentType: false,
                cache: false,
               processData:false,
               beforeSend: function(){
                 $("#myloaderdef").css("display","block");
                    $("#myloaderdef").css("background","url(img/LoaderIcon.gif) center / 75px 75px no-repeat");
                    $("#submitbookheader").prop("disabled", true);
                },
               success: function(data) { console.log(data);
                 $("#submitbookheader").prop("disabled", false);
                 $("#myloaderdef").css("display","none");
                 $("#myloaderdef").css("background","#fff");
                   if(data == '1') {
                        $("#bookerrheader").css('display','block');
                        $("#bookerrheader").text('').text("The course code you entered does not exist!");
                   }else if(data == '3') {
                        $("#bookerrheader").css('display','block');
                        $("#bookerrheader").text('').text("This course is sold out!");
                   } else if(data == '4') {
                        $("#bookerrheader").css('display','block');
                        $("#bookerrheader").text('').text("The course code you entered is expired!");
                   } else {
                        $("#bookerrheader").text('');
                        $("#bookerrheader").css('display','none');
                        window.location.href=data;
                   }
              },       
            });
         }));
         });
</script>
<script>
(function () {
    // Hard unblock mouse / wheel scroll
    window.addEventListener(
        'wheel',
        function (e) {
            e.stopImmediatePropagation();
        },
        { passive: true }
    );

    document.addEventListener(
        'wheel',
        function (e) {
            e.stopImmediatePropagation();
        },
        { passive: true }
    );

    // Safety: force scrollability
    document.documentElement.style.overflowY = 'auto';
    document.body.style.overflowY = 'auto';
})();
$(document).on('show.bs.modal', '.modal', function () {
    $('.modal').not(this).modal('hide');
});
</script>
