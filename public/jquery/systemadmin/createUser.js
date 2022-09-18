$(document).ready(function(){

    $('#create-user-type').on('change', function() {
        const userType = $(this).val()

        if(userType === "referee"){
            // console.log("referee")
            $(".create-user-opid-container").addClass("create-user-appear")
            $(".create-user-rfid-container").removeClass("create-user-appear")
        }else if(userType === "agent"){
            // console.log("agent")
            $(".create-user-opid-container").removeClass("create-user-appear")
            $(".create-user-rfid-container").addClass("create-user-appear")
        }else if(userType === "operationstaff" || userType === "guest"){
            $(".create-user-opid-container").removeClass("create-user-appear")
            $(".create-user-rfid-container").removeClass("create-user-appear")
        }
      });

})
