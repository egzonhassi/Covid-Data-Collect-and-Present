var url = "http://127.0.0.1:8000/api/";


$(document).ready(function () {
    $("#states").select2({
        ajax: {
            url: url+"states",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    
                    q: params.term 
                };
            },
            processResults: function (data, params) {
                var resData = [];

                data.forEach(function (value) {
                    if (value.text.toLowerCase().indexOf(params.term.toLowerCase()) != -1){
                        resData.push(value)
                    }
                        
                })
                return {
                    results: $.map(resData, function (item) {
                        return {
                            text: item.text,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        },
        minimumInputLength: 1
    })

    $.ajax({
        type: "GET",
        url: url + "total",
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function (data) {
            $("#deaths").html(data.deaths);
            $("#recovered").html(data.recovered);
            $("#sick").html(data.confirmed);



        },
        failure: function (errMsg) {
            alert(errMsg);
        }
    });
    
});