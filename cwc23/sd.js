function streamMatch(e){
    document.getElementById("videoPlayer").innerHTML="";
    var t=document.createElement("iframe");
    t.src=e,t.setAttribute("allowfullscreen","true"),
        t.width="100%",
        t.height="600",
        document.getElementById("videoPlayer").appendChild(t)
    }