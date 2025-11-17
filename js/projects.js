const projects = [
  {
    image: "images/hospital.png",
    tag: "Major Project",
    category: "major",
    title: "Hospital Project",
    link: "project-details.php",
    text: "Providing quality healthcare services to underserved communities with compassion and excellence.",
  },
  {
    image: "images/school.png",
    tag: "Major Projects",
    category: "major",
    title: "School Project",
    link: "project-details.php",
    text: "Building educational institutions that nurture both Islamic values and modern knowledge for future generations.",
  },
  {
    image: "images/mosque.png",
    tag: "Major Project",
    category: "major",
    title: "Mosque Project",
    link: "project-details.php",
    text: "Creating spiritual centers for worship, learning, and community gathering for all Muslims.",
  },
  {
    image: "images/act4.webp",
    tag: "Regular Projects",
    category: "regular",
    title: "Meritorious Program",
    link: "project-details.php",
    text: "Financial Support For Madrasha Students which are needed for poor students",
  },
  {
    image: "images/act5.webp",
    tag: "Regular Projects",
    category: "regular",
    title: "Educational Support Program",
    link: "project-details.php",
    text: "Financial Support For Madrasha Students which are needed for poor students",
  },
  {
    image: "images/act6.webp",
    tag: "Social Project",
    category: "social",
    title: "Community Welfare Program",
    link: "project-details.php",
    text: "Financial Support For Madrasha Students which are needed for poor students",
  },
];

function renderProjects(filteredProjects) {
  const container = document.getElementById("projectsGrid");
  if (!container) {
    console.error("projectsGrid container not found!");
    return;
  }
  
  if (filteredProjects.length === 0) {
    container.innerHTML = `
      <div class="col-12 text-center py-5">
        <p class="text-muted">No projects found in this category.</p>
      </div>
    `;
    return;
  }
  
  container.innerHTML = filteredProjects.map(project => `
    <div class="col-lg-4 col-md-6">
      <div class="course">
        <div class="course_image"><img src="${project.image}" alt="${project.title}"></div>
        <div class="course_body">
          <div class="course_header d-flex flex-row align-items-center justify-content-start">
            <div class="activities_tag"><a href="#" class="text-success">${project.tag}</a></div>
          </div>
          <div class="course_title truncated-title"><h3><a href="${project.link}">${project.title}</a></h3></div>
          <div class="course_text text-elipsis">${project.text}</div>
          <div class="button button_1"><a href="${project.link}">See details<div class="button_arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></div></a></div>
          <div class="course_footer d-flex align-items-center justify-content-start">
          </div>
        </div>
      </div>
    </div>
  `).join("");
}

function filterProjects(category, clickedButton) {
  // Update active tab
  const tabs = document.querySelectorAll('.tab-button');
  tabs.forEach(tab => tab.classList.remove('active'));
  
  // Add active class to clicked button
  if (clickedButton) {
    clickedButton.classList.add('active');
  }

  // Filter and render projects
  let filteredProjects;
  if (category === 'all') {
    filteredProjects = projects;
  } else {
    filteredProjects = projects.filter(project => project.category === category);
  }
  
  console.log(`Filtering by: ${category}, Found ${filteredProjects.length} projects`);
  renderProjects(filteredProjects);
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
  console.log('Initializing projects page...');
  
  // Add click event listeners to tabs
  const tabs = document.querySelectorAll('.tab-button');
  tabs.forEach(tab => {
    tab.addEventListener('click', function(e) {
      const category = this.getAttribute('data-category');
      console.log('Tab clicked:', category);
      filterProjects(category, this);
    });
  });
  
  // Initial render - show all projects
  renderProjects(projects);
  console.log('Projects loaded successfully');
});