$(document).ready(function(){
    $.getJSON('http://128.199.201.43/sendlonepyineData', (data, jqXHR) => {

        console.log(data);
        $.each(data.data.salesList, function(index, value){
                // console.log(index)
        })

        const lonePyineListData = data.data.salesList.sort((a,b) => {
            return parseInt(a.id) - parseInt(b.id)
        })

        console.log(lonePyineListData)

    //array of input values
    let rate = []
    let max = []

    //final data array
    let lonepyinedata = []

    //confirm btn clicked
    $(".lonepyine-manage-confirm-btn").click(function(e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        //pushing values from inputs to rate array
        const rateinputArr = $(".lonepyine-manage-numbers-inputs-container #lonepyine-number-rate")
        rateinputArr.each(function(index){
            console.log(index);
            const value = $(this).val()? $(this).val() : lonePyineListData[index]?.compensation //checking if input is empty. if it is empty push the old value
           rate.push(value)

        $(this).val("")
        })


        //pushing values from inputs to max array
        const maxinputarr = $(".lonepyine-manage-numbers-inputs-container #lonepyine-number-max")
        maxinputarr.each(function(index){
            const value = $(this).val()? $(this).val() : lonePyineListData[index]?.max_amount //checking if input is empty. if it is empty push the old value
            max.push(value)

            $(this).val("")
        })

        // making the final data array
        for(let i = 0; i <= 19;i++){
            let number
            if(i <= 9){
                number = `${i}*`
            }else{
                const firstdigit = i.toString().split("")[1]
                number = `*${firstdigit}`
            }
            const lonepyineObject = {
                lonepyineNumber : number,
                compensation : rate[i],
                maxAmount : max[i]
            }
            lonepyinedata.push(lonepyineObject)
        }

        // for(let i = 10; i <=20; i++){

        // }

        console.log(lonepyinedata)

        $.ajax({
            url : '3DManage',
            method: 'post',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data:  {"lonepyaing":lonepyinedata},
            success   : function(data) {
                console.log(data);
            },
            // error : function(err){
            //     console.log(err)
            // }
        });
        //resetting arrays
        lonepyinedata = []
        rate = []
        max = []

        // location.reload(true)
        // window.location.href = window.location.href
        setTimeout(function(){
            window.location.reload();
         }, 2000);

    })


    //rate insert btn clicked
    $("#lonepyine-rate-insert-btn").click(() => {
        const value = $("#lonepyine-rate-insert-input").val()

        if(value){
            const rateinputArr = $(".lonepyine-manage-numbers-inputs-container #lonepyine-number-rate")
            rateinputArr.each(function(){
                $(this).val(value)
            })
            $("#lonepyine-rate-insert-input").val("")
        }else{
            alert("please enter a number")
        }

    })


    //max insert btn clicked
    $("#lonepyine-max-insert-btn").click(() => {
        const value = $("#lonepyine-max-insert-input").val()

        if(value){
            const maxinputarr = $(".lonepyine-manage-numbers-inputs-container #lonepyine-number-max")
            maxinputarr.each(function(){
                $(this).val(value)
            })
            $("#lonepyine-max-insert-input").val("")
        }else{
            alert("please enter a number")
        }

    })

    //cancel btn clicked
    $(".lonepyine-manage-cancel-btn").click(() => {
        const rateinputArr = $(".lonepyine-manage-numbers-inputs-container #lonepyine-number-rate")
        const maxinputarr = $(".lonepyine-manage-numbers-inputs-container #lonepyine-number-max")

        rateinputArr.each(function(){
            $(this).val("")
        })
        maxinputarr.each(function(){
            $(this).val("")
        })

        $("#lonepyine-rate-insert-input").val("")
        $("#lonepyine-max-insert-input").val("")
    })
})

})
