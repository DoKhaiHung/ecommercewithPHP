var buttonSearch=document.querySelector("#search_form_button");
var drop_list=document.querySelectorAll(" .header_drop-list-item")
const $=document.querySelector.bind(document)
drop_list.forEach(ele=>{
    ele.onclick=async(e)=>{
       //e.preventDefault();
        await fetch("../api/collection.php",{
            headers: {
                    'Accept': 'application/json, text/plain, */*',
                    'Content-Type': 'application/x-www-form-urlencoded'
            },
            method: "POST",
            body: `cate=${e.target.textContent}`
        })
    }
})
buttonSearch.onclick=(e)=>{
    let inputt=document.querySelector("#search");
    if(inputt.value==""){
        if(inputt.classList.contains('showInput')){
            inputt.classList.remove("showInput");
        }
       else inputt.classList.add("showInput");
        e.preventDefault();
        console.log("here");   
    }
   
}
// live search
$("#search").onkeyup=(e)=>{
    const in4=e.target.value.trim();
   // console.log(e.target.value)
    if(in4=="") {
        $(".list_suggestion").innerHTML="";
        return;
    }
    fetch("../api/livesearch.php",{
        headers: {
                'Accept': 'application/json, text/plain, */*',
                'Content-Type': 'application/x-www-form-urlencoded'
        },
        method: "POST",
        body: `search=${in4}`
    })
    .then(i=>i.json())
    .then(data=>{
       // console.log(data);
        $(".list_suggestion").innerHTML="";
        for (let i=0;i<data.length;i++){
            $(".list_suggestion").innerHTML+=`
            <div class="list_suggestion-item linked">
                    <img src="${data[i].photo}" alt="">
                    <div class="list_suggestion-item-text">${data[i].name}</div>
                    <a href="../product.php?id=${data[i].id}"></a>
            </div>`
        }
       
    })
}

// mobile
let timerMenu;
const menu=$(".menu")
if(menu){
    menu.onclick=()=>{
        $(".menu_wrapper_con").style.animation="slideShow linear 0.2s"
        $(".menu_wrapper").style.display="block";
        $(".menu_close").onclick=()=>{
            clearTimeout(timerMenu)
            $(".menu_wrapper_con").style.animation="slideHide linear 0.2s"
            timerMenu=setTimeout(()=>{
            $(".menu_wrapper").style.display="none"
            },180)
        }
    }
}
