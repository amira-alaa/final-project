$(document).ready(function () {
    
// fun to change page title

        $.ajax({
            type: 'POST',
            url:'register.php',
            data:{title:newtitle},
            success:function(response){
                console.log(response);
                document.title=newtitle;
            },
            error:function(xhr,status,error){
                console.log("an error ocurred");
            }
        })

// Btns to change between login and register

    $(".login-btn").click(function () {
    //   change from register to login
       $(".register").hide("slow");
       $(".login").show("slow");

    //   change page title to login 
       var newtitle="login";
       updatetitle(newtitle);



    })
    $(".reg-btn").click(function () {
    //    change from login to register
        $(".login").hide("slow");
        $(".register").show("slow");
        $(".register").css({"display": "flex"});

    //   change page title to register 
        var newtitle="register";
        updatetitle(newtitle);
       
    })
    
    // drop down
    $(".dropdown").hover(
        function(){
            $(this).find('.dropdown-menu').stop(true,true).slideDown('slow');
        },
        function(){
            $(this).find('.dropdown-menu').stop(true,true).slideUp('fast');
        }
    );

})

// rating by js
const stars= document.querySelectorAll(".stars i");
stars.forEach((star,index1)=>{

    star.addEventListener("click",()=>{

        stars.forEach((star,index2)=> {
            index1 >= index2 ? star.classList.add("active"):star.classList.remove("active");
        })
    })
})