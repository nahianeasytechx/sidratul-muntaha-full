<?php
$current_page = basename($_SERVER['PHP_SELF']);
$page_title = 'Join Us as Volunteer';
?>
<?php require './components/header.php'; ?>


<!--=======================================================================-->
<!------------------------ Your Content Start From Here --------------------->
<!--=======================================================================-->
<div class="volunteer-home">
    <div class="home">
        <div class="home_background parallax_background parallax-window" data-parallax="scroll" data-image-src="images/courses.jpg" data-speed="0.8"></div>
        <div class="home_container">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="home_content text-center">
                            <div data-aos="fade-up" class="home_title">Join Us as Volunteer</div>
                            <div class="breadcrumbs">
                                <ul>
                                    <li><a href="index.php">Home</a></li>
                                    <li>Volunteer</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="volunteer-page py-5">
    <div class="container">
        <!-- Introduction Section -->
        <div class="row mb-5">
            <div class="col-lg-12 text-center">
                <h2 class="section-title">Be the Change You Want to See</h2>
                <p class="section-description mx-auto" style="max-width: 800px;">
                    Join our dedicated team of volunteers and make a real difference in the lives of those who need it most. 
                    Whether you have a few hours a week or can commit to regular service, your time and skills are invaluable.
                </p>
            </div>
        </div>

        <!-- Why Volunteer Section -->
        <div class="row mb-5">
            <div class="col-lg-6 col-md-12 mb-4" data-aos="fade-right">
                <img src="images/volunteer.webp" alt="Volunteers working" class="w-100 rounded shadow">
            </div>
            <div class="col-lg-6 col-md-12" data-aos="fade-left">
                <h3 class="mb-4">Why Volunteer With Us?</h3>
                <div class="volunteer-benefits">
                    <div class="benefit-item mb-3">
                        <i class="bi bi-heart-fill text-danger me-2"></i>
                        <strong>Make a Real Impact:</strong> Directly help communities in need
                    </div>
                    <div class="benefit-item mb-3">
                        <i class="bi bi-people-fill text-primary me-2"></i>
                        <strong>Build Connections:</strong> Meet like-minded people and build lasting friendships
                    </div>
                    <div class="benefit-item mb-3">
                        <i class="bi bi-book-fill text-success me-2"></i>
                        <strong>Learn New Skills:</strong> Gain valuable experience and develop new abilities
                    </div>
                    <div class="benefit-item mb-3">
                        <i class="bi bi-trophy-fill text-warning me-2"></i>
                        <strong>Personal Growth:</strong> Challenge yourself and grow as a person
                    </div>
                    <div class="benefit-item mb-3">
                        <i class="bi bi-award-fill text-info me-2"></i>
                        <strong>Certificate & Recognition:</strong> Receive certificates for your service
                    </div>
                </div>
            </div>
        </div>

        <!-- Volunteer Opportunities -->
        <div class="row mb-5">
            <div class="col-12 text-center mb-4">
                <h3>Volunteer Opportunities</h3>
            </div>
            <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="opportunity-card p-4 border rounded shadow-sm h-100">
                    <i class="bi bi-book text-primary fs-1 mb-3"></i>
                    <h5>Education Support</h5>
                    <p>Help teach underprivileged children, assist with homework, or organize educational activities.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="opportunity-card p-4 border rounded shadow-sm h-100">
                    <i class="bi bi-heart-pulse text-danger fs-1 mb-3"></i>
                    <h5>Healthcare Support</h5>
                    <p>Assist in medical camps, health awareness programs, or patient care activities.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="300">
                <div class="opportunity-card p-4 border rounded shadow-sm h-100">
                    <i class="bi bi-exclamation-triangle text-warning fs-1 mb-3"></i>
                    <h5>Disaster Relief</h5>
                    <p>Join rapid response teams during emergencies and natural disasters.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="opportunity-card p-4 border rounded shadow-sm h-100">
                    <i class="bi bi-megaphone text-success fs-1 mb-3"></i>
                    <h5>Community Outreach</h5>
                    <p>Organize events, conduct awareness campaigns, and engage with communities.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="opportunity-card p-4 border rounded shadow-sm h-100">
                    <i class="bi bi-laptop text-info fs-1 mb-3"></i>
                    <h5>Administrative Support</h5>
                    <p>Help with office work, data entry, social media management, or website content.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="300">
                <div class="opportunity-card p-4 border rounded shadow-sm h-100">
                    <i class="bi bi-camera text-secondary fs-1 mb-3"></i>
                    <h5>Media & Documentation</h5>
                    <p>Capture events through photography, videography, or content creation.</p>
                </div>
            </div>
        </div>

        <!-- Registration Form -->
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="volunteer-card" data-aos="fade-up">
                    <!-- Header -->
                    <div class="card-header-custom bg-success text-white">
                        <h4>Volunteer Registration Form</h4>
                        <p class="mb-0">Fill out the form below to join our volunteer family</p>
                    </div>

                    <!-- Body -->
                    <div class="card-body p-4">
                        <form id="volunteerForm" method="POST" action="" enctype="multipart/form-data">
                            
                            <!-- Personal Information Section -->
                            <h5 class="section-heading mb-3">
                                <i class="bi bi-person-circle me-2"></i>Personal Information
                            </h5>

                            <!-- Full Name -->
                            <div class="mb-3">
                                <label for="fullName" class="form-label">
                                    Full Name <span class="required">*</span>
                                </label>
                                <input type="text" class="form-control" id="fullName" name="full_name" placeholder="Enter your full name" required>
                            </div>

                            <div class="row">
                                <!-- Email -->
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">
                                        Email Address <span class="required">*</span>
                                    </label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="your.email@example.com" required>
                                </div>

                                <!-- Phone -->
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">
                                        Phone Number <span class="required">*</span>
                                    </label>
                                    <input type="tel" class="form-control" id="phone" name="phone" placeholder="+880 1XXX-XXXXXX" required>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Date of Birth -->
                                <div class="col-md-6 mb-3">
                                    <label for="dob" class="form-label">
                                        Date of Birth <span class="required">*</span>
                                    </label>
                                    <input type="date" class="form-control" id="dob" name="dob" required>
                                </div>

                                <!-- Gender -->
                                <div class="col-md-6 mb-3">
                                    <label for="gender" class="form-label">
                                        Gender <span class="required">*</span>
                                    </label>
                                    <select class="form-select" id="gender" name="gender" required>
                                        <option value="">-- Select --</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Address -->
                            <div class="mb-3">
                                <label for="address" class="form-label">
                                    Address <span class="required">*</span>
                                </label>
                                <textarea class="form-control" id="address" name="address" rows="2" placeholder="Enter your full address" required></textarea>
                            </div>

                            <div class="row">
                                <!-- City -->
                                <div class="col-md-6 mb-3">
                                    <label for="city" class="form-label">
                                        City <span class="required">*</span>
                                    </label>
                                    <input type="text" class="form-control" id="city" name="city" placeholder="Your city" required>
                                </div>

                                <!-- Occupation -->
                                <div class="col-md-6 mb-3">
                                    <label for="occupation" class="form-label">
                                        Occupation/Profession
                                    </label>
                                    <input type="text" class="form-control" id="occupation" name="occupation" placeholder="Student, Teacher, etc.">
                                </div>
                            </div>

                            <!-- Volunteer Information Section -->
                            <h5 class="section-heading mb-3 mt-4">
                                <i class="bi bi-hand-thumbs-up me-2"></i>Volunteer Information
                            </h5>

                            <!-- Areas of Interest -->
                            <div class="mb-3">
                                <label class="form-label">
                                    Areas of Interest <span class="required">*</span>
                                    <small class="text-muted">(Select all that apply)</small>
                                </label>
                                <div class="volunteer-interests">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="interests[]" value="education" id="interest1">
                                        <label class="form-check-label" for="interest1">Education Support</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="interests[]" value="healthcare" id="interest2">
                                        <label class="form-check-label" for="interest2">Healthcare Support</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="interests[]" value="disaster" id="interest3">
                                        <label class="form-check-label" for="interest3">Disaster Relief</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="interests[]" value="outreach" id="interest4">
                                        <label class="form-check-label" for="interest4">Community Outreach</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="interests[]" value="admin" id="interest5">
                                        <label class="form-check-label" for="interest5">Administrative Support</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="interests[]" value="media" id="interest6">
                                        <label class="form-check-label" for="interest6">Media & Documentation</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Skills & Expertise -->
                            <div class="mb-3">
                                <label for="skills" class="form-label">
                                    Skills & Expertise
                                </label>
                                <textarea class="form-control" id="skills" name="skills" rows="3" placeholder="e.g., Teaching, Medical knowledge, Photography, Graphic design, Social media management, etc."></textarea>
                            </div>

                            <!-- Availability -->
                            <div class="mb-3">
                                <label for="availability" class="form-label">
                                    Availability <span class="required">*</span>
                                </label>
                                <select class="form-select" id="availability" name="availability" required>
                                    <option value="">-- Select --</option>
                                    <option value="weekdays">Weekdays</option>
                                    <option value="weekends">Weekends</option>
                                    <option value="both">Both Weekdays & Weekends</option>
                                    <option value="flexible">Flexible</option>
                                    <option value="events">Events Only</option>
                                </select>
                            </div>

                            <!-- Hours per Week -->
                            <div class="mb-3">
                                <label for="hoursPerWeek" class="form-label">
                                    How many hours per week can you volunteer?
                                </label>
                                <select class="form-select" id="hoursPerWeek" name="hours_per_week">
                                    <option value="">-- Select --</option>
                                    <option value="1-5">1-5 hours</option>
                                    <option value="5-10">5-10 hours</option>
                                    <option value="10-20">10-20 hours</option>
                                    <option value="20+">20+ hours</option>
                                </select>
                            </div>

                            <!-- Previous Volunteer Experience -->
                            <div class="mb-3">
                                <label class="form-label">
                                    Previous Volunteer Experience
                                </label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="previous_experience" id="expYes" value="yes">
                                    <label class="form-check-label" for="expYes">Yes</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="previous_experience" id="expNo" value="no" checked>
                                    <label class="form-check-label" for="expNo">No</label>
                                </div>
                            </div>

                            <!-- Experience Details (shown when Yes is selected) -->
                            <div class="mb-3" id="experienceDetails" style="display: none;">
                                <label for="experienceDesc" class="form-label">
                                    Please describe your previous volunteer experience
                                </label>
                                <textarea class="form-control" id="experienceDesc" name="experience_desc" rows="3" placeholder="Organization name, role, duration, etc."></textarea>
                            </div>

                            <!-- Why do you want to volunteer -->
                            <div class="mb-3">
                                <label for="whyVolunteer" class="form-label">
                                    Why do you want to volunteer with us? <span class="required">*</span>
                                </label>
                                <textarea class="form-control" id="whyVolunteer" name="why_volunteer" rows="4" placeholder="Tell us what motivates you..." required></textarea>
                            </div>

                            <!-- Emergency Contact Section -->
                            <h5 class="section-heading mb-3 mt-4">
                                <i class="bi bi-telephone-fill me-2"></i>Emergency Contact
                            </h5>

                            <div class="row">
                                <!-- Emergency Contact Name -->
                                <div class="col-md-6 mb-3">
                                    <label for="emergencyName" class="form-label">
                                        Emergency Contact Name <span class="required">*</span>
                                    </label>
                                    <input type="text" class="form-control" id="emergencyName" name="emergency_name" placeholder="Full name" required>
                                </div>

                                <!-- Emergency Contact Phone -->
                                <div class="col-md-6 mb-3">
                                    <label for="emergencyPhone" class="form-label">
                                        Emergency Contact Phone <span class="required">*</span>
                                    </label>
                                    <input type="tel" class="form-control" id="emergencyPhone" name="emergency_phone" placeholder="+880 1XXX-XXXXXX" required>
                                </div>
                            </div>

                            <!-- Relationship -->
                            <div class="mb-3">
                                <label for="emergencyRelation" class="form-label">
                                    Relationship <span class="required">*</span>
                                </label>
                                <input type="text" class="form-control" id="emergencyRelation" name="emergency_relation" placeholder="e.g., Parent, Spouse, Sibling, Friend" required>
                            </div>

                            <!-- Photo Upload -->
                            <div class="mb-3">
                                <label for="photo" class="form-label">
                                    Upload Your Photo
                                    <small class="text-muted">(Optional, for ID card)</small>
                                </label>
                                <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
                            </div>

                            <!-- Agreement -->
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="agreement" name="agreement" required>
                                    <label class="form-check-label" for="agreement">
                                        I agree to abide by the organization's code of conduct and volunteer policies <span class="required">*</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Info Box -->
                            <div class="info-box mb-3">
                                <p class="mb-0">
                                    <i class="bi bi-info-circle-fill me-2"></i>
                                    After submitting this form, our team will review your application and contact you within 3-5 business days.
                                </p>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-success btn-lg w-100">
                                <i class="bi bi-send-fill me-2"></i>
                                Submit Application
                            </button>

                            <!-- Terms -->
                            <div class="terms-text mt-3">
                                By submitting this form you agree to our
                                <a href="#">Terms and Conditions</a> and
                                <a href="#">Privacy Policy</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>



</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Show/hide experience details based on radio selection
    const expYes = document.getElementById('expYes');
    const expNo = document.getElementById('expNo');
    const experienceDetails = document.getElementById('experienceDetails');

    expYes.addEventListener('change', function() {
        if (this.checked) {
            experienceDetails.style.display = 'block';
        }
    });

    expNo.addEventListener('change', function() {
        if (this.checked) {
            experienceDetails.style.display = 'none';
        }
    });

    // Form validation
    const form = document.getElementById('volunteerForm');
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Check if at least one interest is selected
        const interests = document.querySelectorAll('input[name="interests[]"]:checked');
        if (interests.length === 0) {
            alert('Please select at least one area of interest');
            return;
        }

        // If validation passes, you can submit the form
        // form.submit();
        alert('Thank you for your application! We will contact you soon.');
        // Uncomment the line below in production
        // form.submit();
    });

    // Initialize tooltips if Bootstrap is loaded
    if (typeof bootstrap !== 'undefined') {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }
});
</script>

<!--========================================================================-->
<!---------------------------- Your Content End Here ------------------------->
<!--========================================================================-->

<?php require './components/footer.php'; ?>