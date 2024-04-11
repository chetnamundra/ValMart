let current = 0;
var h = window.innerHeight;
var w = window.innerWidth;
console.log(h,w);
function blank(){}

window.onload = function (){
    putItems();
    putBackdrops();
}
//document.addEventListener("click",TopRibbon());
function slideshow(n){
    let i;
    let slides = document.getElementsByClassName("slides");
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    l = slides.length;
    if(current+n>l-1){
        slides[0].style.display = "block";
        current = 0;
    }
    else if(current+n<0){
        slides[l-1].style.display = "block";
        current = l-1;
    }
    else{
        slides[current+n].style.display = 'block';
        current += n;
    }
}



var lastValue = 0;
document.onscroll = function TopRibbon(){
    let b = document.getElementById('TopRibbon');
    let cur = document.documentElement.scrollTop;
    if(lastValue-20 > cur){
        b.style.visibility = 'visible'; //scroll up
        b.classList.remove('stayUp');
        b.classList.add('visibleOn');
    }
    else if(lastValue+20 < cur){
        //scroll down
        b.classList.add('stayUp');
        b.classList.remove('visibleOn');
        setTimeout(blank,1500);
        b.style.visibility = 'hidden';
    }
    lastValue = cur;
};

document.onscroll = function category(){
    if(w>h){
        b = document.getElementById("category");
        a = b.style.height;
        c = document.getElementsByClassName("flex-container2");
        if(document.documentElement.scrollTop>(h*0.40)){    
            b.classList.add("stick");
            c[0].style.top = String(a)+'px';
        }
        else {
            b.classList.remove("stick");
            c[0].style.top = 0;
        }
    }
}

function Sidebar(){
    var a = document.getElementById("sidebar");
    var b = a.style.width;
    var x =  '30';
    console.log(h/w);
    if(h/w >1 ){
        x = '100';
    }
    if(b==0 || b== '0px'){
        //a.style.visibility =  'h idden';
        document.getElementById("sidebar").style.width = x+"vw";
        //document.getElementById("flex-container2").style.marginLeft = "250px";
        setTimeout(500);
        document.documentElement.style.marginRight = '30vw';
        document.getElementById("category").marginRight = '30vw';
        document.getElementById("close").marginRight = '28vw';
        document.getElementById("close").style.visibility = "visible";
    }
    else{
        document.getElementById("sidebar").style.width = "0px";
        //document.getElementById("flex-container2").style.marginLeft = "0px";
        document.documentElement.style.marginRight = '0px';
        document.getElementById("category").marginRight = '0px';
        document.getElementById("close").marginRight = '0px';
        document.getElementById("close").style.visibility = "hidden";
    }
}

function deleteFlex2(){
    document.getElementById("flex-container2").innerHTML = '';
    console.log("done");

}


// function shifter(){
//     let a = document.getElementById("category");
//     let b = document.getElementById('content');
//     let c = Math.max(a.scrollHeight, a.offsetHeight);
//     //console.log(h*0.60 + c,h*0.6);
//     b.style.top = (h*0.60 + c);
//     b.setAttribute.top= h *0.90 + c;
//     b.style.top = String(h *0.90 + c)+"px";
// }

window.onscroll = function() {
  footer = document.getElementById("footer-bottom");
  if (window.pageYOffset < 50) {
    footer.style.bottom = "-10vh";
  } else {
    footer.style.bottom = "0";
  }
};

function footerToggle(){
    var fb = document.getElementById("contact");
    var fc = document.getElementById("footer-toggle");

    if(fb.innerHTML == "\u21E9"){
        fb.innerHTML = "\u21E7" ;
        document.getElementById("footer-toggle").style.bottom = String(-0.3*h)+'px';
    }
    else{
        fb.innerHTML ="\u21E9";
        document.getElementById("footer-toggle").style.bottom = String(0.10*h)+'px';
    }

}

function changeV(clicked,n){
    if(n==1){
        C = clicked.previousElementSibling;
    }
    else if(n==-1){
        C = clicked.nextElementSibling;
    }
    if(Number(C.innerHTML)+n >=0){
        C.innerHTML = Number(C.innerHTML) + n;
    }
    //Cs.style.display ='none';
}

function updateCart(action, uid, pid, updateId) {
  if (uid == 1) {
      alert("Please login to perform this action.");
      window.location.href = "home1.php";
      return;
  }
  
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function() {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        // Update only the specified shopping cart elements with the response from the server
        var cartElements = document.querySelectorAll("#" + updateId);
        cartElements.forEach(function(element) {
          element.innerHTML = xhr.responseText;
        });
        updatesidecart('cartbutton.php', uid);
        updatesidebar('check_cart.php', uid);
        // Call updatesidecart after updating the shopping cart elements
      } else {
        console.error(xhr.status);
      }
    }
  };
  xhr.open("POST", action);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.send("uid=" + uid + "&pid=" + pid);
}

  function updatesidecart(action, uid) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          var difElement = document.getElementById("cartnewbutton");
          difElement.innerHTML = xhr.responseText;
        } else {
          console.error(xhr.status);
        }
      }
    };
    xhr.open("POST", action);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("uid=" + uid);
  }

  function updatesidebar(action, uid) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          // Update the shopping cart element in the sidebar with the response from the server
          var difElement = document.getElementById("recentcart");
          difElement.innerHTML = xhr.responseText;
        } else {
          console.error(xhr.status);
        }
      }
    };
    xhr.open("POST", action);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("uid=" + uid);
}
//document.addEventListener("srcoll",TopRibbon());