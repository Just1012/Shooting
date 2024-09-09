let lang = document.querySelector(".lang button");
lang.addEventListener("click", changLang);
function changLang() {
    if (lang.innerHTML === "ENGLISH") {
        lang.innerHTML = "العربية";
        document.body.dir = "rtl";
    } else {
        lang.innerHTML = "ENGLISH";
        document.body.dir = "ltr";
    }
}

let header = document.querySelector("header");
let nav = document.querySelector("nav");

window.addEventListener("scroll", () => {
    if (window.scrollY >= nav.offsetTop) {
        header.classList.add("active");
        nav.classList.add("active");
    }
});

window.addEventListener("scroll", () => {
    if (window.scrollY === 0) {
        header.classList.remove("active");
        nav.classList.remove("active");
    }
});

let links = document.querySelector(".links");
let alinks = document.querySelectorAll(".links a");
let iconBars = document.querySelector("nav .icon i");

iconBars.addEventListener("click", () => {
    links.classList.toggle("active");
    if (links.classList.contains("active")) {
        iconBars.setAttribute("class", "fa-solid fa-x");
        document.body.style.overflow = "hidden";
    } else {
        iconBars.setAttribute("class", "fa-solid fa-bars");
        document.body.style.overflow = "auto";
    }
});

// document.body.addEventListener('click',(event)=>{
//   if (!iconBars.contains(event.target) && links.classList.contains('active')) {
//     links.classList.remove('active')
//     iconBars.setAttribute('class','fa-solid fa-bars')
//     document.body.style.overflow = 'auto';

//   }
// })

let NavLinks = document.querySelectorAll("nav a");
NavLinks.forEach((link) => {
    if (link.href == window.location.href) {
        link.classList.add("active");
    }
});

document.addEventListener("DOMContentLoaded", () => {
    let items = Array.from(document.querySelectorAll(".all .items .item"));
    let allItem = document.querySelector(
        '.items .item[data-category-id="all"]'
    ); // "all" item
    let projectsContainer = document.querySelector(".projects");
    let activeItem = allItem; // Initially, set "all" as the active item

    // Assume the app's locale is stored here (you can get this from your app's localization logic)
    let currentLocale = "{{ App::getLocale() }}"; // 'ar' for Arabic or 'en' for English

    // Function to manage the active class and set it to the clicked item
    function manageActive(clickedItem) {
        // Remove active class from all items
        items.forEach((item) => item.classList.remove("active"));

        // Add active class to the clicked item
        clickedItem.classList.add("active");
    }

    // Function to fetch and display brands based on category ID
    function fetchBrands(categoryId) {
        let url =
            categoryId === "all"
                ? "/filter-brands"
                : `/filter-brands/${categoryId}`;

        fetch(url)
            .then((response) => response.json())
            .then((data) => {
                projectsContainer.innerHTML = ""; // Clear current projects
                displayProjects(data.brands); // Display fetched brands
            })
            .catch((error) => {
                console.error("Error fetching brands:", error);
            });
    }

    // Function to display the fetched projects
    function displayProjects(brands) {
        if (brands.length > 0) {
            brands.forEach((brand) => {
                let brandName =
                    currentLocale === "ar"
                        ? brand.brand_name_ar
                        : brand.brand_name_en;
                let categoryNames = brand.categories
                    .map((category) =>
                        currentLocale === "ar"
                            ? category.name_ar
                            : category.name_en
                    )
                    .join(" - ");

                // Build the project HTML
                let projectHTML = `
                    <a href="#" class="project">
                        <div class="image">
                            <img src="/images/${brand.image}" alt="">
                        </div>
                        <div class="info">
                            <h5>${brandName}</h5>
                            <p>${categoryNames}</p>
                        </div>
                    </a>
                `;
                projectsContainer.innerHTML += projectHTML;
            });
        } else {
            // If no brands are found, display a "No results found" message
            projectsContainer.innerHTML = "<p>لم يتم العثور على نتائج</p>";
        }
    }

    // Add event listeners to category items
    items.forEach((item) => {
        item.addEventListener("click", () => {
            let categoryId = item.getAttribute("data-category-id");

            // Check if the "all" category was clicked
            if (categoryId === "all") {
                manageActive(allItem); // Make "all" item active
            } else {
                manageActive(item); // Make the clicked item active
            }

            fetchBrands(categoryId); // Fetch brands based on the selected category
        });
    });

    // Select the "all" category by default on page load
    if (allItem) {
        allItem.classList.add("active"); // Add active class to "all"
        fetchBrands("all"); // Fetch all brands on page load
    }
});

function manageActive() {
    let items = Array.from(document.querySelectorAll(".all .items .item"));
    items.forEach((item) => {
        item.classList.remove("active");
        this.classList.add("active");
    });
}
