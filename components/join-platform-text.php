<div class="my-5 px-3">
    <div
        data-aos="fade-up"
        data-aos-delay="200"
        class="container ">


        <div class="row join-bg">

        <div class="row mx-auto py-2">
            <div class="section_title text-center">
                <h2 class="form-title-text text-uppercase"><b>Make Your Donation</b></h2>
                <div class="title-divider mx-auto mt-2"></div>
            </div>
        </div>

        <style>
            .title-divider {
                width: 60px; 
                height: 4px;               
                background-color:#ffffff; 
            }
        </style>

            
            <div class="row mx-auto pt-2 form-fields-row mt-5">
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="course-lable">Donation Fund<span class="required-asterisk">*</span></label>
                        <select class="course_input" required>
                            <option value="" disabled selected class="p-2">Select Donation Category</option>
                            <option value="education">Education Support</option>
                            <option value="healthcare">Healthcare Aid</option>
                            <option value="food">Food & Nutrition</option>
                            <option value="disaster_relief">Disaster Relief</option>
                            <option value="orphan_support">Orphan Support</option>
                            <option value="mosque_fund">Mosque Fund</option>
                            <option value="environment">Environmental Projects</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="course-lable">Mobile No. <span class="required-asterisk">*</span></label>
                        <input type="text" class="course_input " placeholder="Phone" required="required">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="course-lable">Amount <span class="required-asterisk">*</span></label>
                        <input type="text" class="course_input" placeholder="Donation Amount" required="required">
                    </div>
                </div>
                <div class="col-md-3 button-col d-flex align-items-end">
                    <div class="form-group w-100">
                        <label for="name" class="donate-label-placeholder">Donate</label>
                        <button type="button" class="button w-100 donate-main-button border-0 text-white" style="border-radius: 10px; outline:none; cursor: pointer;">
                            <span>Donate Now</span>
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="alert alert-success text-center mt-5 mx-auto bg-transparent text-white" role="alert">
                <ul>
                    <li>You may receive tax relief when you donate to <strong>Sidratul Muntaha Foundation</strong>.</li>
                </ul>
            </div>

        </div>
    </div>
</div>
<style>
/* --- 1. GLOBAL VARIABLES & UTILITIES --- */
:root {
    --primary-color:rgb(6, 60, 34);
    --primary-hover:rgb(5, 38, 22);
    --text-color: #333;
    --label-color: #555;
    --border-color: #ced4da;
    --input-focus-shadow: 0 0 0 0.2rem rgba(0, 255, 47, 0.25);
    --shadow-light: 0 6px 20px rgba(0, 0, 0, 0.08); 
    --radius: 10px;
}

.join-bg {
    /* Mimics a modern "card" container */

    border-radius: var(--radius);
    box-shadow: var(--shadow-light);
    padding: 30px;
    margin: 20px 0;
}

.form-title-text {
    font-size: 2.2rem;
    font-weight: 700;
    color: var(--primary-color);
}

.required-asterisk {
    color: #dc3545;
}

/* --- 2. INPUT & LABEL STYLING (course-lable, course_input) --- */

/* Modern Label */
.course-lable {
    display: block;
    font-weight: 600;
    color: var(--label-color);
    margin-bottom: 0.4rem;
    font-size: 0.95rem;
}

/* Modern Input/Select (Your existing .course_input class) */
.course_input {
    width: 100%;
    padding: 0.75rem 1rem;
    font-size: 1rem;
    line-height: 1.5;
    color: var(--text-color);
    background-color: #fff;
    border: 1px solid var(--border-color);
    border-radius: var(--radius); /* Uses the radius variable */
    transition: all 0.2s ease-in-out;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    height: calc(2.25rem + 18px); /* Ensures consistent height */
}

/* Input/Select Focus State */
.course_input:focus {
    border-color: var(--primary-color);
    outline: 0;
    box-shadow: var(--input-focus-shadow);
}

/* Custom down arrow for the select input for a cleaner look */
select.course_input {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23333' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right 1rem center;
    background-size: 0.65em 0.65em;
    padding-right: 2.5rem;
}

/* --- 3. BUTTON STYLING (button) --- */

/* Hide placeholder label for button column */
.donate-label-placeholder {
    visibility: hidden;
    height: 1.25rem; /* Reserve space for alignment */
    display: block;
}

/* The primary Donate Button */
.donate-main-button {
    /* Uses your existing .button class, just adding visual polish */
    height: calc(2.25rem + 18px); /* Match input height */
    background-color: var(--primary-color) !important;
    border-radius: var(--radius) !important;
    font-size: 1.1rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: background-color 0.2s ease, transform 0.1s ease, box-shadow 0.2s ease;
}

.donate-main-button:hover {
    background-color: var(--primary-hover) !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.donate-main-button:active {
    transform: translateY(0);
    box-shadow: none;
}

/* Remove old style overrides for button span */
.btn-margin .button span:first-child {
    padding: 0 !important;
    line-height: normal !important;
    white-space: normal !important;
}

/* --- 4. DISCLAIMER/INFO CARD --- */


/* --- 5. RESPONSIVENESS (Mobile Focus) --- */

@media (max-width: 767px) {
    .join-bg {
        padding: 20px;
    }
    
    .form-title-text {
        font-size: 1.8rem;
    }
    
    /* Ensure proper spacing on mobile for the stacked columns */
    .form-fields-row > [class*="col-"] {
        margin-bottom: 1rem;
    }
    
    .button-col {
        margin-top: 0; /* Clear the alignment trick when stacked */
    }

    /* Adjust the button label visibility for mobile stacking */
    .donate-label-placeholder {
        visibility: hidden;
        height: 0;
        margin-bottom: 0;
    }
    
    .donate-main-button {
        height: 50px; /* Slightly easier to tap on mobile */
    }
}
</style>