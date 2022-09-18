$(document).ready(function(){
    $(".cashinout-category").click(function(){
        $(".cashinout-category-active").removeClass("cashinout-category-active")

        $(this).addClass("cashinout-category-active")

        if($("#cash_in").hasClass("cashinout-category-active")){
            console.log("appear")
            $(".cashin-parent-container").addClass("appear")
            $(".cashout-parent-container").removeClass("appear")
            
        }
        if($("#cash_out").hasClass("cashinout-category-active")){
            console.log("appear")
            $(".cashin-parent-container").removeClass("appear")
            $(".cashout-parent-container").addClass("appear")
            
        }
    })

    if($("#cash_in").hasClass("cashinout-category-active")){
        console.log("appear")
        $(".cashin-parent-container").addClass("appear")
        $(".cashout-parent-container").removeClass("appear")
        
    }
    if($("#cash_out").hasClass("cashinout-category-active")){
        console.log("appear")
        $(".cashin-parent-container").removeClass("appear")
        $(".cashout-parent-container").addClass("appear")
        
    }
})