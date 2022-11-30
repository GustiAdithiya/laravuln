const btn = document.getElementById("myBtn")

function myFunction() {
  btn.disabled = true;
  setTimeout(()=>{
    btn.disabled = false;
    console.log('Button Activated')}, 5000)
}