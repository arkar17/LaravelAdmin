$(document).ready(function(){

    const sidebardropdowns = $(".side-bar-link-dropdown-header")
    console.log(sidebardropdowns)
    sidebardropdowns.each(function() {
        $(this).click(() => {
            $(this).siblings(".side-bar-link-drop-down").slideToggle(100)
            $(this).children(".side-bar-link-drop-down-icon").toggleClass("fa-angle-left").toggleClass("fa-angle-down")
        })
    })
    

    $("[href]").each(function() {
        if (this.href == window.location.href) {
            $(this).addClass("active");
            $(this).parent().siblings(".side-bar-link-dropdown-header").addClass("active")
        }
    });
  
  });