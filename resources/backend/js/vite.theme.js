document.addEventListener("DOMContentLoaded", ()=>{ 
    const t = localStorage.getItem("theme") || "light"; 
    document.body.dataset.theme = t; 
    document.querySelector(".js-stylesheet").setAttribute("href", window.themeUrls[t] || window.themeUrls["light"]);

    const setSidebarLayout = (layout) => {
        document.body.setAttribute('data-sidebar-layout', layout);
        localStorage.setItem('sidebarLayout', layout);
    };
    const savedLayout = localStorage.getItem('sidebarLayout') || 'default';
    setSidebarLayout(savedLayout);
    document.querySelectorAll('input[name="sidebarLayout"]').forEach(input => {
        input.addEventListener('change', (e) => {
            setSidebarLayout(e.target.value);
        });
    });        
  });

// localStorage.clear(); //clean the theme if crash