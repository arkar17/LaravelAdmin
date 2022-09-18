const refreebtncontainer = document.querySelector(".refree-btns-container")
var twopiecesArr = []


const btnRow = () => {
    let arr = []
    for(let i = 0;i < 100;i++){
        arr.push(`
        <div class="refree-number-container">
        <p>${i < 10 ? `0${i}` : `${i}`}</p>
        <input type="checkbox" value=${i < 10 ? `0${i}` : `${i}`} class="refree-number-btn" />
        </div>`)
    }
    // console.log(arr)

    return arr
}
refreebtncontainer.innerHTML = btnRow().join("")
const refreebtn = document.querySelectorAll(".refree-number-btn")

const checkTwoPiecesArr = (refreebtn) => {
    const value = refreebtn.value
    if(twopiecesArr.includes(value)){
        refreebtn.classList.remove("check")
        filteredArr = twopiecesArr.filter((number) => {
            if(number !== value){
                return number
            }
        })
        twopiecesArr = filteredArr
    }else{
        refreebtn.classList.add("check")
        twopiecesArr.push(value)
    }

    console.log(twopiecesArr)
}
// console.log(refreebtn)
for(let i = 0; i <refreebtn.length;i++){
    refreebtn[i].addEventListener("click" ,() => checkTwoPiecesArr(refreebtn[i]))
}

