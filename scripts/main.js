
window.onscroll = function () { scrollFunction() };

function scrollFunction() {
    if (document.body.scrollTop > 80 || document.documentElement.scrollTop > 80) {
        document.getElementById("navbar").classList.add("scrolled");
    } else {
        document.getElementById("navbar").classList.remove("scrolled");
    }
}

// JavaScript to make top tags sticky when scrolled
const solutionSections = document.querySelectorAll('.solution-section');

solutionSections.forEach(section => {
    const topTag = section.querySelector('.top-solution-tag');
    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.intersectionRatio > 0) {
                topTag.classList.add('sticky');
            } else {
                topTag.classList.remove('sticky');
            }
        });
    }, { threshold: 0 });

    observer.observe(section);
});


// document.addEventListener('DOMContentLoaded', function() {
//     const scroll = new LocomotiveScroll({
//       el: document.querySelector('[data-scroll-container]'),
//       smooth: true,
//       getDirection: true
//     });
//   });

// document.addEventListener('DOMContentLoaded', function() {
//     const scroll = new LocomotiveScroll({
//       el: document.querySelector('[data-scroll-container]'),
//       smooth: true,
//       getDirection: true
//     });
  
//     const sections = document.querySelectorAll('[data-scroll]');
//     const staticCols = document.querySelectorAll('.static');
//     const solutionBoxes = document.querySelectorAll('.solution-box');
//     let currentIndex = 0;
  
//     // Hide all static columns except the first one
//     for (let i = 1; i < staticCols.length; i++) {
//       staticCols[i].style.display = 'none';
//     }
  
//     // Listen for scroll stop event
//     scroll.on('scrollStop', function() {
//       const direction = scroll.direction;
  
//       if (direction === 'up') {
//         currentIndex--;
//       } else if (direction === 'down') {
//         currentIndex++;
//       }
  
//       if (currentIndex < 0) {
//         currentIndex = 0;
//       } else if (currentIndex >= sections.length) {
//         currentIndex = sections.length - 1;
//       }
  
//       // Hide the current static column and show the next one
//       if (currentIndex > 0) {
//         staticCols[currentIndex - 1].style.display = 'none';
//         staticCols[currentIndex].style.display = 'block';
//       }
  
//       // Add active class to the current solution box
//       solutionBoxes.forEach((box, index) => {
//         if (index === currentIndex) {
//           box.classList.add('active');
//         } else {
//           box.classList.remove('active');
//         }
//       });
  
//       sections[currentIndex].scrollIntoView({ behavior: 'smooth' });
//     });
//   });  