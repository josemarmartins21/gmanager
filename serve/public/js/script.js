var overlay = document.getElementById('overlay')
var btn = document.getElementById('modal-btn')
var modal = document.getElementById('modal')
var modalTable = document.getElementById('modal-table')
var btnTheme = document.getElementById('btn-theme')
var btnCloseModal = document.getElementById('close-modal-btn')

overlay.addEventListener('click', abrirModal)

function abrirModal() {
    var wantOpen = overlay.classList.contains('hidden')
    var o = overlay
    var m = modal

    if (wantOpen) {
        setBoxPositionToOpen(o)   
        setBoxPositionToOpen(m)
    }
    
    if (! wantOpen) {
        alternarClass(o) 
        alternarClass(m) 
    } 
}

function alternarClass(o) {
    o.classList.toggle('hidden') 
}

function setBoxPositionToOpen(o) {
    alternarClass(o)
    o.classList.add('abrir') 
}

// Persistência do tema
const temasalvo = localStorage.getItem('tema');
changeMode(temasalvo === 'escuro')

btnTheme.addEventListener('click', () => {
  var corpo = document.getElementById('corpo')
  const isescuro = corpo.classList.toggle('dark');

  changeMode(isescuro);
  localStorage.setItem('tema', isescuro ? 'escuro' : 'claro');
}) // Dark Mode

function changeMode(tipo) {
    if (tipo == true) {
        corpo.classList.add('dark')
        btnTheme.innerHTML = '<i class="fa-solid fa-sun"></i>';
        return
    } 

    if (tipo == false) {
        corpo.classList.remove('dark')
        btnTheme.innerHTML = '<i class="fa-solid fa-moon"></i>';
        return
    }
}