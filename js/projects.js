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

function renderProjects(projectsToRender) {
  const container = document.getElementById("projectsGrid");
  if (!container) {
    console.error("projectsGrid container not found!");
    return;
  }
  
  if (projectsToRender.length === 0) {
    container.innerHTML = `
      <div class="col-12 text-center py-5">
        <p class="text-muted">No projects found.</p>
      </div>
    `;
    return;
  }
  
  container.innerHTML = projectsToRender.map(project => `
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

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
  console.log('Initializing projects page...');
  
  // Render all projects
  renderProjects(projects);
  console.log('All projects loaded successfully');
});