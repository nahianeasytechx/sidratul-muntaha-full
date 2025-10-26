const activities = [
  {
    image: "images/Financial Support For Madrasha Students.jpeg",
    tag: "Regular Projects",
    title: "Financial Support For Madrasha Students",
    link: "activities-details.php",
    text: "Financial Support For Madrasha Students which are needed for poor students",
  },
  {
    image: "images/WhatsApp Image 2025-09-26 at 2.28.54 AM (2).jpeg",
    tag: "Regular Projects",
    title: "Relief Program",
    link: "activities-details.php",
    text: "Financial Support For Madrasha Students which are needed for poor students",
  },
  {
    image: "images/Financial Support For Madrasha Students.jpeg",
    tag: "Regular Projects",
    title: "Meritorious Program",
    link: "activities-details.php",
    text: "Financial Support For Madrasha Students which are needed for poor students",
  },
  {
    image: "images/act4.webp",
    tag: "Regular Projects",
    title: "Meritorious Program",
    link: "activities-details.php",
    text: "Financial Support For Madrasha Students which are needed for poor students",
  },
  {
    image: "images/act5.webp",
    tag: "Regular Projects",
    title: "Meritorious Program",
    link: "activities-details.php",
    text: "Financial Support For Madrasha Students which are needed for poor students",
  },
  {
    image: "images/act6.webp",
    tag: "Regular Projects",
    title: "Meritorious Program",
    link: "activities-details.php",
    text: "Financial Support For Madrasha Students which are needed for poor students",
  },



];
  const container = document.getElementById("activitiesGrid");
 container.innerHTML = activities.map(activities => `
<a href="activities-details.php">
    <div class="col-lg-4 col-md-6">
      <div class="course">
        <div class="course_image"><img src="${activities.image}" alt=""></div>
        <div class="course_body">
          <div class="course_header d-flex flex-row align-items-center justify-content-start">
            <div class="activities_tag"><a href="#" class="text-success">${activities.tag}</a></div>
          
          </div>
          <div class="course_title truncated-title "><h3><a href="${activities.link}" >${activities.title}</a></h3></div>
          <div class="course_text text-elipsis">${activities.text}</div>
          							<div class="button button_1"><a href="activities-details.php">See details<div class="button_arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></div></a></div>
          <div class="course_footer d-flex align-items-center justify-content-start">
          </div>
        </div>
      </div>
    </div>
</a>
  `).join("");
