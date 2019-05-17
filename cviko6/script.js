
$(document).ready(function(){

    $('#meniny').submit(function() { // catch the form's submit event

        var stat=$("#statik").val();
        var datum=$("#datum").val();
        var res=datum.split(".");
        var den=res[1]+res[0];

        $.ajax({ // create an AJAX call...

            data: $(this).serialize(), // get the form data
            type: $(this).attr('method'), // GET or POST
            url: "index.php/stat/"+stat+"/datum/"+den, // the file to call
            success: function(response) { // on success..

                //Console.log("success");
                $('#myDiv').html(response); // update the DIV
            }
        });
        return false; // cancel original event to prevent form submitting
    });

    $('#date').submit(function() { // catch the form's submit event

        var stat=$("#krajina").val();
        var meno=$("#meno").val();
        //var res=datum.split("-");
        //var den=res[1]+res[2];

        $.ajax({ // create an AJAX call...

            data: $(this).serialize(), // get the form data
            type: $(this).attr('method'), // GET or POST
            url: "index.php/stat/"+stat+"/meno/"+meno, // the file to call
            success: function(response) { // on success..

                //Console.log("success");
                $('#myDiv').html(response); // update the DIV
            }
        });
        return false; // cancel original event to prevent form submitting
    });

    $('#sviatky').submit(function() { // catch the form's submit event

        var stat=$("#statik").val();
        $.ajax({ // create an AJAX call...

            data: $(this).serialize(), // get the form data
            type: $(this).attr('method'), // GET or POST
            url: "index.php/sviatky/"+stat, // the file to call
            success: function(response) { // on success..

                //Console.log("success");
                 $('#myDiv').html(response); // update the DIV
            }
        });
        return false; // cancel original event to prevent form submitting
    });

    $('#pam').submit(function() { // catch the form's submit event

        var stat=$("#coutry").val();
        $.ajax({ // create an AJAX call...

            data: $(this).serialize(), // get the form data
            type: $(this).attr('method'), // GET or POST
            url: "index.php/pamdni/SK", // the file to call
            success: function(response) { // on success..

                //Console.log("success");
                $('#myDiv').html(response); // update the DIV
            }
        });
        return false; // cancel original event to prevent form submitting
    });

    $('#vloz').submit(function() { // catch the form's submit event

        var stat=$("#staty").val();
        var datum=$("#datumm").val();
        var menov=$("#menov").val();
        var res=datum.split(".");
        var den=res[1]+res[0];

        $.ajax({ // create an AJAX call...

            data: $(this).serialize(), // get the form data
            type: $(this).attr('method'), // GET or POST
            url: "index.php/stat/SK/den/"+den+"/meno/"+menov, // the file to call
            success: function(response) { // on success..

                //Console.log("success");
                $('#myDiv').html(response); // update the DIV
            }
        });
        return false; // cancel original event to prevent form submitting
    });
});