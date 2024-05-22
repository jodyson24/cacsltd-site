
document.addEventListener('DOMContentLoaded', function () {
    var toggleButton = document.getElementById('toggleButton');
    var mobileNavList = document.getElementById('mobileNavList');
    var closeButton = mobileNavList.querySelector('.close-button');

    toggleButton.addEventListener('click', function () {
        mobileNavList.classList.toggle('show');
    });

    closeButton.addEventListener('click', function () {
        mobileNavList.classList.remove('show');
    });
});

window.onscroll = function () { scrollFunction() };

function scrollFunction() {
    if (document.body.scrollTop > 80 || document.documentElement.scrollTop > 80) {
        document.getElementById("navbar").classList.add("scrolled");
    } else {
        document.getElementById("navbar").classList.remove("scrolled");
    }
}

// LAnguage Switcher
function updateLanguageLinks(language) {
    var links = document.querySelectorAll('.ldm-item');
    links.forEach(function (link) {
        var href = link.getAttribute('href');
        var newHref = '../' + language + '/' + href.split('/')[2];
        link.setAttribute('href', newHref);
    });
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

// script.js

// Function to scroll to the top of the page
function scrollToTop() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

// Show/hide the scroll-to-top button based on scroll position
window.addEventListener('scroll', () => {
    const scrollToTopButton = document.querySelector('.scroll-to-top');
    if (window.scrollY > 300) {
        scrollToTopButton.classList.add('show');
    } else {
        scrollToTopButton.classList.remove('show');
    }
});


document.getElementById('languageToggleMobile').addEventListener('click', function (event) {
    event.preventDefault();
    event.stopPropagation(); // Prevent closing the dropdown
    const langMenu = document.querySelector('.mobile-lang-drop-menu');
    langMenu.classList.toggle('show');
});

document.addEventListener('click', function (event) {
    const langMenu = document.querySelector('.mobile-lang-drop-menu');
    const langToggle = document.getElementById('languageToggleMobile');

    // Close the language dropdown menu if clicked outside
    if (!langMenu.contains(event.target) && !langToggle.contains(event.target)) {
        langMenu.classList.remove('show');
    }
});