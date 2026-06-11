</div> <!-- end main-content -->

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const links = document.querySelectorAll(".sidebar a");
    const mainContent = document.getElementById("main-content");
    const pageTitle = document.querySelector('title');

    function setActiveLink() {
        const currentPage = window.location.pathname.split('/').pop();
        links.forEach(link => {
            const href = link.getAttribute('href');
            if (href === currentPage) {
                link.classList.add("active");
            } else {
                link.classList.remove("active");
            }
        });
    }

    function loadContent(url, pushState = true) {
        mainContent.innerHTML = `
            <div style="text-align:center; padding:50px;">
                <div class="spinner"></div>
                <p>Loading...</p>
            </div>
        `;

        fetch(url)
            .then(response => response.ok ? response.text() : Promise.reject('Network response was not ok'))
            .then(data => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(data, "text/html");
                
                const newContent = doc.querySelector("#main-content");
                const newTitle = doc.querySelector('title');

                if (newContent) {
                    mainContent.innerHTML = newContent.innerHTML;
                    if (newTitle) pageTitle.innerText = newTitle.innerText;
                    if (pushState) window.history.pushState({path: url}, newTitle ? newTitle.innerText : '', url);
                    setActiveLink();
                } else {
                    mainContent.innerHTML = "<p>Error: Content area not found.</p>";
                }
            })
            .catch((error) => {
                console.error('Fetch error:', error);
                mainContent.innerHTML = "<p>Error loading page. Please try again.</p>";
            });
    }

    links.forEach(link => {
        link.addEventListener("click", function (e) {
            const url = this.getAttribute("href");
            if (url.includes("logout.php") || e.ctrlKey || e.metaKey) {
                return;
            }
            e.preventDefault();
            loadContent(url);
        });
    });

    window.addEventListener('popstate', function(e) {
        if (e.state && e.state.path) {
            loadContent(e.state.path, false);
        }
    });

    setActiveLink();
    if (!window.history.state) {
        window.history.replaceState({path: window.location.href}, document.title, window.location.href);
    }
});
</script>

</body>
</html>