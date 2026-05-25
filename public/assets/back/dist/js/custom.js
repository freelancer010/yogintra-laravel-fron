function logo_header(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#header_logo').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$("#logo_header").change(function() {
    logo_header(this);
});

function logo_footer(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#footer_logo').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$("#logo_footer").change(function() {
    logo_footer(this);
});

function fevicon_icon(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#fevicon').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$("#fevicon_icon").change(function() {
    fevicon_icon(this);
});


let typingTimer; //timer identifier
let doneTypingInterval = 5000; //time in ms (5 seconds)
let myInput = document.getElementById('current_password');

//on keyup, start the countdown
myInput.addEventListener('keyup', () => {
    clearTimeout(typingTimer);
    if (myInput.value) {
        beforeSubmit: $('#result').html("<span>Processing......</span>");
        typingTimer = setTimeout(doneTyping, doneTypingInterval);
    }
});

//user is "finished typing," do something
function doneTyping() {
    var current_password = $('#current_password').val();
    if (current_password != '') {
        $.ajax({
            beforeSubmit: $('#result').html("<span>Processing......</span>"),
            url: base_url + "admin/update_profile/check_current_password",
            method: "POST",
            data: {
                current_password: current_password
            },
            success: function(data) {
                if (data == 1) {
                    $('#result').html("<span style='color:green'>Password Match</span>");
                    $(".new_password").show();
                    $("#submit_button").show();
                } else {
                    $('#result').html("<span style='color:red'>Password Not Match</span>");
                    $(".new_password").hide();
                }
            }
        });
    }
}

function current_password(button) {
    var password = document.getElementById("current_password");
    if (password.type == "password") {
        password.type = "text";
    } else {
        password.type = "password";
    }
}

function show_new_password(button) {
    var password = document.getElementById("new_current_password");
    if (password.type == "password") {
        password.type = "text";
    } else {
        password.type = "password";
    }
}

function show_new_confirm_password(button) {
    var password = document.getElementById("confirm_new_password");
    if (password.type == "password") {
        password.type = "text";
    } else {
        password.type = "password";
    }
}

function noteCheck() {

    var course_mode = $('#course_mode').val();

    if(course_mode == 1)
    {
        
        // var programm_id = $('#programm_id').val();
        // if(!programm_id)
        // {
        //     alert("Please Select Atleast One Programm");
        //     return false;
        // }

        var course_mode = $('#course_mode').val();
        if(!course_mode)
        {
            alert("Please Select Atleast One Course Mode");
            return false;
        }

        var category_id = $('#category_id').val();
        if(!category_id)
        {
            alert("Please Select Atleast One Course Category");
            return false;
        }

        var course_title = $('#course_title').val();
        if(!course_title)
        {
            alert("Please Enter Course Title");
            return false;
        }

        var course_price = $('#course_price').val();
        if(!course_price)
        {
            alert("Please Enter Course Price");
            return false;
        }

        var level = $('#level').val();
        if(!level)
        {
            alert("Please Select Atleast One Level");
            return false;
        }

        var course_price = $('#course_price').val();
        if(!course_price)
        {
            alert("Please Enter Course Price");
            return false;
        }

        $("#choice_form").submit();
    }
    else if(course_mode == 2)
    {
        // var programm_id = $('#programm_id').val();
        // if(!programm_id)
        // {
        //     alert("Please Select Atleast One Programm");
        //     return false;
        // }
        
        var course_mode = $('#course_mode').val();
        if(!course_mode)
        {
            alert("Please Select Atleast One Course Mode");
            return false;
        }

        var category_id = $('#category_id').val();
        if(!category_id)
        {
            alert("Please Select Atleast One Course Category");
            return false;
        }

        var course_title = $('#course_title').val();
        if(!course_title)
        {
            alert("Please Enter Course Title");
            return false;
        }

        var duration = $('#duration').val();
        if(!duration)
        {
            alert("Please Enter Course Duration");
            return false;
        }

        var exam_time = $('#exam_time').val();
        if(!exam_time)
        {
            alert("Please Enter Exam Time");
            return false;
        }

        // var course_price = $('#course_price').val();
        // if(!course_price)
        // {
        //     alert("Please Enter Course Price");
        //     return false;
        // }

        // var study_m_charge = $('#study_m_charge').val();
        // if(!study_m_charge)
        // {
        //     alert("Please Enter Study Material Charges");
        //     return false;
        // }

        var online_marks = $('#online_marks').val();
        if(!online_marks)
        {
            alert("Please Enter Online Exam Total Marks");
            return false;
        }

        var practical_marks = $('#practical_marks').val();
        if(!practical_marks)
        {
            alert("Please Enter Practical Exam Total Marks");
            return false;
        }

        var viva_marks = $('#viva_marks').val();
        if(!viva_marks)
        {
            alert("Please Enter Viva Exam Total Marks");
            return false;
        }

        var total_questions = $('#total_questions').val();
        if(!total_questions)
        {
            alert("Please Enter Online Exam Questions");
            return false;
        }

        // var atp_course_price = $('#atp_course_price').val();
        // if(!atp_course_price)
        // {
        //     alert("Please Enter ATP Course price");
        //     return false;
        // }

        $("#choice_form").submit();
    }
    else
    {
        $("#choice_form").submit();
    }

    
    
}