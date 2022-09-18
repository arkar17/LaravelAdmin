$(document).ready(function(){

    $.getJSON('http://165.22.51.1/send', (data, jqXHR) => {
        console.log(data);
        if(data.data.salesList.length != 0){
            $.each(data.data.salesList, function(index, value){
                $(".twod-manage-numbers-rows-container").append(`
                <div class="twod-manage-numbers-row">
                <div class="twod-manage-numbers-attributes">
                    <p>${value.number}</p>
                    <p>${value.compensation}</p>
                    <p>${value.max_amount}</p>
                    <p>${value.sales == null? `0` : value.sales}</p>

                </div>
                <div class="twod-manage-numbers-inputs-container">
                    <input type="number" name="twodRate" id="twod-number-rate" />
                    <input type="number" name="twodMax" id="twod-number-max"/>
                </div>
                </div> `)
            });
        }
        else{
                        //towd manage list row template
            for(let i = 0;i <= 99; i++){
                $(".twod-manage-numbers-rows-container").append(`
                <div class="twod-manage-numbers-row">
                    <div class="twod-manage-numbers-attributes">
                    <p>${i <= 9? `0${i}` : i}</p>
                    <p>0</p>
                    <p>0</p>
                    <p>0</p>
                    </div>

                    <div class="twod-manage-numbers-inputs-container">
                        <input type="number" name="twodRate" id="twod-number-rate" />
                        <input type="number" name="twodMax" id="twod-number-max"/>
                    </div>
                    </div> `)
            }
        }
    //array of input values
    let rate = []
    let max = []

    //final data array
    let twoddata = []


    //confirm btn clicked
    $(".twod-manage-confirm-btn").click(function(e){
                    // jQuery('#confirm').click(function(e){
                    e.preventDefault();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    //pushing values from inputs to rate array
        const rateinputArr = $(".twod-manage-numbers-inputs-container #twod-number-rate")
        rateinputArr.each(function(index){
            // console.log(index)
            // console.log(data.data[index].max_amount)
            const value = $(this).val()? $(this).val() : data.data.salesList[index].compensation //checking if input is empty. if it is empty push the old value
           rate.push(parseInt(value))
        //    data()

        $(this).val("")
        })


        //pushing values from inputs to max array
        const maxinputarr = $(".twod-manage-numbers-inputs-container #twod-number-max")
        maxinputarr.each(function(index){
            const value = $(this).val()? $(this).val() : data.data.salesList[index].max_amount //checking if input is empty. if it is empty push the old value
            max.push(parseInt(value))

            $(this).val("")
        })

        // making the final data array
        for(let i = 0; i <= 99;i++){
            const twodObject = {
                twodNumber : i <= 9 ? `0${i}` : i.toString(),
                compensation : parseInt(rate[i]),
                maxAmount : parseInt(max[i])
            }
            twoddata.push(twodObject)
        }
        // twoddata = twoddata;
        console.log(twoddata);
                    $.ajax({
                        url : '2DManage',
                        method: 'post',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data:  {"twod":twoddata},
                        success   : function(data) {
                            console.log(data);
                        },
                        // error : function(err){
                        //     console.log(err)
                        // }
                    });

         //resetting arrays
        twoddata = []
        rate = []
        max = []

        window.location.reload()
    });







    // })


    //rate insert btn clicked
    $("#twod-rate-insert-btn").click(() => {
        const value = $("#twod-rate-insert-input").val()

        if(value){
            const rateinputArr = $(".twod-manage-numbers-inputs-container #twod-number-rate")
            rateinputArr.each(function(){
                $(this).val(value)
            })
            $("#twod-rate-insert-input").val("")
        }else{
            alert("please enter a number")
        }

    })


    //max insert btn clicked
    $("#twod-max-insert-btn").click(() => {
        const value = $("#twod-max-insert-input").val()

        if(value){
            const maxinputarr = $(".twod-manage-numbers-inputs-container #twod-number-max")
            maxinputarr.each(function(){
                $(this).val(value)
            })
            $("#twod-max-insert-input").val("")
        }else{
            alert("please enter a number")
        }

    })

    //reset the array on confirm
    // $(".")

    //cancel btn clicked
    $(".twod-manage-cancel-btn").click(() => {
        const rateinputArr = $(".twod-manage-numbers-inputs-container #twod-number-rate")
        const maxinputarr = $(".twod-manage-numbers-inputs-container #twod-number-max")

        rateinputArr.each(function(){
            $(this).val("")
        })
        maxinputarr.each(function(){
            $(this).val("")
        })

        $("#twod-rate-insert-input").val("")
        $("#twod-max-insert-input").val("")
    })

});
});


// })

{/* <div class="twod-manage-numbers-row">
<div class="twod-manage-numbers-attributes">
<p>00</p>
<p>85</p>
<p>1000000</p>
<p>100000</p>
</div>

<div class="twod-manage-numbers-inputs-container">
<input type="number" name="twod-number-rate-input" />
<input type="number" name="twod-number-max-input" />
</div>
 </div> */}
