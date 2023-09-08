$(document).ready(function(){
    $('.text_container').addClass("hidden");

    $('.icon').click(function(){
    var $this = $(this).closest(".text_container")
    if ($this.hasClass("hidden")) {
            $(this).closest(".text_container").removeClass("hidden").addClass("visible");
        } else {
            $(this).closest(".text_container").removeClass("visible").addClass("hidden");
        }
    });
});