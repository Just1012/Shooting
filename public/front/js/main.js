let lang = document.querySelector('.lang button');
lang.addEventListener('click',changLang)
function changLang() {
  if(lang.innerHTML === 'ENGLISH'){
    lang.innerHTML = 'العربية'
    document.body.dir = 'rtl'
  }else{
    lang.innerHTML = 'ENGLISH'
    document.body.dir = 'ltr'
  }
}

let header = document.querySelector('header')
let nav = document.querySelector('nav')

window.addEventListener('scroll',()=>{
  if (window.scrollY >= nav.offsetTop) {
    header.classList.add('active')
    nav.classList.add('active')
  }
})

window.addEventListener('scroll',()=>{
  if (window.scrollY === 0) {
    header.classList.remove('active')
    nav.classList.remove('active')
  }
})


let links = document.querySelector('.links');
let alinks = document.querySelectorAll('.links a');
let iconBars = document.querySelector('nav .icon i');

iconBars.addEventListener('click',()=>{
  
  links.classList.toggle('active');
  if(links.classList.contains('active')){
    iconBars.setAttribute('class','fa-solid fa-x')
    document.body.style.overflow = 'hidden';
  }else{
    iconBars.setAttribute('class','fa-solid fa-bars')
    document.body.style.overflow = 'auto';
  }
})

// document.body.addEventListener('click',(event)=>{
//   if (!iconBars.contains(event.target) && links.classList.contains('active')) {
//     links.classList.remove('active')
//     iconBars.setAttribute('class','fa-solid fa-bars')
//     document.body.style.overflow = 'auto';

//   }
// })


let NavLinks = document.querySelectorAll('nav a');
NavLinks.forEach((link)=>{
  if (link.href == window.location.href) {
    link.classList.add('active')
  }
})


document.addEventListener('DOMContentLoaded', () => {
  let items = Array.from(document.querySelectorAll('.all .items .item'));
  let projectsContainer = document.querySelector('.projects');
  let projects = document.querySelectorAll('.projects .project');

  items.forEach(item => {
    item.addEventListener('click', manageActive);
    item.addEventListener('click', () => {
      // احصل على نص التبويب الذي تم النقر عليه وأزل المسافات الزائدة
      let filterValue = item.textContent.trim();
      let matchFound = false;

      projects.forEach(project => {
        let projectTextSpans = Array.from(project.querySelectorAll('p span'));

        if (filterValue === 'جميع الخدمات') {
          project.style.display = 'block';
          matchFound = true;
        } else {
          let projectMatchFound = projectTextSpans.some(span => {
            let spanText = span.textContent.trim();
            // تقسيم نص التبويب والكلمات في المشروع إلى كلمات فردية
            let tabWords = filterValue.split(' ').filter(word => word.length > 4);
            let spanWords = spanText.split(' ').filter(word => word.length > 4);

            // تحقق من وجود تطابق جزئي
            return tabWords.some(tabWord => spanWords.some(spanWord => spanWord.includes(tabWord)));
          });

          if (projectMatchFound) {
            project.style.display = 'block';
            matchFound = true;
          } else {
            project.style.display = 'none';
          }
        }
      });

      let notFoundDiv = document.querySelector('.projects .not-found');
      if (!matchFound) {
        if (!notFoundDiv) {
          notFoundDiv = document.createElement('div');
          notFoundDiv.className = 'not-found';
          notFoundDiv.textContent = 'لم يتم العثور على نتائج';
          projectsContainer.appendChild(notFoundDiv);
        }
        notFoundDiv.style.display = 'block';
      } else {
        if (notFoundDiv) {
          notFoundDiv.style.display = 'none';
        }
      }
    });
  });
});




function manageActive() {
  let items = Array.from(document.querySelectorAll('.all .items .item'));
  items.forEach(item =>{
    item.classList.remove('active');
    this.classList.add('active')
  })
}