<!-- Join Platform Text -->
<div class="join">
    <div 
        data-aos="fade-up"
        data-aos-delay="200"
        class="container ">
        <div class="row">
            <div class="row mx-auto join-bg">
                <div class="col-lg-10 offset-lg-1 ">
                    <div class="section_title text-center">
                        <h2>Make Your Donation</h2>
                    </div>
                </div>
                <div class="col">
                    <div class="">
                        <form action="#" class="mt-3 course_search_form d-flex flex-md-row gap-2 flex-column align-items-start justify-content-between">
                            <div>
                                <label class="course-lable">Donation Fund<span>*</span></label>
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

                            <div>
                                <label class="course-lable">Mobile No. <span>*</span></label>
                                <input type="text" class="course_input " placeholder="Phone" required="required">
                            </div>
                            <div>
                                <label class="course-lable">Amount <span>*</span></label>
                                <input type="text" class="course_input" placeholder="Donation Amount" required="required">
                            </div>
                            <div class="btn-margin">
                                <button type="button" class="button w-100" style=".btn-margin .btn:hover{background:#ccc}">
                                    <span>Donate</span>

                                </button>
                            </div>
                        </form>
                        <div class="section_subtitle">You may receive tax relief when you donate to Sidratul Muntaha Foundation.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Additional styles for join button alignment */
.btn-margin {
    margin-top: 33px;
}



/* Make sure button text is properly styled */
.btn-margin .button span:first-child {
    padding-left: 33px;
    padding-right: 77px;
    line-height: 47px;
    font-size: 12px;
    font-weight: 600;
    color: #FFFFFF;
    text-transform: uppercase;
    white-space: nowrap;
}

/* Responsive adjustments */
@media(max-width: 991px) {
    .btn-margin {
        width: 100%;
        margin-top: 20px;
    }
    
    .btn-margin .button {
        width: 100%;
    }
}

@media(max-width: 575px) {
    .course_search_form > div {
        width: 100%;
    }
    
    .btn-margin {
        width: 100%;
    }
    
    .btn-margin .button {
        width: 98%;
    }
}
</style>